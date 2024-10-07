## Dependencies
1. Docker Engine
2. Code IDE (VS Code, etc)

## Pre Setup
1. If you are developing an application with a team, you may not be the one that initially creates the Laravel application. Therefore, none of the application's Composer dependencies, including Sail, will be installed after you clone the application's repository to your local computer.

You may install the application's dependencies by navigating to the application's directory and executing the following command. This command uses a small Docker container containing PHP and Composer to install the application's dependencies:
https://laravel.com/docs/11.x/sail#installing-composer-dependencies-for-existing-projects
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

2. Configure `.env` copied from `.env_examples`. Set host, ports, and other server configs.
   
3. Laravel Sail's docker-compose.yml file defines a variety of Docker containers that work together to help you build Laravel applications. Each of these containers is an entry within the services configuration of your docker-compose.yml file. The laravel.test container is the primary application container that will be serving your application.

Before starting Sail, you should ensure that no other web servers or databases are running on your local computer. To start all of the Docker containers defined in your application's docker-compose.yml file, you should execute the up command:
https://laravel.com/docs/11.x/sail#starting-and-stopping-sail

```
sail up -d
```
4. Run sail command `sail artisan key:generate`

## Migration
1. Migration files need are only the following:
   ```
   0001_01_01_000000_create_users_table.php
   0001_01_01_000001_create_cache_table.php
   0001_01_01_000002_create_jobs_table.php
   2024_07_31_031708_create_personal_access_tokens_table.php
   ```
2. NO NEED TO ADD NEW MIGRATIONS. Use only 3rd Party DMBS to add/edit or manage database. Use the existing `ihris` database.
3. To use laravel's models to existing tables from `ihris` database. Read: https://laravel.com/docs/11.x/eloquent#table-names
4. For more info on using laravel's eloquent read: https://laravel.com/docs/11.x/eloquent
