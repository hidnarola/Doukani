function show_sub_cat_fields(subval) {        
        
        $("input[name='sub_cat']").val(subval);
        
        if(subval!='')
            $('#subcat_id_err').hide(); 
            
        var cat_text = $('#cat_id').find('option:selected').text();
        
        if(cat_text=='Real Estate'){                
            if(subval!=0){
                
                var sub_cat = $("#sub_cat option[value='"+subval+"']").text();  
                
                if(sub_cat=='Houses - Apartments for Rent' || sub_cat=='Houses - Apartments for Sale'){
                    
                    $('.default_form').hide();
                    $('.vehicle_form').hide();
                    $('.real_estate').hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $('.real_estate_houses_form').show();
                    
                    $('#form_type').val('real_estate_houses_form');
                    
                }else if(sub_cat=='Rooms for Rent - Shared' || sub_cat=='Housing Swap' || sub_cat=='Land' || sub_cat=='Shops for Rent - Sale' || sub_cat=='Office - Commercial Space'){

                    $('.default_form').hide();
                    $('.vehicle_form').hide();
                    $('.real_estate').hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $('.real_estate_shared_form').show();                    
                    $('#form_type').val('real_estate_shared_form');
                }
            }else{               
                $(".default_form").hide();
                $(".vehicle_form").hide();
                $(".real_estate").hide();
                $('.car_number_form').hide();
                $('.mobile_number_form').hide();
            }
        }else if(cat_text=='Vehicles'){

            if(subval!=0){
                
                var sub_cat = $("#sub_cat option[value='"+subval+"']").text();                
                
                if(sub_cat=='Cars'){
                    $(".default_form").hide();
                    $(".real_estate").hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $('.real_estate_shared_form').hide();  
                    $(".vehicle_form").show();
                    $("#form_type").val("vehicle_form");
                    $("#vehicle_pro_color").colorpicker();
                }
                else if(sub_cat=='Car Number') {
                    $(".real_estate").hide();
                    $(".vehicle_form").hide();                    
                    $(".default_form").hide();                    
                    $('.car_number_form').show();
                    $('.mobile_number_form').hide();
                    $("#form_type").val("car_number_form");
                }    
                else{
                    $(".real_estate").hide();
                    $(".vehicle_form").hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $(".default_form").show();
                    $("#form_type").val("default_form");
                }
            }
        }
        else if(cat_text=='Classifieds') {
            
            if(subval!=0){
                
                var sub_cat = $("#sub_cat option[value='"+subval+"']").text(); 
                
                if(sub_cat=='Mobile Numbers') {
                    
                    $(".real_estate").hide();
                    $(".vehicle_form").hide();                    
                    $(".default_form").hide();                    
                    $('.car_number_form').hide();
                    $('.mobile_number_form').show();
                    $("#form_type").val("mobile_number_form");
                }
                else{
                    $(".real_estate").hide();
                    $(".vehicle_form").hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $(".default_form").show();
                    $("#form_type").val("default_form");
                }
            }
        }
        else{
            $(".real_estate").hide();
            $(".vehicle_form").hide();
            $('.car_number_form').hide();
            $('.mobile_number_form').hide();
            $(".default_form").show();
            $("#form_type").val("default_form");
        }
    }
   
    function goBack()
    {
  	window.history.back()
    }

    function show_emirates_form1(val) {
        var sel_city	=	$("#city_form1").val();		
        $.post(emirate_url, {value: val,sel_city:sel_city}, function(data)
        {			
                $("#city_form1").html("");
                $("#city_form1 option").remove();
                $("#city_form1").append(data);
        });
    }

    function show_emirates_form2(val) {
        var sel_city    =   $("#city_form2").val();             
        $.post(emirate_url, {value: val,sel_city:sel_city}, function(data)
        {           
            $("#city_form2").html("");
            $("#city_form2 option").remove();
            $("#city_form2").append(data);
        });     
    }
    
    function show_emirates_form3(val) {
        var sel_city    =   $("#city_form3").val();             
        $.post(emirate_url, {value: val,sel_city:sel_city}, function(data)
        {           
            $("#city_form3").html("");
            $("#city_form3 option").remove();
            $("#city_form3").append(data);
        });     
    }
    
    function show_emirates_form4(val) {
        var sel_city    =   $("#city_form4").val();             
        $.post(emirate_url, {value: val,sel_city:sel_city}, function(data)
        {           
            $("#city_form4").html("");
            $("#city_form4 option").remove();
            $("#city_form4").append(data);
        });
    }
    
    function show_emirates_form5(val) {
        var sel_city    =   $("#city_form5").val();             
        $.post(emirate_url, {value: val,sel_city:sel_city}, function(data)
        {           
            $("#city_form5").html("");
            $("#city_form5 option").remove();
            $("#city_form5").append(data);
        });
    }
    
    function show_emirates_form6(val) {
        var sel_city    =   $("#city_form6").val();             
        $.post(emirate_url, {value: val,sel_city:sel_city}, function(data)
        {           
            $("#city_form6").html("");
            $("#city_form6 option").remove();
            $("#city_form6").append(data);
        });
    }
      
    function show_prefix(val) {
        var sel_prefix    =   $("#plate_prefix").val();             
        $.post(plate_prefix_url, {value: val,sel_prefix:sel_prefix}, function(data)
        {           
            $("#plate_prefix").html("");
            $("#plate_prefix option").remove();
            $("#plate_prefix").append(data);
        });
    } 

var map;
var marker;
var autocomplete;
var latlng;
var geocoder;
var address;
var lat;
var lng;
var currentReverseGeocodeResponse;
var CITY_MAP_CENTER_LAT = '51.528868434293244';
var CITY_MAP_CENTER_LNG = '-0.10159864999991441';
var CITY_MAP_ZOOMING_FACT = '13';
var street_map_view='';
var street_map_view_post ='';
var geocoder = new google.maps.Geocoder();
var panorama;
function initialize() {
    var latlng = new google.maps.LatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG);
    var isDraggable = jQuery(document).width() > 480 ? true : false;
    var myOptions = {
        zoom: 13,
        center: latlng,
        draggable: isDraggable,
        mapTypeId: google.maps.MapTypeId.ROADMAP    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);    
    var styles = [];            
    map.setOptions({styles: styles});
    marker = new google.maps.Marker();
    jQuery('input[name=map_view]').parent(".radio").removeClass('active');          
    var radio = jQuery('input[name=map_view]:checked');
    var updateDay = radio.val();    
    if(updateDay=='Road Map'){
        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);        
        street_map_view='Road Map';
    }else if(updateDay=='Terrain Map'){
        map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
        street_map_view='Terrain Map';
    }else if(updateDay=='Satellite Map'){
        map.setMapTypeId(google.maps.MapTypeId.SATELLITE);      
        street_map_view='Satellite Map';
    }
    
    
    geocoder = new google.maps.Geocoder();
    google.maps.event.addListener(map, 'zoom_changed', function() {
        document.getElementById("zooming_factor").value = map.getZoom();
    });
    
    /* Initialize autocomplete.*/
    var inputField = document.getElementById('address');
    autocomplete = new google.maps.places.Autocomplete(inputField); 
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      var place = autocomplete.getPlace();    
      if (place.geometry) {
        initialize();
        var location = place.geometry.location;
        map.panTo(location);
        map.setZoom(12);
        marker.setMap(null);
        marker = new google.maps.Marker({
            position: map.getCenter(),
            icon: 'https://demo.templatic.com/directory/wp-content/plugins/Tevolution/images/pin.png',
            draggable: true,
            map: map
        });     
        updateMarkerPosition(marker.getPosition());
        google.maps.event.addListener(marker, 'drag', function() {      
            updateMarkerPosition(marker.getPosition());
        });
        setTimeout("set_address_mapview()",500); 
        show_error_msg_map('','');
      }
    });

    
     var geo_latitude= jQuery('#geo_latitude').val();
     var geo_longitude= jQuery('#geo_longitude').val();  
     if((street_map_view_post=='Street map' && (street_map_view=='Street map' || updateDay=='Street map')) && (geo_latitude!='' && geo_latitude != 0  && geo_longitude!='' && geo_longitude != 0) ) {       
        
        var geo_latitude= jQuery('#geo_latitude').val();
        var geo_longitude= jQuery('#geo_longitude').val();      
        var berkeley = new google.maps.LatLng(geo_latitude,geo_longitude);
        var sv = new google.maps.StreetViewService();
        sv.getPanoramaByLocation(berkeley, 50, processSVData);      
     }
     
      /* Add a DOM event listener to react when the user selects a country.*/
     if(jQuery('#country_id').length >0){
          google.maps.event.addDomListener(document.getElementById('country_id'), 'change', setAutocompleteCountry);
          google.maps.event.addListener(map, 'idle', function() {
            autocomplete.setBounds(map.getBounds());
          });
     }
}

function geocode() {
    var location='';    
    if (jQuery('#zones_id').length && jQuery("#zones_id").val() !='') {
        var zones_name=jQuery("#zones_id option:selected").html();
        location+=','+zones_name+',';
    }
    if (jQuery('#country_id').length && jQuery("#country_id").val() !='') {
        var country_name=jQuery("#country_id option:selected").html();
        location+=country_name;
    }
    
    
    var address = document.getElementById("address").value; 
    var placeholder= jQuery('#address').attr('placeholder');
    var location_address= address+location; 
    
    if(address!='' && address!='Enter a location') {
        geocoder.geocode({
        'address': location_address,
        'partialmatch': false}, geocodeResult);
    }else{
        document.getElementById('geo_latitude').value = '';
        document.getElementById('geo_longitude').value = '';
        document.getElementById('zooming_factor').value = '';
    }
}
  
function geocodeResult(results, status) {   
    if (status == 'OK' && results.length > 0) {
      map.fitBounds(results[0].geometry.viewport);
      map.setCenter(results[0].geometry.location);  
      map.setZoom(13);    
      marker.setMap(null);
      marker = new google.maps.Marker();
      addMarkerAtCenter(results);
      show_error_msg_map('','');
    } else {        
                    show_error_msg_map("Error: google is not able to find out the address you enter, Please enter correct address.");
                    /*alert("Geocode was not successful for the following reason: " + status);*/
    }
}

function getCenterLatLngText() {
    return '(' + map.getCenter().lat() +', '+ map.getCenter().lng() +')';
}
function addMarkerAtCenter(results) {
    marker = new google.maps.Marker({
        position: results[0].geometry.location,
        icon: 'https://demo.templatic.com/directory/wp-content/plugins/Tevolution/images/pin.png',
        draggable: true,
        map: map
    });     
    
    updateMarkerPosition(marker.getPosition()); 
    google.maps.event.addListener(marker, 'drag', function() {
        updateMarkerPosition(marker.getPosition());
    }); 
    
    var text = 'Lat/Lng: ' + getCenterLatLngText();
    if(currentReverseGeocodeResponse) {
      var addr = '';
      if(currentReverseGeocodeResponse.size == 0) {
        addr = 'None';
      } else {
        addr = currentReverseGeocodeResponse[0].formatted_address;
      }
      text = text + '<br>' + 'address: <br>' + addr;
    }
    var infowindow = new google.maps.InfoWindow({ content: text });
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
}
   
function updateMarkerPosition(latLng)
{
    document.getElementById('geo_latitude').value = latLng.lat();
    document.getElementById('geo_longitude').value = latLng.lng();
}


function changeMap()
{
    var newlatlng = document.getElementById('geo_latitude').value;
    var newlong = document.getElementById('geo_longitude').value;
    /* address latitude and longitude blank then return */
    if(newlatlng=='' && newlong==''){
        return '';  
    }
    var latlng = new google.maps.LatLng(newlatlng,newlong);
    map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP    });
    
    var styles = [];            
    map.setOptions({styles: styles});   
    marker = new google.maps.Marker({
        position: latlng,
        title: 'Point A',
        icon: 'https://demo.templatic.com/directory/wp-content/plugins/Tevolution/images/pin.png',
        map: map,
        
    });
    
    updateMarkerPosition(marker.getPosition());
    google.maps.event.addListener(marker, 'drag', function() {      
        updateMarkerPosition(marker.getPosition());
    });

}
/* Find Out Street View Available or not  */
function processSVData(data, status) {
    
    if (status == google.maps.StreetViewStatus.OK) {
        panorama = new google.maps.StreetViewPanorama(document.getElementById('map_canvas'));       
                panorama.set('addressControl', false);
        marker = new google.maps.Marker({
         position: data.location.latLng,
         map: map,
         icon: 'https://demo.templatic.com/directory/wp-content/plugins/Tevolution/images/pin.png',
         title: data.location.description
        });
        panorama.setPano(data.location.pano);
        panorama.setPov({
         heading: 270,
         pitch: 0
        });    
        google.maps.event.addListener(marker, 'click', function() {
         var markerPanoID = data.location.pano;
         /* Set the Pano to use the passed panoID*/
         panorama.setPano(markerPanoID);
         panorama.setPov({
           heading: 270,
           pitch: 0
         });
         panorama.setVisible(true);
        });
        
      show_error_msg_map('','');
    } else {
        /*alert('Street View data not found for this location. So change your Map view');*/
        show_error_msg_map("Street View data not found for this location. So change your Map view",'1');        
    }
    
    return true;
}
    
google.maps.event.addDomListener(window, 'load', initialize);
    google.maps.event.addDomListener(window, 'load', geocode);

/* JavaScript Document*/
jQuery(document).ready(function(){
    
    /* Display map view as per city change */
    jQuery(document).on( 'change','select[name^=post_city_id]', function(e) {
        /* Set address marker if address not blank */
        var address = document.getElementById("address").value;
        var placeholder=jQuery('#address').attr('placeholder');     
        if(address=='' && address=='Enter a location'){         
            var city_name=jQuery("#city_id option:selected").html();
            geocoder.geocode( { 'address': city_name}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  map.setCenter(results[0].geometry.location);                    
                  map.setZoom(jquery('#zooming_factor').val());
                }
            });
        }
        
    });


        /* Set map view on map view click  */
        jQuery(document).on("click",'input[name=map_view]', function(e) {    
                initialize();   
                geocode();
                setTimeout("set_address_mapview()",500);
        });
});
/* Show map address error message on google map */
function show_error_msg_map(msg,set){   
    
    if(msg!=''){
        jQuery('#map_address_message').html(msg);
        jQuery('#map_address_message').fadeIn('slow');
    }else{
        jQuery('#map_address_message').html('');
        jQuery('#map_address_message').css('display','none');
    }
    if(set==1){
        changeMap();        
    }
}

/* [START region_setcountry]*/
/* Set the country restriction based on user input.*/
/* Also center and zoom the map on the given country.*/
function setAutocompleteCountry() {
  var country = jQuery('select#country_id option:selected').attr('data-name'); /*document.getElementById('country').value;*/
  if (country != '') {    
    autocomplete.setComponentRestrictions({ 'country': country });    
  }else{
    autocomplete.setComponentRestrictions([]);  
  }
}
/* [END region_setcountry]*/

/* Set google map view  */
function set_address_mapview(){
    
    jQuery('input[name=map_view]').parent(".radio").removeClass('active');          
    var radio = jQuery('input[name=map_view]:checked');
    var updateDay = radio.val();    
    if(updateDay=='Road Map'){
        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);        
        street_map_view='Road Map';     
    }else if(updateDay=='Terrain Map'){
        map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
        street_map_view='Terrain Map';      
    }else if(updateDay=='Satellite Map'){
        map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
        street_map_view='Satellite Map';
    }
    
    var geo_latitude= jQuery('#geo_latitude').val();
    var geo_longitude= jQuery('#geo_longitude').val();      
    if((updateDay=='Street map' || updateDay=='Street Map' ) && (geo_latitude!='' && geo_latitude != 0  && geo_longitude!='' && geo_longitude != 0) ) {
        var berkeley = new google.maps.LatLng(geo_latitude,geo_longitude);
        var sv = new google.maps.StreetViewService();
        sv.getPanoramaByLocation(berkeley, 50, processSVData);
    }
}

