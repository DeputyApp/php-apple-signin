# Makefile at the root of your project

PHP8_IMAGE=php-apple-signin-php8
PHP74_IMAGE=php-apple-signin-php74
DOCKER_RUN=docker-compose -f docker-compose.yml run --build --rm

php8.code.analysis: ; $(info Running PHP8 code analysis...) @
	@$(DOCKER_RUN) $(PHP8_IMAGE) bash -c '\
		php -v && \
		echo "→ Running Phan..." && \
		vendor/bin/phan --config-file=tools/phan.config.php || true && \
		echo "→ Running PHPCS..." && \
		vendor/bin/phpcs -p src/ tests/ --standard=vendor/phpcompatibility/php-compatibility/PHPCompatibility --runtime-set testVersion 8.4 || true && \
		echo -e "\033[33m️Automated tools may miss to flag some compatibility issues. Manual checks may still be required. Stay diligent!\033[0m"'

php8.code.rector-dry: ; $(info Running Rector (dry run) on PHP8...) @
	@$(DOCKER_RUN) $(PHP8_IMAGE) bash -c '\
		echo -e "→ Rector Dry Run..." && \
		vendor/bin/rector --config tools/rector.config.php --dry-run || true && \
		echo -e "\033[33m️Rector helps with syntax updates mostly, not detect and fix all PHP compatibility issues. Manual checks may still be required. Stay diligent!\033[0m"'

php8.test: ; $(info Running tests on PHP8...) @
	@$(DOCKER_RUN) $(PHP8_IMAGE) bash -c 'php -v && echo "→ Running PHPUnit..." && vendor/bin/phpunit'

php74.test: ; $(info Running tests on PHP7.4...) @
	@$(DOCKER_RUN) $(PHP74_IMAGE) bash -c 'php -v && echo "→ Running PHPUnit..." && vendor/bin/phpunit'
