## Available Make Scripts

These are some scripts to help you run some commands without have to enter the Docker containers.

#### `make help`

Show a list of scripts available to help the developer.

#### `make say-hello`

Show a welcome message to the developer.

#### `make start-install`

Execute the installation of the application, building the containers and installing the dependencies. After the end of the process, the application is ready to use. You only need to run this command once.

#### `make up`

Get up all Docker containers, making the application ready to use on the url provided for the script.

#### `make down`

Get down all Docker containers.

#### `make build`

Build images used on the Docker containers.

#### `make stop`

Show a list of avaliable Docker containers to stop. You have to select the one that you want to stop.

#### `make in`

Show a list of avaliable Docker containers to go inside. You have to select the one that you want to emter.

#### `make generate-laravel-key`

Generate a Laravel key with the command php artisan key:generate. You can check the key generated on the .env file.

#### `make migrate`

Run the Laravel migrations, creating the database structure for the application.

#### `make seed`

Run the Laravel seeders, filling the database tables with necessary data.

#### `make refresh-database`

Refresh database, dropping all tables and re-running migrations and seeds.

#### `make composer-dump`

Run composer dump-autoload within container.

#### `make composer-install`

Run dependencies installation within container using composer.