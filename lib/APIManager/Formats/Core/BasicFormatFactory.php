<?php

namespace APIManager\Formats\Core;

use APIManager\Interfaces\FormatFactoryInterface;

abstract class BasicFormatFactory implements FormatFactoryInterface
{
    protected $_openTag;
    protected $_closeTag;
    protected $_headers = array();
    protected $_concat;
    
    public function __construct($headers = array()) 
    {
        $this->_headers = $headers;
    }
    
    public function buildFullExport($compiledArray) {
        $processed = $this->openTag();
        $processed .= $this->headers().$this->_concat;
        $processed .= implode($this->_concat, $compiledArray);
        $processed .= $this->closeTag();
        
        return $processed;
    }
    
    public function buildPartialExport($rootElement, $dataArray);
    
    public function buildSingleExport($name, $value);
    
    public function openTag() {
        return $this->_openTag;
    }
    
    public function closeTag() {
        return $this->_closeTag;
    }
    
    public function headers();
    
}