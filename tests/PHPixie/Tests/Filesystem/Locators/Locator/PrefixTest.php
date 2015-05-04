<?php

namespace PHPixie\Tests\Filesystem\Locators\Locator;

/**
 * @coversDefaultClass \PHPixie\Filesystem\Locators\Locator\Prefix
 */
class PrefixTest extends \PHPixie\Test\Testcase
{
    protected $resolverBuilder;
    protected $configData;
    
    protected $resolver;
    
    protected $defaultPrefix = 'default';
    protected $resolvers;
    
    public function setUp()
    {
        $this->configData = $this->getData();
        $this->resolverBuilder = $this->quickMock('\PHPixie\Filesystem\Locators');
        
        $this->method($this->configData, 'get', $this->defaultPrefix, array('defaultPrefix', 'default'), 0);
        
        $resolversConfig = $this->getData();
        $this->method($this->configData, 'slice', $resolversConfig, array('locators'), 1);
        
        $this->resolvers = array(
            'default' => $this->abstractMock('\PHPixie\Filesystem\Locators\Locator'),
            'second'  => $this->abstractMock('\PHPixie\Filesystem\Locators\Locator'),
        );
        $this->method($resolversConfig, 'keys', array_keys($this->resolvers), array(null, true), 0);
        
        $i=0;
        
        foreach($this->resolvers as $key => $resolver) {
            $resolverConfig = $this->getData();
            
            $this->method($resolversConfig, 'slice', $resolverConfig, array($key), $i+1);
            $this->method($this->resolverBuilder, 'buildFromConfig', $resolver, array($resolverConfig), $i);
            
            $i++;
        }
        
        $this->resolver = new \PHPixie\Filesystem\Locators\Locator\Prefix(
            $this->resolverBuilder,
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
        $this->method($this->resolvers['second'], 'locate', 'pixie', array('fairy'), 0);
        $this->assertSame('pixie', $this->resolver->locate('second:fairy'));
        
        $this->method($this->resolvers['default'], 'locate', 'pixie', array('fairy'), 0);
        $this->assertSame('pixie', $this->resolver->locate('fairy'));
    }
    
    protected function getData()
    {
        return $this->abstractMock('\PHPixie\Slice\Data');
    }
}