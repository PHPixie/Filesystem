<?php

namespace PHPixie\Filesystem;

class Builder
{
    protected $rootDir;
    protected $locatorRegistry;
    
    protected $instances = array();
    
    public function __construct($rootDir, $locatorRegistry = null)
    {
        $this->rootDir         = $rootDir;
        $this->locatorRegistry = $locatorRegistry;
    }
    
    public function root()
    {
        return $this->instance('root');
    }
    
    public function locators()
    {
        return $this->instance('locators');
    }
    
    protected function buildRoot()
    {
        return new Root($this->rootDir);
    }
    
    protected function buildLocators()
    {
        return new Locators($this, $this->locatorRegistry);
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
}