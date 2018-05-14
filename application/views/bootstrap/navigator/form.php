<?php echo Form::open($form->action(), $form->attrs()) ?>
	
	<?php 
		foreach($form->fields() as $field) : 
		
			if ($field->type() == 'text' || $field->type() == 'select') : 		
	?>	
			<div class="control-group <?php echo $field->error() ? 'error' : ''; ?>">
				<?php echo Form::label($field->name(), $field->label()) ?>
				<div class="controls">
					<?php echo $field; ?>
					
					<?php if ($field->error()) : ?>
					<span class="help-block"><?php echo HTML::chars($field->error()) ?></span>
					<?php endif; ?>
				</div>
			</div>	
	<?php 
			elseif($field->type() == 'radio'):
	?>
			<div class="radio">
					<?php echo $field; ?>
					
			</div>				
	<?php
			elseif($field->type() == 'hidden'):
			
				echo Form::hidden($field->name(), $field->value(), $field->attrs());
		
			endif;
			
		endforeach; 
	?>
	
	<div class="actions">
		<?php echo $form->submit() ?>
	</div>
	
<?php echo Form::close() ?>
