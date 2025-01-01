<?php

declare(strict_types=1);

namespace Jardis\Version\config;

use InvalidArgumentException;

/**
 * Returns the versionConfigKey of the given version
 */
class ClassVersionConfig implements ClassVersionConfigInterface
{
    /** @var array<string, array<string>> */
    private array $version;

    /**
     * @param array<string, array<string>> $version
     * @throws InvalidArgumentException
     */
    public function __construct(array $version = [])
    {
        $this->version = $this->validate($version);
    }

    public function versionKey(?string $version = null): string
    {
        if ($version) {
            foreach ($this->version as $versionConfigKey => $versions) {
                if (in_array($version, $versions)) {
                    return $versionConfigKey;
                }
            }
        }

        return '';
    }

    /**
     * @param array<string, array<string>> $versions
     * @throws InvalidArgumentException
     * @return array<string, array<string>>
     */
    protected function validate(array $versions): array
    {
        if (!empty($versions)) {
            foreach ($versions as $key => $version) {
                /** @phpstan-ignore-next-line */
                if (!is_string($key) || !is_array($version)) {
                    throw new InvalidArgumentException(
                        'Parameter must be an assoc array (key = string and value = array)'
                    );
                }
            }
        }

        return $versions;
    }
}
