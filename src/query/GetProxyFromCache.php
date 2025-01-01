<?php

declare(strict_types=1);

namespace Jardis\Version\query;

/**
 * Returns a proxy object for a given classname (string) and version
 */
class GetProxyFromCache implements ClassFinderInterface
{
    /** @var array<string, array<string, object>> */
    private array $cachedProxy = [];

    /**
     * @param string $className
     * @param ?string $versionConfigKey
     * @return object|null
     */
    public function __invoke(string $className, ?string $versionConfigKey = null)
    {
        $versionConfigKey = trim($versionConfigKey ?? '');
        return array_key_exists($versionConfigKey, $this->cachedProxy)
            ? ($this->cachedProxy[$versionConfigKey][$className] ?? null)
            : null;
    }

    public function addProxy(string $className, object $proxy, ?string $versionConfigKey = null): self
    {
        $versionConfigKey = trim($versionConfigKey ?? '');
        $this->cachedProxy[$versionConfigKey][$className] = $proxy;

        return $this;
    }

    public function removeProxy(string $className, ?string $versionConfigKey = null): self
    {
        $versionConfigKey = trim($versionConfigKey ?? '');

        if (array_key_exists($versionConfigKey, $this->cachedProxy)) {
            unset($this->cachedProxy[$versionConfigKey][$className]);
        }

        return $this;
    }
}
