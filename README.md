# img-src #

## about ##

placeholder image generator used on [http://img-src.co](http://img-src.co "img-src.co").

## how to use ##

### quick start ###

deploy img-src placeholder files to your web root and you're ready to go using the format below.

    <img src="/i/?w=<width>&h=<height>&bgColor=<bg color hex>&textColor=<text color hex>" />

for example:

	<img src="/i/?w=50&h=50" />
	<img src="/i/?w=50&h=80" />
	<img src="/i/?w=50&h=80&bgColor=eee" />
	<img src="/i/?w=50&h=80&bgColor=eee&textColor=999" />

### advanced setup ###

to set up "pretty" urls like those used on [http://img-src.co](http://img-src.co "img-src.co"), you'll need to set up your web server to do some rewriting. in apache this can either be done in the configuration file or in an htaccess access file; in nginx you'll need to put this in your configuration file.

for example:

	<img src="/50" />
	<img src="/50x80" />
	<img src="/50x80/eee" />
	<img src="/50x80/eee/999" />

#### apache rewrites ####

	RewriteEngine On
	RewriteBase /
	RewriteRule ^(\d+)/?$ /i/index.php?w=$1&h=$1
	RewriteRule ^(\d+)x(\d+)/?$ /i/index.php?w=$1&h=$2
	RewriteRule ^(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$1&bgColor=$2
	RewriteRule ^(\d+)x(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$2&bgColor=$3
	RewriteRule ^(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/?$ /i/index.php?w=$1&h=$1&bgColor=$2&textColor=$3
	RewriteRule ^(\d+)x(\d+)/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})/([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$ /i/index.php?w=$1&h=$2&bgColor=$3&textColor=$4

#### nginx rewrites ####

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
	location ~* "^/(\d+)x(\d+)/?$" {
	    try_files $uri $uri/ /i/index.php?w=$1&h=$2;
	}
	location ~* "^/(\d+)/?$" {
	    try_files $uri $uri/ /i/index.php?w=$1&h=$1;
	}

## shout outs ##

img-src uses the [White Rabbit](http://www.squaregear.net/fonts/whitrabt.shtml "White Rabbit") font by [Matthew Welch](http://www.squaregear.net/ "Matthew Welch").