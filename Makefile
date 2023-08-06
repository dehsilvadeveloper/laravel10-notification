COLOR_RESET=\033[0m
COLOR_GREEN=\033[0;32m
COLOR_RED=\033[0;31m
COLOR_BLUE=\033[0;34m
COLOR_YELLOW=\033[1;33m
COLOR_LIGHT_CYAN=\033[1;36m
COLOR_PURPLE=\033[0;35m

MAKEFLAGS += --no-print-directory

.DEFAULT:
	@echo "$(COLOR_LIGHT_CYAN)Executing ENV file verification.$(COLOR_RESET)"
	@bash ./.docker/scripts/check-env.sh
	@echo "$(COLOR_LIGHT_CYAN)ENV file verification is done.$(COLOR_RESET)"

include .env

help: ## Show help
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

say-hello: ## Show a welcome message to the developer
	@echo "Hello, developer. Welcome."

execute-install: ## Executing installation, building and getting up containers
	@echo "$(COLOR_LIGHT_CYAN)Building all containers.$(COLOR_RESET)"
	@docker-compose -f ./docker-compose.yml build --no-cache
	@echo "$(COLOR_LIGHT_CYAN)All containers are build.$(COLOR_RESET)"
	@echo "$(COLOR_BLUE)Getting up all containers.$(COLOR_RESET)"
	@docker-compose -f ./docker-compose.yml up -d
	@echo "$(COLOR_BLUE)All containers are up.$(COLOR_RESET)"

build: ## Build images used on the Docker containers
	@echo "$(COLOR_LIGHT_CYAN)Building all containers.$(COLOR_RESET)"
	@docker-compose -f ./docker-compose.yml build --no-cache
	@echo "$(COLOR_LIGHT_CYAN)All containers are build.$(COLOR_RESET)"

up: ## Get up all Docker containers
	@echo "$(COLOR_BLUE)Getting up all containers.$(COLOR_RESET)"
	@docker-compose -f ./docker-compose.yml up -d
	@echo "$(COLOR_BLUE)All containers are up.$(COLOR_RESET)"
	@echo "$(COLOR_YELLOW)Application is running on $(APP_URL):$(APP_PORT)$(COLOR_RESET)"
	@echo "$(COLOR_GREEN)Application is ready.$(COLOR_RESET)"

down: ## Get down all Docker containers
	@echo "$(COLOR_BLUE)Getting down all containers.$(COLOR_RESET)"
	@docker-compose -f ./docker-compose.yml down
	@echo "$(COLOR_GREEN)All containers are down.$(COLOR_RESET)"

stop: ## Show a list of avaliable Docker containers to stop
	@bash ./.docker/scripts/stop.sh

in: ## Show a list of avaliable Docker containers to go inside
	@bash ./.docker/scripts/in.sh

composer-install: ## Run dependencies installation within container using composer
	@bash ./.docker/scripts/composer-install.sh

composer-dump: ## Run composer dump-autoload within container.
	@bash ./.docker/scripts/composer-dump.sh

refresh-database: ## Refresh database, dropping all tables and re-running migrations and seeds
	@bash ./.docker/scripts/refresh-database.sh

migrate: ## Run migrations
	@bash ./.docker/scripts/migrate.sh

seed: ## Run seeds
	@bash ./.docker/scripts/seed.sh

generate-laravel-key: ## Generate Laravel key with the command php artisan key:generate
	@bash ./.docker/scripts/generate-laravel-key.sh

pre-install-verification: ## Verify if everything is OK for start of installation of application
	@echo "$(COLOR_LIGHT_CYAN)Executing pre-install verification.$(COLOR_RESET)"
	@bash ./.docker/scripts/pre-install.sh
	@echo "$(COLOR_LIGHT_CYAN)Pre-install verification is done.$(COLOR_RESET)"

start-install: ## Start the installation of the application
	@make pre-install-verification
	@echo "$(COLOR_BLUE)Application install starting.$(COLOR_RESET)"
	@make execute-install
	@make composer-install
	@make composer-dump
	@make generate-laravel-key
	@make migrate
	@make seed
	@echo "$(COLOR_YELLOW)Application is running on $(APP_URL):$(APP_PORT)$(COLOR_RESET)"
	@echo "$(COLOR_GREEN)Application is ready.$(COLOR_RESET)"
