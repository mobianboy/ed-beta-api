<?php

namespace APIManager\DataObjects\Core;

use APIManager\Interfaces\DataObjectInterface;
use APIManager\Formats\Core\BasicFormatFactory;

class SingleLevelDataObject implements DataObjectInterface
{
    
    /**
     *
     * @var array 
     */
    protected $_structure = array();
    /**
     *
     * @var array 
     */
    protected $_values = array();
    /**
     *
     * @var string 
     */
    protected $_name = 'UnnamedSingleLevelDataObject';
    /**
     * @var BasicFormatFactory
     */
    protected $_format_factory;
    
    /**
     * 
     * @param array $structure
     * @param string $name
     */
    public function __construct(BasicFormatFactory $formatFactory, $structure = array(), $name = 'UnnamedSingleLevelDataObject') 
    {
        $this->_format_factory = $formatFactory;
        $this->_structure = $structure;
        $this->_name = $name;
    }
    
    /**
     * 
     * @return array 
     */
    public function getStructure() 
    {
        return $this->_structure;
    }
    
    /**
     * 
     * @param string $option
     * @return string
     */
    public function getOption($option) 
    {
        return (isset($this->_values[$option])) ? $this->_values[$option] : '';
    }
    
    public function isOptionSettable($option) {
        return (array_search($option, $this->_structure) !== false) ? true : false;
    }
    
    /**
     * 
     * @return array
     */
    public function getOptions() 
    {
        return $this->_values;
    }
    
    /**
     * 
     * @param array $options
     * @return \APIManager\DataObjects\Core\SingleLevelDataObject
     * @throws \InvalidArgumentException
     */
    public function setOptions($options = array()) 
    {
        if (!is_array($options)) {
            throw new \InvalidArgumentException();
        }
        
        foreach ($options as $option => $value) {
            if (array_search($option, $this->_structure)) {
                $this->_values[$option] = $value;
            }
        }
        
        return $this;
    }
    
    /**
     * 
     * @param string $option
     * @param string $value
     * @return \APIManager\DataObjects\Core\SingleLevelDataObject
     * @throws \InvalidArgumentException
     */
    public function setOption($option, $value) 
    {
        if (!is_string($option)) {
            throw new \InvalidArgumentException();
        }
        
        if (array_search($option, $this->_structure)) {
            $this->_values[$option] = $value;
        }
        
        return $this;
    }
    
    /**
     * 
     * @param string $name
     * @param array $arguments
     * @return \APIManager\DataObjects\Core\SingleLevelDataObject
     * @throws \BadMethodCallException
     */
    public function __call($name, $arguments) 
    {
        if (strpos($name, "get") === 0 && strlen($name) > 3) {
            $option = strtolower(substr($name, 3));
            if (array_search($option, $this->_structure)) {
                return (isset($this->_values[$option])) ? $this->_values[$option] : '';
            } else {
                throw new \BadMethodCallException();
            }
        } elseif (strpos($name, "set") === 0 && strlen($name) > 3) {
            $option = strtolower(substr($name, 3));
            if (array_search($option, $this->_structure)) {
                $this->_values[$option] = $arguments[0];
                
                return $this;
            } else {
                throw new \BadMethodCallException();
            }
        } else {
            throw new \BadMethodCallException();
        }
    }
    
    /*
     * @return string 
     */
    public function __toString() 
    {
        return $this->_format_factory->buildPartialExport($this->_name, $this->_values);
    }
}