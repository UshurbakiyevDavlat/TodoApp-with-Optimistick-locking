DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      services/           contains Service layer classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------
The minimum requirements for this application that you have Docker and docker-compose


INSTALLATION
------------
~~~
### Install with Docker

If you do not have vendor folder, run docker exec {container of application name} ` composer install` to install all dependencies.  
  
Start the container

    docker-compose up -d
    
You can then access the application through the following URL:

    http://127.0.0.1:8000 or http://localhost:8000

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches
~~~
CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=todo',
    'username' => 'davlat',
    'password' => 'qwe1234',
    'charset' => 'utf8',
];

````


### Notes
~~~
- I used `Yii2` framework for this project
- I used `Docker` for this project
- I used `Docker-compose` for this project
- I used `Codeception` for this project
- I used `MySQL` for this project
- I used `Nginx` for this project
- I used `PHP 7.4` for this project
- Container of application name for my docker container is todo-app_php_1, yours you can check with docker ps command
~~~

TESTING
-------
- `unit`

Tests can be executed by running

```
docker exec {container of application name}  vendor/bin/codecept run unit

```

The command above will execute unit tests. 
Unit tests are testing the system components

# Endpoints
~~~
- http://localhost:8000/todo/create - Create todo
- http://localhost:8000/todo - For getting all todo items
- http://localhost:8000/todo/{id}/update - for updating todo item
- http://localhost:8000/todo/5 - for getting todo item by id
- PUT http://localhost:8000/todo-item/{id}/done - For marking todo item as done
    - Content-type should be : application/json
    - Body should be : {"done": true} or {"done": false}
~~~

![image](https://user-images.githubusercontent.com/66309313/229360477-e6f9a664-094e-4d59-9f5d-fdceea33db5d.png)
![image](https://user-images.githubusercontent.com/66309313/229360526-510ce1a5-d6d2-4c2d-bc3a-eafd9864f67a.png)
![image](https://user-images.githubusercontent.com/66309313/229360591-8cfbef3d-a0bf-4219-a042-dd0e1c5e52bb.png)

В эндпоинте, нужно обязательно указать в хедерах X-CSRF-TOKEN, взять его можно из сессии в браузере или отправив гет запрос и взять из ответа.
![image](https://user-images.githubusercontent.com/66309313/229360732-af4fc105-a712-4d5b-838a-6961e75507bd.png)

