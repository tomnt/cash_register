# Cash Register API
 This is a simple API endpoint example,accepts two arguments, “total cost” and “amount provided”. (both in dollars and/or cents)
 Returns count of each denomination of the change.

 Return as output the change that should be provided, **by returning the count of each denomination of bills and/or coins**.  

## Setting up
```
# Obtaining code
git clone https://github.com/tomnt/cash_register

# Moving to repository directory
cd cash_register

# Obtaining dependencies
composer install
```

## DB setting up
### Edit .env file
1 Open a file '.env'
2 Replace a line starts with 'DATABASE_URL=mysql'... by a line below at the file(with your preferred user name and password);

This is an example. Use parameters corresponding to your configuration.
```
DATABASE_URL=mysql://user_cash_register:password@127.0.0.1:3306/cash_register
```

### Creating MySQL user
1 Logging in to the MySQL server by console.

This is an example. Use parameters corresponding to your configuration.
```
mysql -u root
```
2 Creating a user

This is an example. Use parameters corresponding to your configuration.
```
CREATE USER 'user_cash_register'@'localhost';
GRANT ALL ON *.* TO 'user_cash_register'@'localhost';
SET PASSWORD FOR 'user_cash_register'@'localhost' = PASSWORD('password');
```

3 Creating DB
```
php bin/console doctrine:database:create
```

## Table setting up 
1 Creating table ('yes' for the option)
```
php bin/console doctrine:schema:create
```
2 Data seeding
```
php bin/console doctrine:fixtures:load
```

## Trying the API
Starting the web server
```
symfony serve
```

API URL format;
http://localhost:8000/api/cash_register/{total_cost}/{amount_provided}
 - {total_cost}: Total cost in cents.
 - {amount_provided}: Amount provided in cents.


API URL example;
[http://localhost:8000/api/cash_register/7512/10000/](http://localhost:8000/api/cash_register/7512/10000/)
 - Total cost: $75.12 (or 7512 cents)
 - Amount provided: $100.00 (or 10000 cents)

Response example;
```
{"change":1234,"denominations":[{"count":1,"amount":10,"name":"Ten Dollars","type":"note"},{"count":2,"amount":1,"name":"One Dollar","type":"note"},{"count":1,"amount":0.25,"name":"quarter","type":"coin"},{"count":1,"amount":0.05,"name":"nickel","type":"coin"},{"count":4,"amount":0.01,"name":"penny","type":"coin"}]}
```

## Running UnitTest
./vendor/bin/phpunit --bootstrap ./vendor/autoload.php ./tests/

## System Requirements
- [PHP 7.0 or higher](https://www.php.net/downloads.php)
- [Git(CLI client)](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
- [Composer](https://getcomposer.org/download/)
- [Symfony executable](https://symfony.com/download)
