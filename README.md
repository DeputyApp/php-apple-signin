php-apple-signin
=======
PHP library to manage Sign In with Apple identifier tokens, and validate them server side passed through by the iOS client.

Installation
------------

Use composer to manage your dependencies and download php-apple-signin:

```bash
composer require griffinledingham/php-apple-signin
```

Example
-------
```php
```php
<?php
use AppleSignIn\Decoder;

$clientUser = "example_client_user";
$identityToken = "example_encoded_jwt";

$appleSignInPayload = ASDecoder::getAppleSignInPayload($identityToken);

/**
 * Obtain the Sign In with Apple email and user creds.
 */
$email = $appleSignInPayload->getEmail();
$user = $appleSignInPayload->getUser();

/**
 * Determine whether the client-provided user is valid.
 */
$isValid = $appleSignInPayload->verifyUser($clientUser);

?>
```

# PHP Upgrade

There is a provided set of `Makefile` commands to assist with upgrading between PHP versions (e.g. from PHP 7.4 to PHP 8.4, or future versions). These commands help you test, analyze, and refactor code using Dockerized tools in multiple PHP environments.

While these tools automate much of the upgrade process, they do **not replace manual review**. Please use them as a guide, and always validate behavior through tests and code inspection.


---

## 🧪 Testing on PHP 7.4 and PHP 8.4

We use two isolated environments to run tests on both PHP versions to catch any behavioral changes early.

### Run tests in PHP 7.4:
```bash
make php74.test
```
- Runs PHPUnit inside a PHP 7.4 container.
- Verifies existing behavior is preserved.

### Run tests in PHP 8.4:
```bash
make php8.test
```
- Runs PHPUnit inside a PHP 8.4 container.
- Ensures the codebase remains functional after the upgrade.

> ✅ **Tip**: Always ensure your code passes tests in both environments before considering a migration complete.

---

## 🔍 Static Code Analysis (PHP 8.4)

To help identify compatibility issues and deprecated usages, we use **Phan** and **PHPCS**.

### Run analysis tools:
```bash
make php8.code.analysis
```

- **Phan**: Performs static analysis to detect type and compatibility issues.
- **PHPCS**: Runs PHPCompatibility checks targeting PHP 8.4.

> ⚠️ These tools do **not catch 100%** of PHP 8 incompatibilities or deprecations.  
> You **must still manually review** any risk areas, especially dynamic features or runtime edge cases.

---

## 🛠️ Rector Refactoring Suggestions (Dry Run)

Rector provides suggestions for upgrading your code to PHP 8 syntax and best practices.

### Run Rector in dry-run mode:
```bash
make php8.code.rector-dry
```

- Suggests PHP 8-specific syntax upgrades.
- Flags deprecated usage where possible.
- **Dry-run mode** means no files are actually changed.

> 🧠 Use these suggestions to guide your refactors, but manually verify correctness.

---

## 💡 Why this setup?

This toolset enables safer and more maintainable PHP upgrades:
- Quickly detect what breaks in PHP 8.
- Compare behavior across PHP 7.4 and PHP 8.4.
- See static issues early.
- Get syntax upgrade suggestions.
- Avoid surprises during CI, QA, or release.

---

## ✅ Developer Checklist

- [ ] Run `make php74.test` and confirm tests pass
- [ ] Run `make php8.test` and confirm tests pass
- [ ] Run `make php8.code.analysis` and review all warnings
- [ ] Run `make php8.code.rector-dry` and consider suggested upgrades
- [ ] Perform **manual** review of edge cases and tricky logic


# FAQ

[FAQ](doc/faq.md)
