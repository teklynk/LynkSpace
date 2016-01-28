
$(document).ready(function () {
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
					$('#nav_newurl').attr('value', 'page.php?ref='+$('#exist_page').val());
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
			window.location.href='?section='+$('#nav_menu').val();
	    }
	);

	$('#page_image').change (
	    function () {
			if ($('#page_image').val()=='') {
				$('#page_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#page_image_preview').attr('src', '../uploads/'+$('#page_image').val());
			}
	    }
	);

	$('#slide_image').change (
	    function () {
			if ($('#slide_image').val()=='') {
				$('#slide_image_preview').attr('src', 'http://placehold.it/350x150&text=No Image');
			} else {
				$('#slide_image_preview').attr('src', '../uploads/'+$('#slide_image').val());
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
				$('#service_image_preview').attr('src', '../uploads/'+$('#service_image_select').val());
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
				$('#featured_image_preview').attr('src', '../uploads/'+$('#featured_image').val());
			}
	    }
	);

	$('#about_image').change (
	    function () {
			if ($('#about_image').val()=='') {
				$('#about_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#about_image_preview').attr('src', '../uploads/'+$('#about_image').val());
			}
	    }
	);

	$('#customer_image').change (
	    function () {
			if ($('#customer_image').val()=='') {
				$('#customer_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#customer_image_preview').attr('src', '../uploads/'+$('#customer_image').val());
			}
	    }
	);

	$('#team_image').change (
	    function () {
			if ($('#team_image').val()=='') {
				$('#team_image_preview').attr('src', 'http://placehold.it/140x100&text=No Image');
			} else {
				$('#team_image_preview').attr('src', '../uploads/'+$('#team_image').val());
			}
	    }
	);

	$('#nav_Table .nav_win_checkbox').change (
		function(){
			$.get('ajax/updateNewWin.php?update=true', { id: this.id, checked: this.checked });
		}
	);

	//Boostrap tooltips function
	$('[data-toggle="tooltip"]').tooltip(); 

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