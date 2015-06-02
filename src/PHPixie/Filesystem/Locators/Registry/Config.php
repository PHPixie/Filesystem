<?php

namespace PHPixie\Filesystem\Locators\Registry;

class Config implements \PHPixie\Filesystem\Locators\Registry
{
    protected $locatorBuilder;
    protected $configData;
    
    protected $locators = array();
    
    public function __construct($locatorBuilder, $configData)
    {
        $this->locatorBuilder = $locatorBuilder;
        $this->configData     = $configData;
    }
    
    public function get($name)
    {
        if(!array_key_exists($name, $this->locators)) {
            $locatorConfig = $this->configData->slice($name);
            $this->locators[$name] = $this->locatorBuilder->buildFromConfig($locatorConfig);
        }
        
        return $this->locators[$name];
    }
}