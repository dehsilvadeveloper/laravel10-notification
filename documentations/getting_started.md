## Getting Started

Open a terminal on the root of the project and follow the instructions on this file.

### Install

For start, clone the repository to your local environment. After that, run the following script:

`make start-install`

This script will build the containers and install the dependencies. After that, the application is ready to use on the url provided for the script.

You only need to make this procedure once.

### Starting the application

If you want to start the application, use the following script:

`make up`

This script will get up all Docker containers, making the application ready to use on the url provided for the script.

It won't be necessary to keep the terminal open for the application to keep running.

### Shutting down the application

If you want to stop the application, use the following script:

`make down`

This script will get down all Docker containers and the application will not be available for use anymore.

### Testing the API enpoints

To test the API endpoints you will need a program that can perform http requests. You can use **Postman** or **Insomnia**, for example.

[Postman](https://www.postman.com/downloads/)

[Insomnia](https://insomnia.rest/download)
