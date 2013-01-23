# img-src.co Placeholder Image Generator #

## About ##

PHP placeholder image generator used on [http://img-src.co](http://img-src.co "img-src.co").

## Requirements ##

*  PHP 5.1.0 or higher

## How to use ##

### Quick start ###

1.  Copy the `/i/` folder and all of its contents to your web root directory.
2.  You're now ready to make placeholder images using the following format:  
    `<img src="/i/?w={width}&h={height}&bgColor={background color hex}&textColor={text color hex}" />`

Examples:

    <img src="/i/?w=50&h=50" />
    <img src="/i/?w=50&h=80" />
    <img src="/i/?w=50&h=80&bgColor=eee" />
    <img src="/i/?w=50&h=80&bgColor=eee&textColor=999" />

### Advanced setup ("pretty URLs") ###

1.  Copy the `/i/` folder and all of its contents to your web root directory.
2.  Set up the rewrite rules for your web server (see below).
3.  You're now ready to make placeholder images using the following format (background & text colors are optional):  
    `<img src="/{width}/{height}/{background color hex}/{text color hex}" />`

Examples:

    <img src="/50" />
    <img src="/50x80" />
    <img src="/50x80/eee" />
    <img src="/50x80/eee/999" />


**Apache rewrites**: This can either go in an .htaccess file or your site config file. A sample .htaccess file is included in the repository.

    RewriteEngine On
    RewriteBase /
    RewriteRule ^(\d+)/?$ /i/index.php?w=$1&h=$1
    RewriteRule ^(\d+)x(\d+)/?$ /i/index.php?w=$1&h=$2
    RewriteRule ^(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$1&bgColor=$2
    RewriteRule ^(\d+)x(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$2&bgColor=$3
    RewriteRule ^(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$1&bgColor=$2&textColor=$3
    RewriteRule ^(\d+)x(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$2&bgColor=$3&textColor=$4

**Nginx rewrites**: This needs to go in your site config file. A sample config file is included in the repository that can be included by your site config.

    location ~* "^/(\d+)x(\d+)/([a-f0-9]{3}|[a-f0-9]{6})/([a-f0-9]{3}|[a-f0-9]{6})/?$" {  
      try_files $uri $uri/ /i/index.php?w=$1&h=$2&bgColor=$3&textColor=$4;  
    }  
    location ~* "^/(\d+)/([a-f0-9]{3}|[a-f0-9]{6})/([a-f0-9]{3}|[a-f0-9]{6})/?$" {  
      try_files $uri $uri/ /i/index.php?w=$1&h=$1&bgColor=$2&textColor=$3;  
    }  
    location ~* "^/(\d+)x(\d+)/([a-f0-9]{3}|[a-f0-9]{6})/?$" {  
      try_files $uri $uri/ /i/index.php?w=$1&h=$2&bgColor=$3;  
    }  
    location ~* "^/(\d+)/([a-f0-9]{3}|[a-f0-9]{6})/?$" {  
      try_files $uri $uri/ /i/index.php?w=$1&h=$1&bgColor=$2;  
    }  
    location ~ "^/(\d+)x(\d+)/?$" {
      try_files $uri $uri/ /i/index.php?w=$1&h=$2;  
    }  
    location ~ "^/(\d+)/?$" {
      try_files $uri $uri/ /i/index.php?w=$1&h=$1;  
    }

## Support ##

To report a bug, please use our [GitHub issue tracker](https://github.com/img-src/placeholder/issues "GitHub issue tracker"). Better yet, if you find a bug, feel free to fork our code and submit a pull request with your fix.

## License ##

The img-src.co placeholder image generator is distributed under the terms of the [MIT license](http://www.opensource.org/licenses/mit-license.php). copyright © 2012-2013