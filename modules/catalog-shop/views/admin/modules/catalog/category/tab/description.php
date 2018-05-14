<?php defined('SYSPATH') or die('No direct access allowed.');

	$orm = $helper_orm->orm();
	$labels = $orm->labels();
	$required = $orm->required_fields();
	

/**** image ****/
	
	echo View_Admin::factory('form/image', array(
		'field' => 'image',
		'value' => $orm->image,
		'orm_helper' => $helper_orm,
		'errors' => $errors,
		'labels' => $labels,
		'required' => $required,
// 		'help_text' => '360x240px',
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