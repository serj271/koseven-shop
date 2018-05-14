<?php defined('SYSPATH') or die('No direct script access.');

return array(

	'default' => array(
		/**
		 * The following options must be set:
		 *
		 * string   key     secret passphrase
		 * integer  mode    encryption mode, one of MCRYPT_MODE_*
		 * integer  cipher  encryption cipher, one of the Mcrpyt cipher constants
		 */
		'cipher' => MCRYPT_RIJNDAEL_256,
		'mode'   => MCRYPT_MODE_ECB,
		'key'	=>'sdfg_HTR231naQl$',/* 16 24 or 32 symvols*/
	),

);
