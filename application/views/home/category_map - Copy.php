<html>
<head>
	<style>
    html { height: auto; }
    body { height: auto; margin: 0; padding: 0; font-family: Georgia, serif; font-size: 0.9em; }
    table { border-collapse: collapse; border-spacing: 0; }
    p { margin: 0.75em 0; }
    #map_canvas { height: auto; position: absolute; bottom: 0; left: 0; right: 0; top: 0; }
    @media print { #map_canvas { height: 950px; } }
  </style>
  <script src="./Overlapping Marker Spiderfier demo_files/js"></script>
  <script src="./Overlapping Marker Spiderfier demo_files/oms.min.js"></script>
  <script>
    window.onload = function() {
      var gm = google.maps;
      var map = new gm.Map(document.getElementById('map_canvas'), {
        mapTypeId: gm.MapTypeId.ROADMAP,
        center: new gm.LatLng(50, 0), zoom: 6,  // whatevs: fitBounds will override
        scrollwheel: true
      });
      var iw = new gm.InfoWindow();
      var oms = new OverlappingMarkerSpiderfier(map,
        {markersWontMove: true, markersWontHide: true});

      var usualColor = 'eebb22';
      var spiderfiedColor = 'ffee22';
      var iconWithColor = function(color) {
        return 'http://chart.googleapis.com/chart?chst=d_map_xpin_letter&chld=pin|+|' +
          color + '|000000|ffff00';
      }
      var shadow = new gm.MarkerImage(
        'https://www.google.com/intl/en_ALL/mapfiles/shadow50.png',
        new gm.Size(37, 34),  // size   - for sprite clipping
        new gm.Point(0, 0),   // origin - ditto
        new gm.Point(10, 34)  // anchor - where to meet map location
      );
      
      oms.addListener('click', function(marker) {
        iw.setContent(marker.desc);
        iw.open(map, marker);
      });
      oms.addListener('spiderfy', function(markers) {
        for(var i = 0; i < markers.length; i ++) {
          markers[i].setIcon(iconWithColor(spiderfiedColor));
          markers[i].setShadow(null);
        } 
        iw.close();
      });
      oms.addListener('unspiderfy', function(markers) {
        for(var i = 0; i < markers.length; i ++) {
          markers[i].setIcon(iconWithColor(usualColor));
          markers[i].setShadow(shadow);
        }
      });
      
      var bounds = new gm.LatLngBounds();
      for (var i = 0; i < window.mapData.length; i ++) {
        var datum = window.mapData[i];		
        var loc = new gm.LatLng(datum.lat, datum.lon);
        bounds.extend(loc);
        var marker = new gm.Marker({
          position: loc,
          title: datum.h,
          map: map,
          icon: iconWithColor(usualColor),
          shadow: shadow
        });
        marker.desc = datum.d;
        oms.addMarker(marker);
      }
      map.fitBounds(bounds);

      // for debugging/exploratory use in console
      window.map = map;
      window.oms = oms;
    }
  </script>
  <div id="map_canvas" ></div>
  <script>
  // randomize some overlapping map data -- more normally we'd load some JSON data instead
  var baseJitter = 2.5;
  var clusterJitterMax = 0.1;
  var rnd = Math.random;
  var data = [];
  //var clusterSizes = [1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2,2, 3, 3, 4, 5, 6, 7, 8, 9, 12, 18, 24];
  var clusterSizes = [ 9, 12, 18, 24];
  for (var i = 0; i < clusterSizes.length; i++) {
    var baseLon = -1 - baseJitter / 2 + rnd() * baseJitter;
    var baseLat = 52 - baseJitter / 2 + rnd() * baseJitter;
    var clusterJitter = clusterJitterMax * rnd();
    for (var j = 0; j < clusterSizes[i]; j ++) data.push({
      lon: baseLon - clusterJitter + rnd() * clusterJitter,
      lat: baseLat - clusterJitter + rnd() * clusterJitter,
      h:   new Date(1E12 + rnd() * 1E11).toString(),
      d:   Math.round(rnd() * 100) + '% happy'
    });
  }
  window.mapData = data;
</script>

     <?php $this->load->view('include/head'); ?>     
    <script>
	
	 function initialize() {
    
        var map_options = {
            center: new google.maps.LatLng(25.2048493,55.270782800000006),            
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var google_map = new google.maps.Map(document.getElementById("googleMap"), map_options);

        var info_window = new google.maps.InfoWindow({
            content: 'loading'
        });
       
		//console.log("<?php //json_encode($product); ?>");
		var lat='',lng='';
        <?php foreach ($product as $pro) {
          
		  $state_name = $pro['state_name'];
          if($pro['state_name'] == '' )
            $state_name = 'Dubai';
        ?>
		  //alert("<?php echo $pro['username1']; ?>");
          // t.push('<?php echo $pro["product_name"]; ?>');
          var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': '<?php echo $state_name; ?>'}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
			
              //console.log(results[0].geometry.location.lat());
              lat = results[0].geometry.location.lat();
              lng = results[0].geometry.location.lng();
            
			//here start
			/*
			var coordinates_hash = new Array();
			var coordinates_str, actual_lat, actual_lon, adjusted_lat, adjusted_lon;

				 actual_lat = adjusted_lat = this.locations[i].latitude;
				 actual_lon = adjusted_lon = this.locations[i].longitude;
				 coordinates_str = actual_lat + actual_lon;
				 while (coordinates_hash[coordinates_str] != null) {
				  // adjust coord by 50m or so
				  adjusted_lat = parseFloat(actual_lat) + (Math.random() -.5) / 750;
				  adjusted_lon = parseFloat(actual_lon) + (Math.random() -.5) / 750;
				  coordinates_str = String(adjusted_lat) + String(adjusted_lon);
				 }
				 coordinates_hash[coordinates_str] = 1;

				 var myLatLng = new google.maps.LatLng(adjusted_lat, adjusted_lon); */
			//here end
			
			
			
			  var imgerr	=	"onerror=this.src='<?php echo base_url() ?>assets/upload/No_Image.png'";
			  <?php $profile_picture = '';
					if($pro['profile_picture'] != ''){
						$profile_picture = base_url() . profile . "original/" .$pro['profile_picture'];	
					}
					elseif($pro['facebook_id'] != ''){
						$profile_picture = 'https://graph.facebook.com/'.$pro['facebook_id'].'/picture?type=large';
					}elseif($pro['twitter_id'] != ''){
						$profile_picture = 'https://twitter.com/'.$pro['username'].'/profile_image?size=original';     
					}
					elseif($pro['google_id'] != ''){
						$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$pro['google_id'].'?alt=json');
						$d = json_decode($data);
						$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
					}
			 ?>
			  var imgproerr	=	"onerror=this.src='<?php echo base_url() ?>assets/upload/avtar.png'";
			  		  
			  
              var m = new google.maps.Marker({
                map:       google_map,
                animation: google.maps.Animation.DROP,
                title:     '<?php echo $pro["product_name"]; ?>',                
                position:  new google.maps.LatLng( lat,lng),
                html:      '<div class="col-sm-12 list-item"><div class="col-sm-3 img-holder"><?php if($pro['product_is_sold']==1) { ?><div class="sold"><span>SOLD</span></div><?php } ?><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" '+imgerr+' /><div class="count-img"><i class="fa fa-image"></i><span><?php echo $pro['cntimg']+$pro['main']; ?></span></div></div>   <div class="col-sm-9 info-holder"><?php if($pro['product_is_sold']!=1) { ?><?php if($is_logged!=0){ ?><?php if(@$pro['product_total_favorite'] != 0){ ?><div class="star fav" ><a href="#"><i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i></a></div><?php } else { ?><div class="star" ><a href="#"> <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i></a></div><?php }} else { ?>   <div class="star" ><a href="<?php echo base_url() .'login/index'; ?>"><i class="fa fa-star-o"></i></a></div><?php } ?><?php } ?><div class="col-sm-6"><a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><h3><?php echo $pro['product_name']; ?></h3></a><small><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></small></div><div class="col-sm-6 price padding-r50"><h4>AED <?php echo number_format($pro['product_price']); ?></h4></div><div class="infobar col-sm-12"><?php if($category_id == 7){?>     <?php if(@$pro['year'] != ""){?><div class="col-sm-4 col-md-3">Year : <span><?php echo @$pro['year']; ?></span></div><?php } if(@$pro['colorname']){?><div class="col-sm-4 col-md-3">Color : <span><?php echo @$pro['colorname']; ?></span></div><?php } if(@$pro['mileagekm']){?><div class="col-sm-4 col-md-3">KM : <span><?php echo @$pro['mileagekm']; ?></span></div><?php }if(@$pro['model']){ ?><div class="col-sm-4 col-md-3">Model : <span><?php echo @$pro['mname']; ?></span></div><?php } if(@$pro['type_of_car']){ ?><div class="col-sm-4 col-md-3">Type : <span><?php echo @$pro['type_of_car']; ?></span></div><?php }if(@$pro['make']){ ?><div class="col-sm-4 col-md-3">Make : <span><?php echo @$pro['make']; ?></span></div><?php }   ?><?php } else if($category_id == 8){?><?php if(@$pro['Country'] != ""){?><div class="col-sm-4 col-md-3">Country : <span><?php echo @$pro['Country']; ?></span></div><?php } if(@$pro['Emirates']){?><div class="col-sm-4 col-md-3">Emirates : <span><?php echo @$pro['Emirates']; ?></span></div></div><?php } if(@$pro['PropertyType']){?><div class="col-sm-4 col-md-3">Property Type : <span><?php echo @$pro['PropertyType']; ?></span></div><?php }if(@$pro['Bathrooms']){ ?><div class="col-sm-4 col-md-3">Bathrooms : <span><?php echo @$pro['Bathrooms']; ?></span></div><?php } if(@$pro['Bedrooms']){ ?><div class="col-sm-4 col-md-3">Bedrooms : <span><?php echo @$pro['Bedrooms']; ?></span></div><?php }if(@$pro['Area']){ ?><div class="col-sm-4 col-md-3">Area : <span><?php echo @$pro['Area']; ?></span></div><?php }if(@$pro['Amenities']){ ?><div class="col-sm-4 col-md-3">Amenities : <span><?php echo @$pro['Amenities']; ?></span></div><?php } ?><?php } ?></div>   <div class="by-user col-sm-6 padding5"><img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" '+imgproerr+' /><a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a></div><div class="col-sm-6 padding5 text-right"><a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>" class="btn mybtn">View</a></div></div></div>'
            });
			//google.maps.mapMarkersArray.push(m);
            google.maps.event.addListener(m, 'click', function() {			
				console.log(m);
                info_window.setContent(this.html);
                info_window.open(google_map, this);
            });
                
            }
        });
 <?php } ?>
    }

	google.maps.event.addDomListener(window, 'load', initialize);
	
	$(document).ready(function () {

  //  LoadMarkers();

});


/*
function LoadMarkers() { 
    var locations = [
      ['Ongoye Nature Reserve', -28.842569,31.702595, 4],
      ['Rust De Winter Nature Reserve', -25.231342,28.492355, 5],
      ['Musina', -22.343963,30.042028, 3],
      ['Musina', -22.343963,30.042028, 3],
      ['Lokshoek', -29.166477,26.049914, 2],
      ['Mafikeng', -25.867874,25.695305, 1]
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 5,
      center: new google.maps.LatLng(-28.613459,24.082031),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });
        
      google.maps.event.addListener(map, 'click', find_closest_marker);

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
}

function rad(x) {return x*Math.PI/180;}
function find_closest_marker( event ) {
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();
    var R = 6371;
    var distances = [];
    var closest = -1;
    for( i=0;i<map.markers.length; i++ ) {
        var mlat = map.markers[i].position.lat();
        var mlng = map.markers[i].position.lng();
        var dLat  = rad(mlat - lat);
        var dLong = rad(mlng - lng);
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        distances[i] = d;
        if ( closest == -1 || d < distances[closest] ) {
            closest = i;
        }
    }

    alert(map.markers[closest].title);
}  */



	</script>
</head>
<body>
<!--container-->
	<div class="container-fluid">
	
            
    	<!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
        <!--//ad1 header-->
        <!--menu-->
		<?php $this->load->view('include/menu'); ?>
        <!--//menu-->
        
        <!--body-->
        <div class="row page">
            <!--header-->
           <?php $this->load->view('include/sub-header'); ?>
            <!--//header-->
            <!--main-->
            <div class="col-sm-12 main">
		<div class="row">
                    <!--cat-->
                   <?php $this->load->view('include/left-nav'); ?>
                    <!--//cat-->
                    <!--content-->
                    <div class="col-sm-10">
                    	<!--row-->
                    	<div class="row subcat-div">
			<!--
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
</head> 
    <body>
      <div id="map" style="width: 500px; height: 400px;"></div>
    </body>
</html> -->
							
						
                        	<div class="col-sm-8">
                            	<?php $this->load->view('include/breadcrumb'); ?>
                                 <span class="result"><?php echo @$subcat_name?@$subcat_total:$total; ?> Results</span>
                                
                            </div>
                            <div class="col-sm-4 text-right views">
                            	<a href="<?php echo  base_url();?>home/category/<?php echo $category_id; ?>" ><span class="fa  fa-th"></span></a>
                                <a href="<?php echo  base_url();?>home/category_listing/<?php echo $category_id; ?>"><span class="fa  fa-th-list"></span></a>
                                <a href="<?php echo  base_url();?>home/category_map/<?php echo $category_id; ?>" class="view-active"><span class="fa  fa-map-marker"></span></a>
                            </div>
                            <div class="col-sm-12">
                            	<div class="col-sm-12 no-padding-xs">
                                    <div class="col-sm-12 subcats">
                                       <?php foreach ($subcat as $sub){ ?>
                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                          
                                            <a href="<?php echo  base_url();?>home/category_map/<?php echo $category_id."/".$sub['id']; ?>"><?php echo $sub['name'];?> <span class="count"> (<?php echo $sub['total'];?>)</span></a>
                                        </div>
                                       <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <!----Product------>
                           <!--//-->
                        <div class="row">
                            <div class="col-sm-12 catlist">
                                  <h3><?php echo str_replace('\n', " ", @$subcat_name?@$subcat_name:$category_name); ?></h3>
                            	<div class="col-sm-12"><div id="googleMap" class="map" style="width:100%;height:600px; margin:20px 0;"></div></div>
                               
                                <?php /*
                              if (!empty($product)){
                                foreach ($product as $pro) { 
                                  if($pro['product_id'] == $pro_id){?>
                                <div class="col-sm-8 list-item arrow">
                                    <div class="col-sm-3 img-holder">
                                       <?php //if (!empty($pro['product_image'])): ?>
                                               <img src="<?php echo base_url() . product . "original/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'"/>
                                             <?php //endif; ?>
                                        <div class="count-img">
                                        	<i class="fa fa-image"></i><span><?php echo $pro['product_total_views']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 info-holder">
                                          <?php if($is_logged!=0){ ?>
                                                <?php if(@$pro['product_total_favorite'] != 0){ ?>
                                                         <div class="star fav" ><a href="#">
                                                            <i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
                                                           </a></div>
                                                <?php } else { ?>
                                                     <div class="star" ><a href="#">
                                                      <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
                                                     </a></div>
                                                <?php }
                                                 } else { ?>

                                                <div class="star" ><a href="<?php echo base_url() .'login/index'; ?>">
                                                      <i class="fa fa-star-o"></i>
                                                     </a></div>
                                               <?php } ?>
                                        <div class="col-sm-6">
                                        	<a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><h3><?php echo $pro['product_name']; ?></h3></a>
                                        	<small><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></small>
                                        </div>
                                        <div class="col-sm-6 price padding-r50">
                                        	<h4>AED <?php echo $pro['product_price']; ?></h4>
                                        </div>
                                        <div class="infobar col-sm-12 hidden-md">
                                        	
                                                 <?php if($category_id == 7){?>
                                                    <?php if(@$pro['year'] != ""){?>
                                                        <div class="col-sm-4">Year : <?php echo @$pro['year']; ?></div>
                                                    <?php } if(@$pro['color']){?>
                                                        <div class="col-sm-4">Color : <?php echo @$pro['color']; ?></div>
                                                    <?php } if(@$pro['millage']){?>
                                                        <div class="col-sm-4">KM : <?php echo @$pro['millage']; ?></div>
                                                    <?php }if(@$pro['model']){ ?>
                                                        <div class="col-sm-4">Model : <?php echo @$pro['model']; ?></div>
                                                    <?php } if(@$pro['type_of_car']){ ?>
                                                        <div class="col-sm-4">Type : <?php echo @$pro['type_of_car']; ?></div>
                                                    <?php }if(@$pro['make']){ ?>
                                                        <div class="col-sm-4">Make : <?php echo @$pro['make']; ?></div>
                                                    <?php } ?>
                                            <?php } else if($category_id == 8){?>
                                                    <?php if(@$pro['Country'] != ""){?>
                                                        <div class="col-sm-4">Country : <?php echo @$pro['Country']; ?></div>
                                                    <?php } if(@$pro['Emirates']){?>
                                                        <div class="col-sm-4">Emirates : <?php echo @$pro['Emirates']; ?></div>
                                                    <?php } if(@$pro['PropertyType']){?>
                                                        <div class="col-sm-4">Property Type : <?php echo @$pro['PropertyType']; ?></div>
                                                    <?php }if(@$pro['Bathrooms']){ ?>
                                                        <div class="col-sm-4">Bathrooms : <?php echo @$pro['Bathrooms']; ?></div>
                                                    <?php } if(@$pro['Bedrooms']){ ?>
                                                        <div class="col-sm-4">Bedrooms : <?php echo @$pro['Bedrooms']; ?></div>
                                                    <?php }if(@$pro['Area']){ ?>
                                                        <div class="col-sm-4">Area : <?php echo @$pro['Area']; ?></div>
                                                    <?php }if(@$pro['Amenities']){ ?>
                                                        <div class="col-sm-4">Amenities : <?php echo @$pro['Amenities']; ?></div>
                                                    <?php } ?>
                                            <?php } ?>
                                        </div>
                                        <div class="by-user col-sm-6 padding5">
                                            <img src="<?php echo base_url() . profile . "original/" . $pro['profile_picture']; ?>" class="img-responsive img-circle"  onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
                                            <a href="#"><?php echo $pro['username']; ?></a>                                            
                                        </div>
                                        <div class="col-sm-6 padding5 text-right">
                                        	<button class="btn mybtn">View</button>
                                        </div>
                                    </div>
                                </div>
                                
                               
                                       
                              <?php } } }*/
                               $flag = 1;
                              if (!empty($product)){
                                foreach ($product as $pro) { 
                                  // if($pro['product_id'] != $pro_id){
                                            if($flag == 1){ ?>
                                                 <div class="col-sm-12">
                                                <div class="table-responsive">
                                              <table id="table-map" class="dataTable table-responsive table-map table table-striped" >
                                                  <tbody>
                                                  <tr>
                                                  <td><h3>Title</h3></td>
                                                    <td><h3>Price</h3></td>
                                                </tr>
                                           <?php  }
                                            if(@$subcat_id == "")
                                                $subcat_id = 0;
                                            ?>
                                             <tr>
                                                 <td><a href="<?php echo  base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><?php echo $flag.". ".$pro['product_name']; ?></a></td>
													<td>AED <?php echo number_format($pro['product_price']).'===='.$pro['state_name']; ?></td>
											</tr>
                              <?php $flag++; 
                            // } 
                             } } ?>
                                        	
                                         </tbody>	
                                      </table>
                                      <nav class="col-sm-12 text-right">
                                        <?php echo $links; ?>
                                      </nav>
                                    </div>
                                </div>
                                <!--//table-->
                            </div>
                        </div>
                        <!--//-->                        
                      <!-- end product -->
                    </div>
                    <!--//content-->
                </div>
            </div>
            <!--//main-->
        </div>
        <!--//body-->        
        <!--footer-->
            <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>

<script type="text/javascript">
     $('.price').click(function() { 
            var url = "<?php echo base_url() ?>home/add_to_favorites";
            var fav = 0;
            var id = $("div.star a i").attr('id');
            console.log(id);
             if($("#"+id).hasClass('fa-star-o')){
                  $("#"+id).closest('div').addClass('fav');
                 $("#"+id).removeClass("fa-star-o");
                 $("#"+id).addClass("fa-star");
                 fav = 1;
            }else if($("#"+id).hasClass('fa-star')){
                 $("#"+id).closest('div').removeClass('fav');
                 $("#"+id).addClass("fa-star-o");
                 $("#"+id).removeClass("fa-star");
                 fav = -1;
            }
            
             $.post(url, {value: fav,product_id:id}, function(response)
            {   
                console.log(response);

            });
            
            
        });

//        $("#table-map").dataTable({
//             pageSize: 2
//        });
        
</script>
<!--container-->
</body>
</html>