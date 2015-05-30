<?php

namespace PHPixie\Tests\Filesystem;

/**
 * @coversDefaultClass \PHPixie\Filesystem\Locators
 */
class LocatorsTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    protected $locatorRegistry;
    
    protected $locators;
    
    protected $root;
    
    public function setUp()
    {
        $this->builder          = $this->quickMock('\PHPixie\Filesystem\Builder');
        $this->locatorRegistry  = $this->quickMock('\PHPixie\Filesystem\Locators\Registry');
        
        $this->locators = new \PHPixie\Filesystem\Locators(
            $this->builder,
            $this->locatorRegistry
        );
        
        $this->root = $this->quickMock('\PHPixie\Filesystem\Root');
        $this->method($this->builder, 'root', $this->root, array());
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::directory
     * @covers ::<protected>
     */
    public function testDirectory()
    {
        $configData = $this->getTypeConfig('directory');
        
        $locator = $this->locators->directory($configData);
        $this->assertInstance($locator, '\PHPixie\Filesystem\Locators\Locator\Directory', array(
            'root'      => $this->root,
            'directory' => '/fairy',
            'defaultExtension' => 'php'
        ));
    }
    
    /**
     * @covers ::group
     * @covers ::<protected>
     */
    public function testGroup()
    {
        $configData = $this->getTypeConfig('group');
        
        $locator = $this->locators->group($configData);
        $this->assertInstance($locator, '\PHPixie\Filesystem\Locators\Locator\Group', array(
            'locators' => array()
        ));
    }
    
    /**
     * @covers ::prefix
     * @covers ::<protected>
     */
    public function testPrefix()
    {
        $configData = $this->getTypeConfig('prefix');
        
        $locator = $this->locators->prefix($configData);
        $this->assertInstance($locator, '\PHPixie\Filesystem\Locators\Locator\Prefix', array(
            'locators' => array()
        ));
    }
    
    /**
     * @covers ::mount
     * @covers ::<protected>
     */
    public function testMount()
    {
        $configData = $this->getTypeConfig('mount');
        
        $subLocator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
        $this->method($this->locatorRegistry, 'get', $subLocator, array('pixie'), 0);

        $locator = $this->locators->mount($configData);
        $this->assertInstance($locator, '\PHPixie\Filesystem\Locators\Locator\Mount', array(
            'locator' => $subLocator
        ));
        
        $locators = new \PHPixie\Filesystem\Locators($this->builder);
        $this->assertException(function() use($locators, $configData) {
            $locators->mount($configData);
        }, '\PHPixie\Filesystem\Exception');
    }
    
    /**
     * @covers ::buildFromConfig
     * @covers ::<protected>
     */
    public function testBuildFromConfig()
    {
        foreach(array('directory', 'group', 'prefix', 'mount') as $type) {
            $configData = $this->getTypeConfig($type);
            $locator = $this->locators->buildFromConfig($configData);
            $this->assertInstance($locator, '\PHPixie\Filesystem\Locators\Locator\\'.ucfirst($type));
        }
        
        $locators = $this->locators;
        $configData = $this->getTypeConfig('pixie');
        
        $this->assertException(function() use($locators, $configData){
            $locators->buildFromConfig($configData);
        }, '\PHPixie\Filesystem\Exception');
    }
    
    protected function getTypeConfig($type)
    {
        if($type === 'directory') {
            return $this->getConfigData(array(
                'directory' => '/fairy',
                'defaultExtension' => 'php',
                'type' => 'directory'
            ));
        }
        
        if($type === 'group') {
            $locatorsConfig = $this->getConfigData();
            return $this->getConfigData(array(
                'type' => 'group'
            ), $locatorsConfig);
        }
        
        if($type === 'prefix') {
            $locatorsConfig = $this->getConfigData();
            return $this->getConfigData(array(
                'defaultPrefix' => 'default',
                'type' => 'prefix'
            ), $locatorsConfig);
        }
        
        if($type === 'mount') {
            $locatorsConfig = $this->getConfigData();
            return $this->getConfigData(array(
                'name' => 'pixie',
                'type' => 'mount'
            ), $locatorsConfig);
        }
        
        return $this->getConfigData(array(
            'type' => $type
        ));
    }
    
    protected function getConfigData($data = array(), $slice = null, $keys = array())
    {
        $get = function($key) use($data) {
            return $data[$key];
        };
        
        $configData = $this->getData();
        $this->method($configData, 'get', $get);
        $this->method($configData, 'getRequired', $get);
        $this->method($configData, 'slice', $slice);
        $this->method($configData, 'keys', $keys);
        
        return $configData;
    }
    
    protected function getData()
    {
        return $this->abstractMock('\PHPixie\Slice\Data');
    }
}