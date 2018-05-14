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
	);
	
	$open_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['category'],
		'query' => Helper_Page::make_query_string($query_array),
	));
	$elements_list_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['element'],
		'query' => Helper_Page::make_query_string($query_array),
	));
	
	$query_array['category'] = $CATALOG_CATEGORY_ID;
	if ( ! empty($BACK_URL)) {
		$query_array['back_url'] = $BACK_URL;
	}
	$delete_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['category'],
		'action' => 'delete',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
	
	$query_array = Paginator::query(Request::current(), $query_array);
	$edit_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['category'],
		'action' => 'edit',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));

	
	$query_array['mode'] = 'first';
	$first_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['category'],
		'action' => 'position',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
	$query_array['mode'] = 'up';
	$up_tpl	= Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['category'],
		'action' => 'position',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
	$query_array['mode'] = 'down';
	$down_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['category'],
		'action' => 'position',
		'id' => '{id}',
		'query' => Helper_Page::make_query_string($query_array),
	));
	$query_array['mode'] = 'last';
	$last_tpl = Route::url('modules', array(
		'controller' => $CONTROLLER_NAME['category'],
		'action' => 'position',
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
		$orm_helper = ORM_Helper::factory('Catalog_Category');
		foreach ($list as $_orm):
?>
			<tr>
				<td><?php echo $_orm->id ?></td>
				<td>
<?php
					echo View_Admin::factory('layout/list/image', array(
						'field' => 'image',
						'orm_helper' => $orm_helper,
						'value' => $_orm->image,
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
					
						echo HTML::anchor(str_replace('--CATEGORY_ID--', $_orm->id, $open_tpl), '<i class="icon-folder-open"></i> '.__('Open'), array(
							'class' => 'btn',
							'title' => __('Open category'),
						));
						if ($ACL->is_allowed($USER, $_orm, 'edit')) {
							echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
							echo '<ul class="dropdown-menu">';
								
								echo '<li>', HTML::anchor(str_replace('--CATEGORY_ID--', $_orm->id, $elements_list_tpl), '<i class="icon-list"></i> '.__('Elements list'), array(
									'title' => __('Elements list'),
								)), '</li>';
								
								echo '<li class="divider"></li>';
								
								echo '<li>', HTML::anchor(str_replace('{id}', $_orm->id, $edit_tpl), '<i class="icon-edit"></i> '.__('Edit'), array(
									'title' => __('Edit'),
								)), '</li>';
							
								echo '<li class="divider"></li>';
								
								echo View_Admin::factory('layout/controls/position', array(
									'orm' => $_orm,
									'first_tpl' => $first_tpl,
									'up_tpl' => $up_tpl,
									'down_tpl' => $down_tpl,
									'last_tpl' => $last_tpl,
								));
								
								if ( ! in_array($_orm->id, $not_deleted_categories)) {
									echo '<li>', HTML::anchor(str_replace('{id}', $_orm->id, $delete_tpl), '<i class="icon-remove"></i> '.__('Delete'), array(
										'class' => 'delete_button',
										'title' => __('Delete'),
									)), '</li>';
								}
							echo '</ul>';
						} else {
							echo '<li>', HTML::anchor(str_replace('--CATEGORY_ID--', $_orm->id, $elements_list_tpl), '<i class="icon-list"></i> '.__('Elements list'), array(
								'title' => __('Elements list'),
							)), '</li>';
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
	if (empty($BACK_URL)) {
		$query_array = array(
			'category' => $CATALOG_CATEGORY_ID,
		);
		$link = Route::url('modules', array(
			'controller' => $CONTROLLER_NAME['category'],
			'query' => Helper_Page::make_query_string($query_array),
		));
	} else {
		$link = $BACK_URL;
	}
	
	echo $paginator->render($link);