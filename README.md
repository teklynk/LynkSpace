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