# Jardis ClassVersion
![Build Status](https://github.com/lane4jardis/classversion/actions/workflows/ci.yml/badge.svg)

### ClassVersion enables loading classes with the same name from specific subdirectories associated with respective version labels.

## Description for example code
This code implements a dynamic loading system for classes, allowing different versions of a class to be loaded from corresponding subdirectories. The main functionality is provided by the ClassVersion and ClassVersionConfig classes. Here is a step-by-step explanation:
1.	Class Version Configuration:
      - The `$classVersions` variable defines a mapping of subdirectories (`subDirectory`) to available version labels (`version1`, `version2`).
2.	Configuration Initialization:
      - A `ClassVersionConfig` object is created and initialized with the version configuration `$classVersions`.
3.	ClassVersion Instance:
      - An instance of `ClassVersion` is created, working with the previously defined configuration.
4.	Loading Classes:
      - `ClassVersion` enables loading classes in different versions:
  - `$classVersion(YourClass::class)`: Loads the default version of the class `YourClass`.
  - `$classVersion(YourClass::class, 'version1')`: Loads version `version1` of the class `YourClass`.
  - `$classVersion(YourClass::class, 'version2')`: Loads version `version2` of the class `YourClass`.

### Code Benefits

This approach allows different versions of a class to be dynamically loaded without directly referencing the implementations in the code. This is particularly useful in projects that require versioning, such as API versions or experimental implementations of classes.

## Example Code

```php
use Jardis\Version\ClassVersion;
use Jardis\Version\config\ClassVersionConfig;

$classVersions = ['subDirectory' => ['version1', 'version2']];
$classVersionConfig = new ClassVersionConfig($classVersions);
$classVersion = new ClassVersion($classVersionConfig);

$class = $classVersion(YourClass::class)
$class1 = $classVersion(YourClass::class, 'version1')
$class2 = $classVersion(YourClass::class, 'version2')
```

## Quickstart Composer

```bash
composer require jardis/classversion
make install
```

## Quickstart GitHub

```bash
git clone https://github.com/lane4jardis/classversion.git
cd classversion
```

---

## GitHub Repository Contents

- **Source Files**:
  - `src`
  - `tests`
- **Support**:
  - Docker Compose
  - `.env`
  - `pre-commit-hook.sh`
  - `Makefile`: Simply run `make` in the terminal.
- **Documentation**:
  - `README.md`

The structure of the `Dockerfile` for building the PHP image is more comprehensive than necessary for this tool, as the resulting PHP image is used in various Lane4 tools.

[![Docker Image Version](https://img.shields.io/docker/v/lane4jardis/phpcli?sort=semver)](https://hub.docker.com/r/lane4jardis/phpcli)

We also ensure that our images are as small as possible and that no unnecessary files remain on your system during repeated builds.

---

### Our Principles:
#### Delivery of very high software quality
- Analyzability
- Adaptability
- Extensibility
- Modularity
- Maintainability
- Testability
- Scalability
- High performance

Enjoy using it!
