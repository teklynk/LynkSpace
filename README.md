# LynkSpace

Enable .htaccess by editing your sites-enabled config file:

```
<Directory /var/www/>
Options Indexes FollowSymLinks MultiViews
AllowOverride All
Order allow,deny
allow from all
</Directory>
 ```
 Create a virtual host for the project:
 ```
DocumentRoot /var/www/html/LynkSpace
ServerName lynkspace.local
<Directory "/var/www/html/LynkSpace">
allow from all
Options None
Require all granted
</Directory>
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
