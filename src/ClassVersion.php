<?php

declare(strict_types=1);

namespace Jardis\Version;

use Jardis\Version\config\ClassVersionConfigInterface;
use Jardis\Version\query\ClassFinderInterface;

/**
 * Returns the classVersion of a given class with version
 */
class ClassVersion implements ClassVersionInterface
{
    private ClassVersionConfigInterface $versionConfig;

    /** @var array<class-string, ClassFinderInterface> */
    private array $versionFinder = [];

    public function __construct(ClassVersionConfigInterface $versionConfig)
    {
        $this->versionConfig = $versionConfig;
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @param ?string $version
     * @return string|T
     */
    public function __invoke(string $className, ?string $version = null)
    {
        $versionConfigKey = $this->versionConfig->versionKey($version);

        /** @var ClassFinderInterface $versionFinder */
        foreach ($this->versionFinder as $versionFinder) {
            $classVersion = $versionFinder($className, $versionConfigKey);
            if ($classVersion) {
                return $classVersion;
            }
        }

        return $className;
    }

    public function addFinder(ClassFinderInterface $versionFinder, bool $onTop = true): self
    {
        $versionFinderClass = get_class($versionFinder);
        if (!array_key_exists($versionFinderClass, $this->versionFinder)) {
            $this->versionFinder = $onTop
                ? array_merge([$versionFinderClass => $versionFinder], $this->versionFinder)
                : array_merge($this->versionFinder, [$versionFinderClass => $versionFinder]);
        }

        return $this;
    }

    public function removeFinder(ClassFinderInterface $versionFinder): self
    {
        $versionFinder = get_class($versionFinder);
        if (array_key_exists($versionFinder, $this->versionFinder)) {
            unset($this->versionFinder[$versionFinder]);
        }

        return $this;
    }

    /** @return array<class-string, ClassFinderInterface> */
    public function getVersionFinder(): array
    {
        return $this->versionFinder;
    }
}
