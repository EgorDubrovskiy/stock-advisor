Laravel Docker:
--------------

#### Installation on Ubuntu/MacOS:

##### Requirements:
- [docker](docker.com)
- [Git](https://git-scm.com/)

1. Make clone of this repo:
```bash
git clone https://github.com/iTechArt/php-labs-2018-team2
cd php-labs-2018-team2/backend
```

2. Make copy of laravel .env.example to .env:
```bash
cp .env.example .env
```

3. Build docker images
```bash
docker-compose build
```

4. Run services:
```bash
docker-compose up
```

5. Install php dependencies:
```bash
docker-compose exec laravel-php composer install
```

6. Generate application key:
```bash
docker-compose exec laravel-php php artisan key:generate
```

7. Apply migrations:
```bash
docker-compose exec laravel-php php artisan migrate
```

8. Check whether it works, open browser on [localhost:8000/healthcheck](http://localhost:8000/healthcheck).  

To get phpinfo, use the following endpoint: [localhost:8000/phpinfo](http://localhost:8000/phpinfo)

#### Debugging:
Use the following to enable debugger on mac: [Debug on Mac](./xdebug_on_mac.md)  
For Ubuntu try use this article: [Debug in Docker](https://blog.philipphauer.de/debug-php-docker-container-idea-phpstorm/)

#### Connect to docker instances:
Connect to redis instance:
```bash
docker-compose exec laravel-redis redis-cli
```

#### Installation on Windows (without Docker usage):

1. Install [OpenServer](https://ospanel.io/)

2. Install [Composer](https://getcomposer.org/doc/00-intro.md#installation-windows)

3. Create a new project (use php 7.2, mysql 5.7)

4. Create database `laravel` with username `laravel` and password `laravel`

5. Install php dependencies:
```bash
composer install
```

6. Generate application key:
```bash
php artisan key:generate
```

7. Apply migrations:
```bash
php artisan migrate
```
