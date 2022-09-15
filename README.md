# squidmin
squid user-management WebUI alternative proxymin,Squid Users Manager

Very simple and secure administration panel optimized for proxy distributors


[![user](https://user-images.githubusercontent.com/7544687/190421128-30b4993b-4067-4cbc-98cd-66c1260137ac.JPG)](https://user-images.githubusercontent.com/7544687/190421128-30b4993b-4067-4cbc-98cd-66c1260137ac.JPG)

[![usecase](https://user-images.githubusercontent.com/7544687/190421255-c60abafb-da99-41a3-bf18-c07d75cb774f.jpg)](https://user-images.githubusercontent.com/7544687/190421255-c60abafb-da99-41a3-bf18-c07d75cb774f.jpg)

## Pre requirements
- Make sure squid is compiled with --enable-basic-auth-helpers=DB option.
- Use MySQL driver settings in the squid.conf file
https://wiki.squid-cache.org/ConfigExamples/Authenticate/Mysql
  
- Additional Module
  - https://github.com/39ff/squid-db-auth-ip
  

## Installation
- PHP8+
- composer
- MySQL


### All-in-one Docker configuration.
https://github.com/39ff/docker-squidmin-all-in-one

### Manual Installation
See Wiki
https://github.com/39ff/squid-db-auth-web/wiki

## Create an Administrator
```
php artisan db:seed --class=CreateAdministratorSeeder
```

