# vadiasov/upload

## PHP configuration
PHP must be able to upload your files. That means that  upload_max_filesize and post_max_size
must be equal to appropriate value.

For example:

Find php.ini. Insert in the working file:
````
<?php
phpinfo();
````
Open this file in any browser. See where is your php.ini. Open it in terminal. For example (Ubuntu 16.04):
````
sudo nano /etc/php/7.0/fpm/php.ini
````
Find upload_max_filesize and post_max_size and change their values. For example:
````
post_max_size=128M
upload_max_filesize=128M
````
Then you need to restart PHP. For example:
````
service php7.0-fpm restart
````
After that check phpinfo() again to be sure that PHP got new values.
