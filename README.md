## php-libguides

Makes interactions with the LibGuides v2 API using PHP 5.4.0+ even easier. There isn't much to the LibGuides 2 API yet.

### Installation

`php-alma` uses the [Composer](http://getcomposer.org/) dependency management system. It uses GitHub as a repository now, but when it reaches some degree of stability it will be added to Packagist.

1. If you haven't already, [install `composer.phar`](http://getcomposer.org/doc/00-intro.md#installation-nix). To install `composer.phar` in the `/usr/bin` directory on Linux/OS X:
 
		sudo curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin

2. Create a `composer.json` file. The example below will install `php-alma`:


		{
            "name": "your-org/your-project",
            "description": "Describe your project",
            "license": "MIT",
            "repositories": [
                {
                    "type": "vcs",
                    "url": "https://github.com/BCLibraries/php-libguides"
                }
            ],
            "require": {
                "bclibraries/php-libguides": "0.0.2"
            }
        }
   
   Transitive composer installs don't work with PEAR repositories, so you'll have to specifically include the PEAR install in your `composer.json`.
    
3. Install using `composer.phar`:

		php composer.phar install


Composer will load all the required dependencies and create a `vendor/autoload.php` file to handle autoloading classes.

### Use

First instantiate a client:


```php
$client = new \BCLib\LibGuides\Client('94', 'http://libguides.bc.edu');
```

#### Guides

The only active part of the LibGuides 2 API is getting guides. You can get all guides:

```php
$guides = $client->getGuides();
```

or get certain guides by ID:

```php
$guides = $client->getGuides(['44559','43982']);
```

## License

See MIT-LICENSE.