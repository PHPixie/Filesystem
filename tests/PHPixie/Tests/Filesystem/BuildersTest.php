<?php

namespace PHPixie\Tests\Filesystem;

/**
 * @coversDefaultClass \PHPixie\Filesystem\Builder
 */
class BuildersTest extends \PHPixie\Test\Testcase
{
    protected $rootDir = '/pixie/';
    protected $builders;
    
    public function setUp()
    {
        $this->builder = new \PHPixie\Filesystem\Builder($this->rootDir);
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::root
     * @covers ::<protected>
     */
    public function testRoot()
    {
        $root = $this->builder->root();
        $this->assertInstance($root, '\PHPixie\Filesystem\Root', array(
            'path' => $this->rootDir
        ));
        
        $this->assertSame($root, $this->builder->root());
    }
    
    /**
     * @covers ::locators
     * @covers ::<protected>
     */
    public function testLocators()
    {
        $locators = $this->builder->locators();
        $this->assertInstance($locators, '\PHPixie\Filesystem\Locators', array(
            'builder' => $this->builder
        ));
        
        $this->assertSame($locators, $this->builder->locators());
    }
}