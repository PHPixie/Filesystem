<?php

namespace PHPixie\Filesystem;

class Builder
{
    protected $locators;
    
    public function __construct()
    {
        
    }
    
    public function root($directory)
    {
        return new Root($directory);
    }
    
    public function locators()
    {
        if($this->locators === null) {
            $this->locators = $this->buildLocators();
        }
        
        return $this->locators;
    }
    
    protected function buildLocators()
    {
        return new Locators($this);
    }
}