# nbt-api
Symfony API paired with frontend project nbt-front.

##Launch project
### Connect database
Edit your .env file

###Initialize project with the following command prompts
composer install
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
symfony server:start
