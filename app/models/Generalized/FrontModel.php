<?php

namespace app\models\Generalized;
use ReflectionClass;
use ReflectionProperty;
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

                $type = 'text'; // Default type
                if ($property->hasType()) {
                    $typeName = $property->getType()->getName();
                    if (in_array($typeName, ['int', 'float', 'double'])) {
                        $type = 'number';
                    } elseif ($typeName === 'DateTime') {
                        $type = 'date';
                    }
                }
                $formHtml .= "<label for=\"$propertyName\">$label:</label>";
                $formHtml .= "<input type=\"$type\" name=\"$propertyName\"/>";
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

    public function setSelectOptions($object, $html, $name, $options, $values) {
        try {
            $reflection = new ReflectionClass($object);
            $property = $reflection->getProperty($name);
            
            $type = 'text'; // Default to text
            
            if ($property->hasType()) {
                $typeName = $property->getType()->getName();
                if (in_array($typeName, ['int', 'float', 'double'])) {
                    $type = 'number';
                } elseif ($typeName === 'DateTime') {
                    $type = 'date';
                }
            }
    
            $original = "<input type=\"$type\" name=\"$name\"/>";
            $select = "<select id=\"$name\" class=\"form-control\" name=\"$name\">";
            $select .= "<option value='-1'>Select</option>";
    
            foreach ($options as $index => $option) {
                $select .= "<option value='" . htmlspecialchars($values[$index]) . "'>" . htmlspecialchars($option) . "</option>";
            }
            $select .= "</select>";
    
            return str_replace($original, $select, $html);
        } catch (\ReflectionException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    
    

}