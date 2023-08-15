## Adding new dependencies

It is possible to add **new dependencies** to the project. The installation will use the dependency manager **Composer**.

Open a terminal on the root of the project. Update the *composer.json* file with information about the package (or packages) that you want to install. Then use the following make script to proceed the installation:

```
make composer-install
```

If you are using **Windows**, you will have to use the following command instead, after update the *composer.json* file:

```
docker-compose -f ./docker-compose.yml exec main composer install --no-interaction
```

After this, the new dependencies will be available for the application.