<?php

declare(strict_types=1);

namespace Jardis\Version\query;

use InvalidArgumentException;

/**
 * Returns the classVersion of a given class from directory
 */
class GetClassFromDirectory implements ClassFinderInterface
{
    /**
     * @template T
     * @param class-string<T> $className
     * @param ?string $versionConfigKey
     * @return string|T
     * @throws InvalidArgumentException
     */
    public function __invoke(string $className, ?string $versionConfigKey = null)
    {
        $versionConfigKey = trim($versionConfigKey ?? '');
        $class = $className;

        if (!empty($versionConfigKey)) {
            $pos = str_contains($className, '\\') ? strrpos($className, '\\') + 1 : 0;
            $class = substr($className, 0, $pos) . trim($versionConfigKey) . '\\' . substr($className, $pos);
        }

        if ($versionConfigKey && class_exists($class)) {
            return $class;
        }

        if (class_exists($className)) {
            return $className;
        }


        throw new InvalidArgumentException(sprintf('Given class %s not found', $className));
    }
}
