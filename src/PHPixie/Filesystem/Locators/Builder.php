<?php

namespace PHPixie\Filesystem\Locators;

class Builder
{
    protected $locators;
    protected $rootPath;
    protected $locatorRegistry;
    
    public function __construct($locators, $rootPath, $locatorRegistry = null)
    {
        $this->locators        = $locators;
        $this->rootPath        = $rootPath;
        $this->locatorRegistry = $locatorRegistry;        
    }
    
    protected function directory($configData)
    {
        $this->locators->directory($this->rootPath, $configData);
    }
    
    protected function group($configData)
    {
        $this->locators->group($this, $configData);
    }
    
    protected function prefix($configData)
    {
        $this->locators->prefix($this, $configData);
    }
    
    protected function mount($configData)
    {
        if ($this->locatorRegistry === null) {
            throw new \PHPixie\Filesystem\Exception("Locator registry was not set");
        }
        
        $this->locators->mount($his->locatorRegistry, $configData);
    }
    
    public function buildFromConfig($configData) {
        $type = $configData->get('type', 'directory');
        return $this->$type($configData);
    }
}