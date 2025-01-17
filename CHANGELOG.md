# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v1.1.0] - 2023-08-14

### Added
- Explicit PHP version requirement, including support for PHP versions 8.1 and 8.2

## [Earlier Releases]

Releases up to and including v1.0.0 predate this changelog, but see the [README](README.md) for summary of functionality.

## 2025-01-17

### Added
- Converted PHPUnit test to Kahlan.

### Changed
- Replace `WP_MOCK` with `allow()` and `expect()`, following Kahlan's idiomatic approach
- Updated dependencies in `composer.json` to remove `phpunit/phpunit` and `10up/wp_mock`.
- Update the CI workflow in `continuos-integrasion.yml` to support Kahlan testing.