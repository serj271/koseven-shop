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
	    echo HTML::script("media/js/".$scr.".js").PHP_EOL;
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
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="topNav">
		<div class="container">
			<div class="alignR">
				<div class="pull-left socialNw">
					<a href="#"><span class="icon-twitter"></span></a>
					<a href="#"><span class="icon-facebook"></span></a>
					<a href="#"><span class="icon-youtube"></span></a>
					<a href="#"><span class="icon-tumblr"></span></a>
				</div>
				<a class="active" href="<?=URL::base()?>"> <span class="icon-home"></span> Home</a> 
				<a href="<?=URL::base()?>user"><span class="icon-user"></span> My Account</a> 
				<a href="<?=URL::base()?>user/auth/join"><span class="icon-edit"></span> Free Register </a> 
				<a href="<?=URL::base()?>user/auth/login"><span class="icon-edit"></span> Login </a> 
				<a href="contact.html"><span class="icon-envelope"></span> Contact us</a>
				<a href="contact.html"><span class="icon-envelope"></span><?php echo $cart; ?></a>
				<a href="<?=URL::base()?>basket"><span class="icon-shopping-cart"></span> 2 Item(s) - <span class="badge badge-warning"> $448.42</span></a>
			</div>
		</div>
	</div>
</div>
-->
<!---
Navigation Bar Section 
-->
<div class="navbar">
	  <div class="navbar-inner">
		<div class="container">
		  <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </a>
		  <div class="nav-collapse">
			<ul class="nav">
			  <li class="active"><a href="<?=URL::base()?>">Home	</a></li>
			  <li class=""><a href="<?=URL::base()?>catalog">List View</a></li>
			  <li class=""><a href="<?=URL::base()?>product">List Product</a></li>
			  <li class=""><a href="three-col.html">Three Column</a></li>
			  <li class=""><a href="four-col.html">Four Column</a></li>
			  <li class=""><a href="general.html">General Content</a></li>
			</ul>
			<form action="#" class="navbar-search pull-left">
			  <input type="text" placeholder="Search" class="search-query span2">
			</form>
			<ul class="nav pull-right">
			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="icon-lock"></span> Login <b class="caret"></b></a>
				<div class="dropdown-menu">
				<form class="form-horizontal loginFrm">
				  <div class="control-group">
					<input type="text" class="span2" id="inputEmail" placeholder="Email">
				  </div>
				  <div class="control-group">
					<input type="password" class="span2" id="inputPassword" placeholder="Password">
				  </div>
				  <div class="control-group">
					<label class="checkbox">
					<input type="checkbox"> Remember me
					</label>
					<button type="submit" class="shopBtn btn-block">Sign in</button>
				  </div>
				</form>
				</div>
			</li>
			</ul>
		  </div>
		</div>
	  </div>
	</div>



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
	    <a title="To main" href="<?=URL::base()?>personal"></a>
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