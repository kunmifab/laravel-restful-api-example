

## Laravel RESTful API Example

This Laravel RESTful API provides a set of endpoints for managing [resources] within your application. 
It leverages Laravel's robust features to offer a secure and well-structured API for interacting with your data.

Developed using Laravel 9.52.16
## Installation 

git clone https://github.com/kunmifab/laravel-restful-api-example.git
cd laravel-restful-api-example
composer install
php artisan key:generate


| Method | URL                                   | Description                                         |
|--------|------------------------------------------|-----------------------------------------------------|
| GET    | `api/users/all-users`                                 | Get a list of all users                           |
| POST   | `api/users/create-user`                                 | Create a new user                                  |
| POST    | `api/users/update-user/{id}`                            | Update an existing user by ID                      |
| DELETE | `api/users/delete-user/{id}`                            | Delete a user by ID                               |



