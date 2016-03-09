Facebook Login for Codeigniter with Ben Edmunds Ion Auth
========================================================

> This library is based on Facebook SDK for PHP (v5)
> https://github.com/facebook/facebook-php-sdk-v4

## Setup
Install Facebook SDK for PHP with [Composer](https://getcomposer.org/). Run this command:

```sh
composer require facebook/php-sdk-v4
```

> **NOTICE:** This version of the Facebook SDK for PHP requires PHP 5.4 or greater.

First go to /application/config/ and edit facebook.php

```php
$config[ 'app_id' ] = '';
$config[ 'app_secret' ] = '';
```
> insert APP_ID and SECRET_APP_ID

```php
$config[ 'redirect_uri' ] = '';
```
> insert REDIRECT_URI example facebook/do_login

```php
$config[ 'default_facebook_password' ] = '';
```
> insert DEFAULT_FACEBOOK_PASSWORD
> **NOTICE:**  when you first time setup the password do not change it

## Usage
> Soon description and example files

## Author
**Mladen Janjusevic**

- http://designia.rs
- https://fb.me/designia.rs
- https://fb.me/DjMladen
- https://rs.linkedin.com/in/mladenjanjusevic

## License
> Copyright (c) 2016 Mladen Janjusevic

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

[CONFIG]: https://github.com/puneetkay/Facebook-PHP-CodeIgniter/blob/master/config/facebook.php
