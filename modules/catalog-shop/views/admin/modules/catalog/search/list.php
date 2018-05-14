<?php defined('SYSPATH') or die('No direct access allowed.'); 

	echo View_Admin::factory('layout/breadcrumbs', array(
		'breadcrumbs' => $breadcrumbs
	));
	
	echo View_Admin::factory('modules/catalog/search/filter');

	if ($list->count() <= 0) {
		return;
	}

	$query_array = array(
		'category' => '--CATEGORY_ID--',
		'back_url' => Route::url('modules', array(
			'controller' => $CONTROLLER_NAME['search'],
			'query' => Helper_Page::make_query_string(array(
				'filter' => Request::current()->query('filter'),
			)),
		)),
	);

	$query_array = Paginator::query(Request::current(), $query_array);
	$delete_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['element'],
		'action' => 'delete',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
	$edit_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['element'],
		'action' => 'edit',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
?>

	<table class="table table-bordered table-striped">
		<colgroup>
			<col class="span1">
			<col class="span2">
			<col class="span4">
			<col class="span2">
		</colgroup>
		<thead>
			<tr>
				<th><?php echo __('ID'); ?></th>
				<th><?php echo __('Image'); ?></th>
				<th><?php echo __('Title'); ?></th>
				<th><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
<?php 			
		$orm_helper = ORM_Helper::factory('catalog_Element');
		foreach ($list as $_orm):
?>
			<tr>
				<td><?php echo $_orm->id; ?></td>
				<td>
<?php
					echo View_Admin::factory('layout/list/image', array(
						'field' => 'image_1',
						'orm_helper' => $orm_helper,
						'value' => $_orm->image_1,
					));
?>				
				</td>
				<td>
<?php
					if ( (bool) $_orm->active) {
						echo '<i class="icon-eye-open"></i>&nbsp;';
					} else {
						echo '<i class="icon-eye-open" style="background: none;"></i>&nbsp;';
					}
					echo HTML::chars($_orm->title);
?>
				</td>
				<td>
<?php 
					echo '<div class="btn-group">';
						if ($ACL->is_allowed($USER, $_orm, 'edit')) {
							echo HTML::anchor(str_replace(
								array('{id}', '--CATEGORY_ID--'),
								array($_orm->id, $_orm->category_id),
							$edit_tpl), '<i class="icon-edit"></i> '.__('Edit'), array(
								'class' => 'btn',
								'title' => __('Edit'),
							));
							echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
							echo '<ul class="dropdown-menu">';
								echo '<li>', HTML::anchor(str_replace(
									array('{id}', '--CATEGORY_ID--'),
									array($_orm->id, $_orm->category_id),
								$delete_tpl), '<i class="icon-remove"></i> '.__('Delete'), array(
									'class' => 'delete_button',
									'title' => __('Delete'),
								)), '</li>';
							echo '</ul>';
						}
					echo '</div>';
?>				
				</td>
			</tr>
<?php 
		endforeach;
?>
		</tbody>
	</table>
<?php
	$query_array = array(
		'filter' => Request::current()->query('filter'),
	);
	$link = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['search'],
		'query' => Helper_Page::make_query_string($query_array),
	));
	
	echo $paginator->render($link);
