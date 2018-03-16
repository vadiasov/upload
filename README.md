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

## Preparation
You need to have a directory to upload files. Decide first where do you want to place uploaded files. As rule it's some subdirectory in storage/app/public.

When you have decided about subdirectory:
* write it in a config (see next section)
* create it in a real file system
* get appropriate access (777) to it.

## Installation
1. Create row in the application root composer:
````
"require": {
      ...
        "vadiasov/upload": "^1.0",
      ...  
    },
````
2.Run in your terminal:
````
cd your_application_root
composer update
````
3.This package is developed with discovery feature. So it must itself to create row in a config/app.com about ServiceProvider:
````
/*
 * Package Service Providers...
 */
...
Vadiasov\Upload\UploadServiceProvider::class,
````
4.Publish Assets. dropzone.js and dropzone.css will be copied from the package to public/js and css directories accordingly. 
5.Edit config file that you will use in outer controller to start upload (for example: config/upload-admin.php):
5.1.For a single parent:
````
return [
    'rules'              => [
        'url'           => '/arts-store',
        'acceptedFiles' => 'image/*',
        'maxFilesize'   => '250000',
    ],
    'path'               => '/app/public/arts/',
    'db_table'           => 'arts',
    'id_item'            => 'album_id',
    'id_item_2'          => '',
    'column'             => 'file',
    'backUrl'            => '\Vadiasov\ArtsAdmin\Controllers\ArtsController@index',
    'pageHeader'         => 'Arts',
    'header'             => 'Add arts to the album ',
    'parent_table'       => 'albums',
    'parent_column_name' => 'title',
    'view'               => 'upload_3',
];
````
5.1.For a two-parents case:
````
return [
    'rules'                  => [
        'url'           => '/items-store',
        'acceptedFiles' => 'image/*',
        'maxFilesize'   => '250000',
    ],
    'path'                   => '/app/public/arts/',
    'db_table'               => 'arts',
    'id_item'                => 'album_id',
    'id_item_2'              => 'track_id',
    'column'                 => 'file',
    'backUrl'                => '\Vadiasov\ArtsAdmin\Controllers\ArtsController@indexTrack',
    'pageHeader'             => 'Arts',
    'header'                 => 'Add arts to the track ',
    'header_second_part'     => ' of the album ',
    'parent_db_table'        => 'albums',
    'sub_parent_db_table'    => 'tracks',
    'parent_column_name'     => 'title',
    'sub_parent_column_name' => 'title',
    'view'                   => 'upload_4',
];
````
* where url - package route of package controller function that process files
* acceptedFiles - mime rules for uploading files
* maxFilesize - maximum file size that is accepted
* path - path to directory of uploaded files
* db_table - DB table name where you save file names of uploaded files
* column - table column name that keep file names of uploaded files
* id_item - table column name that you can use to bind uploaded file to. For example, "album_id" of album that has this file (track).
* backUrl - route name for a button "Back" under the form of uploading (you uploaded all files and click it to come back to somewhere).
* header - String that may be inserted in the Upload form header (with title of an album).
* parent_table - DB table name of parent packages. For example may be used to get a title of album.
* parent_column_name - DB table column name of parent packages. For example may be used to get a title of album.
 

## Using
Open page with route for a single parent:
````
'/tracks-upload/{config}/{id}'
````
Open page with route for a two-parents case:
````
'/tracks-upload/{config}/{first_parent_id}/{second_parent_id}'
````
to open upload form.
Where 
* config - name of config file (see p.4 - upload-admin)
* id - parameter that you can use (for examle: id of album that has to include uploading tracks).

Example:
* first parent - Album
* second parent - tracks
we upload arts for a specific track of an album. 


