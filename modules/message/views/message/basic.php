<ul id="messages">
	<?php foreach( $messages as $message ): ?>
		<li class="<?php echo $message->type; ?>">
			<?php echo $message; ?>
		</li>
	<?php endforeach; ?>
</ul>
