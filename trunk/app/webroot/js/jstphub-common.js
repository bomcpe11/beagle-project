
var G_WEB_ROOT = '';

function getURL(url){
	url = G_WEB_ROOT + url;
	return url.replace('//', '/');
}
function setDatePicker(selector){
	jQuery(selector).datepicker({
		showOn: 'button',
		buttonImage: getURL('img/calendar.png'),
		buttonImageOnly: true
	});
}
function setBirthDatePicker(selector){
	jQuery(selector).datepicker({
		showOn: 'button',
		buttonImage: getURL('img/calendar.png'),
		buttonImageOnly: true
	});
}