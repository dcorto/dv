# Test

## Start & Stop environment 
```
$ docker-compose up -d

$ docker-compose stop
```

## Install vendors
```
$ docker-compose exec php composer install
```

## Create database
```
$ docker-compose exec php bin/console doctrine:schema:create
```

## Run tests

```
$ docker-compose exec php ./bin/phpunit
```

