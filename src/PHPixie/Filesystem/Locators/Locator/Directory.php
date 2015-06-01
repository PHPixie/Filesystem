<?php

namespace PHPixie\Filesystem\Locators\Locator;

class Directory implements \PHPixie\Filesystem\Locators\Locator
{
    protected $root;
    protected $directory;
    protected $defaultExtension;
    
    public function __construct($root, $configData)
    {
        $this->root             = $root;
        $this->directory        = $configData->getRequired('directory');
        $this->defaultExtension = $configData->get('defaultExtension', 'php');
    }
    
    public function locate($path, $isDirectory = false)
    {
        $path = $this->directory.'/'.$path;
        $path = $this->root->path($path);
        
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if($extension === '') {
            $path.='.'.$this->defaultExtension;
        }
        
        $exists = !$isDirectory && file_exists($path);
        $exists = $exists || $isDirectory && is_dir($path);
        
        if(!$exists) {
            $path = null;
        }
        
        return $path;
    }
}