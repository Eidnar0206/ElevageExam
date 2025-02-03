<?php

namespace app\models\Generalized;
use ReflectionClass;
use ReflectionProperty;
use Exception;

class FrontModel
{
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    public function generateForm($object, $location) {
        try {
            // Ensure the object is an instance of a class
            if (!is_object($object)) {
                throw new \InvalidArgumentException('The provided parameter is not an object.');
            }

            $reflection = new ReflectionClass($object);
            $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

            // Check if the object has a getLabels method
            if (!method_exists($object, 'getLabels')) {
                throw new \RuntimeException('The object does not have a getLabels() method.');
            }

            $labels = $object->getLabels(); // Get labels from the object
            $formHtml = '<form action="' . htmlspecialchars($location) . '" method="post">';

            foreach ($properties as $property) {
                $propertyName = $property->getName();
                $label = isset($labels[$propertyName]) ? $labels[$propertyName] : ucfirst($propertyName); // Get the label for the property

                // Determine input type based on property name
                if (strpos($propertyName, 'Date') !== false) {
                    $formHtml .= "<label for=\"$propertyName\">$label:</label>";
                    $formHtml .= "<input type=\"date\" name=\"$propertyName\" />"; // No value set
                } elseif (strpos($propertyName, 'age') !== false) {
                    $formHtml .= "<label for=\"$propertyName\">$label:</label>";
                    $formHtml .= "<input type=\"number\" name=\"$propertyName\" />"; // No value set
                } else {
                    $formHtml .= "<label for=\"$propertyName\">$label:</label>";
                    $formHtml .= "<input type=\"text\" name=\"$propertyName\" placeholder=\"Entrer $label\" />"; // No value set
                }

                $formHtml .= "<br>";
            }

            $formHtml .= '<input type="submit" value="Submit" />';
            $formHtml .= '</form>';

            return $formHtml;

        } catch (\InvalidArgumentException|\RuntimeException $e) {
            return 'Error: ' . $e->getMessage();
        } catch (\Exception $e) {
            // Catch any other generic exception
            return 'An unexpected error occurred: ' . $e->getMessage();
        }
    }
    public function createNewObject($object) {
        $formValues = array_merge($_POST, $_FILES);
        $reflectionClass = new ReflectionClass($object);
        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            // If there's no constructor, just create the object without arguments
            return $reflectionClass->newInstance();
        }
        $parameters = $constructor->getParameters();

        $args = [];
        foreach ($parameters as $param) {
            $paramName = $param->getName();
            if (isset($formValues[$paramName])) {
                $args[] = $formValues[$paramName];
            } elseif ($param->isOptional()) {
                $args[] = $param->getDefaultValue();
            } else {
                throw new Exception("Missing required parameter: $paramName");
            }
        }
        // Create a new instance with the matched arguments
        return $reflectionClass->newInstanceArgs($args);
    }

    function insertObject($object, $tableName) {
        // Get the object's class and properties
        $object = $this->createNewObject($object);
        $reflectionClass = new ReflectionClass($object);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);

        // Build column names and values
        $columns = [];
        $placeholders = [];
        $values = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $value = $property->getValue($object);

            $columns[] = $propertyName;
            $placeholders[] = ":$propertyName";
            $values[":$propertyName"] = $value;
        }

        // Construct the SQL query
        $columnsString = implode(", ", $columns);
        $placeholdersString = implode(", ", $placeholders);
        $sql = "INSERT INTO `$tableName` ($columnsString) VALUES ($placeholdersString)";

        // Prepare and execute the query
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($values)) {
            return $this->db->lastInsertId(); // Return the ID of the inserted row
        } else {
            throw new Exception("Failed to insert object: " . implode(", ", $stmt->errorInfo()));
        }
    }

}