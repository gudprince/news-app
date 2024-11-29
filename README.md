## Requirements

* PHP ^8.2
* MySQL 8

* Check Laravel 11 Requirements https://laravel.com/docs/11.x/deployment

## Installation

*  `composer install` (Install dependencies)

* Set Database Credentials, in dotenv file (.env)

* `php artisan migrate` (Migrate Database)

* `php artisan schedule:work` (this command start the cron job to frequently update the database with news data)

 * `php artisan serve` (this command start the application server)

## Test

`php artisan test` (test the application)

## Postman Documentaion Link

https://documenter.getpostman.com/view/22023924/2sAYBXCX4x

**Note: there is a default API keys for the third party APIs used for this project**
