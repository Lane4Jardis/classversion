<?php

namespace Jardis\Version\Tests\unit\query;

use Jardis\Version\query\GetProxyFromCache;
use PHPUnit\Framework\TestCase;

class GetProxyFromCacheTest extends TestCase
{
    private GetProxyFromCache $cache;

    protected function setUp(): void
    {
        $this->cache = new GetProxyFromCache();
    }

    public function testReturnsNullWhenProxyDoesNotExist(): void
    {
        $result = ($this->cache)('NonExistentClass', 'versionKey');
        $this->assertNull($result);
    }

    public function testReturnsProxyWhenItExists(): void
    {
        $proxyObject = new \stdClass();
        $this->cache->addProxy('TestClass', $proxyObject, 'versionKey');

        $result = ($this->cache)('TestClass', 'versionKey');
        $this->assertSame($proxyObject, $result);
    }

    public function testAddProxyStoresProxyCorrectly(): void
    {
        $proxyObject = new \stdClass();
        $this->cache->addProxy('TestClass', $proxyObject, 'versionKey');

        $storedProxy = ($this->cache)('TestClass', 'versionKey');
        $this->assertInstanceOf(\stdClass::class, $storedProxy);
        $this->assertSame($proxyObject, $storedProxy);
    }

    public function testAddProxyHandlesEmptyVersionConfigKey(): void
    {
        $proxyObject = new \stdClass();
        $this->cache->addProxy('TestClass', $proxyObject);

        $storedProxy = ($this->cache)('TestClass');
        $this->assertSame($proxyObject, $storedProxy);
    }

    public function testRemoveProxyDeletesProxySuccessfully(): void
    {
        $proxyObject = new \stdClass();
        $this->cache->addProxy('TestClass', $proxyObject, 'versionKey');

        // Verify that the proxy is added
        $this->assertSame($proxyObject, ($this->cache)('TestClass', 'versionKey'));

        // Remove the proxy
        $this->cache->removeProxy('TestClass', 'versionKey');

        // Verify that the proxy is removed
        $this->assertNull(($this->cache)('TestClass', 'versionKey'));
    }

    public function testRemoveProxyHandlesEmptyVersionConfigKey(): void
    {
        $proxyObject = new \stdClass();
        $this->cache->addProxy('TestClass', $proxyObject);

        // Verify that the proxy is added
        $this->assertSame($proxyObject, ($this->cache)('TestClass'));

        // Remove the proxy using an empty versionConfigKey
        $this->cache->removeProxy('TestClass');

        // Verify that the proxy is removed
        $this->assertNull(($this->cache)('TestClass'));
    }

    public function testAddProxyOverwritesExistingProxy(): void
    {
        $firstProxy = new \stdClass();
        $secondProxy = new \stdClass();

        // Add the first proxy
        $this->cache->addProxy('TestClass', $firstProxy, 'versionKey');

        // Overwrite with the second proxy
        $this->cache->addProxy('TestClass', $secondProxy, 'versionKey');

        // Verify that the second proxy is stored
        $this->assertSame($secondProxy, ($this->cache)('TestClass', 'versionKey'));
    }

    public function testRemoveProxyDoesNothingIfProxyDoesNotExist(): void
    {
        // Attempt to remove a non-existing proxy
        $this->cache->removeProxy('NonExistentClass', 'versionKey');

        // Verify that no error occurs and nothing exists in the cache
        $result = ($this->cache)('NonExistentClass', 'versionKey');
        $this->assertNull($result);
    }

}
