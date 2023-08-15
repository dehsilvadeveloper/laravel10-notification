## Getting Started (For Windows users)

The make scripts of the **Makefile** will not work for default on the operational system **Windows**. Because of this, I have prepared instructions for those using **Windows**.

Open a terminal on the root of the project and follow the instructions on this file.

### Install

#### Step 1

Duplicate the `.env.example` file, renaming the copy to `.env`. This file contains the environments variables that will be used for the application.

#### Step 2

The next step is build the Docker containers. For this you have to use the following command:

```
docker-compose -f ./docker-compose.yml build --no-cache
```

#### Step 3

After the containers are built, you need to enable them for use. For this you have to use the following command:

```
docker-compose -f ./docker-compose.yml up -d
```

The `-d` means *detached*, which means that it won't be necessary to keep the terminal open for the application to keep running.

#### Step 4

Now you need to install the application dependencies using the dependency manager **Composer**. For this you have to use the following command:

```
docker-compose -f ./docker-compose.yml exec main composer install --no-interaction
```

After this you need to generate the autoload of application classes (classmap) for better performance. For this you have to use the following command:

```
docker-compose -f ./docker-compose.yml exec main composer dump-autoload -o
```

#### Step 5

The next step is to generate the Laravel key. This key is used for any encryption realized by the application (passwords, for example). For this you have to use the following command:

```
docker-compose -f ./docker-compose.yml exec main php artisan key:generate
```

#### Step 6

Now you need to run the Laravel migrations, creating the database structure for the application. For this you have to use the following command:

```
docker-compose -f ./docker-compose.yml exec main php artisan migrate
```

#### Step 7

The next step is to run the Laravel seeders, filling the database tables with necessary data. For this you have to use the following command:

```
docker-compose -f ./docker-compose.yml exec main php artisan db:seed
```

#### Installation finished

After following the installation steps, the application is ready to use on the following url:

```
http://localhost:9999
```

You only need to make the installation procedure once.

### Starting the application

If you want to start the application, use the following command:

```
docker-compose up -d
```

This script will get up all Docker containers, making the application ready to use.

It won't be necessary to keep the terminal open for the application to keep running.

### Shutting down the application

If you want to stop the application, use the following command:

```
docker-compose down
```

This script will get down all Docker containers and the application will not be available for use anymore.

### Testing the API enpoints

To test the API endpoints you will need a program that can perform http requests. You can use **Postman** or **Insomnia**, for example.

[Postman](https://www.postman.com/downloads/)

[Insomnia](https://insomnia.rest/download)