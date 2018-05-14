<div id='result' >
    <?php echo Form::open("user/form/$id",array('id'=>'registration','onsubmit'=>'return validateForm(this);')); ?>
    <table class="table-bordered">   
    <?php foreach($results as $row){ ?>
	<tr><th>Табельный номер</th><td><?=$row['id']; ?></td><td></td></tr>
    <tr><th>Комната</th><td><?php echo $row['room']; ?></td><td></td></tr>
    <tr><th>Отделение</th><td><?php echo $row['department']; ?></td><td></td></tr>
    <tr><th>Имя</th><td><?php echo($row['first_name']." ".$row['name_name']." ".$row['last_name']);?></td><td></td></tr>
    <tr><th>Телефон</th><td><?php echo $row['phone']; ?></td><td></td></tr>
    <tr><th>Email</th><td ><input type="text" name="email" id="email"  readonly value="<?=$row['email_zimbra']  ?>" /></td><td><span class="error" ><?php echo Arr::get($errors,'email'); ?></span></td></tr>
    <tr><th>Логин для входа</th><td><input type='text' name='username' id="username" value="<?php echo $username; ?>" /> </td><td><span class="error"><?php echo Arr::get($errors,'username'); ?> </span></td></tr>
    <tr><th>Пароль</th><td><input type='password' name='password' id='password'></td><td><span class="error"><?php echo Arr::get($errors,'password'); ?></span></td></tr>  
    <tr><th>Повтор пароля</th><td><input type='password' name='password_confirm' id='password_confirm'></td><td><p class="error"><?= Arr::path($errors,'_external.password_confirm'); ?></p></td></tr>
    <tr><td>&nbsp;</td><td><?php echo Form::submit('login','Login'); ?></td><td></td></tr> 
    <?php } ?>
    </table>
    <?php echo Form::close(); ?>  
</div>