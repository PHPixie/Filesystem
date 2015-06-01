<?php

namespace PHPixie\Tests;

/**
 * @coversDefaultClass \PHPixie\Filesystem
 */
class FilesystemTest extends \PHPixie\Test\Testcase
{
    protected $rootDir = '/pixie/';
    protected $locatorRegistry;
    
    protected $filesystem;
    
    protected $builder;
    
    protected $root;
    protected $locators;
    
    public function setUp()
    {
        $this->locatorRegistry = $this->quickMock('\PHPixie\Filesystem\Locators\Registry');
        
        $this->filesystem = $this->getMockBuilder('\PHPixie\Filesystem')
            ->setMethods(array('buildBuilder'))
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->builder = $this->quickMock('\PHPixie\Filesystem\Builder');
        $this->method($this->filesystem, 'buildBuilder', $this->builder, array(
            $this->rootDir,
            $this->locatorRegistry
        ), 0);
        
        $this->filesystem->__construct(
            $this->rootDir,
            $this->locatorRegistry
        );
        
        $this->root = $this->quickMock('\PHPixie\Filesystem\Root');
        $this->method($this->builder, 'root', $this->root, array());
        
        $this->locators = $this->quickMock('\PHPixie\Filesystem\Locators');
        $this->method($this->builder, 'locators', $this->locators, array());
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstructor()
    {
        
    }
    
    /**
     * @covers ::builder
     * @covers ::<protected>
     */
    public function testBuilder()
    {
        $this->assertSame($this->builder, $this->filesystem->builder());
    }
    
    /**
     * @covers ::root
     * @covers ::<protected>
     */
    public function testRoot()
    {
        $this->assertSame($this->root, $this->filesystem->root());
    }
    
    /**
     * @covers ::rootPath
     * @covers ::<protected>
     */
    public function testRootPath()
    {
        $this->method($this->root, 'path', '/pixie/trixie', array('trixie'), 0);
        $this->assertSame('/pixie/trixie', $this->filesystem->rootPath('trixie'));
        
        $this->method($this->root, 'path', '/pixie/', array(null), 0);
        $this->assertSame('/pixie/', $this->filesystem->rootPath());
    }
    
    /**
     * @covers ::locator
     * @covers ::<protected>
     */
    public function testLocator()
    {
        $configData = $this->quickMock('\PHPixie\Slice\Data');
        $locator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
        
        $this->method($this->locators, 'buildFromConfig', $locator, array($configData), 0);
        $this->assertSame($locator, $this->filesystem->locator($configData));
    }
    
    /**
     * @covers ::buildBuilder
     * @covers ::<protected>
     */
    public function testBuildBuilder()
    {
        $this->filesystem = new \PHPixie\Filesystem(
            $this->rootDir,
            $this->locatorRegistry
        );
        
        $builder = $this->filesystem->builder();
        $this->assertInstance($builder, '\PHPixie\Filesystem\Builder', array(
            'rootDir'         => $this->rootDir,
            'locatorRegistry' => $this->locatorRegistry
        ));
        
        $this->filesystem = new \PHPixie\Filesystem(
            $this->rootDir
        );
        
        $builder = $this->filesystem->builder();
        $this->assertInstance($builder, '\PHPixie\Filesystem\Builder', array(
            'rootDir'         => $this->rootDir,
            'locatorRegistry' => null
        ));
    }
}