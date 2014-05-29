
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

function openPopupHtml(title, html, buttons, openFunc, closeFunc, isPutCloseBtn){
//	var NewDialog = jQuery('<div style="width:800px;">\
//            <p>This is your dialog content, which dfssssssss sssssssss sssssssssssss<br /><br /><br /><br /><br /><br /><br /><br /><br /> sssssssssssss sssssssss ssssss can be multiline and dynamic.</p>\
//        </div>');
	
	var NewDialog = jQuery(html);
	
	//</?\w+((\s+\w+(\s*=\s*(?:".*?"|'.*?'|[^'">\s]+))?)+\s*|\s*)/?>
	var isHTML = false;
//	var re = new RegExp("</?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)/?>");
	var re = new RegExp("</?\\w+((\\s+\\w+(\\s*=\\s*(?:\".*?\"|'.*?'|[^'\">\\s]+))?)+\\s*|\\s*)/?>");
	if (html.match(re)) {
		isHTML = true;
	}
	
	if(buttons==undefined) buttons = [{text: "Close", click: function() {jQuery(this).dialog("close"); jQuery(this).remove();}}]
	else if(isPutCloseBtn==undefined || isPutCloseBtn==true){
			buttons.push({text: "Close", click: function() {jQuery(this).dialog("close");}});
	}
        NewDialog.dialog({
            modal: true,
            title: title,
            resizable: false,
            show: 'fade',
            width: NewDialog.width(),
            buttons: buttons,
            open: openFunc,
            close: function(){
	            	if(closeFunc!=undefined) closeFunc();
	            	if(isHTML){
	            		jQuery(this).closest('div.ui-dialog').remove();
	        		}
	            }
        });
}

function closePopup(selector){
	jQuery(selector).dialog("close"); 
	jQuery(selector).remove();
}

function jAlert(msg, okFunc, openFunc, closeFunc){
	var NewDialog = jQuery('<div style="width:300px;"><p>'+msg+'</p></div>');
	NewDialog.dialog({
	  modal: true,
	  title: 'JSTP Alert',
	  resizable: false,
	  closeOnEscape: false,
	  show: 'fade',
	  width: NewDialog.width(),
      open: function(){
    	  jQuery(this).parent().find('button.ui-dialog-titlebar-close').hide();
    	  if(openFunc!=undefined) openFunc(); 
      },
      close: closeFunc,
	  buttons: [
		{text: "OK", click: function() {jQuery(this).dialog("close"); okFunc(); jQuery(this).remove();}}
	  ]
	});
}

function jConfirm(msg, okFunc, cancelFunc, openFunc, closeFunc){
	var NewDialog = jQuery('<div style="width:300px;"><p>'+msg+'</p></div>');
	NewDialog.dialog({
	  modal: true,
	  title: 'JSTP Confirm',
	  resizable: false,
	  closeOnEscape: false,
	  show: 'fade',
	  width: NewDialog.width(),
	  open: function(){
    	  jQuery(this).parent().find('button.ui-dialog-titlebar-close').hide();
    	  if(openFunc!=undefined) openFunc(); 
      },
      close: closeFunc,
	  buttons: [
		{text: "OK", click: function() {jQuery(this).dialog("close"); okFunc(); jQuery(this).remove();}},
		{text: "Cancel", click: function() {jQuery(this).dialog("close"); cancelFunc(); jQuery(this).remove();}}
	  ]
	});
}