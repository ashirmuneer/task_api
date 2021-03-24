# RESTFUL API TASK

This contains the application code for the RESTFUL API TASK. The app is build on top of [Laravel framework](http://laravel.com/docs) which runs on the XAMP OR LAMP stack.


## Requirements
* PHP Version >= 7.3
* composer 
* for more detail you can visit this link [Laravel Installation Guide](https://medium.com/@owthub/laravel-8-installation-guide-php-framework-de42e145765c)


## Setting up

Follow these steps to set up the project.

```
git clone <project.url> <project>
cd <project>
composer install
change the  .env.example to .env and Add databse name in db DB_DATABASE  and DB_USERNAME And DB_PASSWORD
```

Change the values of the `.env` file as necessary.

## Run the following Command

* php artisan migrate
* php artisan passport:install
* php aritsan key:generate



## Testing

* After all this thing done your URL is  [task APi](http://localhost/task_api/public/)

