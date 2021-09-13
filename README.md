
## SellLaptop

This is a project created to serve selling laptops and has a chatbot to support it. The project was done during the internship period 

## Prerequisites

Before you continue, ensure you install the following requirements:
<p align="left"><a href="https://www.php.net/manual/en/install.php" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/vi/thumb/2/27/PHP-logo.svg/1200px-PHP-logo.svg.png" width="60"></a>Version>=7.2.5</p>
<p align="left"><a href="https://nodejs.org/en/download/" target="_blank"><img src="https://d1iv5z3ivlqga1.cloudfront.net/wp-content/uploads/2021/01/30153840/cai-nodejs-tren-window-1.png" width="60"></a></p>
<p align="left"><a href="https://dev.mysql.com/doc/mysql-installation-excerpt/5.7/en/" target="_blank"><img src="https://nghiahsgs.com/wp-content/uploads/2020/08/sql.png" width="60"></a></p>
<p align="left"><a href="https://docs.npmjs.com/downloading-and-installing-node-js-and-npm" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/d/db/Npm-logo.svg" width="60"></a></p>
<p align="left"><a href="https://getcomposer.org/download/" target="_blank"><img src="https://getcomposer.org/img/logo-composer-transparent.png" width="60"></a></p>
<p align="left"><a href="https://redis.io/download" target="_blank"><img src="https://1.bp.blogspot.com/-5k958LlJol8/VSFvGnofvCI/AAAAAAAACOY/WM4CxLtpcOU/s1600/redis.png" width="60"></a></p>
<p align="left"><a href="https://laravel.com/docs/8.x/installation" target="_blank"><img src="https://vuvanlong.com/wp-content/uploads/2021/06/laravel-featured.png" width="65"></a>Version 8.X</p>

If you have all of the above installed
## Clone Repo
```bash
git clone https://github.com/manhuetcc/SellLaptop
```
Install the dependencies.

```bash
cd SellLaptop

composer install
npm install
```

To start the project, run the following

```bash
php artisan serve
npm run watch
redis-server
laravel-echo-server start
php artisan queue:listen
```
Then, Open http://127.0.0.1:8000 
