# Software Developer Coding Challenge

This is a coding challenge for software developer applicants applying through http://work.traderev.com/

## Backend

PHP Laravel used for backend API  
Documentation of laravel can be find here: https://laravel.com/docs/6.x  

**Server requirements**  
* PHP >= 7.2.0
* BCMath PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
**Configuration** 
Create a file named `.env` in `server` directory with following content:

```yaml
APP_NAME=Traderev
APP_ENV=local
APP_KEY=base64:UvxDdOuch1JUJDxYv8DsbXVWHYLJlOPvkfRXwRO7E5Q=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<database_nam>
DB_USERNAME=<database_username>
DB_PASSWORD=<database_password>
```  

**Installation**  
To install required files, run following commands from `server` directory:  
```bash
composer install  
composer update
php artisan config:cache
php artisan route:cache
php artisan migrate
```

**Run test server**  
Run following command from code `server` directory
```bash
php artisan serve
```

**Accessing API server**
API server can be accessed using following routes:
```
http://localhost:8000/api/register                  #Method: Post, register a new user
http://localhost:8000/api/login                     #Method: Post, login the user
http://localhost:8000/api/logout                    #Method: Post, logout the user
http://localhost:8000/api/me                        #Method: Get,  returns logged in user
http://localhost:8000/api/users                     #Method: Get, All Users
http://localhost:8000/api/auctions                  #Method: Get, All Auctions
http://localhost:8000/api/user/{id}                 #Method: Get, user information
http://localhost:8000/api/user/{id}/auctions        #Method: Get, auctions created by user
http://localhost:8000/api/user/{id}/bids            #Method: Get, bids posted by the user
http://localhost:8000/api/auction/{id}              #Method: Get, auction information
http://localhost:8000/api/auction/{id}/bids         #Method: Get, all bids for an auction
http://localhost:8000/api/auction/{id}/highestBid   #Method: Get, auction highest bid
http://localhost:8000/api/auction                   #Method: Post, create an auction
http://localhost:8000/api/auction/{id}              #Method: Delete, delete an auction
http://localhost:8000/api/auction/{id}              #Method: Put, submit a bid for an auction
```

**Running unit test**
Run following command from code `server` directory
```bash
vendor/bin/phpunit tests/Feature/AuctionTest.php
vendor/bin/phpunit tests/Feature/UserTest.php
```

## Front End
Vue.js used for front end SPA application

**Installation**
To install required files, run following commands from `client` directory:
```bash
npm install
```

**Running Server**
To run web server, run following command from `client` directory
```bash
npm run dev
```

### Note
Client application expect the server to be accessible over `http://localhost:8000`
