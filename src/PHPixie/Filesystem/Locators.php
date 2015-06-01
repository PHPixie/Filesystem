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
        return new Locators\Locator\Mount(
            $this->locatorRegistry,
            $configData
        );
    }
    
    public function build($configData, $rootPath = null, $locatorRegistry = null) {
        $builder = $this->locatorBuilder($rootPath, $locatorRegistry);
        return $builder->buildFromConfig($configData);
    }
}