<?php

namespace APIManager\Responders\Responders;

use APIManager\DataObjects\DataObjects\StatusCode;
use APIManager\Formats\Core\BasicFormatFactory;
use APIManager\Responders\Core\BasicResponder;

class NullResponder extends BasicResponder
{
    
    public function __construct(BasicFormatFactory $formatFactory) 
    {
        parent::__construct($formatFactory);
        $this->_data['status'] = new StatusCode($formatFactory);
    }
    
}