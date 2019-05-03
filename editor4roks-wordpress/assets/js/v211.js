function addEditorBtn() {

		jQuery('.input-prepend .add-on .tool.text').parent().parent().find('.peritempicker-wrapper:not("peritempicker-noncustom") .e4r-btn').remove();



		jQuery('.item-params li:not(:first-child) .peritempicker-wrapper').append('<span class="e4r-btn" style="display: none; border-radius:0; float: right; margin-top: 3px;" title="Open Editor"><i class="icon tool picker" style="cursor: pointer;"></i></span>');



		jQuery('.input-prepend .add-on .tool.text').parent().parent().find('.peritempicker-wrapper:not(".peritempicker-noncustom") .e4r-btn').css('display','block');



		jQuery('.input-prepend .add-on .tool.text').parent().parent().find('.peritempicker-wrapper.peritempicker-noncustom .e4r-btn').css('display','none');



		jQuery('html,body.admin_page_roksprocket-edit').css('overflow','hidden').css('overflow','auto');



		jQuery('.e4r-link-btn').remove();



		jQuery('.input-prepend .add-on .tool.link').parent().parent().find('.e4r-btn').attr('class', 'e4r-link-btn').attr('title','Select Menu or File');



		jQuery('.input-prepend .add-on .tool.link').parent().parent().find('.peritempicker-wrapper:not(".peritempicker-noncustom") .e4r-link-btn').css('display','block');



		jQuery('.input-prepend .add-on .tool.link').parent().parent().find('.peritempicker-wrapper.peritempicker-noncustom .e4r-link-btn').css('display','none');



}



jQuery(document).ready(function($) {



	if (jQuery("body").hasClass("admin_page_roksprocket-edit")) {

		

		addEditorBtn();



	}



	jQuery('body.admin_page_roksprocket-edit').on('click','#e4r-reload',function(){



		jQuery('#e4r-reload').fadeOut();



	});



	jQuery('body.admin_page_roksprocket-edit').on('click','.peritempicker-wrapper .dropdown-menu li:last-child a',function(){



		jQuery(this).parent().parent().parent().parent().parent().find('.add-on .tool.text').parent().parent().find('.e4r-btn').css('display','block');



		if(!jQuery(this).parent().parent().parent().parent().parent().find('.add-on .tool.text').parent().parent().find('.e4r-btn').is(':visible')) {



			addEditorBtn();



		}



	});



	jQuery('body.admin_page_roksprocket-edit').on('click','.peritempicker-wrapper .dropdown-menu li:not(":last-child") a',function(){



		jQuery(this).parent().parent().parent().parent().parent().find('.add-on .tool.text').parent().parent().find('.e4r-btn').css('display','none');



		jQuery(this).parent().parent().parent().parent().parent().find('.add-on .tool.link').parent().parent().find('.e4r-link-btn').css('display','none');



	});





	jQuery('body.admin_page_roksprocket-edit').on('click','.e4r-btn',function(){



		jQuery(this).parent().find('input').addClass('e4r-editing');



		jQuery('html,body.admin_page_roksprocket-edit').css('overflow','hidden');



		jQuery('.editor4roks').fadeIn();





		if(jQuery('.mce-tinymce').is(':visible')) {



			if (jQuery('.e4r-editing').val() == '') {

				

				document.getElementById("e4r-textarea_ifr").contentWindow.document.getElementsByTagName("body")[0].innerHTML = '';



			} else {



				document.getElementById("e4r-textarea_ifr").contentWindow.document.getElementsByTagName("body")[0].innerHTML = jQuery('.e4r-editing').val();



			}



		} else if(jQuery('.nicEdit-panelContain').is(':visible')) {

			if (jQuery('.e4r-editing').val() == '') {

				jQuery('.e4r-editing').val('<p><br></p>');

				jQuery(".editor4roks .nicEdit-main").html(jQuery('.e4r-editing').val());

			} else {

				jQuery(".editor4roks .nicEdit-main").html(jQuery('.e4r-editing').val());

			}

		} else {



			jQuery('#e4r-textarea').val(jQuery('.e4r-editing').val());



		}

		

	});



	jQuery('body.admin_page_roksprocket-edit').on('click','.e4r-link-btn',function(){



		jQuery(this).parent().find('input').addClass('e4r-editing');



		jQuery('html,body.admin_page_roksprocket-edit').css('overflow','hidden');



		jQuery('.linkeditor4roks').fadeIn();



	});



	jQuery('body.admin_page_roksprocket-edit').on('click','.editor4roks .btn-insert',function(){



		if(jQuery('.mce-tinymce').is(':visible')) {



			jQuery('input.e4r-editing').val(document.getElementById("e4r-textarea_ifr").contentWindow.document.getElementsByTagName("body")[0].innerHTML);

			

			document.getElementById("e4r-textarea_ifr").contentWindow.document.getElementsByTagName("body")[0].innerHTML = "";



		} else if(jQuery('.nicEdit-panelContain').is(':visible')) {

			jQuery('input.e4r-editing').val(jQuery(".editor4roks .nicEdit-main").html());

		} else {



			jQuery('input.e4r-editing').val(jQuery('#e4r-textarea').val());

			

		}



		jQuery('html,body.admin_page_roksprocket-edit').css('overflow','auto');



		jQuery('.editor4roks').fadeOut();



		jQuery('input.e4r-editing').removeClass('e4r-editing');



	});

	

	jQuery('body.admin_page_roksprocket-edit').on('click','.nicEdit-pane #src',function(){

		jQuery('.nicEdit-pane #src').attr("list","imagelist").attr("autocomplete","off").attr("placeholder","Search or insert URL");

	});

	jQuery('body.admin_page_roksprocket-edit').on('click','.nicEdit-pane #href',function(){

		jQuery('.nicEdit-pane #href').attr("list","menufilelist").attr("autocomplete","off").attr("placeholder","Search menu or insert URL");

	});





	jQuery('body.admin_page_roksprocket-edit').on('click','.editor4roks .btn-cancel',function(){



		jQuery('html,body.admin_page_roksprocket-edit').css('overflow','auto');



		jQuery('.editor4roks').fadeOut();



		jQuery('input.e4r-editing').removeClass('e4r-editing');



	});



	



	jQuery('body.admin_page_roksprocket-edit').on('click','.linkeditor4roks .btn-insert',function(){



		jQuery('input.e4r-editing').val(jQuery('#e4r-linkarea').val());

		

		jQuery('#e4r-linkarea').val('');



		jQuery('html,body.admin_page_roksprocket-edit').css('overflow','auto');



		jQuery('.linkeditor4roks').fadeOut();



		jQuery('input.e4r-editing').removeClass('e4r-editing');





	});



	jQuery('body.admin_page_roksprocket-edit').on('click','.linkeditor4roks .btn-cancel',function(){



		jQuery('#e4r-linkarea').val('');



		jQuery('html,body.admin_page_roksprocket-edit').css('overflow','auto');



		jQuery('.linkeditor4roks').fadeOut();



		jQuery('input.e4r-editing').removeClass('e4r-editing');



	});



	jQuery('body.admin_page_roksprocket-edit').on('click','.editor4roks .btn-options',function(){



		jQuery('.e4r-options').fadeToggle();



	});

	

});
