# nginx
wget http://nginx.org/download/nginx-1.11.7.tar.gz
tar xzf nginx-1.11.7.tar.gz
cd nginx-1.11.7
yum install gcc pcre-devel zlib-devel -y
./configure --prefix=/usr/local/nginx
make && make install

# php
yum install gcc gcc-c++ libxml2-devel 
libXpm libXpm-devel libcurl-devel libjpeg-devel 
libpng-devel libwebp-devel freetype-devel 
libicu-devel libmcrypt-devel libtidy-devel -y

./configure \
    --prefix=/usr/local/php \
    --enable-fpm \
    --with-fpm-user=nobody \
    --with-fpm-group=nobody \
    --with-config-file-path=/usr/local/php/etc \
    --with-config-file-scan-dir=/usr/local/php/etc/config.d \
    --with-openssl \
    --with-pcre-regex \
    --with-pcre-jit \
    --with-zlib \
    --enable-calendar \
    --with-curl \
    --enable-exif \
    --enable-ftp \
    --enable-intl \
    --enable-mbstring \
    --enable-mysqlnd \
    --with-mcrypt \
    --with-mysqli \
    --with-pdo-mysql \
    --enable-sockets \
    --with-tidy \
    --with-gd \
    --with-jpeg-dir=/usr/local  \
    --with-png-dir=/usr/local \
    --with-freetype-dir=/usr/local \
    --with-webp-dir=/usr/local \
    --with-xpm-dir=/usr/local

make && make install
cp ./sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm
chmod +x /etc/init.d/php-fpm

cp php.ini-production /usr/local/php/etc/php.ini
cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf
cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf

# composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '61069fe8c6436a4468d0371454cf38a812e451a14ab1691543f25a9627b97ff96d8753d92a00654c21e2212a5ae1ff36') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

mv composer.phar /usr/local/php/bin/composer
composer --version

# mariadb
vi /etc/yum.repos.d/MariaDB.repo

```
# MariaDB 10.1 CentOS repository list - created 2016-12-27 04:54 UTC
# http://downloads.mariadb.org/mariadb/repositories/
[mariadb]
name = MariaDB
baseurl = http://yum.mariadb.org/10.1/centos7-amd64
gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB
gpgcheck=1
```
yum install MariaDB-server MariaDB-client MariaDB-devel -y

# erlang
wget http://erlang.org/download/otp_src_19.2.tar.gz
tar xzf otp_src_19.2.tar.gz
cd otp_src_19.2
./configure --prefix=/usr/local/erlang
make && make install

# emqtt
git clone https://github.com/emqtt/emq-relx.git
cd emq-relx && make
cd _rel/emqttd && ./bin/emqttd console