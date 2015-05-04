<?php

namespace PHPixie\Filesystem\Locators;

interface Locator{
    public function locate($name);
}