default: help

help:
	@echo "Targets:"
	@echo " - setup-docker"

setup-docker:
	docker-compose stop | docker-compose rm -f | docker-compose up -d --build
