//ca module
function getCity(){
	var province_id = parseInt($('#province').val());
	$.ajax({
		type:"POST",
		url:'/ca/company/acl_city',
		data:{id:province_id},
		success: function(data){
			var obj = eval("("+data+")");
			$('#_area').html(obj.area);
			$('#_city').html(obj.city);
		}
	});
}

function getArea(){
	var city_id = parseInt($('#city').val());
	$.ajax({
		type:"POST",
		url:'/ca/company/acl_area',
		data:{id:city_id},
		success: function(data){
			$('#_area').html(data);
		}
	});
}
//end

//member module
function _getCity(){
	var province_id = parseInt($('#province').val());
	$.ajax({
		type:"POST",
		url:'/member/membercompany/acl_city',
		data:{id:province_id},
		success: function(data){
			var obj = eval("("+data+")");
			$('#_area').html(obj.area);
			$('#_city').html(obj.city);
		}
	});
}

function _getArea(){
	var city_id = parseInt($('#city').val());
	$.ajax({
		type:"POST",
		url:'/member/membercompany/acl_area',
		data:{id:city_id},
		success: function(data){
			$('#_area').html(data);
		}
	});
}
//end