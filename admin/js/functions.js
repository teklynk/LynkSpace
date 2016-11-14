
$(document).ready(function () {

	// get an array with all querystring values
	// example: var valor = getUrlVars()["valor"];
	function getUrlVars() {
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for (var i = 0; i < hashes.length; i++) {
					hash = hashes[i].split('=');
					vars.push(hash[0]);
					vars[hash[0]] = hash[1];
			}
			return vars;
	}

	//clear inputs on reset
	$(':reset').click (
		function () {
			$('#del_cat .fa-trash').css( 'visibility', 'hidden');
			$('#rename_cat .fa-save').css( 'visibility', 'hidden');
			$('#page_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			$('#featured_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			$('#customer_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			$('#team_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			$('#about_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			$('#slide_image_preview').attr('src', 'http://placehold.it/350x150&text=No Image');

			$('#service_image_select').val('');
			$('#service_icon_select').val('');
			$('#service_image_preview').attr('src', '');
			$('#service_icon').attr('class', '');

			$('#nav_newname').attr('value', '');
			$('#nav_newurl').attr('value', '');
			$('#exist_page').attr('value', '');
			$('#exist_cat').attr('value', '');
			$('#nav_newcat').attr('value', '');
		}
	);

	$('#exist_page').change (
	    function () {
			if ($('#exist_page').val()=='') {
				$('#nav_newname').val('');
				$('#nav_newurl').attr('value', '');
			} else {
				$('#nav_newname').val($('#exist_page option:selected').text());
				if (isNaN($('#exist_page').val())) {
					//alert('is text');
					$('#nav_newurl').attr('value', $('#exist_page').val());
				} else {
					$('#nav_newurl').attr('value', 'page.php?page_id='+$('#exist_page').val()+'&loc_id='+getUrlVars()['loc_id']);
				}
			}
	    }
	);

	$('#exist_cat').change (
	    function () {
			if ($('#exist_cat').val()=='' || $('#exist_cat').val()==29) { //NOTE: 29=None in the category table
				$('#nav_newcat').val('');
				$('#del_cat .fa-trash' ).css( 'visibility', 'hidden');
				$('#rename_cat .fa-save' ).css( 'visibility', 'hidden');
			} else {
				$('#nav_newcat').val($('#exist_cat option:selected').text());
				$('#del_cat .fa-trash' ).css( 'visibility', 'visible');
				$('#rename_cat .fa-save' ).css( 'visibility', 'visible');
			}
	    }
	);

	$('#nav_menu').change (
	    function () {
				var loc_id = getUrlVars()['loc_id'];
				window.location.href='?section='+$('#nav_menu').val()+'&loc_id='+getUrlVars()['loc_id'];
	    }
	);

	$('#page_image').change (
	    function () {
			if ($('#page_image').val()=='') {
				$('#page_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#page_image_preview').attr('src', '../uploads/'+getUrlVars()['loc_id']+'/'+$('#page_image').val());
			}
	    }
	);

	$('#slide_image').change (
	    function () {
			if ($('#slide_image').val()=='') {
				$('#slide_image_preview').attr('src', 'http://placehold.it/350x150&text=No Image');
			} else {
				$('#slide_image_preview').attr('src', '../uploads/'+getUrlVars()['loc_id']+'/'+$('#slide_image').val());
			}
	    }
	);

	$('#service_icon_select').change (
	    function () {
			if ($('#service_icon_select').val()=='') {
				$('#service_icon').attr('class', '');
				$('#service_image_preview').attr('src', '');
				$('#service_image_preview').css('display', 'none');
			} else {
				$('#service_image_select').val(''); //Sets image select value to None
				$('#service_icon').attr('class', 'fa fa-fw fa-'+$('#service_icon_select').val());
				$('#service_image_preview').attr('src', '');
				$('#service_image_preview').css('display', 'none');
			}
	    }
	);

	$('#service_image_select').change (
	    function () {
			if ($('#service_image_select').val()=='') {
				$('#service_image_preview').attr('src', '');
				$('#service_image_preview').css('display', 'none');
				$('#service_icon').attr('class', 'fa fa-fw fa-'+$('#service_icon_select').val());
			} else {
				$('#service_icon_select').val(''); //Sets icon select value to None
				$('#service_image_preview').attr('src', '../uploads/'+getUrlVars()['loc_id']+'/'+$('#service_image_select').val());
				$('#service_image_preview').css('display', 'block');
				$('#service_icon').attr('class', '');
			}
	    }
	);

	$('#featured_image').change (
	    function () {
			if ($('#featured_image').val()=='') {
				$('#featured_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#featured_image_preview').attr('src', '../uploads/'+getUrlVars()['loc_id']+'/'+$('#featured_image').val());
			}
	    }
	);

	$('#about_image').change (
	    function () {
			if ($('#about_image').val()=='') {
				$('#about_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#about_image_preview').attr('src', '../uploads/'+getUrlVars()['loc_id']+'/'+$('#about_image').val());
			}
	    }
	);

	$('#customer_image').change (
	    function () {
			if ($('#customer_image').val()=='') {
				$('#customer_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#customer_image_preview').attr('src', '../uploads/'+getUrlVars()['loc_id']+'/'+$('#customer_image').val());
			}
	    }
	);

	$('#team_image').change (
	    function () {
			if ($('#team_image').val()=='') {
				$('#team_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#team_image_preview').attr('src', '../uploads/'+getUrlVars()['loc_id']+'/'+$('#team_image').val());
			}
	    }
	);

	//Ajax Calls
	$('#nav_Table .nav_win_checkbox').change (
		function(){
			$.get('ajax/update_navwin.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	$('.searchopt_checkbox').change (
		function(){
			$.get('ajax/update_searchoptions.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	$('.page_status_checkbox').change (
		function(){
			$.get('ajax/update_pageactive.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	$('.page_disqus_checkbox').change (
		function(){
			$.get('ajax/update_pagedisqus.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	$('.slider_status_checkbox').change (
		function(){
			$.get('ajax/update_slideractive.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	$('.services_status_checkbox').change (
		function(){
			$.get('ajax/update_servicesactive.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	$('.team_status_checkbox').change (
		function(){
			$.get('ajax/update_teamactive.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	$('.customer_status_checkbox').change (
		function(){
			$.get('ajax/update_customersactive.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	//Boostrap tooltips function
	$('[data-toggle="tooltip"]').tooltip();

	//Not a Robot
	$('#not_robot').change (
	    function () {
	    	if ($('#not_robot').prop('checked')) {
				$('#not_robot').attr('value', 'e6a52c828d56b46129fbf85c4cd164b3');
				$('#sign_in').removeAttr('disabled', 'disabled');
			} else {
				$('#not_robot').attr('value', '');
				$('#sign_in').attr('disabled', 'disabled');
			}
	    }
	);

});

//modal preview window
function showMyModal(myTitle, myFile) {
   $('#myModalTitle').html(myTitle);
   $('#myModalFile').attr('src', myFile);
   $('#myModal').modal('show');
   $('#webslideDialog').modal('show');
   $('#webpageDialog').modal('show');
   $('#webserviceDialog').modal('show');
};
