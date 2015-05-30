<?php

namespace PHPixie\Filesystem\Locators\Locator;

class Mount implements \PHPixie\Filesystem\Locators\Locator
{
    protected $locator;
    
    public function __construct($locatorRegistry, $configData)
    {
        $name = $configData->getRequired('name');
        $this->locator = $locatorRegistry->get($name);
    }
    
    public function locate($path)
    {
        return $this->locator->locate($path);
    }
}