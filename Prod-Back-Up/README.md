# IT490Project

File Hirarchy 


IT490Project

    Prod
        lib
            .env
            config.php
            db.php
            functions.php

        partials 
            footer.php
            flash.php
            nav.php

        public_html
            css
                styles.css
            js
                form_validation.js
            rabbitmqphp_example
                rpc
                    local.ini
                    loginRequest.php
                    path.inc
                .testRabbitMQClient.php.swp
                composer.json
                get_host_info.inc
                host.ini
                local.ini
                mongoClient.php
                mysqlconnect.php
                path.ini
                rabbitMQ_db.ini
                rabbitMQLib.inc
                README.md
                soccerData.php
                testphp.php
                testRabbitMQ.ini
                testRabbitMQClient.php
                testRabbitMQServer.conf
                testRabbitMQServer.monit
                testRabbitMQServer.php
            server_functions
                auth_server.php
                worker.php
            home.php
            login_register.php
            logout.php


    Dev
        lib
            .env
            config.php
            db.php
            functions.php

        partials 
            footer.php
            flash.php
            nav.php

        public_html
            css
                styles.css
            js
                form_validation.js
            rabbitmqphp_example
                rpc
                    local.ini
                    loginRequest.php
                    path.inc
                .testRabbitMQClient.php.swp
                composer.json
                get_host_info.inc
                host.ini
                local.ini
                mongoClient.php
                mysqlconnect.php
                path.ini
                rabbitMQ_db.ini
                rabbitMQLib.inc
                README.md
                soccerData.php
                testphp.php
                testRabbitMQ.ini
                testRabbitMQClient.php
                testRabbitMQServer.conf
                testRabbitMQServer.monit
                testRabbitMQServer.php
            server_functions
                auth_server.php
                worker.php
            home.php
            login_register.php
            logout.php


    QA_testing
        lib
            .env
            config.php
            db.php
            functions.php

        partials 
            footer.php
            flash.php
            nav.php

        public_html
            css
                styles.css
            js
                form_validation.js
            rabbitmqphp_example
                rpc
                    local.ini
                    loginRequest.php
                    path.inc
                .testRabbitMQClient.php.swp
                composer.json
                get_host_info.inc
                host.ini
                local.ini
                mongoClient.php
                mysqlconnect.php
                path.ini
                rabbitMQ_db.ini
                rabbitMQLib.inc
                README.md
                soccerData.php
                testphp.php
                testRabbitMQ.ini
                testRabbitMQClient.php
                testRabbitMQServer.conf
                testRabbitMQServer.monit
                testRabbitMQServer.php
            server_functions
                auth_server.php
                worker.php
            home.php
            login_register.php
            logout.php



#restart apache2
sudo systemctl restart apache2






sudo nano /etc/hosts

127.0.0.1       localhost
127.0.1.1       alejo.myguest.virtualbox.org    alejo

# The following lines are desirable for IPv6 capable hosts
::1     ip6-localhost ip6-loopback
fe00::0 ip6-localnet
ff00::0 ip6-mcastprefix
ff02::1 ip6-allnodes
ff02::2 ip6-allrouters


sudo nano /etc/apache2/apache2.conf
<Directory />
        Options FollowSymLinks
        AllowOverride None
        Require all denied
</Directory>

<Directory /usr/share>
        AllowOverride None
        Require all granted
</Directory>

<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>

<VirtualHost *:80>
    DocumentRoot /var/www/html/IT490Project/
    ServerName localhost
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>


Cerfificates for HTTPS are at 
/etc/httpd/certs

If you want to set up HTTPS for it490project.local, you'll need to add a <VirtualHost *:443> section in your it490project.conf with SSL configurations:
<IfModule mod_ssl.c>
    <VirtualHost *:443>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/IT490Project/Prod/public_html
        ServerName it490project.local
        ServerAlias www.it490project.local

        SSLEngine on
        SSLCertificateFile /path/to/your/certificate.crt
        SSLCertificateKeyFile /path/to/your/private.key

        <Directory /var/www/html/IT490Project/Prod/public_html>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
</IfModule>

