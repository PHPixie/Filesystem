<?php

namespace PHPixie;

class Filesystem
{
    protected $builder;
    
    public function __construct($rootDir)
    {
        $this->builder = $this->buildBuilder($rootDir);
    }
    
    public function builder()
    {
        return $this->builder;
    }
    
    public function root()
    {
        return $this->builder->root();
    }
    
    public function rootPath($path = null)
    {
        $root = $this->builder->root();
        return $root->path($path);
    }
    
    public function locator($configData)
    {
        $locators = $this->builder->locators();
        return $locators->buildFromConfig($configData);
    }
    
    protected function buildBuilder($rootDir)
    {
        return new Filesystem\Builder($rootDir);
    }
}