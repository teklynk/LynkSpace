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
    
Screenshots
# Screenshots
![screenshot01](https://github.com/teklynk/LynkSpace/blob/development/screenshots/screenshot01.png)
![screenshot02](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot02.png)
![screenshot03](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot03.png)
![screenshot04](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot04.png)
![screenshot05](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot05.png)
![screenshot06](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot06.png)
![screenshot07](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot07.png)
![screenshot08](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot08.png)
![screenshot09](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot09.png)
![screenshot10](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot10.png)
![screenshot11](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot11.png)
![screenshot12](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot12.png)
![screenshot13](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot13.png)
![screenshot14](https://github.com/teklynk/lynkspace/blob/development/screenshots/screenshot14.png)