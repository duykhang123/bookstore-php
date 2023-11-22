function changeStatus(link){
	$.ajax({
		url: link,
		dataType : 'json'
	  }).success(function(data) {
		var id = data[0];
		var status = data[1];
		var link = data[2];
		var element = 'a#status-' + id;
		classRemove = 'publish';
		classAdd = 'unpublish';
		if(status == 1){
			classRemove = 'unpublish';
			classAdd = 'publish';
		}
		$(element).attr('href',"javascript:changeStatus('"+link+"')");
		$(element + ' span').removeClass(classRemove).addClass(classAdd);
	  });
}

function changeACP(link){
	$.ajax({
		url: link,
		dataType : 'json'
	  }).success(function(data) {
		var id = data[0];
		var group_acp = data[1];
		var link = data[2];
		var element = 'a#group-acp-' + id;
		var classRemove = 'publish';
		var classAdd = 'unpublish';
		if(group_acp == 1){
			classRemove = 'unpublish';
			classAdd = 'publish'
		}
		$(element).attr('href',"javascript:changeACP('"+link+"')");
		$(element + ' span').removeClass(classRemove).addClass(classAdd);
	  });
}

function changeSpecial(link){
	$.ajax({
		url: link,
		dataType : 'json'
	  }).success(function(data) {
		var id = data[0];
		var group_acp = data[1];
		var link = data[2];
		var element = 'a#special-acp-' + id;
		var classRemove = 'publish';
		var classAdd = 'unpublish';
		if(group_acp == 1){
			classRemove = 'unpublish';
			classAdd = 'publish'
		}
		$(element).attr('href',"javascript:changeSpecial('"+link+"')");
		$(element + ' span').removeClass(classRemove).addClass(classAdd);
	  });
}

function submitForm(url){
	$('#adminForm').attr('action', url);
	$('#adminForm').submit();
}

function sortList(column, order){
	$('input[name=filter_column]').val(column);
	$('input[name=filter_column_dir]').val(order);
	$('#adminForm').submit();
}

function changePage(page){
	$('input[name=filter_page]').val(page);
	$('#adminForm').submit();
}

$(document).ready(function(){
	$('input[name=checkall-toggle]').change(function(){
		var check = this.checked;
		$('#adminForm').find(':checkbox').each(function(){
			this.checked = check;
		})
	})

	$('#filter-bar button[name=submit_keyword]').click(function(){
		$('#adminForm').submit();
	})

	$('#filter-bar button[name=clear_keyword]').click(function(){
		$('input[name=filter_search]').val('');
		$('#adminForm').submit();
	})

	$('#filter-bar select[name=filter_state]').change(function(){
		$('#adminForm').submit();
	})

	$('#filter-bar select[name=filter_group_acp]').change(function(){
		$('#adminForm').submit();
	})

	$('#filter-bar select[name=filter_group_id]').change(function(){
		$('#adminForm').submit();
	})

	$('#filter-bar select[name=filter_category_id]').change(function(){
		$('#adminForm').submit();
	})

	$('#filter-bar select[name=filter_special]').change(function(){
		$('#adminForm').submit();
	})
})