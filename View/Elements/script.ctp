<script type="text/javascript" src="/js/libs/handlebars/handlebars-1.0.rc.1.js"></script>
<script type="text/javascript">
	var workflow_categories = <?php echo $params['params']['workflowCategories_json'];?> 
	var workflow_types = <?php echo $params['params']['workflowTypes_json'];?> 
	$(document).ready(function(){
	
		$('.editable').bind('click', function(){
			text_to_input($(this));
		});
		$('.editable').each(function() {
			clone_editable($(this));
		});
			
	});
	function clone_editable($this) {
		$element = $this.clone();
		$index = $this.parent().index($this);
		$element.insertAfter($this);
		$id = $element.attr('id');
		$tag = $element.get(0).tagName;
		$text = $element.text();
		$class = $element.attr('class');
		$type = $element.data('type');
		
		if ($type == 'text') {
			$element.replaceWith($('<input />').attr({id: $id+$type, class:'edit_element', type:'text',value:$text, 'data-id':$id}));
		} else if ($type == 'category-list') {
			$element.replaceWith($('<select />').attr({id: $id+$type, class:'edit_element', type:'list', 'data-id':$id}));
			$.each(workflow_categories, function(val, text) {
		    	$('#'+$id+$type).append(
			        $('<option></option>').val(val).html(text)
			    );
			});
		} else if ($type == 'type-list') {
			$element.replaceWith($('<select />').attr({id: $id+$type, class:'edit_element', type:'list', 'data-id':$id}));
			$.each(workflow_types, function(val, text) {
		    	$('#'+$id+$type).append(
			        $('<option></option>').val(val).html(text)
			    );
			});
		}
		$('#'+$id+$type).css('display', 'none');

		$('#'+$id+$type).blur(function(){
			input_to_text($(this));
		});
		
		$('#'+$id+$type).on('keyup', function(e) {
			var code = e.keyCode || e.which;
		    if (code == 13 || e.code == 9) {
		    	$this = $(this);
		    	$id = $this.data('id');
		        var ind = $('.editable').index($('#'+$id));
		        $this.blur();
		        $('.editable').eq(ind + 1).click();
		    }
		});
	}
	function text_to_input($this) {
		$id = $this.attr('id');
		// $tag = $this.get(0).tagName;
		// $text = $this.text();
		// $class = $this.attr('class');
		$type = $this.data('type');
		// if ($type == 'text') {
			// $this.replaceWith($('<input />').attr({id: $id, class:'editable', type:'text',value:$text}));
		// } else if ($type == 'list') {
			// $this.replaceWith($('<select />').attr({id: $id, class:'editable', type:'text',value:$text}));
			// $.each(workflow_categories, function(val, text) {
		    	// $('#'+$id).append(
			        // $('<option></option>').val(val).html(text)
			    // );
			// });
		// }
// 		
		// $('#'+$id).data('tag', $tag);
		// $('#'+$id).data('class', $class);
		// $('#'+$id).data('prev-text', $text);
		$('#'+$id+$type).css('display','');
		$('#'+$id).css('display','none');
		$('#'+$id+$type).focus();
		// $('#'+$id).blur(function(){
			// $this = $(this);
			// if ($this.val().length > 0) {
				// $text = $this.val();
			// } else {
				// $text = $this.data('prev-text');
			// }
// 
			// $id = $this.attr('id');
			// $class = $('#'+$id).data('class');
			// $this.replaceWith($('<'+$this.data('tag')+' />').attr({id: $id, class:$class}));
			// $('#'+$id).html($text);
			// $('#'+$id).bind('click', function(){
				// text_to_input($(this));
			// });
		// });
		
	}
	function input_to_text ($this) {
		if ($this.attr('type') == 'text') {
			$('#'+$this.data('id')).text($this.val());
		} else if ($this.attr('type') == 'list') {
			$id = $this.attr('id');
			console.log($('#'+$id+' option:selected').text());
			$('#'+$this.data('id')).text($('#'+$id+' option:selected').text());
		}
		
		$('#'+$this.data('id')).css('display', '');
		$this.css('display','none');
	}
	function create_object($name) {
		var source = $('#'+$name+'_list-template').html();
        var template = Handlebars.compile(source);
        var context = {count:$('.'+$name).length};
        return template(context);
	}
	
	function create_stage($from) {
		var html = create_object('stage');
		$('#'+$from+' .stages').append(html);
		$('#stage'+($('.stage').length-1)+' .editable').each(function() {
			clone_editable($(this));
		});
		$('#stage'+($('.stage').length-1)+' .editable').bind('click', function(){
			text_to_input($(this));
		});
	}
	function create_task($from) {
		var html = create_object('task');
		$('#'+$from+' .tasks').append(html);
		$('#task'+($('.task').length-1)+' .editable').each(function() {
			clone_editable($(this));
		});
		$('#task'+($('.task').length-1)+' .editable').bind('click', function(){
			text_to_input($(this));
		});
	}
	function create_step($from) {
		var html = create_object('step');
		$('#'+$from+' .steps').append(html);
		$('#step'+($('.step').length-1)+' .editable').each(function() {
			clone_editable($(this));
		});
		$('#step'+($('.step').length-1)+' .editable').bind('click', function(){
			text_to_input($(this));
		});
	}
	function swapUp($name) {
		var parent = $('#'+$name).parent().children();
		var ind = $('#'+$name).index();
		if (ind > 0) {
			$to = parent.eq(ind-1);
			$from = parent.eq(ind);
			var copyTo = $to.clone(true);
	        var copyFrom = $from.clone(true);
	        $to.replaceWith(copyFrom);
	        $from.replaceWith(copyTo);
		} 
	}
	function swapDown($name) {
		var parent = $('#'+$name).parent().children();
		var ind = $('#'+$name).index();
		var length = $('#'+$name).parent().children().length;
		if (ind < length -1) {
			$to = parent.eq(ind + 1);
			$from = parent.eq(ind);
			var copyTo = $to.clone(true);
	        var copyFrom = $from.clone(true);
	        $to.replaceWith(copyFrom);
	        $from.replaceWith(copyTo);
		} 
	}
</script>
<?php echo $this->Element('Workflows/stage');?>
<?php echo $this->Element('Workflows/task');?>
<?php echo $this->Element('Workflows/step');?>