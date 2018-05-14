<!DOCTYPE HTML >
<html>
<head>
<title><?php echo $title ?></title>
<!--<base href="https://web-remont.online/" />-->
    <meta charset="utf-8">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
    <?php 
	foreach($styles as $style){ 
	    echo HTML::style("media/css/".$style.".css");
	}
	foreach($scripts as $scr){
//	    echo HTML::script("js/".$scr.".js").PHP_EOL;
	}
    ?>
    <!--[if IE]>
	<link href="<?=URL::base()?>/media/css/ie-v4.css" rel="stylesheet" type="text/css">
    <![endif]-->

</head>
<body>

<div id="container">
<div id="gototop"> </div>

<!--
Navigation Bar Section 
-->
    <div id="main">
        <div id="all">
           <div id="in">
                <div id="center">
		    <?php echo $content;?>
					
				</div>
           </div>
           <div id="left">
		    <b class="bottom"></b>                
		    <b class="top"></b>                
                <div class="content">
		    <?php echo $navigator; ?>
                </div>
           </div>
        </div>
    </div>
<!--
    <div id="footer">
        <div class="contant">
            <b class="border lt"></b>
            <b class="border rt"></b>
	    <b class="bottom"></b>                
        </div>
    </div>
-->
</div>
<!--
<div id="header">
	<div id="logo">
	    <a title="To main" href="#"></a>
	</div>
	<?=$menu; ?>
	<?=$breadcrumbs; ?>

</div>
-->


<!--[if IE]>
    <script type="text/javascript">
	document.body.setAttribute('class','ie');
    </script>
<![endif]-->


</body>
</html>