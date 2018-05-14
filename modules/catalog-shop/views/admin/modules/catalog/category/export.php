<?php defined('SYSPATH') or die('No direct access allowed.');

	echo "category_id;title;code;path\r\n";
	foreach ($list as $_item) {
		echo $_item['id'], ';"', $_item['title'], '";"', $_item['code'], '";"', implode(' -> ', $_item['path']), '"', "\r\n";
	}
