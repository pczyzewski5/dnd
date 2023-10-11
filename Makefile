PHPCLI=docker-compose run --rm php-upstream
MYSQL_LOG_FILE=/var/lib/mysql/general_log.log

##################################################################################################################
# MAIN
##################################################################################################################

start: stop up

stop:
	docker-compose stop
	docker-compose rm -f -v

up:
	docker-compose up -d --remove-orphans


build: build_local_clear build_docker_php
	docker-compose down --remove-orphans -v

build_local_clear:
	rm -rf var/cache/*
	echo $(CI_BUILD_REF) > .revision

build_docker_php:
	docker-compose build
	$(PHPCLI) composer install --optimize-autoloader --ignore-platform-reqs
	$(PHPCLI) php bin/console cache:clear
	$(PHPCLI) php bin/console cache:warmup

cli-php:
	$(PHPCLI) bash

##################################################################################################################
# TESTS
##################################################################################################################

tests: start quick-tests
	docker-compose stop
	docker-compose rm -f -v

quick-tests:
	docker-compose run --rm php-upstream php ./bin/phpunit

dev-quick-tests:
	docker-compose run --rm php-upstream php ./bin/phpunit --group=dev

##################################################################################################################
# COMMANDS
##################################################################################################################

create-character-card:
	docker-compose run --rm php-upstream php ./bin/console dnd:create-character-card