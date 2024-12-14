##################################################################################################################
# MAIN
##################################################################################################################

start: build init-db init-test-db
	docker-compose up -d

stop:
	docker-compose stop

build:
	rm -rf var/cache/*
	docker-compose down -v --remove-orphans
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install --optimize-autoloader --ignore-platform-reqs
	docker-compose exec php php bin/console cache:clear
	docker-compose exec php php bin/console cache:warmup
	docker-compose ps
	sleep 20

php-cli:
	docker-compose exec php bash

##################################################################################################################
# TESTS
##################################################################################################################

dev-test:
	docker-compose exec php php ./vendor/phpunit/phpunit/phpunit --group=dev

##################################################################################################################
# MYSQL
##################################################################################################################

init-db:
	docker-compose exec -T mysql mysql -u root -proot -e 'SET GLOBAL general_log_file = "/var/lib/mysql/general_log.log";'
	docker-compose exec -T mysql mysql -u root -proot -e 'SET GLOBAL general_log = "ON";'
	docker-compose exec php ./bin/console doctrine:cache:clear-metadata
	docker-compose exec php ./bin/console doctrine:migrations:migrate
	docker-compose exec php ./bin/console app:import-sql

init-test-db:
	docker-compose exec -T mysql mysql -u root -proot -e 'CREATE DATABASE IF NOT EXISTS dnd_test;'
	docker-compose exec php ./bin/console doctrine:cache:clear-metadata --env=test
	docker-compose exec php ./bin/console doctrine:migrations:migrate --env=test

##################################################################################################################
# MIGRATION
##################################################################################################################

generate-migration:
	docker-compose exec php ./bin/console doctrine:migrations:generate

migration:
	docker-compose exec php ./bin/console doctrine:migrations:migrate
