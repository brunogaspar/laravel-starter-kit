## Laravel 4 - Starter Kit

This is a Laravel 4 Starter Kit and it will help you getting started with Laravel 4.

It includes examples on how to use the framework itself and how to use some
packages, like the awesome [Sentry 2](https://github.com/cartalyst/sentry) package.

-----

## Included goodies

* Twitter Bootstrap 2.3.1
* jQuery 1.9.1
* Custom CLI Installer
* Custom Error Pages:
	* 403 for forbidden page access
	* 404 for not found pages
	* 500 for internal server errors
	* 503 to show the maintenance page
* Back-end
	* User and Group management
	* Manage blog posts and comments
* Front-end
	* User login, registration, activation and forgot password
	* User account area
	* Blog functionality with commentaries
	* Contact us page
* Packages included:
	* [Cartalyst Sentry 2 - Authentication and Authorization package](https://github.com/cartalyst/sentry)

-----

## How to Install

### 1) Downloading
#### 1.1) Clone the Repository

	git clone http://github.com/brunogaspar/laravel4-starter-kit your-folder

#### 1.2) Download the Repository

	https://github.com/brunogaspar/laravel4-starter-kit/archive/master.zip

-----

### 2) Install the Dependencies via Composer
##### 2.1) If you don't have composer installed globally

	cd your-folder
	curl -s http://getcomposer.org/installer | php
	php composer.phar install

##### 2.2) For globally composer installations

	cd your-folder
	composer install

-----

### 3) Setup Database

Now that you have the Laravel 4 cloned and all the dependencies installed, you need to create a database for it.

After the database is created, open the file `app/config/database.php` and update the needed entries, just like in Laravel 3.

-----

### 4) Setup Mail Settings

Now, you need to setup your mail settings by just opening and updating the following file `app\config\mail.php`.

This will be used to send emails to your users, when they register and they request a password reset.

-----

### 5) Use custom CLI Installer Command

Now, you need to create yourself a user and finish the installation.

Use the following command to create your default user, user groups and run all the necessary migrations automatically.

	php artisan app:install

-----

### 6) Accessing the Administration

To access the administration page, you just need to access `http://your-host/public/admin` on your browser and it will automatically redirect you to the login page, in the login page, just fill in and submit the form.

After you being authenticated, you will be redirected back to the administration page.

-----

### LICENSE

> Version 1, December 2009

> Copyright (C) 2009 Philip Sturgeon <email@philsturgeon.co.uk>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

> DON'T BE A DICK PUBLIC LICENSE
> TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

 1. Do whatever you like with the original work, just don't be a dick.

     Being a dick includes - but is not limited to - the following instances:

	 1a. Outright copyright infringement - Don't just copy this and change the name.
	 1b. Selling the unmodified original with no work done what-so-ever, that's REALLY being a dick.
	 1c. Modifying the original work to contain hidden harmful content. That would make you a PROPER dick.

 2. If you become rich through modifications, related works/services, or supporting the original work,
 share the love. Only a dick would make loads off this work and not buy the original works
 creator(s) a pint.

 3. Code is provided with no warranty. Using somebody else's code and bitching when it goes wrong makes
 you a DONKEY dick. Fix the problem yourself. A non-dick would submit the fix back.
