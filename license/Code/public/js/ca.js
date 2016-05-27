function getCity(){
	var province_id = parseInt($('#province').val());
	$.ajax({
		type:"POST",
		url:'/ca/company/city',
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
		url:'/ca/company/area',
		data:{id:city_id},
		success: function(data){
			$('#_area').html(data);
		}
	});
}














/* function getProvince(){
	var country_id = parseInt($('#place_country').val());
	$.ajax({
		type:"POST",
		url:'/ca/company/province',
		data:{id:country_id},
		success: function(data){
			$('#_county').html('');
			$('#_area').html('');
			$('#_city').html('');
			$('#_province').html(data);
		}
	});
	$('#place').val(country_id);
}
	
function getCity(){
	var province_id = parseInt($('#place_province').val());
	$.ajax({
		type:"POST",
		url:'/ca/company/city',
		data:{id:province_id},
		success: function(data){
			$('#_county').html('');
			$('#_area').html('');
			$('#_city').html(data);
		}
	});
	var pObj = $('#place');
	if(province_id===0){
		pObj.val(parseInt($('#place_country').val()));
	}else{
		pObj.val(province_id);
	}
}

function getArea(){
	var city_id = parseInt($('#place_city').val());
	$('#_county').html('');
	var pObj = $('#place');
	if(city_id===0){
		pObj.val(parseInt($('#place_province').val()));		
	}else{
		pObj.val(city_id);
	}
} */
