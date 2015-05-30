<?php

namespace PHPixie\Tests\Filesystem\Locators\Locator;

/**
 * @coversDefaultClass \PHPixie\Filesystem\Locators\Locator\Mount
 */
class MountTest extends \PHPixie\Test\Testcase
{
    protected $locatorRegistry;
    protected $configData;
    
    protected $locator;
    
    protected $name = 'pixie';
    protected $subLocator;
    
    public function setUp()
    {
        $this->locatorRegistry = $this->quickMock('\PHPixie\Filesystem\Locators\Registry');
        
        $this->configData = $this->quickMock('\PHPixie\Slice\Data');
        $this->method($this->configData, 'getRequired', $this->name, array('name'), 0);
        
        $this->subLocator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
        $this->method($this->locatorRegistry, 'get', $this->subLocator, array($this->name), 0);
        
        $this->locator = new \PHPixie\Filesystem\Locators\Locator\Mount(
            $this->locatorRegistry,
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
     * @covers ::locate
     * @covers ::<protected>
     */
    public function testLocate()
    {
        $this->method($this->subLocator, 'locate', 'trixie.php', array('pixie'), 0);
        $this->assertSame('trixie.php', $this->locator->locate('pixie'));
    }
}