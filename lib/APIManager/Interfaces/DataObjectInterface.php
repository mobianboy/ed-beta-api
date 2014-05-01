<?php

namespace APIManager\Interfaces;

interface DataObjectInterface
{
    /**
     * This function should return the full structure of the DataObject in the form of an array.
     * 
     * @return array
     */
    public function getStructure();
    
    /**
     * This function sets DataObject options based on key => value.
     * 
     * @param array $options
     * @return APIManager\Interfaces\DataObjectInterface
     */
    public function setOptions($options = array());
    
    /**
     * This function should return the current state of the DataObject in the form of an array.
     * 
     * @return array
     */
    public function getOptions();
    
    /**
     * Checks the _structure array to see if the $option key exists anywhere.
     * 
     * @param string $option
     */
    public function isOptionSettable($option);
    
    /**
     * This function should return the value of the option provided.
     * 
     * @param string $option
     * @return string
     */
    public function getOption($option);
    
}