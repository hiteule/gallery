.PHONY: docker/restart docker/up docker/down docker/build docker/rm docker/clean db/reset

docker/restart: docker/down docker/up

docker/up:
	docker-compose up -d

docker/down:
	docker-compose down

docker/build:
	docker-compose build --pull

docker/rm:
	docker-compose rm --force

docker/clean: docker/down docker/rm

db/reset:
	docker-compose run db /app/docker/mariadb/reset.sh "db" "root" "root"