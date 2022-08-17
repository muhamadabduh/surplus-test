# Surplus Test Backend

## Stacks 
- Laravel 9
- Docker
- Postgresql

## Requirements
- Docker desktop

## How To Run
- clone repo
- run command ```cp .env.example .env```
- run ```docker-compose up -d --build```
- application running in localhost:8000


## Interacting with App Container
- with command : ```docker exec -it backend bash``` then you can run any artisan commands  
- run : ```composer install``` if necessary.
- run : ```php artisan key:generate``` if necessary.


## Interacting with Database Container

### Connect with Database tools
You can connect to the db container by using any database tools that supports postgres e.g dbeaver, heidisql, pgadmin, etc. 
 
### Connect with postgres sql cli 
command : ```docker exec -it laravel9-docker_postgres_1 psql -U root``` 

### Create Database
after connect with postgres sql cli. make commands : ```create database surplus;```

### Migrating Database 
- ```docker exec -it backend bash```
- ```php artisan migrate```

### Seed Database
