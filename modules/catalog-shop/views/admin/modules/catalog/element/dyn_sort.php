<?php defined('SYSPATH') or die('No direct access allowed.'); ?>

<script>
	$(function(){
		var $list = $('.js-dyn-input');
		if ($list.length) {
			$(window).on('click', function(e){
				if ($(e.target).hasClass('casted-input')) {
					return;
				}
				$list.filter('.casted').each(function(){
					var $this = $(this);
					$('body').addClass('ajax-requestion');
					$.ajax({
						url: $this.data('action'),
						type: 'post',
						data: {
							id: $this.data('id'),
							field: $this.data('field'),
							value: $.trim($this.children('input').val())
						},
						dataType: 'json',
						cache: false
					}).done(function(data){
						$this.html(data);
					}).fail(function(){
						$this.html($this.data('value'));
					}).always(function(){
						$this.removeClass('casted');
						$('body').removeClass('ajax-requestion');
					});
				});
			});
			
			$list.on('click', function(e){
				e.stopPropagation();
			});
			$list.on('dblclick', function(e){
				var $this = $(this);
				$this.addClass('casted');
				$this.data('value', $.trim($this.text()));
				$this.html('<input class="casted-input" value="'+$this.data('value')+'" style="width:70px !important;">');
				$this.children('input').select();
			});
			$list.on("keydown", ".casted-input", function(e){
				switch(e.which) {
					case 27:
					case 13:
						$(this).parent()
							.trigger("click");
						e.preventDefault();
						$(this).parent()
							.trigger("click");
						break;
				}
			});
			$list.on("keypress", ".casted-input", function(e){
				if (e.which < 48 || e.which > 57) {
					return false;
				}
			});
		}
	});
</script>
