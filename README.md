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