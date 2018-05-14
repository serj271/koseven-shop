<p class="text-warning">
<?php 
	$lang = Lang::instance()->get();
//	Log::instance()->add(Log::NOTICE, $lang);
	if($lang == 'ru'){
	    I18n::lang('ru');	
	} else {
	    I18n::lang('en-us');		
	}
echo __('File not found');
echo '<br>'.$message;
?>
</p>