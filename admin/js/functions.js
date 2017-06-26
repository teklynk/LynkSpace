$(document).ready(function () {
    //Sibebar Nav Menu Collapse
    if ($.cookie('sidebar-collapse') == 1) {
        $('.fa-dedent').addClass('fa-indent');
        $('.side-nav').addClass('shrink');
        $('#wrapper').addClass('shrink_wrap');
        $('#button-menu').attr('title', 'Expand Menu');
    } else {
        $('#button-menu').attr('title', 'Collapse Menu');
    }

    $('#button-menu').click(function () {
        $('.fa-dedent').toggleClass('fa-indent');
        $('.side-nav').toggleClass('shrink');
        $('#wrapper').toggleClass('shrink_wrap');
        if ($('.side-nav').hasClass('shrink')) {
            $.cookie('sidebar-collapse', 1);
            $('#button-menu').attr('title', 'Expand Menu');
            $('.navbar-brand').toggleClass('shrink_brand');
        } else {
            $.cookie('sidebar-collapse', null);
            $('.fa-dedent').removeClass('fa-indent');
            $('.side-nav').removeClass('shrink');
            $('#wrapper').removeClass('shrink_wrap');
            $('.navbar-brand').removeClass('shrink_brand');
            $('#button-menu').attr('title', 'Collapse Menu');
        }
    });

    //Boostrap alert fadeout and close function
    setTimeout(function () {
        $('.alert-success').fadeTo('slow', 0.1, function () {
            $('.alert-success').alert('close')
        });
    }, 3000);

    //Character Counter
    //Taken from https://www.codefromjames.com/scripts/charcount.js
    var LabelCounter = 0;

    function parseCharCounts() {
        //Get Everything...
        var elements = document.getElementsByClassName('count-text');
        var element = null;
        var maxlength = 9;
        var newlabel = null;
        for (var i = 0; i < elements.length; i++) {
            element = elements[i];
            if (element.getAttribute('maxlength') != null && element.getAttribute('limiterid') == null) {
                maxlength = element.getAttribute('maxlength');
                //Create new label
                newlabel = document.createElement('small');
                newlabel.id = 'limitlbl_' + LabelCounter;
                newlabel.className = 'count-message';
                newlabel.style.color = 'rgb(123, 123, 123)';
                newlabel.style.display = 'block'; //Make it block so it sits nicely.
                newlabel.innerHTML = "Updating...";
                //Attach limiter to our textarea
                element.setAttribute('limiterid', newlabel.id);
                element.onkeyup = function () {
                    displayCharCounts(this);
                };
                //Append element
                element.parentNode.insertBefore(newlabel, element);
                //Force the update now!
                displayCharCounts(element);
            }
            //Push up the number
            LabelCounter++;
        }
    }

    function displayCharCounts(element) {
        var limitLabel = document.getElementById(element.getAttribute('limiterid'));
        var maxlength = element.getAttribute('maxlength');
        var enforceLength = false;
        if (element.getAttribute('lengthcut') != null && element.getAttribute('lengthcut').toLowerCase() == 'true') {
            enforceLength = true;
        }
        var value = element.value.replace(/\u000d\u000a/g, '\u000a').replace(/\u000a/g, '\u000d\u000a');
        var currentLength = value.length;
        var remaining = 0;
        if (maxlength == null || limitLabel == null) {
            return false;
        }
        remaining = maxlength - currentLength;
        if (remaining >= 0) {
            limitLabel.style.color = 'rgb(123, 123, 123)';
            limitLabel.innerHTML = remaining + ' character';
            if (remaining != 1) limitLabel.innerHTML += 's';
            limitLabel.innerHTML += ' remaining';
        } else {
            if (enforceLength == true) {
                value = value.substring(0, maxlength);
                element.value = value;
                element.setSelectionRange(maxlength, maxlength);
                limitLabel.style.color = 'rgb(123, 123, 123)';
                limitLabel.innerHTML = '0 characters remaining';
            } else {
                //Non-negative
                remaining = Math.abs(remaining);
                limitLabel.style.color = 'rgb(123, 123, 123)';
                limitLabel.innerHTML = 'Over by ' + remaining + ' character';
                if (remaining != 1) limitLabel.innerHTML += 's';
                limitLabel.innerHTML += '!';
            }
        }
    }

    //Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    // get an array with all querystring values
    // example: var valor = getUrlVars()["valor"];
    function getUrlVars() {
        var vars = [],
            hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    //Disable inputs if the Use Defaults checkbox is active
    $('.defaults-toggle').change(function () {
        if ($('.defaults-toggle').prop('checked') == true) {
            $('form :input, form :button, form, button, select, textarea, .mce-tinymce').attr('disabled', true);
        } else {
            $('form :input, form :button, form, button, select, textarea, .mce-tinymce').attr('disabled', false);
        }
        //prevents Use Default button from disabling these elements
        $('.defaults-toggle').attr('disabled', false);
        $('#loc_id_list').attr('disabled', false);
        $('#nav_menu').attr('disabled', false);
        $('#updates_btn').attr('disabled', false);
        $('[data-id="loc_id_list"]').attr('disabled', false);
    }).change();

    //clear inputs on reset
    $(':reset').click(function () {
        $('#del_cat .fa-trash').css('visibility', 'hidden');
        $('#rename_cat .fa-save').css('visibility', 'hidden');
        $('#customer_image_preview').attr('src', '//placehold.it/140x100&text=No Image');
        $('#service_image_preview').attr('src', '//placehold.it/140x100&text=No Image');
        $('#team_image_preview').attr('src', '//placehold.it/140x100&text=No Image');
        $('#slide_image_preview').attr('src', '//placehold.it/350x150&text=No Image');
        $('#theme_image_preview').attr('src', '//placehold.it/140x100&text=No Image');
        $('#service_image_select').val('');
        $('#service_icon_select').val('');
        $('#service_icon').attr('class', '');
        $('#customer_image_select').val('');
        $('#customer_icon_select').val('');
        $('#customer_icon').attr('class', '');
        $('#nav_newname').attr('value', '');
        $('#nav_newurl').attr('value', '');
        $('#exist_page').attr('value', '');
        $('#slide_exist_page').attr('value', '');
        $('#slide_link').attr('value', '');
        $('#service_exist_page').attr('value', '');
        $('#service_link').attr('value', '');
        $('#exist_cat').attr('value', '');
        $('#nav_newcat').attr('value', '');
        $('#cust_newcat').attr('value', '');
        $('#cust_newcatsort').attr('value', '');
        $('#loc_newcat').attr('value', '');
    });

    $('#exist_page').change(function () {
        if ($('#exist_page').val() == '') {
            $('#nav_newname').val('');
            $('#nav_newurl').attr('value', '');
        } else {
            $('#nav_newname').val($('#exist_page option:selected').text());
            if (isNaN($('#exist_page').val())) {
                $('#nav_newurl').attr('value', $('#exist_page').val());
            } else {
                $('#nav_newurl').attr('value', 'page.php?page_id=' + $('#exist_page').val() + '&loc_id=' + getUrlVars()['loc_id']);
            }
        }
    });
    $('#slide_exist_page').change(function () {
        if ($('#slide_exist_page').val() == '') {
            $('#slide_link').attr('value', '');
        } else {
            if ($('#slide_exist_page').val()) {
                $('#slide_link').attr('value', $('#slide_exist_page').val());
            }
        }
    });
    $('#service_exist_page').change(function () {
        if ($('#service_exist_page').val() == '') {
            $('#service_link').attr('value', '');
        } else {
            if ($('#service_exist_page').val()) {
                $('#service_link').attr('value', $('#service_exist_page').val());
            }
        }
    });
    $('#exist_cat').change(function () {
        if ($('#exist_cat').val() == '' || $('#exist_cat').val() == 0) { //NOTE: 0=None in the category table
            $('#nav_newcat').val('');
            $('#cust_newcat').val('');
            $('#cust_newcatsort').val('');
            $('#loc_newcat').val('');
            $('#add_cat .fa-plus').css('visibility', 'visible');
            $('#del_cat .fa-trash').css('visibility', 'hidden');
            $('#rename_cat .fa-save').css('visibility', 'hidden');
        } else {
            $('#nav_newcat').val($('#exist_cat option:selected').text());
            $('#cust_newcat').val($('#exist_cat option:selected').text());
            $('#cust_newcatsort').val($('#exist_cat option:selected').attr('data-sort'));
            $('#loc_newcat').val($('#exist_cat option:selected').text());
            $('#add_cat .fa-plus').css('visibility', 'hidden');
            $('#del_cat .fa-trash').css('visibility', 'visible');
            $('#rename_cat .fa-save').css('visibility', 'visible');
        }
    });

    $('#nav_menu').change(function () {
        var loc_id = getUrlVars()['loc_id'];
        window.location.href = '?section=' + $('#nav_menu').val() + '&loc_id=' + getUrlVars()['loc_id'];
    });
    $('#site_logo').change(function () {
        if ($('#site_logo').val() == '') {
            $('#site_logo_preview').attr('src', '//placehold.it/140x100&text=No Image');
        } else {
            $('#site_logo_preview').attr('src', '../uploads/' + getUrlVars()['loc_id'] + '/' + $('#site_logo').val());
        }
    });
    $('#slide_image').change(function () {
        if ($('#slide_image').val() == '') {
            $('#slide_image_preview').attr('src', '//placehold.it/350x150&text=No Image');
        } else {
            $('#slide_image_preview').attr('src', '../uploads/' + getUrlVars()['loc_id'] + '/' + $('#slide_image').val());
        }
    });
    $('#site_theme').change(function () {
        if ($('#site_theme').val() == '') {
            $('#theme_image_preview').attr('src', '//placehold.it/240x280&text=No Image');
            $('#theme_href_preview').attr('href', '#');
        } else {
            $('#theme_image_preview').attr('src', '../themes/'+$('#site_theme').val()+'/screenshot_thumb.png');
            $('#theme_href_preview').attr('href', '../themes/'+$('#site_theme').val()+'/screenshot.png');
        }
    });
    $('#service_icon_select').change(function () {
        if ($('#service_icon_select').val() == '') {
            $('[data-id="service_icon_select"] > span.filter-option').text('None');
            $('[data-id="service_icon_select"]').attr('title', 'None');
            $('#service_icon').attr('class', '');
            $('#service_image_preview').attr('src', '');
            $('#service_image_preview').css('display', 'none');
        } else {
            $('#service_image_select').val(''); //Sets image select value to None
            $('#service_icon').attr('class', 'fa fa-fw fa-' + $('#service_icon_select').val());
            $('#service_image_preview').attr('src', '');
            $('#service_image_preview').css('display', 'none');
        }
    });
    $('#service_image_select').change(function () {
        if ($('#service_image_select').val() == '') {
            $('#service_image_preview').attr('src', '');
            $('#service_image_preview').css('display', 'none');
            $('#service_icon').attr('class', 'fa fa-fw fa-' + $('#service_icon_select').val());
        } else {
            $('#service_icon_select').val(''); //Sets icon select value to None
            $('[data-id="service_icon_select"] > span.filter-option').text('None');
            $('[data-id="service_icon_select"]').attr('title', 'None');
            $('#service_image_preview').attr('src', '../uploads/' + getUrlVars()['loc_id'] + '/' + $('#service_image_select').val());
            $('#service_image_preview').css('display', 'block');
            $('#service_icon').attr('class', '');
        }
    });
    $('#customer_icon_select').change(function () {
        if ($('#customer_icon_select').val() == '') {
            $('[data-id="customer_icon_select"] > span.filter-option').text('None');
            $('[data-id="customer_icon_select"]').attr('title', 'None');
            $('#customer_icon').attr('class', '');
            $('#customer_image_preview').attr('src', '');
            $('#customer_image_preview').css('display', 'none');
        } else {
            $('#customer_image_select').val(''); //Sets image select value to None
            $('#customer_icon').attr('class', 'fa fa-fw fa-' + $('#customer_icon_select').val());
            $('#customer_image_preview').attr('src', '');
            $('#customer_image_preview').css('display', 'none');
        }
    });
    $('#customer_image_select').change(function () {
        if ($('#customer_image_select').val() == '') {
            $('#customer_image_preview').attr('src', '');
            $('#customer_image_preview').css('display', 'none');
            $('#customer_icon').attr('class', 'fa fa-fw fa-' + $('#customer_icon_select').val());
        } else {
            $('#customer_icon_select').val(''); //Sets icon select value to None
            $('[data-id="customer_icon_select"] > span.filter-option').text('None');
            $('[data-id="customer_icon_select"]').attr('title', 'None');
            $('#customer_image_preview').attr('src', '../uploads/' + getUrlVars()['loc_id'] + '/' + $('#customer_image_select').val());
            $('#customer_image_preview').css('display', 'block');
            $('#customer_icon').attr('class', '');
        }
    });
    $('#team_image').change(function () {
        if ($('#team_image').val() == '') {
            $('#team_image_preview').attr('src', '//placehold.it/140x100&text=No Image');
        } else {
            $('#team_image_preview').attr('src', '../uploads/' + getUrlVars()['loc_id'] + '/' + $('#team_image').val());
        }
    });
    //Ajax Calls
    $('#nav_Table .nav_win_checkbox').change(function () {
        $.get('ajax/update_navwin.php?update=true', {
            id: this.id,
            checked: this.checked
        });

        $('#nav_Table .nav_win_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('#nav_Table .nav_win_checkbox').attr('disabled', false);
        }, 500);
    });
    $('#nav_Table .nav_active_checkbox').change(function () {
        $.get('ajax/update_navactive.php?update=true', {
            id: this.id,
            checked: this.checked
        });

        $('#nav_Table .nav_active_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('#nav_Table .nav_active_checkbox').attr('disabled', false);
        }, 500);
    });

    //Disable radio buttons if one checkbox is active
    if ($('.ls2kids_active').prop('checked') == true && $('.ls2pac_active').prop('checked') == true) {
        $('.ls2pac_default').attr('disabled', false);
        $('.ls2kids_default').attr('disabled', false);
    } else {
        $('.ls2pac_default').attr('disabled', true);
        $('.ls2kids_default').attr('disabled', true);
    }

    //Ajax calls for PAC setting checkboxes and radios
    $('.searchopt_checkbox').change(function () {
        $.get('ajax/update_searchoptions.php?update=true', {
            id: this.id,
            checked: this.checked
        });

        $('.searchopt_checkbox').attr('disabled', true);

        setTimeout(function() {
            $('.searchopt_checkbox').attr('disabled', false);
        }, 500);

        $('.searchopt_radio').attr('disabled', true);

        //Swap Default radios if only one option is checked
        if ($('.ls2pac_active').prop('checked') == true && $('.ls2kids_active').prop('checked') == false) {
            $('.ls2pac_default').attr('disabled', true);
            $('.ls2kids_default').attr('disabled', true);
            $('.ls2pac_default').prop('checked', true);
            $('.ls2kids_default').prop('checked', false);
            $.get('ajax/update_searchdefault.php?update=true', {
                value: 1,
                checked: this.checked
            });
        }else if ($('.ls2kids_active').prop('checked') == true && $('.ls2pac_active').prop('checked') == false) {
            $('.ls2pac_default').attr('disabled', true);
            $('.ls2kids_default').attr('disabled', true);
            $('.ls2pac_default').prop('checked', false);
            $('.ls2kids_default').prop('checked', true);
            $.get('ajax/update_searchdefault.php?update=true', {
                value: 2,
                checked: this.checked
            });
        }else if ($('.ls2kids_active').prop('checked') == true && $('.ls2pac_active').prop('checked') == true) {
            $('.ls2pac_default').attr('disabled', false);
            $('.ls2kids_default').attr('disabled', false);
        }else if ($('.ls2kids_active').prop('checked') == false && $('.ls2pac_active').prop('checked') == false) {
            $('.ls2pac_default').prop('checked', false);
            $('.ls2kids_default').prop('checked', false);
            $.get('ajax/update_searchdefault.php?update=true', {
                value: 0,
                checked: this.checked
            });
        }
    });

    $('.searchopt_radio').change(function () {
        $.get('ajax/update_searchdefault.php?update=true', {
            value: this.value,
            checked: this.checked
        });
        $('.searchopt_radio').attr('disabled', true);
        setTimeout(function() {
            $('.searchopt_radio').attr('disabled', false);
        }, 500);
    });
    $('.page_status_checkbox').change(function () {
        $.get('ajax/update_pageactive.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.page_status_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.page_status_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.slider_status_checkbox').change(function () {
        $.get('ajax/update_slideractive.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.slider_status_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.slider_status_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.services_status_checkbox').change(function () {
        $.get('ajax/update_servicesactive.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.services_status_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.services_status_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.team_status_checkbox').change(function () {
        $.get('ajax/update_teamactive.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.team_status_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.team_status_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.customer_status_checkbox').change(function () {
        $.get('ajax/update_customersactive.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.customer_status_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.customer_status_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.hottitles_status_checkbox').change(function () {
        $.get('ajax/update_hottitlesactive.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.hottitles_status_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.hottitles_status_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.customer_featured_checkbox').change(function () {
        $.get('ajax/update_customersfeatured.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.customer_featured_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.customer_featured_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.hottitles_defaults_checkbox').change(function () {
        $.get('ajax/update_hottitlesdefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.hottitles_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.hottitles_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.aboutus_defaults_checkbox').change(function () {
        $.get('ajax/update_aboutusdefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.aboutus_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.aboutus_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.featured_defaults_checkbox').change(function () {
        $.get('ajax/update_featureddefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.featured_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.featured_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.multibranch_checkbox').change(function () {
        $.get('ajax/update_multibranch.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.multibranch_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.multibranch_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.generalinfo_defaults_checkbox').change(function () {
        $.get('ajax/update_generalinfodefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.generalinfo_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.generalinfo_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.contact_defaults_checkbox').change(function () {
        $.get('ajax/update_contactdefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.contact_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.contact_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.social_defaults_checkbox').change(function () {
        $.get('ajax/update_socialmediadefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.social_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.social_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.slider_defaults_checkbox').change(function () {
        $.get('ajax/update_sliderdefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.slider_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.slider_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.databases_defaults_checkbox').change(function () {
        $.get('ajax/update_databasesdefaults.php?update=true&section='+getUrlVars()['section'], {
            id: this.id,
            checked: this.checked
        });
        $('.databases_defaults_checkbox_1').attr('disabled', true);
        setTimeout(function() {
            $('.databases_defaults_checkbox_1').attr('disabled', false);
        }, 500);
    });
    $('.databases_defaults_checkbox_2').change(function () {
        $.get('ajax/update_databasesdefaults.php?update=true&sub_section=2', {
            id: this.id,
            checked: this.checked
        });
        $('.databases_defaults_checkbox_2').attr('disabled', true);
        setTimeout(function() {
            $('.databases_defaults_checkbox_2').attr('disabled', false);
        }, 500);
    });
    $('.databases_defaults_checkbox_3').change(function () {
        $.get('ajax/update_databasesdefaults.php?update=true&sub_section=3', {
            id: this.id,
            checked: this.checked
        });
        $('.databases_defaults_checkbox_3').attr('disabled', true);
        setTimeout(function() {
            $('.databases_defaults_checkbox_3').attr('disabled', false);
        }, 500);
    });
    $('.navigation_defaults_checkbox_1').change(function () {
        $.get('ajax/update_navigationdefaults.php?update=true&sub_section=1', {
            id: this.id,
            checked: this.checked
        });
        $('.navigation_defaults_checkbox_1').attr('disabled', true);
        setTimeout(function() {
            $('.navigation_defaults_checkbox_1').attr('disabled', false);
        }, 500);
    });
    $('.navigation_defaults_checkbox_2').change(function () {
        $.get('ajax/update_navigationdefaults.php?update=true&sub_section=2', {
            id: this.id,
            checked: this.checked
        });
        $('.navigation_defaults_checkbox_2').attr('disabled', true);
        setTimeout(function() {
            $('.navigation_defaults_checkbox_2').attr('disabled', false);
        }, 500);
    });
    $('.navigation_defaults_checkbox_3').change(function () {
        $.get('ajax/update_navigationdefaults.php?update=true&sub_section=3', {
            id: this.id,
            checked: this.checked
        });
        $('.navigation_defaults_checkbox_3').attr('disabled', true);
        setTimeout(function() {
            $('.navigation_defaults_checkbox_3').attr('disabled', false);
        }, 500);
    });
    $('.services_defaults_checkbox').change(function () {
        $.get('ajax/update_servicesdefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.services_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.services_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.team_defaults_checkbox').change(function () {
        $.get('ajax/update_teamdefaults.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.team_defaults_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.team_defaults_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.location_status_checkbox').change(function () {
        $.get('ajax/update_setupactive.php?update=true', {
            id: this.id,
            checked: this.checked
        });
        $('.location_status_checkbox').attr('disabled', true);
        setTimeout(function() {
            $('.location_status_checkbox').attr('disabled', false);
        }, 500);
    });
    $('.set_logo_default').click(function () {
        $.get('ajax/update_logodefaults.php?loc_id=1&update=true&defaultlogo='+$('select[name=site_logo] option:selected').text(), {
            success: function () {
                $('.set_logo_default').attr('disabled', true);
                $('.set_logo_default>i').addClass('fa-spin');
                $('.set_logo_default_msg').html('');
                setTimeout(function() {
                    $('.set_logo_default').attr('disabled', false);
                    $('.set_logo_default>i').removeClass('fa-spin');
                    $('.set_logo_default_msg').html('Process may still be running in the background');
                }, 3000);
            }
        });
    });
    $('.copy_files_to_locs').click(function () {
        $.get('ajax/update_images.php?loc_id=1&update=true', {
            success: function () {
                $('.copy_files_to_locs').attr('disabled', true);
                $('.copy_files_to_locs>i').addClass('fa-spin');
                $('.copy_files_to_locs_msg').html('');
                setTimeout(function() {
                    $('.copy_files_to_locs').attr('disabled', false);
                    $('.copy_files_to_locs>i').removeClass('fa-spin');
                    $('.copy_files_to_locs_msg').html('Process may still be running in the background');
                }, 3000);
            }
        });
    });
    $('.sitemap_builder').click(function () {
        $.get('ajax/update_sitemapxml.php?update=true', {
            success: function () {
                $('.sitemap_builder').attr('disabled', true);
                $('.sitemap_builder>i').addClass('fa-spin');
                $('.sitemap_builder_msg').html('');
                setTimeout(function() {
                    $('.sitemap_builder').attr('disabled', false);
                    $('.sitemap_builder>i').removeClass('fa-spin');
                    $('.sitemap_builder_msg').html('View the <a href="../sitemap.xml" target="_blank">Sitemap.xml</a>');
                }, 3000);
            }
        });
    });
    //Run Installer Button
    $('#run_installer').click(function () {
        setTimeout(function() {
            $('#run_installer').attr('disabled', true);
            $('#run_installer>i').removeClass('fa-cloud-upload');
            $('#run_installer>i').addClass('fa-refresh fa-spin');
        }, 500);
    });

    //Updates/Ugrades Button
    $('#update_download').click(function () {
        setTimeout(function() {
            $('#update_download').attr('disabled', true);
            $('#update_download>i').removeClass('fa-cloud-download');
            $('#update_download>i').addClass('fa-refresh fa-spin');
        }, 500);
    });
    $('#update_install').click(function () {
        setTimeout(function() {
            $('#update_install').attr('disabled', true);
            $('#update_install>i').removeClass('fa-cloud-upload');
            $('#update_install>i').addClass('fa-refresh fa-spin');
        }, 500);
    });

    //Not a Robot Function
    $('#not_robot').change(function () {
        if ($('#user_name').val().length && $('#user_email').val().length) {
            if ($('#not_robot').prop('checked')) {
                $('#not_robot').attr('value', 'e6a52c828d56b46129fbf85c4cd164b3');
                $('#sign_in').attr('disabled', false);
                $('#run_installer').attr('disabled', false);
            } else {
                $('#not_robot').attr('value', '');
                $('#sign_in').attr('disabled', true);
                $('#run_installer').attr('disabled', true);
            }
        }
    });

    //Boostrap-select actions
    $('select.selectpicker-auto').change(function () {
        var selected = $('.selectpicker-auto option:selected').val();
        window.location.href = '?loc_id=' + selected;
    });

    //Category expand/collapse
    $('#addCat_button').click(function () {
        setTimeout(function () {
            if ($('#addCatDiv').hasClass('in')) {
                $('#addCat_button').html("<i class='fa fa-fw fa-times'></i> Close");
            } else {
                $('#addCat_button').html("<i class='fa fa-fw fa-plus'></i> Add / Edit a Category");
            }
        }, 500);
    });

    $('#addHottitles_button').click(function () {
        setTimeout(function () {
            if ($('#addHottitlesDiv').hasClass('in')) {
                $('#addHottitles_button').html("<i class='fa fa-fw fa-times'></i> Close");
            } else {
                $('#addHottitles_button').html("<i class='fa fa-fw fa-plus'></i> Add a List");
            }
        }, 500);
    });

    $('#addUser_button').click(function () {
        setTimeout(function () {
            if ($('#addUserDiv').hasClass('in')) {
                $('#addUser_button').html("<i class='fa fa-fw fa-times'></i> Close");
            } else {
                $('#addUser_button').html("<i class='fa fa-fw fa-plus'></i> Add a User");
            }
        }, 500);
    });

    //Returns Character Count Function
    parseCharCounts();
    
    //Returns Boostrap tooltips function
    $('[data-toggle="tooltip"]').tooltip();

    //Location Select Drop Down list. Sets selected value based on loc_id=querystring value
    $(function () {
        if ($('select[name="loc_id_list"]').length) {
            var queryStrVal = getUrlVars()['loc_id'];
            $('select[name="loc_id_list"]').val(queryStrVal);
        }
    });

    //Dirty Form Check - Confirmation Message
    $(function() {
        $('.dirtyForm').areYouSure({
                //custom message may not show in all browsers
                message: 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.'
            }
        );
    });
});



//--Outside of Document.Ready functions
//modal preview window
function showMyModal(myTitle, myFile) {
    $('#myModalTitle').html(myTitle);
    $('.modal-title').html(myTitle);
    $('#myModalFile').attr('src', myFile);
    $('#myModal').modal('show');
    $('#webslideDialog').modal('show');
    $('#webpageDialog').modal('show');
    $('#databasesDialog').modal('show');
    $('#webserviceDialog').modal('show');
    $('#changlogDialog').modal('show');
}
//Page Load/Performance Checker
window.onload = function () {
    var loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart;
    console.log('Page load time is ' + loadTime);
    console.log(window.performance);
};