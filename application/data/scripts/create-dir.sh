#!/usr/local/bin/bash

cache=/usr/local/www/koseven-shop/application/cache

logs=/usr/local/www/koseven-shop/application/logs

echo 'ok'
if [ -d $cache ]
    then
	echo ' cache exists'
    else 
	echo 'create cache directory'
	mkdir $cache
	chmod +x $cache
	chown www:www  $cache
fi

if [ -d $logs ]
    then
	echo ' log exists'
    else 
	echo 'create log directory'
	mkdir $logs
	chmod +x $logs
	chown www:www $logs
fi

echo 'done'

exit 1