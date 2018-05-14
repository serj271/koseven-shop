<div id='result' >
<?php if ($uploaded_file): ?>
	<p class="lead">Upload success</p>
	<p>
		Here is your uploaded avatar:
		<img src="<?php echo URL::site("/uploads/$uploaded_file") ?>" alt="Uploaded avatar" />
	</p>
	<?php else: ?>
	<h1>Something went wrong with the upload</h1>
	<p><?php echo $error_message ?></p>
<?php endif ?>

</div>