<div id='result' >
<?php
    echo HTML::anchor('/user/logout',Kohana::$config->load('personal.user.private.message')).'<br>';
    echo HTML::anchor('/user/phoneedit',Kohana::$config->load('personal.user.private.phoneedit')).'<br>';
#    echo HTML::anchor('/user/file',Kohana::$config->load('personal.user.private.upload.title')).'<br>';
#    echo HTML::anchor('/user/avatar',Kohana::$config->load('personal.user.private.avatar.title')).'<br>';

?>


</div>