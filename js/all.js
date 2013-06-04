/*JS*/

$(document).ready(function() {	
nav();	
choiceLang();

if($('#home').length) {
	initCarouselHome();	
}

if($('#biggerText').length) {
	fontSizing();
}

if($('#moteurResa').length) {	
	skinSelectResa();	
}

if($('#carousel_actu').length) {
	initCarouselActu();
}

if($('#carousel_promo').length) {
	initCarouselPromo();
}

if($('#blocSlider').length) {
		blocSlider();
}

if($('#ficheDest_side').length) {
	initCarouselDest();
}

if($('.skinThisForm').length) {
	skinSelectContact();	
}

if($('#filter_results').length) {
	skinSelectFilter();	
}

$('.popinLink_ajax').colorbox({opacity:"0.7" , width:"650px" , close:"FERMER" , scrolling:false , scalePhotos:false });

$('.popinLink_Gmap').colorbox({opacity:"0.7" , width:"940px" , close:"FERMER" , scrolling:false , scalePhotos:false });

$('.popinLink_ajax_noSize').colorbox({opacity:"0.7" , close:"FERMER" , scrolling:false , scalePhotos:false });

$('.popinLink_inline').click(function() {
	var popinToShow = $(this).attr('href');			
	$.fn.colorbox({opacity:"0.7" , close:"FERMER" ,width:"650px" , scrolling:false , scalePhotos:false ,inline:true, href:popinToShow});
	return false;
});

$('img.tooltipped').tooltip({ 
		track: true, 
		delay: 0, 
		showURL: false, 
		//showBody: " - ",      
		opacity: 0.95, 
		top: -40 ,
		left: -8 
	});	

/*only functions for IE 6*/
	if ($.browser.msie && $.browser.version <= 6 ) {
		try {document.execCommand('BackgroundImageCache', false, true);} catch(e) {} //caching CSS images	
		//sizeSubMenu();
	}		
/*end IE6*/	
});

function fontSizing() {
	$('#biggerText').click(function() {
		var currentTextSize = $('body').css('font-size');
		var currentValue = parseInt(currentTextSize);
		if(currentValue <= 12) {
			$('body').css('font-size', currentValue + 2);
		}
		return false;
	});
	
	$('#smallerText').click(function() {
		var currentTextSize = $('body').css('font-size');
		var currentValue = parseInt(currentTextSize);
		if(currentValue > 10) {
			$('body').css('font-size', currentValue - 2);
		}		
		return false;
	});
}

function nav() {
	$('#nav > li').hover(function() {
		if($(this).children('ul').length) {
			$(this).children('a').css("cursor","default");
		} 
		$(this).addClass('navHover');
	}, function() {
		$(this).removeClass('navHover');
	});
	
	$('#nav > li > ul > li').hover(function() {		
		$(this).addClass('subNavHover');
	}, function() {
		$(this).removeClass('subNavHover');
	});
}

function choiceLang() {
	$('#currentLang').toggle(function() {
		$(this).addClass('lang_showed');
		$('#choiceLang').slideDown();
	}, function() {
		$('#choiceLang').slideUp();
		$(this).removeClass('lang_showed');
	});	
}

/*function sizeSubMenu() {
	$('#nav > li').each(function() {
		var listWidth = $(this).width();		
		var submenu = $(this).children('ul');
		submenu.width(listWidth);
	});
}*/

function blocSlider() {	
	$sliderTrigger = $('#blocSlider h3');
	$sliderContent = $('#blocSlider .blocSlider_content');
	$sliderTrigger.eq(0).addClass('active');
	$sliderContent.eq(0).show();
	
	$sliderTrigger.click(function() {
			$sliderContent.slideUp();
			$sliderTrigger.removeClass('active');
			$(this).next('.blocSlider_content:hidden').slideDown('normal' , function() {
				$(this).prev('h3').addClass('active');
			});	
	});
	
	if($('#blocSlider div.sliderPrice').length) {
		$sliderTriggerPrice = $('#blocSlider span.triggerPrice');
		$sliderContentPrice = $('#blocSlider div.sliderPrice');
		
		$sliderTriggerPrice.click(function() {
			$sliderContentPrice.slideUp();		
			$sliderTriggerPrice.removeClass('active');	
			$(this).next('div.sliderPrice:hidden').slideDown('normal' , function() { 
				$(this).prev('span.triggerPrice').addClass('active');
			});	
		});		
	}
}

function initCarouselActu() {
	 $("#carousel_actu .inner_carousel").jCarouselLite({
		btnNext: "#next_carousel_actu",
        btnPrev: "#prev_carousel_actu",
		visible: 1 	
		//auto: 2000,
		//speed: 1000	
    });
} 

function initCarouselHome() {
	 $("#carousel_actu_home .inner_carousel").jCarouselLite({
		btnNext: "#next_carousel_actuHome",
        btnPrev: "#prev_carousel_actuHome",
		visible: 2 	
		//auto: 2000,
		//speed: 1000	
    });
	
	 $("#carousel_dest_home .inner_carousel").jCarouselLite({
		btnNext: "#next_carousel_destHome",
        btnPrev: "#prev_carousel_destHome",
		visible: 2 	
		//auto: 2000,
		//speed: 1000	
    });
} 

function initCarouselPromo() {
	 $("#carousel_promo .inner_carousel").jCarouselLite({
		btnNext: "#next_carousel_promo",
        btnPrev: "#prev_carousel_promo",
		visible: 1 	
		//auto: 2000,
		//speed: 1000	
    });
} 

function initCarouselDest() {
	$("#ficheDest_side .inner_carousel").jCarouselLite({
		btnNext: "#next_carousel_dest",
        btnPrev: "#prev_carousel_dest",
		visible: 4	
		//auto: 2000,
		//speed: 1000	
    });
	
	$switchers = $("#ficheDest_side .inner_carousel li img");
		
	$switchers.click(function() {
		$switchers.removeClass('current');
		$(this).addClass('current');
		$("#ficheDest_side #placeholder").attr("src", $(this).attr("src"));
		return false;
	});
}

function skinSelectContact() {
	$('fieldset.skinThisForm select').sSelect({ddMaxHeight: '155px'});
}

function skinSelectFilter() {
	$('#filter_results fieldset select').sSelect({ddMaxHeight: '155px'});
}

function skinSelectResa() {
	$('#searchingFor , #resa_filter1 , #resa_filter2').sSelect({ddMaxHeight: '155px'});
}

function verifCandidature(){
	if(document.getElementById('datepicker').value==""){
		alert(get_trad_champ('datepiker'));
		document.getElementById('datepicker').focus();
		return false;
	}
	if(document.getElementById('postulerNom').value==""){
		alert(get_trad_champ('nom'));
		document.getElementById('postulerNom').focus();
		return false;
	}
	if(document.getElementById('postulerPrenom').value==""){
		alert(get_trad_champ('prenom'));
		document.getElementById('postulerPrenom').focus();
		return false;
	}
	if(document.getElementById('postulerEmail').value==""){
		alert(get_trad_champ('email'));
		document.getElementById('postulerEmail').focus();
		return false;
	}
	if(!isValidEmail('postulerEmail')){
		alert(get_trad_champ('email'));
		document.getElementById('postulerEmail').focus();
		return false;
	}
	if(document.getElementById('postulerTelephone').value==""){
		alert(get_trad_champ('tel'));
		document.getElementById('postulerTelephone').focus();
		return false;
	}
	if(document.getElementById('postulerMessage').value==""){
		alert(get_trad_champ('postulerMessage'));
		document.getElementById('postulerMessage').focus();
		return false;
	}
	document.getElementById('formPostuler').submit();
}