## Atarim URL Shortener


### Installation Instructions

The first step is to copy the `.env.example` and create your own `.env` file.

Next, install laravel locally by running the following command:
```
composer install
```
Now create the database and run the seeder that creates the user table with the single atarim user:
```
php artisan migrate --seed
```
And finally run the install command to create your new api authentication token.  Please make sure you take note of the token returned by the command.
```
php artisan install:api
```
### API Token based authentication
This API implememnts a simple authorisation token approach which is implemented by an `Authorization` header which restricts access to authorised users only.  Please ensure that all requests made to the api endpoints include your api token that you generated in the last step of the installation instructions.  Simply add the Authorization header as per the example below
```
Authorization: Bearer ********
```

### Postman
I have included a Postman collection for your convenience. It can be found in the root of this project.

