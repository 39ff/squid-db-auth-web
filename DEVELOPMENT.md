## Getting started (BareMetal)
Start with a freshly CentOS7
```shell script
yum update
yum install squid git unzip "perl(DBD::mysql)"
yum install epel-release
rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
yum install --enablerepo=remi,remi-php74 php php-devel php-mbstring php-pdo php-gd php-mysql php-intl php-xml php-zip
git clone https://github.com/39ff/squidmin
```
- /etc/yum.repos.d/MariaDB.repo
```shell script
# MariaDB 10.4 CentOS repository list - created 2020-04-24 06:00 UTC
# http://downloads.mariadb.org/mariadb/repositories/
[mariadb]
name = MariaDB
baseurl = http://yum.mariadb.org/10.4/centos7-amd64
gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB
gpgcheck=1
```
```shell script
sudo yum install MariaDB-server MariaDB-client
systemctl start mariadb.service
systemctl enable mariadb
mysql -u root -p
> create user squidmin;
> create database squidmin;
> GRANT ALL PRIVILEGES ON squidmin.* TO squidmin@localhost IDENTIFIED BY 'squidmin';
> exit
```

```shell script
./composer.phar install --no-dev --optimize-autoloader
php bin/console doctrine:migrations:migrate
```

- /etc/squid/squid.conf
```shell script
#dbauth
auth_param basic program /usr/lib64/squid/basic_db_auth --dsn "DBI:mysql:database=squidmin" --user squidmin --password squidmin --plaintext --persist
auth_param basic children 5
auth_param basic realm Web-Proxy
auth_param basic credentialsttl 1 minute
auth_param basic casesensitive off
acl db-auth proxy_auth REQUIRED
http_access allow db-auth
http_access allow localhost
#end
```
