/******************js工具函数**********************/

//删除字符串前后的空格。
function trim(str){
	var regExp = /^\s*(.*?)\s*$/;
	return str.replace(regExp, "$1");
}


function isMobile(mobile)
{
	var pattern = /^0?1[358]\d{9}$/;
//	var mobile = "18676660185";
	return pattern.test(mobile);
}


function isTel(tel)
{
	var pattern = /^0?\d{2,3}[-_－—\s]?\d{7,8}([-_－—\s]\d{3,})?$/;
//	str = "746 4831012 123";
	return pattern.test(tel);
}


function isEmail(email)
{
	//摘自php和MySQL开发
	var pattern = /^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+$/;
	return pattern.test(email);
}
