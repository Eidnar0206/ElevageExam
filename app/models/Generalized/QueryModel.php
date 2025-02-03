<?php

namespace app\models\Generalized;
use \Exception;
use ReflectionClass;
use ReflectionProperty;
class QueryModel
{
    private $db;
    public function __construct($db) {
        $this->db = $db;
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

    function updateObject($object, $tableName) {
        
    }

}