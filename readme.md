# Neami Challenge

Installation and usage instructions

# Get started with Docker

```bash
# Turn off other mysql and apache services running(like MAMP etc)
# Install and setup Docker for Mac or Windows if not already

# Build docker containers
# below command will take about 5 minutes. Please be patient
cd neami-challenge
docker-compose build

# Run all
docker-compose up

# Run commands inside containers
docker-compose exec <container> <command>
# e.g. docker-compose exec lumen-api php artisan migrate:refresh --seed
```

# Neami Backend

## Configuration & Usage

1. Rename or copy `.env.example` file to `.env`
1. Update APP_KEY and JWT_SECRET with your own secret keys
1. Set your database credentials in your `.env` file to match Docker settings
1. Set your `APP_URL` in your `.env` file.
1. `docker-compose exec lumen-api php artisan migrate:refresh --seed`
1. Above command will freshly migrate and seed default roles, permissions and users for testing.
1. Visit http://localhost:8000 to access Lumen API

## Permissions and Roles

User roles and permissions are handled by this [Laravel Permission](https://github.com/spatie/laravel-permission) library. 

After seeding, default permissions `manage-users, delete-users` will be created.

And default role `super-admin` with all permissions will be created.

## Authentication and Authorization
1. Authentication is implemented using JSON Web Tokens with the help of [PHP-JWT](https://github.com/firebase/php-jwt) library
1. JWT token is saved in localStorage and set to expire after 24hrs.
1. Logged in user's information also stored in localStorage. Note that the authorization process does not rely on this localStorage user information.
1. Authorized users only routes are protected by Vue Router `meta` option `permission`. Refer `vue-spa/src/router/index.js`
1. All protected routes will trigger `'/permissions'` API call automatically to get fresh set of user's permissions and store it in Vue memory. Unauthorized entries will be redirected to `/store`

## Usage

1. Visit `localhost:8080` in your browser
1. Hot Module Replacement is enabled by default by the docker configuration.
1. For admin level access visit `/login` and use the default super admin User/Password: `admin@admin.com/000000`. 
1. For user level access visit `/login` and use the default user User/Password: `user@user.com/000000`

## CoreUI for Vue.js

Neami Challenge Frontend is built on top of [CoreUI for Vue.js](https://coreui.io/vue/). Refer its extensive [documentation](https://coreui.io/v1/docs/getting-started/introduction/) to understand the file structure, layouts, and components.


## TODO

1. `Users` CRUD operations as administrator
1. Option to add/remove roles & permissions to each user as administrator
1. New page to maintain roles and permissions CRUD operations
1. Push the production build to https://neami.iamraja.com
