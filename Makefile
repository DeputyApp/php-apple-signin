# Makefile at the root of your project

php8.code.analysis: ; $(info $(M) Running code analysis for PHP8 with Phan) @
	@docker-compose -f docker-compose.yml run --build --rm php-apple-signin-php8 bash -c "\
		php -v && \
        echo -e 'Running Phan...' && \
		vendor/bin/phan --config-file=tools/phan.config.php || true && \
		echo -e 'Running PHPCS...' && \
		vendor/bin/phpcs -p src/ tests/ --standard=vendor/phpcompatibility/php-compatibility/PHPCompatibility --runtime-set testVersion 8.4 || true && \
		echo -e '\033[33mThe code analysis tool we use will not catch all PHP 8 deprecations and backward incompatibilities.\033[0m' && \
		echo -e '\033[33mPlease perform manual checks as well to ensure full compatibility. Ensure tests are passing in the target PHP version. Stay diligent!\033[0m'"

php8.code.rector-dry: ; $(info $(M) Running Rector in Dry Run mode for PHP8) @
	@docker-compose -f docker-compose.yml run --build --rm php-apple-signin-php8 bash -c "\
	echo -e '\033[33mRunning Rector in Dry Run mode.\nNote: Rector is not designed to catch all PHP 8 backward incompatibilities.\033[0m' && \
    echo -e '\033[33mIt mainly suggests to refactor to new syntax and flags deprecated features. Use accordingly!\033[0m' && \
	vendor/bin/rector --config tools/rector.config.php --dry-run"

php8.test: ; $(info $(M) Running test in PHP8 environment) @
	@docker-compose -f docker-compose.yml run --build --rm php-apple-signin-php8 bash -c "php -v && echo 'Running PHPUnit...' && vendor/bin/phpunit"

php74.test: ; $(info $(M) Running test in PHP7.4 environment) @
	@docker-compose -f docker-compose.yml run --build --rm php-apple-signin-php74 bash -c "php -v && echo 'Running PHPUnit...' && vendor/bin/phpunit"



