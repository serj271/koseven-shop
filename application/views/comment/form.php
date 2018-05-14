<h2><?php echo $legend ?></h2>
<?php echo Form::open('comment', array('method'=>'POST')) ?> 


<p>
	<?php echo $comment->label('name') ?> 
	<?php echo $comment->input('name') ?> 
	<?php echo isset($errors['name']) ? '<span class="text-error">'.$errors['name'].'</span>' : ''; ?> 
</p>

<p>
	<?php echo $comment->label('email') ?> 
	<?php echo $comment->input('email') ?> 
	<?php echo isset($errors['email']) ? '<span class="text-error">'.$errors['email'].'</span>' : ''; ?> 
</p>

<p>
	<?php echo $comment->label('url') ?> 
	<?php echo $comment->input('url') ?> 
	<?php echo isset($errors['url']) ? '<span class="text-error">'.$errors['url'].'</span>' : ''; ?> 
</p>

<p>
	<?php echo $comment->label('state') ?> 
	<?php echo $comment->input('state') ?> 
	<?php echo isset($errors['state']) ? '<span class="text-error">'.$errors['state'].'</span>' : ''; ?> 
</p>

<p>
	<?php echo $comment->label('text') ?> 
	<?php echo $comment->input('text') ?> 
	<?php echo isset($errors['text']) ? '<span class="text-error">'.$errors['text'].'</span>' : ''; ?> 
</p>

<?php echo Form::hidden('token',Security::token()); ?>

<p class="submit">
	<?php echo Form::submit('submit', $submit) ?> 
</p>
<?php echo Form::close() ?> 
