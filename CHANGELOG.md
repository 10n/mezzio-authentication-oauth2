# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 0.3.1 - 2018-02-28

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-expressive-authentication-oauth2#18](https://github.com/zendframework/zend-expressive-authentication-oauth2/pull/18)
  updates the default SQL shipped with the package in `data/oauth2.sql` for
  generating OAuth2 tables to ensure it works with MySQL 5.7+; the SQL will
  still work with older versions, as well as other relational databases.

## 0.3.0 - 2018-02-07

### Added

- [zendframework/zend-expressive-authentication-oauth2#11](https://github.com/zendframework/zend-expressive-authentication-oauth2/pull/11)
  adds support for mezzio-authentication 0.3.0.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.2.1 - 2017-12-11

### Added

- [zendframework/zend-expressive-authentication-oauth2#1](https://github.com/zendframework/zend-expressive-authentication-oauth2/pull/1)
  adds support for providing configuration for the cryptographic key. This may
  be done by providing any of the following via the `authentication.private_key`
  configuration:

  - A string representing the key.
  - An array with the following key/value pairs:
    - `key_or_path` representing either the key or a path on the filesystem to a key.
    - `pass_phrase` with the pass phrase to use with the key, if needed.
    - `key_permissions_check`, a boolean for indicating whether or not to verify
      permissions of the key file before attempting to load it.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.2.0 - 2017-11-28

### Added

- Adds support for mezzio-authentication 0.2.0.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Removes support for mezzio-authentication 0.1.0.

### Fixed

- Nothing.

## 0.1.0 - 2017-11-20

Initial release.

### Added

- Everything.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
