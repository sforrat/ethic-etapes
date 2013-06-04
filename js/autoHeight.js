function doIframe(){
	$("iframe").each(function(){
		if (/\bautoHeight\b/.test(this.className)){
			setHeight(this);
			addEvent(this, 'load', doIframe);
		}
	});
}

function setHeight(e){
	if (e.Document && e.Document.body.scrollHeight){
		e.height = e.contentWindow.document.body.scrollHeight;
	
	}else if (e.contentDocument && e.contentDocument.body.scrollHeight){
		e.height = e.contentDocument.body.scrollHeight + 35;
	
	}else if (e.contentDocument && e.contentDocument.body.offsetHeight){
		e.height = e.contentDocument.body.offsetHeight + 35;
	}
}

function addEvent(obj, evType, fn){
	if(obj.addEventListener)
	{
	obj.addEventListener(evType, fn,false);
	return true;
	} else if (obj.attachEvent){
	var r = obj.attachEvent("on"+evType, fn);
	return r;
	} else {
	return false;
	}
}

if (document.getElementById && document.createTextNode){
 addEvent(window,'load', doIframe);	
}
