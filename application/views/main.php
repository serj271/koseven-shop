<!DOCTYPE HTML >
<html>
<head>
	<title><?php echo $title ?></title>
<!--	<base href="http://web-remont.online/" /> -->
    <meta charset="utf-8">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
    <?php 
	foreach($styles as $style){ 
	    echo HTML::style("media/css/".$style.".css", NULL, 'http');
	}
	foreach($scripts as $scr){
//	    echo HTML::script("media/js/".$scr).PHP_EOL;
	}
//	    echo HTML::script("media/js/public/common.js").PHP_EOL;
    ?>
    <!--[if IE]>
	<link href="<?=URL::base()?>/media/css/ie-v4.css" rel="stylesheet" type="text/css">
    <![endif]-->

</head>
<body>

<div id="container">
<div id="gototop"> </div>
<?php echo $fixedTop;?>

<?php echo $header; ?>
<!--
Navigation Bar Section 
-->
<?php echo $navbar; ?>

    <div id="main">
        <div id="all">
           <div id="in">
                <div id="center">
		    <?php echo $breadcrumbs;?>
		    <?php echo $content;?>
					
				</div>
           </div>
           <div id="left">
		    <b class="bottom"></b>                
		    <b class="top"></b>                
                <div class="content">
		    

		    <div class="panel">
			<p class="text-info">
			    <?php echo $navigator; ?>
			</p>
		    </div>
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

</div>
-->


<!--[if IE]>
    <script type="text/javascript">
	document.body.setAttribute('class','ie');
    </script>
<![endif]-->


</body>
</html>