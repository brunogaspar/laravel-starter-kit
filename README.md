##Laravel 4 - Starter Kit

This is a Laravel 4 Starter Kit, it will help you getting started with Laravel 4.

It includes examples on how to use the framework itselff and how to use some packages, like the awesome [Sentry 2](http://github.com/cartalyst/sentry) package.

-----

##Included goodies:

* Twitter Bootstrap 2.2.2
* Custom CLI Installer
* Custom Error Pages
	* 403 for forbidden page accesses
	* 404 for not found pages
	* 500 for internal server problems
* Cartalyst Sentry 2 for Authentication and Authorization
* Back-end
	* Manage users and groups
	* Manage blog posts and comments
* Front-end
	* User login, registration, forgot password
	* User account area
	* Simple Blog functionally
* Packages included:
	* Cartalyst Sentry 2
	* Jason Lewis Expressive Date
	* Meido HTML
	* Meido Str

-----

##How to Install

###1) Downloading
####1.1) Cloning the Repository

	git clone http://github.com/brunogaspar/laravel4-starter-kit your-folder

####1.2) Download the Repository

	https://github.com/brunogaspar/laravel4-starter-kit/archive/master.zip

-----

###2) Install the Dependencies via Composer
#####2.1) If you don't have composer installed globally

	cd your-folder
	curl -s http://getcomposer.org/installer | php
	php composer.phar install

#####2.2) For globally composer installations

	cd your-folder
	composer install

-----

###3) Setup Database

Now that you have the Laravel 4 cloned and all the dependencies installed, you need to create a database for it.

After the database is created, open the file ***app/config/database.php*** and update it, just like in Laravel 3.

-----

###4) Use custom CLI Installer Command

Now, you need to create yourself a user and finish the installation.

Use the following command to create your default user, user groups and run all the necessary migrations automatically.

	php artisan app:install

-----

###5) Accessing the Administration

To access the administration page, you just need to access `http://your-host/public/admin` on your browser and it will automatically redirect you to the login page, in the login page, just fill in and submit the form.

After you being authenticated, you will be redirected back to the administration page.
