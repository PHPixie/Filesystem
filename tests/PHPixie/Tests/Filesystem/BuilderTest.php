<?php

namespace PHPixie\Tests\Filesystem;

/**
 * @coversDefaultClass \PHPixie\Filesystem\Builder
 */
class BuilderTest extends \PHPixie\Test\Testcase
{
    protected $rootDir = '/pixie/';
    protected $locatorRegistry;
    
    protected $builders;
    
    public function setUp()
    {
        $this->locatorRegistry = $this->quickMock('\PHPixie\Filesystem\Locators\Registry');
        $this->builder = new \PHPixie\Filesystem\Builder(
            $this->rootDir,
            $this->locatorRegistry
        );
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
            'builder'         => $this->builder,
            'locatorRegistry' => $this->locatorRegistry,
        ));
        
        $this->assertSame($locators, $this->builder->locators());
        
        $this->builder = new \PHPixie\Filesystem\Builder($this->rootDir);
        $this->assertInstance($this->builder->locators(), '\PHPixie\Filesystem\Locators', array(
            'builder'         => $this->builder,
            'locatorRegistry' => null,
        ));
    }
}