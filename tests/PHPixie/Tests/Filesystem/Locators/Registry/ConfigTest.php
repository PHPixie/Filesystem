<?php

namespace PHPixie\Tests\Filesystem\Locators\Registry;

/**
 * @coversDefaultClass \PHPixie\Filesystem\Locators\Registry\Config
 */
class ConfigTest extends \PHPixie\Test\Testcase
{
    protected $locatorBuilder;
    protected $configData;
    
    protected $config;
    
    public function setUp()
    {
        $this->locatorBuilder    = $this->quickMock('\PHPixie\Filesystem\Locators\Builder');
        $this->configData = $this->getData();
        
        $this->config = new \PHPixie\Filesystem\Locators\Registry\Config(
            $this->locatorBuilder,
            $this->configData
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
     * @covers ::get
     * @covers ::<protected>
     */
    public function testGet()
    {
        $locatorConfig = $this->getData();
        $this->method($this->configData, 'slice', $locatorConfig, array('pixie'), 0);
        
        $locator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
        $this->method($this->locatorBuilder, 'buildFromConfig', $locator, array($locatorConfig), 0);
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($locator, $this->config->get('pixie'));
        }
    }
    
    protected function getData()
    {
        return $this->quickMock('\PHPixie\Slice\Data');
    }
}