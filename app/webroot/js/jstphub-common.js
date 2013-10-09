
var G_WEB_ROOT = '';

function getURL(url){
	url = G_WEB_ROOT + url;
	return url.replace('//', '/');
}
function setDatePicker(selector){
	var separator = "/";
	var dateBefore = null;
	jQuery(selector).datepicker({
		showOn: 'button',
		buttonImage: getURL('img/calendar.png'),
		buttonImageOnly: true,
		beforeShow:function(){
			if(jQuery(this).val()!=""){
				var arrayDate=jQuery(this).val().split(separator);		
				arrayDate[2]=parseInt(arrayDate[2])-543;
				jQuery(this).val(arrayDate[0]+separator+arrayDate[1]+separator+arrayDate[2]);
			}
			setTimeout(function(){
				jQuery.each(jQuery(".ui-datepicker-year option"),function(j,k){
					var textYear=parseInt(jQuery(".ui-datepicker-year option").eq(j).val())+543;
					jQuery(".ui-datepicker-year option").eq(j).text(textYear);
				});				
			},50);

		},
		onChangeMonthYear: function(){
			setTimeout(function(){
				jQuery.each(jQuery(".ui-datepicker-year option"),function(j,k){
					var textYear=parseInt(jQuery(".ui-datepicker-year option").eq(j).val())+543;
					jQuery(".ui-datepicker-year option").eq(j).text(textYear);
				});				
			},50);		
		},
		onClose:function(){
			if(jQuery(this).val()!="" && jQuery(this).val()==dateBefore){			
				var arrayDate=dateBefore.split(separator);
				arrayDate[2]=parseInt(arrayDate[2])+543;
				jQuery(this).val(arrayDate[0]+separator+arrayDate[1]+separator+arrayDate[2]);	
			}		
		},
		onSelect: function(dateText, inst){ 
			dateBefore=jQuery(this).val();
			var arrayDate=dateText.split(separator);
			arrayDate[2]=parseInt(arrayDate[2])+543;
			jQuery(this).val(arrayDate[0]+separator+arrayDate[1]+separator+arrayDate[2]);
		}
	});
	//jQuery(selector).css('display', 'none');
}
function setBirthDatePicker(selector){
	var separator = "/";
	var dateBefore = null;
	jQuery(selector).datepicker({
		showOn: 'button',
		buttonImage: getURL('img/calendar.png'),
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+0",
		beforeShow:function(){
			if(jQuery(this).val()!=""){
				var arrayDate=jQuery(this).val().split(separator);		
				arrayDate[2]=parseInt(arrayDate[2])-543;
				jQuery(this).val(arrayDate[0]+separator+arrayDate[1]+separator+arrayDate[2]);
			}
			setTimeout(function(){
				jQuery.each(jQuery(".ui-datepicker-year option"),function(j,k){
					var textYear=parseInt(jQuery(".ui-datepicker-year option").eq(j).val())+543;
					jQuery(".ui-datepicker-year option").eq(j).text(textYear);
				});				
			},50);

		},
		onChangeMonthYear: function(){
			setTimeout(function(){
				jQuery.each(jQuery(".ui-datepicker-year option"),function(j,k){
					var textYear=parseInt(jQuery(".ui-datepicker-year option").eq(j).val())+543;
					jQuery(".ui-datepicker-year option").eq(j).text(textYear);
				});				
			},50);		
		},
		onClose:function(){
			if(jQuery(this).val()!="" && jQuery(this).val()==dateBefore){			
				var arrayDate=dateBefore.split(separator);
				arrayDate[2]=parseInt(arrayDate[2])+543;
				jQuery(this).val(arrayDate[0]+separator+arrayDate[1]+separator+arrayDate[2]);	
			}		
		},
		onSelect: function(dateText, inst){ 
			dateBefore=jQuery(this).val();
			var arrayDate=dateText.split(separator);
			arrayDate[2]=parseInt(arrayDate[2])+543;
			jQuery(this).val(arrayDate[0]+separator+arrayDate[1]+separator+arrayDate[2]);
		}
	});
}
//function callAjax(url, data, succesFuc, errorFn, type){
//	if(type==undefined) type="json";
//	jQuery.post(getURL(url), 
//			data, 
//			function(data) {
//				succesFuc(data);
//			}, type)
//			.error(function() {
//				errorFn();
//			}
//	);
//}