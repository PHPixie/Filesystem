<?php

namespace PHPixie\Filesystem\Locators\Locator;

class Prefix implements \PHPixie\Filesystem\Locators\Locator
{
    protected $locatorBuilder;
    protected $locatorsConfig;
    protected $defaultPrefix;
    
    protected $locators = array();
    
    public function __construct($locatorBuilder, $configData)
    {
        $this->locatorBuilder = $locatorBuilder;
        $this->locatorsConfig = $configData->slice('locators');
        $this->defaultPrefix  = $configData->get('defaultPrefix', 'default');
    }
    
    protected function locator($key)
    {
        if(!array_key_exists($name, $this->locators)) {
            $locatorConfig = $locatorsConfig->slice($key);
            $this->locators[$key] = $this->locatorBuilder->build($locatorConfig);
        }
        
        return $this->locators[$key];
    }
    
    public function locate($name, $isDirectory = false)
    {
        $split = explode(':', $name, 2);
        if(count($split) > 1) {
            list($prefix, $name) = $split;
            
        }else{
            $prefix = $this->defaultPrefix;
            $name = $name;
        }
        
        return $this->locator($key)->locate($name, $isDirectory);
    }
}
