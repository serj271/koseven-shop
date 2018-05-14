
<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</a>
			<div class="nav-collapse">
			<?php if (isset($navbar_items)){?>
				<ul class="nav">
				<?php foreach($navbar_items as $item){?>
					<li class="<?php if($item['active']) echo 'active'?>"><?php echo HTML::anchor($item['url'],$item['text']);?></li>
				<?php } ?>
				</ul>
			<?php }?>
			<form action="#" class="navbar-search pull-left">
			  <input type="text" placeholder="Search" class="search-query span2" />
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
									<input type="password" class="span2" id="inputPassword" placeholder="Password" />
								</div>
								<div class="control-group">
									<label class="checkbox">
									<input type="checkbox" /> Remember me
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

