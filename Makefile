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

php-cs-fixer:
	docker-compose -f ./docker/docker-compose.yml exec php-fpm vendor/bin/php-cs-fixer fix

php-cs-fixer-diff:
	docker-compose -f ./docker/docker-compose.yml exec php-fpm vendor/bin/php-cs-fixer fix --dry-run --diff

deptrac-layers:
	docker-compose -f ./docker/docker-compose.yml exec php-fpm vendor/bin/deptrac analyze --config-file=deptrac-layers.yaml

deptrac-modules:
	docker-compose -f ./docker/docker-compose.yml exec php-fpm vendor/bin/deptrac analyze --config-file=deptrac-modules.yaml