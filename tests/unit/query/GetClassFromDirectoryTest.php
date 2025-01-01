<?php

namespace Jardis\Version\Tests\unit\query;

use Jardis\Version\query\GetClassFromDirectory;
use Jardis\Version\Tests\fixtures\VersionClass;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class GetClassFromDirectoryTest extends TestCase
{
    private GetClassFromDirectory $classFinder;

    protected function setUp(): void
    {
        $this->classFinder = new GetClassFromDirectory();
    }

    public function testReturnsClassNameIfClassExists(): void
    {
        $result = ($this->classFinder)(VersionClass::class);

        $this->assertSame(VersionClass::class, $result);
    }

    public function testReturnsClassVersionIfClassExists(): void
    {
        $result = ($this->classFinder)(VersionClass::class, 'v1');

        $this->assertSame(\Jardis\Version\Tests\fixtures\v1\VersionClass::class, $result);

        $result = ($this->classFinder)(VersionClass::class, 'v2');

        $this->assertSame(\Jardis\Version\Tests\fixtures\v2\VersionClass::class, $result);
    }

    public function testInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ($this->classFinder)("VersionClass::class", '');
    }
}
