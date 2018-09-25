/* Location navigation open close script */
jQuery(document).ready(function(){jQuery("#directorytab").click(function(){jQuery("#directory_location_navigation").toggleClass("horizontal_open");jQuery("#horizontal_show_togglebox-button").toggleClass('horizontal_open');jQuery("#directorytab").toggleClass("directorytab_open")})})

jQuery(document).ready(function(){	
	jQuery("#location_con_form1").change(function(){
		jQuery("#location_loading").show();
	    var country_id = jQuery('#location_con_form1').val();		
		jQuery.ajax({
			url:ajaxUrl,
			type:'POST',
			data:'action=fill_states_cmb&country_id=' + country_id+'&front=1&header=1',
			success:function(results) {				
				results=results.split('++');
				jQuery('#city_form1').html(results[0]);
				jQuery('#header_city').html(results[1]);
				if(jQuery('select#city_form1 option:selected').val()!=''){
					//jQuery('.horizontal_location_nav select#header_city').trigger('change');		
					jQuery('select#city_form1 option:selected').prop('selected',false);
				}else{					
					/*city_form1*/
					var first_option = jQuery('#city_form1 option').first();					
					jQuery('#city_form1 + span.select').text(first_option.text());
					/*header_city*/
					var city_first_option = jQuery('#header_city option').first();					
					jQuery('#header_city + span.select').text(city_first_option.text());
				}
				jQuery("#location_loading").hide();
			}
		});
	});
	
	
});
jQuery(document).ready(function(){	
	jQuery("#city_form1").change(function(){
		jQuery("#location_loading").show();
	    var state_id = jQuery('#city_form1').val();		
		jQuery.ajax({
			url:ajaxUrl,
			type:'POST',
			data:'action=fill_city_cmb&state_id=' + state_id+'&front=1',
			success:function(results) {			
				jQuery('#header_city').html(results);
				/* call fill city cmb function is one state in available */
				jQuery('.horizontal_location_nav select#header_city').trigger('change');
				if(jQuery('select#header_city option:selected').val()!=''){
					jQuery.ajax({
						url:ajaxUrl,
						type:'POST',
						data:'action=tmpl_change_multicity_form_actoin&city_id=' + jQuery('select#header_city option:selected').val(),
						success:function(action_url) {
							jQuery('#multicity_form').attr('action',action_url);
							jQuery('#multicity_form').submit();
						}
					});
				}else{
					/*header_city*/
					var city_first_option = jQuery('#header_city option').first();					
					jQuery('#header_city + span.select').text(city_first_option.text());
				}
				jQuery("#location_loading").hide();
			}
		});	
	});		
});
jQuery(document).ready(function(){	
	jQuery("#header_city").change(function(){
		if(jQuery(this).val()!=''){
			jQuery.ajax({
				url:ajaxUrl,
				type:'POST',
				data:'action=tmpl_change_multicity_form_actoin&city_id=' + jQuery('select#header_city option:selected').val(),
				success:function(action_url) {
					jQuery('#multicity_form').attr('action',action_url);
					jQuery('#multicity_form').submit();
				}
			});
		}
	});		
});

jQuery(document).ready(function(){	
	jQuery("#adv_zone").change(function(){				
	    	var state_id = jQuery('#adv_zone').val();		
		jQuery.ajax({
			url:ajaxUrl,
			type:'POST',
			data:'action=fill_city_cmb&state_id=' + state_id,
			success:function(results) {				
				jQuery('#adv_city').html(results);
				/* call fill city cmb function is one state in available */
				jQuery('.widget select#adv_city').trigger('change');
				if(jQuery('select#adv_city option:selected').val()!=''){
					jQuery('select#adv_city').trigger('change');						
				}else{
					var city_first_option = jQuery('#adv_city option').first();					
					jQuery('#adv_city + span.select').text(city_first_option.text());
				}
			}
		});	
	});		
});


/*Finish the advance search shortcode multicity */
/*Set Cookies Function */
function setCookie(name,value,days) {
   if (days) {
	  var date = new Date();
	  date.setTime(date.getTime()+(days*24*60*60*1000));
	  var expires = "; expires="+date.toGMTString();
   }
   else var expires = "";
   document.cookie = name+"="+value+expires+"; path=/";
}
function getCookie(name) {
   var nameEQ = name + "=";
   var ca = document.cookie.split(';');
   for(var i=0;i < ca.length;i++) {
	  var c = ca[i];
	  while (c.charAt(0)==' ') c = c.substring(1,c.length);
	  if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
   }
   return null;
}
function deleteCookie(name) {
   setCookie(name,"",-1);
}
