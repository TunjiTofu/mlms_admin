# Documentation for Mobile Learning Management System (Admin Module)
## Introduction
This repository houses the administrative features to manage the entire MLMS system. Users attached to this module have total control over all other modules and can thus take actions to overwrite actions taken by other users 

## Prerequisites
Things you need to install the software.

- Git.

## Setup
- Clone the git repository on your computer
```
$ git clone https://github.com/TunjiTofu/mlms_admin.git
```
You can also download the entire repository as a zip file and unpack on your computer.

- After cloning the application, you need to install its dependencies.
```
$ cd mlms_admin
$ composer install 
```
- Setup your Environement Variables
```
$ cp .env.example .env
```
- Generate an App Key
```
$ php artisan key:generate
```
- Open the directory with your desired code editor
- Open the .env file and do the following
    - Update the following variables in the .env file
    ```
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE= << use a desired database name >>
    DB_USERNAME= << provide your Database username >>
    DB_PASSWORD= << provide your Database username >>
    ```
- Using any Database Management System (DBMS), create a database that conforms with the database variable name in your .env file
- Run the following command to run the database migrations
```
$ php artisan migrate
```
- Run the following command to seed the database
```
$ php artisan db:seed
```
- Serve the Application
```
$ php artisan serve
```
