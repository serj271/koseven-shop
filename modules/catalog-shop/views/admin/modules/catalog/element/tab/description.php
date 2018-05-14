<?php defined('SYSPATH') or die('No direct access allowed.');

	$orm = $helper_orm->orm();
	$labels = $orm->labels();
	$required = $orm->required_fields();
	

/**** announcement ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'announcement',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls' => Form::textarea('announcement', $orm->announcement, array(
			'id' => 'announcement_field',
			'class' => 'text_editor',
		)),
	));
	
/**** text ****/
	
	echo View_Admin::factory('form/control', array(
		'field' => 'text',
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
		'controls' => Form::textarea('text', $orm->text, array(
			'id' => 'text_field',
			'class' => 'text_editor',
		)),
	));
	