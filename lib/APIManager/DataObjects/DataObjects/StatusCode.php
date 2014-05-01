<?php

namespace APIManager\DataObjects\DataObjects;

use APIManager\DataObjects\Core\SingleLevelDataObject;
use APIManager\Formats\Core\BasicFormatFactory;

class StatusCode extends SingleLevelDataObject
{
    
    /**
     * @var BasicFormatFactory
     */
    protected $_format_factory;
    
    /**
     * 
     * 
     * @param BasicFormatFactory $formatFactory
     */
    public function __construct(BasicFormatFactory $formatFactory) 
    {
        parent::__construct(
                $formatFactory,
                array("code", "message"), 
                "status"
        );
    }
    
    /**
     * 
     * 
     * @param type $code
     * @throws \InvalidArgumentException
     */
    public function setCode($code) 
    {
        if (is_int($code)) {
            $this->setOption("code", $code);
        } else {
            throw new \InvalidArgumentException();
        }
    }
    
}