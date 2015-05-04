<?php

namespace PHPixie\Filesystem;

class Builder
{
    protected $rootDir;
    protected $instances = array();
    
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
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
        return new Locators($this);
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