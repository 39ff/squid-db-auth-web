# squidmin
next generation squid user-management WebUI alternative proxymin,Squid Users Manager

![index](https://user-images.githubusercontent.com/7544687/79716113-a3db6000-8310-11ea-8f53-3f512e02aa46.PNG)


## Pre requirements
- Make sure squid is compiled with --enable-basic-auth-helpers=DB option.
- Use MySQL driver settings in the squid.conf file
https://wiki.squid-cache.org/ConfigExamples/Authenticate/Mysql

## Installation
PHP7+ , [DEVELOPMENT.md](DEVELOPMENT.md) 

## Todo
- [x] Basic User Management
- [ ] Add Authorization
- [ ] Customize ACL Rules
- [ ] Documentation

## Project Goal
A secure and reliable management panel.

## Inspired by
- http://freshmeat.sourceforge.net/projects/proxymin
- http://freshmeat.sourceforge.net/projects/squsermanager