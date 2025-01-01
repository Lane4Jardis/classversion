<?php

namespace Jardis\Version\Tests\unit;

use Jardis\Version\ClassVersion;
use Jardis\Version\config\ClassVersionConfig;
use Jardis\Version\query\GetClassFromDirectory;
use Jardis\Version\query\GetProxyFromCache;
use Jardis\Version\Tests\fixtures\VersionClass;
use PHPUnit\Framework\TestCase;

class ClassVersionTest extends TestCase
{
    public function testReturnsClassNameWhenNoFinderExists(): void
    {
        $classVersionConfig = new ClassVersionConfig(['v1'=>[1.0]]);
        $classVersion = new ClassVersion($classVersionConfig);

        $result = $classVersion(VersionClass::class);

        $this->assertSame(VersionClass::class, $result);
    }

    public function testReturnsClassVersionWhenFinderMatches(): void
    {
        $classVersionConfig = new ClassVersionConfig(['v1'=>[1.0]]);
        $classVersion = new ClassVersion($classVersionConfig);
        $classVersion->addFinder(new GetClassFromDirectory());

        $result = $classVersion(VersionClass::class);
        $this->assertSame(VersionClass::class, $result);

        $result = $classVersion(VersionClass::class, '1.0');
        $this->assertSame(\Jardis\Version\Tests\fixtures\v1\VersionClass::class, $result);
    }

    public function testAddFinderAddsFinderToTop(): void
    {
        $classVersionConfig = new ClassVersionConfig(['v1'=>[1.0]]);
        $classVersion = new ClassVersion($classVersionConfig);

        $classVersion->addFinder(new GetClassFromDirectory());
        $classVersion->addFinder(new GetProxyFromCache());

        $result = $classVersion->getVersionFinder();

        $this->assertSame(GetProxyFromCache::class, array_key_first($result));
    }

    public function testAddFinderAddsFinderToBottom(): void
    {
        $classVersionConfig = new ClassVersionConfig(['v1'=>[1.0]]);
        $classVersion = new ClassVersion($classVersionConfig);

        $classVersion->addFinder(new GetClassFromDirectory());
        $classVersion->addFinder(new GetProxyFromCache(), false);

        $result = $classVersion->getVersionFinder();

        $this->assertSame(GetClassFromDirectory::class, array_key_first($result));
    }

    public function testAddFindersGetClassFromProxy(): void
    {
        $classVersionConfig = new ClassVersionConfig(['v1'=>[1.0]]);
        $classVersion = new ClassVersion($classVersionConfig);

        $proxy = new GetProxyFromCache();
        $proxy->addProxy(VersionClass::class, new \stdClass());

        $classVersion->addFinder(new GetClassFromDirectory());
        $classVersion->addFinder($proxy);

        $result = $classVersion(VersionClass::class);

        $this->assertInstanceOf(\stdClass::class, $result);
    }

    public function testRemoveFinderCorrectlyRemovesFinder(): void
    {
        $classVersionConfig = new ClassVersionConfig(['v1'=>[1.0]]);
        $classVersion = new ClassVersion($classVersionConfig);
        $classVersion->addFinder(new GetClassFromDirectory());

        $finder = $classVersion->getVersionFinder()[GetClassFromDirectory::class];
        $classVersion->removeFinder($finder);

        $this->assertEmpty($classVersion->getVersionFinder());
    }
}
