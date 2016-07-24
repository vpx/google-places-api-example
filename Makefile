default: help

help:
	@echo "Targets:"
	@echo "   docker-stop   Start docker containers"
	@echo "   docker-remove Remove docker containers"
	@echo "   docker-start  Build & start docker containers"
	@echo "   phpcs         Run PHP Code Sniffer"
	@echo "   phpunit       Run PHPUnit tests"
	@echo "   test          Run test"

test: phpcs phpunit

docker-stop:
	docker-compose stop

docker-remove: docker-stop
	docker-compose rm -f

docker-start: docker-remove
	docker-compose up -d --build

phpcs:
	php vendor/bin/phpcs --colors --standard=PSR2 --encoding=UTF-8 --extensions=php src/

phpunit:
	php vendor/bin/phpunit -c phpunit.dist.xml --coverage-html build/coverage
