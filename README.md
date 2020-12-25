# LynkSpace
Enable .htaccess by editing your sites-enabled config files: example
```
<Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
 Create a virtual host for the project: example
```
<VirtualHost 127.0.0.1:80>
   DocumentRoot /var/www/html/LynkSpace/htdocs
   ServerName lynkspace.local
   DirectoryIndex index.php
   <Directory "/var/www/html/LynkSpace/htdocs">
       allow from all
       Options None
       Require all granted
   </Directory>
</VirtualHost>
```
Nginx configuration: example
```
server_name lynkspace.local;

index index.php;

autoindex off;

root /var/www/html/LynkSpace/htdocs;

location /var/www/html/LynkSpace/htdocs {
    if (!-e $request_filename){
        rewrite ^(.*)$ /index.php break;
    }
}
```
 PHP Modules
```
curl
xml
zip
imagick
mbstring
mcrypt
mysqli
mysqlnd
```
 Apache Modules
```
mod_rewrite
mod_headers
mod_vhost_alias
```
Run Composer
```
composer install
```
NPM (Development Tools) YUI Compressor
```
npm install
```

Install Guide

- Go to the config directory and rename each -sample.php by removing the "-sample" so that 
    - config-sample.php becomes config.php
    - dbconn-sample.php becomes dbconn.php
    - blowfishsalt-sample.php becomes blowfishsalt.php
    
- Create a hash/salt and add it to the blowfishsalt.php file.
    - example: $2a$04$kqaxJ29XS/N.hQ0YWt.mu.ms1vjy.donotusethis
    - Good site for generating hashes: https://www.devglan.com/online-tools/bcrypt-hash-generator
    
- Update dbconn.php with your database server settings

- Import new_website.sql into your MySql database schema.

- Visit http://your_domain.com/admin 
    - You should now be prompted to create an Admin user.