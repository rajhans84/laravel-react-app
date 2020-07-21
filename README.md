## Overview

A laravel application to manage organisation's users:

- Extending `users` table to have both `ADMIN` and `EMPLOYEE` users.
- `ADMIN` users can register a new account and create a new `Organisation`.
- `ADMIN` users can see a `EMPLOYEE` users data grid after logging in, including `ADMIN` users.
- `ADMIN` users can create, edit, and delete users.
- Create seeders can create organisations and users, including admin users.
- A Company CRUD for `ADMIN` users. (Search is optional)
- Allow `ADMIN` users can search `EMPLOYEE` users.
- A policy to prevent `ADMIN` users from updating and deleting other `ADMIN` users.
- A policy to prevent `ADMIN` users from deleting himself.

## Stack

1. Database: MySQL
2. Backend Framework: Laravel
3. Frontend: React 
4. Docker


## Setup the project

This project has a `docker-compose.yml` contains the basic stack setup to quickly spin up the local development environment.

To set up the project please follow the steps below:
 
1. Set up the `.env` file:

```bash
cp .env.example .env
``` 

2. Start up the services

```bash
docker-compose up -d
``` 

3. Install the dependencies

```bash
docker-compose exec php composer install

npm install
``` 

4. Build the frontend

```bash
npm run dev
```

5. Create a key

```bash
docker-compose exec php php artisan key:generate
```

6. Run migrations

```bash
docker-compose exec php php artisan migrate --seed
```
