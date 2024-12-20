## Atarim URL Shortener


### Installation Instructions

Install the applications locally by running the following command:
```
composer install
```
Now create the database and seed the user table with the atarim user:
```
php artisan migrate --seed
```
And finally run the install command to create your new api authentication token 
```
php artisan install:api
```
### API Token based authentication
This API implememnts an `Authorization` header to restrict access to authorised users.  Please ensure that all requests made to the api endpoints include the your api token generated in the last step of the installation instructions.
```
Authorization: Bearer ********
```

