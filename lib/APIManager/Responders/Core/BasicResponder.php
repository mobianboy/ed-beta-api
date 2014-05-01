<?php

namespace APIManager\Responders\Core;

use APIManager\Interfaces\ResponderInterface;
use APIManager\Formats\Core\BasicFormatFactory;

class BasicResponder implements ResponderInterface
{
    
    protected $_data = array();
    protected $_export = array();
    /**
     * @var BasicFormatFactory
     */
    protected $_format_factory;
    
    public function __construct(BasicFormatFactory $formatFactory) 
    {
        $this->_format_factory = $formatFactory;
    }

    public function getBlock($block)
    {
        if (!isset($this->_data[$block])) {
            throw new \InvalidArgumentException();
        }
        
        return $this->_data[$block];
    }
    
    public function __toString() {
        $this->_export = array();
        
        foreach ($this->_data as $dataobject) {
            $this->_export[] = $dataobject->__toString();
        }
        
        $this->_export[] = $this->_format_factory->buildSingleExport("generated", new \DateTime());
        
        return $this->_format_factory->buildFullExport($this->_export);
    }
    
}