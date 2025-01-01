<?php

declare(strict_types=1);

namespace Jardis\Version\config;

interface ClassVersionConfigInterface
{
    public function versionKey(?string $version = null): string;
}
