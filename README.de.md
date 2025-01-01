# Jardis ClassVersion
![Build Status](https://github.com/lane4jardis/classversion/actions/workflows/ci.yml/badge.svg)

### ClassVersion ermöglicht das Laden gleichnamiger Klassen aus spezifischen Unterverzeichnissen, die jeweiligen Versionsbezeichnungen zugeordnet sind.

## Beschreibung zum Beispiel Code
Dieser Code implementiert ein dynamisches Ladesystem für Klassen, das es ermöglicht, verschiedene Versionen einer Klasse aus entsprechenden Unterverzeichnissen zu laden. Die Hauptfunktionalität wird durch die Klassen ClassVersion und ClassVersionConfig bereitgestellt. Hier ist eine Beschreibung der einzelnen Schritte:
1.	Konfiguration der Klassen-Versionen:
- Die Variable $classVersions definiert eine Zuordnung von Unterverzeichnissen (subDirectory) zu den verfügbaren Versionsbezeichnungen (version1, version2).
2.	Initialisierung der Konfiguration:
- Ein ClassVersionConfig-Objekt wird erstellt und mit der Versionskonfiguration $classVersions initialisiert.
3.	Instanz von ClassVersion:
- Eine Instanz von ClassVersion wird erstellt, die mit der zuvor definierten Konfiguration arbeitet.
4.	Laden von Klassen:
- ClassVersion ermöglicht das Laden von Klassen in verschiedenen Versionen:
- `$classVersion(YourClass::class)`: Lädt die Standardversion der Klasse YourClass.
- `$classVersion(YourClass::class, 'version1')`: Lädt die Version version1 der Klasse YourClass.
- `$classVersion(YourClass::class, 'version2')`: Lädt die Version version2 der Klasse YourClass.

Nutzen des Codes

Mit diesem Ansatz können verschiedene Versionen einer Klasse dynamisch geladen werden, ohne die Implementierungen direkt im Code zu referenzieren. Dies ist besonders nützlich in Projekten, die Versionierung benötigen, z. B. bei API-Versionen oder experimentellen Implementierungen von Klassen.


## Beispielcode

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

## Quickstart composer

```bash
composer require jardis/classversion
make install
```

## Quickstart github

```bash
git clone https://github.com/Land4Jardis/classversion.git
cd classversion
```

---

## Lieferumfang im Github Repository

- **SourceFile**: 
  - src
  - tests
- **Support**: 
  - Docker Compose
  - .env
  - pre-commit-hook.sh
  - `Makefile` Einfach `make` in der Konsole aufrufen
- **Dokumentation**:
  - README.md

Der Aufbau des DockerFiles zum erstellen des PHP Images ist etwas umfänglicher gebaut als es für dieses Tool notwendig ist, da das resultierende PHP Image in verschiedenen Lane4 Tools eingesetzt wird.

[![Docker Image Version](https://img.shields.io/docker/v/lane4jardis/phpcli?sort=semver)](https://hub.docker.com/r/lane4jardis/phpcli)

Es wird auch darauf geachtet, das unsere Images so klein wie möglich sind und auf eurem System durch ggf. wiederholtes bauen der Images keine unnötigen Dateien verbleiben.

---

### Unsere Leitsätze:
#### Lieferung sehr hoher Softwarequalität
- Analysierbarkeit
- Anpassbarkeit
- Erweiterbarkeit
- Modularität
- Wartbarkeit
- Testbarkeit
- Skalierbarkeit
- Hohe Performance


Viel Freude bei der Nutzung!
