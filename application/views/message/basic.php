<ul id="messages">
	<?php if (Arr::get($messages, 'success')) : ?>
		<li class="text-info">
			<?php echo join('<br>', $messages['success']) ?>
		</li>
	<?php endif; ?>	
	<?php if (Arr::get($messages, 'error')) : ?>
		<li class="text-error">
			<?php echo join('<br>', $messages['error']) ?>
		</li>
	<?php endif;
	
	if (Arr::get($messages, 'warning')) : ?>
		<li class="text-warning">
			<?php echo join('<br>', $messages['warning']) ?>
		</li>
	<?php endif;

	if (Arr::get($messages, 'notice')) : ?>	
		<li class="text-info">
			<?php echo join('<br>', $messages['notice']) ?>
		</li>
	<?php endif; ?>
</ul>
