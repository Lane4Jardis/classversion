<?php

namespace Jardis\Version\Tests\unit\config;

use Jardis\Version\config\ClassVersionConfig;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class ClassVersionConfigTest extends TestCase
{
    public function testConstructorWithValidArray(): void
    {
        $versions = [
            'v1' => ['1.0', '1.1'],
            'v2' => ['2.0', '2.1'],
        ];

        $config = new ClassVersionConfig($versions);

        $this->assertInstanceOf(ClassVersionConfig::class, $config);
    }

    public function testConstructorThrowsExceptionOnInvalidArray(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $invalidVersions = [
            123 => ['1.0', '1.1'],
        ];

        new ClassVersionConfig($invalidVersions);
    }

    public function testVersionKeyReturnsCorrectKey(): void
    {
        $versions = [
            'v1' => ['1.0', '1.1'],
            'v2' => ['2.0', '2.1'],
        ];

        $config = new ClassVersionConfig($versions);

        $this->assertEquals('v1', $config->versionKey('1.0'));
        $this->assertEquals('v1', $config->versionKey('1.1'));
        $this->assertEquals('v2', $config->versionKey('2.0'));
        $this->assertEquals('v2', $config->versionKey('2.1'));
    }

    public function testVersionKeyReturnsEmptyStringWhenVersionNotFound(): void
    {
        $versions = [
            'v1' => ['1.0', '1.1'],
        ];

        $config = new ClassVersionConfig($versions);

        $this->assertEquals('', $config->versionKey('2.0'));
    }

    public function testVersionKeyReturnsEmptyStringWhenVersionIsNull(): void
    {
        $versions = [
            'v1' => ['1.0', '1.1'],
        ];

        $config = new ClassVersionConfig($versions);

        $this->assertEquals('', $config->versionKey(null));
    }

}
