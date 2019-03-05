function addEditorBtn() {
		jQuery('.input-prepend .add-on .tool.text').parent().parent().find('.peritempicker-wrapper:not("peritempicker-noncustom") .e4r-btn').remove();
		jQuery('.item-params li:not(:first-child) .peritempicker-wrapper').append('<span class="e4r-btn" style="display: none; border-radius:0; float: right; margin-top: 3px;" title="Open Editor"><i class="icon tool picker" style="cursor: pointer;"></i></span>');
		jQuery('.input-prepend .add-on .tool.text').parent().parent().find('.peritempicker-wrapper:not(".peritempicker-noncustom") .e4r-btn').css('display','block');
		jQuery('.input-prepend .add-on .tool.text').parent().parent().find('.peritempicker-wrapper.peritempicker-noncustom .e4r-btn').css('display','none');
		jQuery('html,body.com_roksprocket').css('overflow','hidden').css('overflow','auto');
		jQuery('.e4r-link-btn').remove();
		jQuery('.input-prepend .add-on .tool.link').parent().parent().find('.e4r-btn').attr('class', 'e4r-link-btn').attr('title','Select a menu or insert link');
		jQuery('.input-prepend .add-on .tool.link').parent().parent().find('.peritempicker-wrapper:not(".peritempicker-noncustom") .e4r-link-btn').css('display','block');
		jQuery('.input-prepend .add-on .tool.link').parent().parent().find('.peritempicker-wrapper.peritempicker-noncustom .e4r-link-btn').css('display','none');
}
jQuery(document).ready(function($) {
	if (jQuery("body.com_roksprocket").hasClass("com_roksprocket")) {
		addEditorBtn();
	}
	jQuery('body.com_roksprocket').on('click','#e4r-reload',function(){
		jQuery('#e4r-reload').fadeOut();
	});
	jQuery('body.com_roksprocket').on('click','.peritempicker-wrapper .dropdown-menu li:last-child a',function(){
		jQuery(this).parent().parent().parent().parent().parent().find('.add-on .tool.text').parent().parent().find('.e4r-btn').css('display','block');
		if(!jQuery(this).parent().parent().parent().parent().parent().find('.add-on .tool.text').parent().parent().find('.e4r-btn').is(':visible')) {
			addEditorBtn();
		}
	});
	jQuery('body.com_roksprocket').on('click','.peritempicker-wrapper .dropdown-menu li:not(":last-child") a',function(){
		jQuery(this).parent().parent().parent().parent().parent().find('.add-on .tool.text').parent().parent().find('.e4r-btn').css('display','none');
		jQuery(this).parent().parent().parent().parent().parent().find('.add-on .tool.link').parent().parent().find('.e4r-link-btn').css('display','none');
	});
	jQuery('body.com_roksprocket').on('click','.e4r-btn',function(){
		jQuery(this).parent().find('input').addClass('e4r-editing');
		jQuery('html,body.com_roksprocket').css('overflow','hidden');
		jQuery('.editor4roks').fadeIn();
		if(jQuery('#e4r_textarea_ifr').is(':visible')) {
			document.getElementById("e4r_textarea_ifr").contentWindow.document.getElementsByTagName("body")[0].innerHTML = jQuery('.e4r-editing').val();
		} else if(jQuery('.nicEdit-panelContain').is(':visible')) {
			if (jQuery('.e4r-editing').val() == '') {
				jQuery('.e4r-editing').val('<p><br></p>');
				jQuery(".editor4roks .nicEdit-main").html(jQuery('.e4r-editing').val());
			} else {
				jQuery(".editor4roks .nicEdit-main").html(jQuery('.e4r-editing').val());
			}
		} else {
			jQuery('#e4r_textarea').val(jQuery('.e4r-editing').val());
		}
	});
	jQuery('body.com_roksprocket').on('click','.e4r-link-btn',function(){
		jQuery(this).parent().find('input').addClass('e4r-editing');
		jQuery('html,body.com_roksprocket').css('overflow','hidden');
		jQuery('.linkeditor4roks').fadeIn();
	});
	jQuery('body.com_roksprocket').on('click','.editor4roks .btn-insert',function(){
		if(jQuery('#e4r_textarea_ifr').is(':visible')) {
			jQuery('input.e4r-editing').val(document.getElementById("e4r_textarea_ifr").contentWindow.document.getElementsByTagName("body")[0].innerHTML);
			document.getElementById("e4r_textarea_ifr").contentWindow.document.getElementsByTagName("body")[0].innerHTML = "";
		} else if(jQuery('.nicEdit-panelContain').is(':visible')) {
			jQuery('input.e4r-editing').val(jQuery(".editor4roks .nicEdit-main").html());
		} else {
			jQuery('input.e4r-editing').val(jQuery('#e4r_textarea').val());
		}
		jQuery('html,body.com_roksprocket').css('overflow','auto');
		jQuery('.editor4roks').fadeOut();
		jQuery('input.e4r-editing').removeClass('e4r-editing');
	});
	jQuery('body.com_roksprocket').on('click','.nicEdit-pane #src',function(){
		jQuery('.nicEdit-pane #src').attr("list","imagelist").attr("autocomplete","off").attr("placeholder","Search or insert URL");
	});
	jQuery('body.com_roksprocket').on('click','.nicEdit-pane #href',function(){
		jQuery('.nicEdit-pane #href').attr("list","menufilelist").attr("autocomplete","off").attr("placeholder","Search menu or insert URL");
	});
	jQuery('body.com_roksprocket').on('click','.editor4roks .btn-cancel',function(){
		jQuery('html,body.com_roksprocket').css('overflow','auto');
		jQuery('.editor4roks').fadeOut();
		jQuery('input.e4r-editing').removeClass('e4r-editing');
	});
	jQuery('body.com_roksprocket').on('click','.linkeditor4roks .btn-insert',function(){
		jQuery('input.e4r-editing').val(jQuery('#e4r-linkarea').val());
		jQuery('#e4r-linkarea').val('');
		jQuery('html,body.com_roksprocket').css('overflow','auto');
		jQuery('.linkeditor4roks').fadeOut();
		jQuery('input.e4r-editing').removeClass('e4r-editing');
	});
	jQuery('body.com_roksprocket').on('click','.linkeditor4roks .btn-cancel',function(){
		jQuery('#e4r-linkarea').val('');
		jQuery('html,body.com_roksprocket').css('overflow','auto');
		jQuery('.linkeditor4roks').fadeOut();
		jQuery('input.e4r-editing').removeClass('e4r-editing');
	});
});
