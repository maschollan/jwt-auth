<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## JWT AUTH Simple

this is a simple jwt auth for laravel 8

## Installation

clone this project

```bash
git clone https://github.com/maschollan/jwt-auth.git
```
copy .env.example to .env

```bash
cp .env.example .env
```

install composer

```bash
composer install
```

generate key

```bash
php artisan key:generate
```

migrate database

```bash
php artisan migrate
```

## Usage

run server

```bash
php artisan serve
```

open postman or other endpoint test  http://localhost:8000/api/register with method POST

```json
{
    "name": "maschollan",
    "email": "maschollan@mail.com",
    "password": "Password123",
}
```

open postman or other endpoint test  http://localhost:8000/api/login with method POST

```json
{
    "email": "maschollan@mail.com",
    "password": "Password123",
}
```

and get token like this 

```json
{
    "success": true,
    "message": "User successfully logged in",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjYxNjk1ODUxLCJleHAiOjE2NjE2OTk0NTEsIm5iZiI6MTY2MTY5NTg1MSwianRpIjoic2lkc0JxbmRuc0RpR2xqQSIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.B4xl4cJlGlJUGNlxDiaoMCr2xoW7m_qzbqHFL8TZnDQ"
}
```

include token as parameter to access endpoint like 

``` url
https://localhost:8000/api/user?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjYxNjk1NDExLCJleHAiOjE2NjE2OTkwMTEsIm5iZiI6MTY2MTY5NTQxMSwianRpIjoiZElrZzBvUmIyV3VObDMyQyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.kIBklh4qYFVZZ2JZwzACeAzSUECKKA7FWqyiUjbGeTc 
```
with method GET and respon will be like this
```json
{
    "success": true,
    "message": "success get user data",
    "data": {
        "id": 1,
        "name": "maschollan",
        "email": "maschollan@mail.com",
        "email_verified_at": null,
        "created_at": "2022-08-28T13:57:07.000000Z",
        "updated_at": "2022-08-28T13:57:07.000000Z"
    }
}
```

## License

This project create with the Laravel framework and this is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
