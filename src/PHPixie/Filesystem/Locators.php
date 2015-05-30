<?php

namespace PHPixie\Filesystem;

class Locators
{
    protected $builder;
    protected $locatorRegistry;
    
    protected $locators = array(
        'directory',
        'group',
        'prefix',
        'mount'
    );
    
    public function __construct($builder, $locatorRegistry = null)
    {
        $this->builder         = $builder;
        $this->locatorRegistry = $locatorRegistry;
    }
    
    public function directory($configData)
    {
        return new Locators\Locator\Directory(
            $this->builder->root(),
            $configData
        );
    }
    
    public function group($configData)
    {
        return new Locators\Locator\Group(
            $this,
            $configData
        );
    }
    
    public function prefix($configData)
    {
        return new Locators\Locator\Prefix(
            $this,
            $configData
        );
    }
    
    public function mount($configData)
    {
        if ($this->locatorRegistry === null) {
            throw new \PHPixie\Filesystem\Exception("Locator registry was not set");
        }
        
        return new Locators\Locator\Mount(
            $this->locatorRegistry,
            $configData
        );
    }
    
    public function buildFromConfig($configData) {
        $type = $configData->get('type', 'directory');
        if(!in_array($type, $this->locators, true)) {
            throw new \PHPixie\Filesystem\Exception("Locator type '$type' does not exist");
        }
        
        return $this->$type($configData);
    }
}