.PHONY: build
build: ## sail build and up project
		./vendor/bin/sail build --no-cache
		./vendor/bin/sail up -d --remove-orphans
		./vendor/bin/sail composer install
		./vendor/bin/sail artisan migrate:fresh --seed
		./vendor/bin/sail npm install
		./vendor/bin/sail npm run build

.PHONY: start
start: ## sail up project
		./vendor/bin/sail up -d

.PHONY: stop
stop: ## sail up project
		./vendor/bin/sail stop

.PHONY: install
install: ## initialize composer and project dependencies
		./vendor/bin/sail composer install

.PHONY: update
update: ## initialize composer update
		./vendor/bin/sail composer update

.PHONY: cleanup
cleanup: ## cleanup all caches
		./vendor/bin/sail artisan clear-compiled
		./vendor/bin/sail artisan event:clear
		./vendor/bin/sail artisan cache:clear
		./vendor/bin/sail artisan route:clear
		./vendor/bin/sail artisan config:clear

.PHONY: cleardb
cleardb: ## clear database and run seeders
		./vendor/bin/sail artisan migrate:fresh --seed

.PHONY: migrate
migrate: ## migrate database
		./vendor/bin/sail artisan migrate

.PHONY: rollback
rollback: ## rollback database
		./vendor/bin/sail artisan migrate:rollback

.PHONY: style
style: ## executes pint
		./vendor/bin/pint

.PHONY: test
test: ## executes phpunit tests
		./vendor/bin/sail test --do-not-cache-result

.PHONY: help
help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
