## About

This is an app that allows authenticated users to go through a loan application.




## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone https://github.com/mmuniraju4444/loan.git

Switch to the repo folder

    cd loan

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

To Run Test Cases

    php artisan test

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

PostMan Collection

`https://www.getpostman.com/collections/454711ca2d404753b8d9
`
