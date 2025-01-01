<?php

declare(strict_types=1);

namespace Jardis\Version;

use Jardis\Version\query\ClassFinderInterface;

interface ClassVersionInterface
{
    /**
     * @template T
     * @param class-string<T> $className
     * @param ?string $version
     * @return string|T
     */
    public function __invoke(string $className, ?string $version = null);

    public function addFinder(ClassFinderInterface $versionFinder, bool $onTop = true): self;

    public function removeFinder(ClassFinderInterface $versionFinder): self;

    /** @return array<class-string, ClassFinderInterface> */
    public function getVersionFinder(): array;
}
