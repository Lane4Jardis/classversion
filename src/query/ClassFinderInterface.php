<?php

declare(strict_types=1);

namespace Jardis\Version\query;

use InvalidArgumentException;

interface ClassFinderInterface
{
    /**
     * @template T
     * @param class-string<T> $className
     * @param ?string $versionConfigKey
     * @return string|T
     * @throws InvalidArgumentException
     */
    public function __invoke(string $className, ?string $versionConfigKey = null);
}
