# img-src #

## about ##

php placeholder image generator used on [http://img-src.co](http://img-src.co "img-src.co").

## requirements ##

*  PHP 5.1.0 or higher

## how to use ##

### quick start ###

1.  copy the `/i/` folder and its contents to your web root directory
2.  that's it, you can now make placeholder images with the following format  
    `<img src="/i/?w=<width>&h=<height>&bgColor=<bg color hex>&textColor=<text color hex>" />`

examples:

	<img src="/i/?w=50&h=50" />
	<img src="/i/?w=50&h=80" />
	<img src="/i/?w=50&h=80&bgColor=eee" />
	<img src="/i/?w=50&h=80&bgColor=eee&textColor=999" />

### advanced setup ("pretty urls") ###

1.  copy the `/i/` folder and its contents to your web root directory
2.  set up the rewrite rules for your web server (see below)
3.  that's it, you can now make placeholder images with the following format (bg & text colors are optional)  
    `<img src="/<width>/<height>/<bg color hex>/<text color hex>" />`

examples:

	<img src="/50" />
	<img src="/50x80" />
	<img src="/50x80/eee" />
	<img src="/50x80/eee/999" />


**apache rewrites**: this can either go in an htaccess file or your site config file

	RewriteEngine On
	RewriteBase /
	RewriteRule ^(\d+)/?$ /i/index.php?w=$1&h=$1
	RewriteRule ^(\d+)x(\d+)/?$ /i/index.php?w=$1&h=$2
	RewriteRule ^(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$1&bgColor=$2
	RewriteRule ^(\d+)x(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$2&bgColor=$3
	RewriteRule ^(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$1&bgColor=$2&textColor=$3
	RewriteRule ^(\d+)x(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$ /i/index.php?w=$1&h=$2&bgColor=$3&textColor=$4

**nginx rewrites**: this needs to go in your site config file  

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

## shout outs ##

img-src uses the [White Rabbit](http://www.squaregear.net/fonts/whitrabt.shtml "White Rabbit") font by [Matthew Welch](http://www.squaregear.net/ "Matthew Welch").

## support ##

to report a bug, please use our [github issue tracker](https://github.com/img-src/placeholder/issues "github issue tracker").

better yet, if you find a bug, feel free to fix it and submit a pull request!

## license ##
img-src placeholder is distributed under the terms of the [MIT license](http://www.opensource.org/licenses/mit-license.php). copyright © 2012