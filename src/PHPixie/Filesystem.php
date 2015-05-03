<?php

namespace PHPixie;

class Filesystem
{
    protected $root;
    
    public function __construct($root)
    {
        $this->root = $root;
    }
}