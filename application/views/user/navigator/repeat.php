
<div class="panel">
<?php
echo Form::open($acrion='user');
#echo Form::hidden('hidden','form_sent');
echo "<span class='message'>".$message."</span>";
echo '<p>'.Form::submit('submit',Kohana::$config->load('personal.user.submit_repeat')).'</p>';
echo Form::close();
?>
</div>