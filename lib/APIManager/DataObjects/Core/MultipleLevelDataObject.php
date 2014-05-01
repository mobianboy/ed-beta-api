<?php

namespace APIManager\DataObjects\Core;

use APIManager\Interfaces\DataObjectInterface;
use APIManager\Formats\Core\BasicFormatFactory;

class MultipleLevelDataObject implements DataObjectInterface
{
    
    /**
     * @var array 
     */
    protected $_structure = array();
    /**
     * @var array 
     */
    protected $_values = array();
    /**
     * @var string 
     */
    protected $_name = 'UnnamedMultipleLevelDataObject';
    /**
     * @var BasicFormatFactory
     */
    protected $_format_factory;
    /**
     * @var array
     */
    protected $_valid_keypaths = array();
    
    /**
     * 
     * @param array $structure
     * @param string $name
     */
    public function __construct(BasicFormatFactory $formatFactory, $structure = array(), $name = 'UnnamedMultipleLevelDataObject') 
    {
        $this->_format_factory = $formatFactory;
        $this->_structure = $structure;
        $this->_name = $name;
        $this->buildFlatKeypaths($structure);
    }
    
    /**
     * 
     * @return array
     */
    public function getStructure() 
    {
        return $this->_structure;
    }
    
    public function getOption($option) 
    {
        return (isset($this->_values[$option])) ? $this->_values[$option] : '';
    }
    
    public function isOptionSettable($option) {
        return (isset($this->_structure[$option])) ? true : false;
    }
    
    public function isKeyPathValid($path, $mode = "flat") {
        
        if ($mode == "flat") {
            if (isset($this->_valid_keypaths[$path])) {
                return true;
            } else {
                return false;
            }
        } else {
            $pathSize = count($path);

            $builtPath = "";
            for ($i=0;$i<$pathSize;$i++) {
                if ($i > 0) {
                    $builtPath .= ".";
                }
                $builtPath .= $path[$i];
            }
            
            return $this->isKeyPathValid($builtPath);
        }
    }
    
    public function getOptions() 
    {
        return $this->_values;
    }
    
    public function setOptions($options = array(), $keyType = "array") 
    {
        if ($keyType == "array") {
            $values = $this->recurseArray($options);
        } elseif ($keyType == "flat") {
            $values = $options;
        }
        
        foreach ($values as $key => $value) {
            $this->setOption($key, $value);
        }
        
        return $this;
    }
    
    public function recurseArray($array, $builtKey = "") {
        
        $values = array();
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                array_merge($values, $this->recurseArray($value, $builtKey.".".$key));
            } else {
                $values[$builtKey.$key] = $value;
            }
        }
        
        return $values;
    }
    
    public function buildFlatKeypaths($array, $builtKey = "") {
        $values = array();
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                array_merge($values, $this->recurseArray($value, $builtKey.".".$key));
            } else {
                if (is_int($key)) {
                    $values[$builtKey.$value] = true;
                } else {
                    $values[$builtKey.$key] = true;
                }
            }
        }
        
        if (empty($builtKey)) {
            $this->_valid_keypaths = $values;
        }
        
        return $this;
    }
    
    public function setOption($option, $value, $optionMode = "flat") 
    {
        if ($this->isKeyPathValid($option, $optionMode) == false) {
            throw new \InvalidArgumentException("The requested key path does not exist: ".$option);
        }
        
        $current = &$this->_values;
        
        $namespaces = explode(".", $option);
        
        foreach ($namespaces as $space) {
            if (!is_array($current)) {
                $current = array();
                $current[$space] = null;
            } elseif (!isset($current[$space])) {
                $current[$space] = null;
            }
            $current = &$current[$space];
        }
        
        $current = $value;
        
        return $this;
    }
    
    public function __call($name, $arguments) 
    {
        //
    }
    
    public function __toString() 
    {
        $data = json_encode($this->_values, JSON_FORCE_OBJECT);
        
        $compiled = "\"".$this->_name."\": ".$data;
        
        return $compiled;
    }
}