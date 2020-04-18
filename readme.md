sudo systemctl start mysql

php -S 127.0.0.1:8000 -t public

php bin/console doctrine:database:drop --force

php bin/console doctrine:database:create

php bin/console make:migration

php bin/console doctrine:migrations:migrate

php bin/console doctrine:fixtures:load

php bin/console make:entity --api-resource
