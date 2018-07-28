## Using docker for laravel

run composer

Step 1. dowload laravel lastest
$ cd to /project/path/Laravel

Step 2. Run composer
$ docker run --rm -v $(pwd):/app composer/composer install --ignore-platform-reqs

Step 3. Create the development docker-compose.yml file

- docker-compose.yml
