# Cash Register API
 This is a simple API endpoint example,accepts two arguments, “total cost” and “amount provided”. (both in dollars and/or cents)
 Returns count of each denomination of the change.

 Return as output the change that should be provided, **by returning the count of each denomination of bills and/or coins**.  

## 1. Program files set up
```
# Obtaining code
git clone https://github.com/tomnt/cash_register

# Moving to repository directory
cd cash_register

# Obtaining dependencies
composer install
```

## 2. DB connection set up
### Edit .env file
1 Open a file '.env'
2 Replace a line starts with 'DATABASE_URL=mysql'... by a line below at the file(with your preferred user name and password);<br/>
(This is an example. Use parameters corresponding to your configuration.)
```
DATABASE_URL=mysql://user_cash_register:password@127.0.0.1:3306/cash_register
```

## 3. MySQL DB set up
1 Logging in to the MySQL server by console.<br/>
(This is an example. Use parameters corresponding to your configuration.)
```
mysql -u root
```
2 Creating a user<br/>
(This is an example. Use parameters corresponding to your configuration.)<br/>
```
CREATE USER 'user_cash_register'@'localhost';
GRANT ALL ON *.* TO 'user_cash_register'@'localhost';
SET PASSWORD FOR 'user_cash_register'@'localhost' = PASSWORD('password');
```
3 Creating DB
```
php bin/console doctrine:database:create
```

## 4. Table set up 
1 Creating table ('yes' for the option)
```
php bin/console doctrine:schema:create
```
2 Data seeding
```
php bin/console doctrine:fixtures:load
```

## 5. API try out
Starting the web server ('symfony' could be a filename of the executable file)
```
symfony serve
```

**API URL format**<br/>
*http://localhost:8000/api/cash_register/?total_cost={total_cost}&amount_provided={amount_provided}*
 - *{total_cost}*: Total cost in cents.<br/>
   Example (means $75.12) : 75.12
 - *{amount_provided}*: Amount provided in cents.<br/> 
   Example (means $100.00): 100.00

**API URL example**<br/>
*[http://localhost:8000/api/cash_register/?total_cost=87.66&amount_provided=100.00](http://localhost:8000/api/cash_register/?total_cost=87.66&amount_provided=100.00)*
 - *Total cost*: $75.12
 - *Amount provided*: $100.00

**Response example**
```
{
	"change": 12.34,
	"denominations": [
		{
			"count": 1,
			"amount": 10,
			"name": "Ten Dollars",
			"type": "note"
		},
		{
			"count": 2,
			"amount": 1,
			"name": "One Dollar",
			"type": "note"
		},
		{
			"count": 1,
			"amount": 0.25,
			"name": "quarter",
			"type": "coin"
		},
		{
			"count": 1,
			"amount": 0.05,
			"name": "nickel",
			"type": "coin"
		},
		{
			"count": 4,
			"amount": 0.01,
			"name": "penny",
			"type": "coin"
		}
	]
}
```

**Possible scenario for this example<br/>**
*You paid $100 for an item costs $87.66.<br/>*
*Then, you will receive $12.34 as change.<br/>*

*The denominations of currencies you will receive for the change, $12.34 are;<br/>*
* *1 x $10.00 ( Ten Dollars note )<br/>*
* *2 x $1.00 ( One Dollar note )<br/>*
* *1 x $0.25 ( quarter coin )<br/>*
* *1 x $0.05 ( nickel coin )<br/>*
* *4 x $0.01 ( penny coin )<br/>*

## 6. UnitTest
```
./vendor/bin/phpunit --bootstrap ./vendor/autoload.php ./tests/
```
## 7. Packages
These are list of package used in this project.<br/>
(This is just for reference and no particular action needed.)<br/>
 - [symfony/website-skeleton](https://packagist.org/packages/symfony/website-skeleton)
 - [psr-http-message-bridge](https://packagist.org/packages/symfony/psr-http-message-bridge)
 - [mevdschee/php-crud-api](https://packagist.org/packages/mevdschee/php-crud-api)
 - [phpunit/phpunit](https://packagist.org/packages/phpunit/phpunit)

## 8. System Requirements
- [PHP 7.0 or higher](https://www.php.net/downloads.php)
- [MySQL/MariaDB](https://mariadb.com/downloads/)
- [Git(CLI client)](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
- [Composer](https://getcomposer.org/download/)
- [Symfony executable](https://symfony.com/download)
