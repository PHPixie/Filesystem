<?php

namespace PHPixie\Filesystem\Locators\Locator;

class Group
{
    protected $locators = array();
    
    public function __construct($locators, $configData)
    {
        $locatorsConfig = $configData->slice('locators');
        foreach($locatorsConfig->keys(null, true) as $key) {
            $locatorConfig = $locatorsConfig->slice($key);
            $this->locators[] = $locators->buildFromConfig($locatorConfig);
        }
    }
    
    public function locate($name)
    {
        $path = null;
        foreach($this->locators as $locator) {
            $path = $locator->locate($name);
            if($path !== null) {
                break;
            }
        }
        
        return $path;
    }
}