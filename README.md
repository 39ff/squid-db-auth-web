# squidmin
next generation squid user-management WebUI alternative proxymin,Squid Users Manager

![index](https://user-images.githubusercontent.com/7544687/79716113-a3db6000-8310-11ea-8f53-3f512e02aa46.PNG)


## Pre requirements
- Make sure squid is compiled with --enable-basic-auth-helpers=DB option.
- Use MySQL driver settings in the squid.conf file
https://wiki.squid-cache.org/ConfigExamples/Authenticate/Mysql
  
- Additional Module
  - https://github.com/39ff/squid-db-auth-ip
  

## Installation
PHP8+


## Todo
- [x] WebAPI
- [ ] WebGUI
- [x] Basic User Management
- [x] IP Address Management  
- [ ] Customize ACL Rules (ansible?)
- [ ] Documentation
- [ ] WebAPI Documentation  
- [x] Feature Tests
- [ ] E2E Tests  
- [ ] create docker-compose
- [ ] Multiple Server Management
- [ ] Metrics
