
<div class="panel ">
<?php
echo Form::open($acrion='user',array('id'=>'pre'));
echo "<div class='controls'>";
echo Form::hidden('hidden','form_sent');
echo "<span class='text-info help-block'>".$message."</span>";
echo '<p  >'.Form::input('job',$value=NULL,array('id'=>'job','class'=>'')).'</p>';
#echo '<p>'.Form::submit('submit',Kohana::$config->load('personal.user.submit')).'</p>';
echo '<button type="submit"><span><span>'.Kohana::$config->load("personal.personalviewer.button").'</span></span></button>';
echo "</div>";
echo Form::close();

?>
</div>