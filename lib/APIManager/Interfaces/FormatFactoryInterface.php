<?php

namespace APIManager\Interfaces;

interface FormatFactoryInterface
{
    
    public function buildFullExport();
    
    public function buildPartialExport($rootElement, $dataArray);
    
    public function buildSingleExport($name, $value);
    
    public function openTag();
    
    public function closeTag();
    
    public function headers();
    
}