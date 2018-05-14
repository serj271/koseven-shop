<div class="row">
	<?php if (Arr::get($messages, 'success')) : ?>
	<div class="col-lg-12">
		<div class="alert alert-success" role="alert">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			<strong><?php echo __('Success!') ?>&nbsp;</strong>
			<?php echo join('<br>', $messages['success']) ?>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if (Arr::get($messages, 'error')) : ?>
	<div class="col-lg-12">
		<div class="alert alert-danger" role="alert">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			<strong><?php echo __('Woops!') ?>&nbsp;</strong>
			<?php echo join('<br>', $messages['error']) ?>
		</div>
	</div>
	<?php endif;
	
	if (Arr::get($messages, 'warning')) : ?>
	<div class="col-lg-12">
		<div class="alert alert-warning" role="alert">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			<strong><?php echo __('Warning!') ?>&nbsp;</strong>
			<?php echo join('<br>', $messages['warning']) ?>
		</div>
	</div>
	<?php endif;

	if (Arr::get($messages, 'notice')) : ?>	
	<div class="col-lg-12">
		<div class="alert alert-info" role="alert">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			<strong><?php echo __('Heads up!') ?>&nbsp;</strong>
			<?php echo join('<br>', $messages['notice']) ?>
		</div>
	</div>
	<?php endif; ?>
</div>