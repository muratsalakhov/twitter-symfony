build:
	docker-compose -f ./docker/docker-compose.yml build

up:
	docker-compose -f ./docker/docker-compose.yml up -d

down:
	docker-compose -f ./docker/docker-compose.yml down

create-migration:
	docker-compose -f ./docker/docker-compose.yml exec php-fpm php bin/console doctrine:migrations:diff

migrate:
	docker-compose -f ./docker/docker-compose.yml exec php-fpm php bin/console doctrine:migrations:migrate