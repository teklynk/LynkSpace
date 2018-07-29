# LynkSpace

Enable .htaccess by editing your sites-enabled config files:

```
<Directory /var/www/>
    Options Indexes FollowSymLinks
    AllowOverride None
    Require all granted
</Directory>
 ```
 Create a virtual host for the project:
 ```
<VirtualHost 127.0.0.1:80>
    DocumentRoot /var/www/html/LynkSpace
    ServerName lynkspace.local
    <Directory "/var/www/html/LynkSpace">
        allow from all
        Options None
        Require all granted
    </Directory>
</VirtualHost>
 ```
 PHP Modules
```
curl
xml
zip
imagick
mbstring
mcrypt
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
NPM (Development Tools)
YUI Compressor
```
npm install
```