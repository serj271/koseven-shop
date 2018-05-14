
<div id="result">
<?php
echo Form::open($acrion='user/login');
echo Form::hidden('hidden','login');
?>
<table>
    <tr><th>Логин для входа</th><td><input type='text' name='username' id="username" value="<?=$username ?>"  /></td><td><span class="error"><?php echo Arr::get($errors,'username'); ?> </span></td></tr>
    <tr><th>Пароль</th><td><input type='password' name='password' id='password'></td><td><span class="error"><?php echo Arr::get($errors,'password'); ?></span></td></tr>  
</table>
<?php
	echo '<p>'.Form::submit('submit',Kohana::$config->load('personal.user.formInfo')).'</p>';
	echo Form::close();

?>
</div>