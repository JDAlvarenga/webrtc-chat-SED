# webrtc-chat-SED

# Requirements
- Install Apache 2.4
- Install PHP 5.6
- Install Postrgesql (psql) 9.5

# Simple Install 
Clone this repo to any folder, copy the contents from ./webrtc-chat-SED/ to /var/www/html/

# Or Installation with Virtual Host Files
### Files and Folders
```sh
$ sudo mkdir -p /var/www/webchatsed.org/public
$ sudo chown -R $USER:$USER /var/www/webchatsed.org/public
$ sudo chmod -R 755 /var/www
```

### Clone this repo to /var/www
```sh
$ cd /var/www/webchatsed.org
$ git clone https://github.com/JDAlvarenga/webrtc-chat-SED.git .
$ composer install
```

### Create New Virtual Host Files
```sh
$ sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/webchatsed.org.conf
```

Open the new file in your editor with root privileges:

```sh
$ sudo nano /etc/apache2/sites-available/webchatsed.org.conf
```

The file will look something like this (I've removed the comments here to make the file more approachable):
```sh
<VirtualHost *:80>
    ServerAdmin admin@example.com
    ServerName webchatsed.org
    ServerAlias www.webchatsed.org
    DocumentRoot /var/www/webchatsed.org/public
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### Enable the New Virtual Host Files
```sh
$ sudo a2ensite example.com.conf
$ sudo service apache2 restart
```
