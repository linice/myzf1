$(document).ready(function(){
	$('#email').focus();
	
	$('#email').keydown(function(event){
		if (event.keyCode==13) 
			login();
	});
	
	$('#passwd').keydown(function(event){
		if (event.keyCode==13) 
			login();
	});
	
	$('#btn_login').click(function(){
		login();
	});
	
}); //End: $(document).ready


function login()
{
	var email = trim($('#email').val());
	var passwd = trim($('#passwd').val());
	var obj = {'email':email, 'passwd':passwd};
	var param = $.param(obj);
	
//	$('#btn_login').attr({'disabled': true});
	
	if (email == '') {
		$('#tipsLogin').html('Email不能为空');
		return;
	} else if (!isEmail(email)) {
		$('#tipsLogin').html('Email不合法');
		return;
	}
	if (passwd == '') {
		$('#tipsLogin').html('密码不能为空');
		return;
	}
	
	$.ajax({
		url: '/default/login/login',
		type: 'post',
		data: param,
		dataType: 'html', //xml, json, script or html
		success: function(data){
//			$('#bbBinView').css('display', 'block');
//			$('#bbBinModify').css('display', 'none');
//			alert(data);
//			location.reload(true);
			$('#tipsLogin').html('');
//			location.href='/';
//			history.go(-1);
		},
		error: function(data){
			$('#btn_login').attr({'disabled': false});
			$('#tipsLogin').html(data);
		}
	});
}
