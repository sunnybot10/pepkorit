# Pepkorit Assessment

A basic API to wrap the Database. Include the following function points:
  - Add a new User
  - Update a User's details
  - Delete a User
  - Search users  

## Getting Started
	Cloning a Git repository
	

### Prerequisites

What things you need to install the software and how to install them

	PHP7 
	MYSQL 
	composer

```
Give examples
```

### Installing

Create a mysql database pepkorit
	Then import sql file provided data to database tables.
	Then you can change the env. variables
 
Go to the main directory cd/pepkor

Then the following commands 
	composer install
	composer update
	composer dumpautoload
	
Then run the following command
	php -S 127.0.0.1:8000 -t public

The you can use postman to post, search, update and delete database
e.g. http://127.0.0.1:8000/user/312
