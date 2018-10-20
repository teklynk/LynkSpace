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
    DocumentRoot /var/www/html/LynkSpace/htdocs
    ServerName lynkspace.local
    <Directory "/var/www/html/LynkSpace/htdocs">
        allow from all
        Options None
        Require all granted
    </Directory>
</VirtualHost>

```
Nginx configuration

```

index index.php;

location ~ /\.|^\. {
    return 403;
}

autoindex off;

location / {
    if (!-e $request_filename){
        rewrite ^(.*)$ /index.php break;
    }
}

location ~ .(htaccess|htpasswd|ini|phps|fla|psd|log|sh)$ {
    deny all;
}

```
Nginx vhost

```

server_name lynkspace.local;

root /var/www/html/LynkSpace/htdocs;

location /var/www/html/LynkSpace/htdocs {
    allow all;
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

NPM (Development Tools)
YUI Compressor

```
npm install
```