# squidmin
squid user-management WebUI alternative proxymin,Squid Users Manager

Very simple and secure administration panel optimized for proxy distributors


## Pre requirements
- Make sure squid is compiled with --enable-basic-auth-helpers=DB option.
- Use MySQL driver settings in the squid.conf file
https://wiki.squid-cache.org/ConfigExamples/Authenticate/Mysql
  
- Additional Module
  - https://github.com/39ff/squid-db-auth-ip
  

## Installation
PHP8+,composer


## Create an Administrator
```
php artisan db:seed --class=CreateAdministratorSeeder
```

