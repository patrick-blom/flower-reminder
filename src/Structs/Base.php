<?php

namespace FlowerReminder\Structs;

use FlowerReminder\Exceptions\OutOfBoundsException;

class Base
{
    public function __construct($properties = [])
    {
        if (!empty($properties)) {
            foreach ($properties as $property => $propertyValue) {
                if (!property_exists($this, $property)) {
                    throw new OutOfBoundsException($property . "does not exists");
                }
                $this->$property = $propertyValue;
            }
        }
    }
}
