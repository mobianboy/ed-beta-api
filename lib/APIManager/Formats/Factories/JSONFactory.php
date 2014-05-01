<?php

namespace APIManager\Formats\Factories;

use APIManager\Formats\Core\BasicFormatFactory;

class JSONFactory extends BasicFormatFactory
{
    
    protected $_openTag = "{";
    protected $_closeTag = "}";
    protected $_headers = array();
    protected $_concat = ",";
    
    public function __construct($headers = array()) 
    {
        parent::__construct($headers);
    }
    
    public function buildFullExport($compiledArray) 
    {
        parent::buildFullExport($compiledArray);
    }
    
    public function buildPartialExport($rootElement, $dataArray)
    {
        return "\"".$rootElement."\": ".json_encode($dataArray);
    }
    
    public function buildSingleExport($name, $value) {
        return (is_int($value)) ? "\"".$name."\": ".$value : "\"".$name."\": \"".addslashes($value)."\"";
    }

    protected function headers()
    {
        return (count($this->_headers)) ? "\"headers\": ".json_encode($this->_headers, JSON_FORCE_OBJECT) : "";
    }
    
}