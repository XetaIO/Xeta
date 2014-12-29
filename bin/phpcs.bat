@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/squizlabs/php_codesniffer/scripts/phpcs
php "%BIN_TARGET%" %*
