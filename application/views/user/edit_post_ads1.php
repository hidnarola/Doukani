<html>
<head>
     <?php $this->load->view('include/head'); ?>
    <?php $this->load->view('include/google_tab_manager_head'); ?>
    <script type="text/javascript">
    function initialize() {
      var mapProp = {
        center:new google.maps.LatLng(51.508742,-0.120850),
        zoom:5,
        mapTypeId:google.maps.MapTypeId.ROADMAP
      };
      var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>

<!-- Bootstrap styles -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/blueimp/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/blueimp/jquery.fileupload.css">

<link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/plugins/jquery_fileupload/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/blueimp/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/blueimp/jquery.fileupload-ui-noscript.css"></noscript>	
</head>

<body>
    <?php $this->load->view('include/google_tab_manager_body'); ?>
<!--container-->
    <div class="container-fluid">
        <?php $this->load->view('include/header'); ?>
        <?php $this->load->view('include/menu'); ?>
        <div class="row page">
            <?php $this->load->view('include/sub-header'); ?>
            <div class="col-sm-12 main postad">
                <div class="row">
                    <?php $this->load->view('include/left-nav'); ?>
                    <div class="col-sm-10 post-ad">
                        <h3>Edit your ad</h3>
                        <div class='box-content'>
                            <div class='row'>
                            <div class='form-group'>  
                                
                                <div class="col-md-2 col-sm-3">Category</div>
                                <div class='col-md-6 col-sm-8 controls' style="padding: 0px 12px 14px 14px;">
                                     <select class="form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);">
                                        <?php foreach ($category1 as $cat): ?>
                                            <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $product[0]['category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <div class='row'>       
                                                <div class='form-group'>  
                                                <!--<label class='col-md-2 control-label text-right' for='inputText1'>Sub Category</label>-->                                                
                                                <div class="col-md-2 col-sm-3">Sub Category</div>
                                                <div class='col-md-6 col-sm-8 controls' id="sub_cat_list" style="padding: 0px 12px 14px 14px;">
                                                     <select class="form-control" id="sub_cat1" name="sub_cat" >
                                                        <?php foreach ($sub_category1 as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>" <?php echo ($cat['sub_category_id'] == $product[0]['sub_category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                            
                                                </div>
                                                </div>
                                            </div>
                                            <!--===================== DEFAULT FORM ======================-->


		<?php if($product_type=='default'){ ?>


		 <form  name="default_form" action='<?php echo base_url() . 'user/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form default_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="fileupload">
		
			<input type="hidden" name="cat_id" value="<?php echo $product[0]['category_id']; ?>">
			<input type="hidden" name="sub_cat" value="<?php echo $product[0]['sub_category_id']; ?>">
					<div class='form-group'>
						<input type="hidden" id='mycounter1' value="<?php echo $mycounter; ?>">
							<div class="col-md-2 col-sm-3">Name<span> *</span></div>
							<div class='col-md-6 col-sm-8 controls'>
								<input placeholder='Product Name' class="form-control" value="<?php echo $product[0]['product_name']; ?>" name="pro_name" type='text' data-rule-required='true' />
							</div>
						</div>
					<div class='form-group'>                        
						<div class="col-md-2 col-sm-3">Description<span> *</span></div>
						<div class='col-md-6 col-sm-8 controls'>
							<textarea class="form-control" id="inputTextArea1" placeholder="Description" name="pro_desc" rows="3" data-rule-required='true'><?php echo $product[0]['product_description']; ?></textarea>
						</div>
					</div>    
			<div class="row fileupload-buttonbar">
			<div class="col-md-2 col-sm-3"></div>
				<div class="col-lg-7">
					<!-- The fileinput-button span is used to style the file input field as button -->
					<span class="btn btn-success fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span>Add files...</span>
						<input type="file" name="userfile" multiple>
					</span>
					<button type="submit" class="btn btn-primary start">
						<i class="glyphicon glyphicon-upload"></i>
						<span>Start upload</span>
					</button>
					<button type="reset" class="btn btn-warning cancel">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span>Cancel upload</span>
					</button>
					<button type="button" class="btn btn-danger delete">
						<i class="glyphicon glyphicon-trash"></i>
						<span>Delete</span>
					</button>
					<input type="checkbox" class="toggle">
					<!-- The global file processing state -->
					<span class="fileupload-process"></span>
				</div>
				<!-- The global progress state -->
				<div class="col-lg-5 fileupload-progress fade">
					<!-- The global progress bar -->
					<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
						<div class="progress-bar progress-bar-success" style="width:0%;"></div>
					</div>
					<!-- The extended global progress state -->
					<div class="progress-extended">&nbsp;</div>
				</div>
			</div>					
			
			<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
					<div class='form-group'>                        
						<div class="col-md-2 col-sm-3">Cover Image</div>
						<div class='col-md-5'>
							<?php if (!empty($product[0]['product_image'])): ?>
							<div class='form-group' style="display: inline-block;">
								<div class="col-md-2"></div>
								<div class='col-md-5'>
									<div class='gallery'>                                                   
										<ul class='list-unstyled list-inline'>  
										<li>                                                  
											<div class='picture'>
											  <div class='tags'>
												<div class='label label-important'><a  class="delete_btn1" style="cursor:pointer;" onclick="javascript:deletemainimg('<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
											  </div>                              
											  <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $product[0]['product_image']; ?>'>
												<img alt="product Image" src="<?php echo base_url() . product . "medium/" . $product[0]['product_image']; ?>" />
											  </a>
											</div>                          
										</li>
										</ul>                       
									</div>                                              
								</div>
							</div>
						<?php endif; ?>
						</div>                                              						
					</div>                                          					
					<div class="form-group" >                                                
						 <div class='col-md-12'>
						  <div class='gallery'>                                                 
							<ul class='list-unstyled list-inline'>
							<?php  foreach($images as $i):  ?>  
							  <li>                                                  
								<div class='picture'>
								  <div class='tags'>
									<div class='label label-important'>
									<a  style="cursor:pointer;" class="delete_btn2" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>','<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
								  </div>                              
									<a data-lightbox='flatty' href="<?php echo base_url() . product . "original/" . $i['product_image']; ?>">
									<img alt="product Image" src="<?php echo base_url() . product . "medium/" . $i['product_image']; ?>" width="150px" height="150px">
								  </a>
								</div>                          
							  </li>      
								<?php   endforeach; ?>                        
							</ul>                       
						  </div>
						</div>
					</div>
														   
					
					<div class="form-group" >
						<div class="col-md-2 col-sm-3">Emirate<span> *</span></div>
						 <div class='col-md-6 col-sm-8 controls'>
							<select id="shared_location" name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required="true">
								<option value="">Select</option>
								<?php foreach ($state as $o) { ?>
									<option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
								<?php } ?>
							</select>                     
						</div>
					</div>
					<div class='form-group'>                        
						<div class="col-md-2 col-sm-3">Price<span> *</span></div>
						<div class='col-md-6 col-sm-8 controls'>
							<input class="form-control"  placeholder="Price" value="<?php echo $product[0]['product_price']; ?>" name="pro_price" type="text" data-rule-required='true' />
						</div>
					</div>
					<!--<div class='form-group'>                        
						<label class='col-md-2 control-label' for='inputText1'>Brand</label>
						<div class='col-md-5'>
							<!--<input class="form-control"  placeholder="Brand" name="pro_brand" type="text" value="<?php //echo $product[0]['product_brand']; ?>" />-->
						   <!-- <select name="pro_brand"  class="form-control select2 ">    
								<option value="">Select Brand</option>  
								<?php //foreach($brand as $col):?>
									<option value="<?php //echo $col['brand_id']; ?>"
									<?php //if($col['brand_id']==$product[0]['product_brand']) echo 'selected=selected'; else echo ''; ?>><?php //echo $col['name']; ?></option>            
								<?php //endforeach;   ?>
							</select>       
						</div>
					</div>-->
					<div class="form-actions form-actions-padding-sm">
						<div class="row">
							<div class="col-md-10 col-md-offset-2">
								<button class='btn btn-primary' type='submit' id="submitHandler" name="default_submit">
									<i class='icon-save'></i>
									Repost
								</button>
								<a href='<?php echo base_url(); ?>user/my_listing' title="Cancel" class="btn">Cancel</a>
							</div>
						</div>
					</div>
		
		
	</form>

					<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>     

            <?php $this->load->view('include/footer'); ?>

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}				
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<!--<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.fileupload-audio.js"></script> -->
<!-- The File Upload video preview plugin -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="assets/js/fileupload/cors/jquery.xdr-transport.js"></script>
<![endif]-->			
			
			

<!-- / jquery migrate (for compatibility with new jquery) [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
<!-- / jquery ui -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / jQuery UI Touch Punch -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<!-- / bootstrap [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
<!-- / theme file [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
<!-- / demo file [not required!] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/demo.js" type="text/javascript"></script>
<!-- / wysihtml5 -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/wysihtml5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/bootstrap-wysihtml5.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
<!-- / validation --> 
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/javascripts/jquery.multiple.select.js"></script>
    </div>
   <script type="text/javascript">

var base_url = "<?php echo base_url(); ?>admin/";

</script>
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/javascripts/multiupload.js"></script>-->
<script type="text/javascript">
var hei			=	150;
var wid			=	150;
var min_height	=	400;
var min_width	=	700;
var err_msg		=	"Image Dimension must be grater than 700*400";
$(function(){
    $('#submitHandler').click(function(){
        var inp = document.getElementById('multiUpload');
        var cnt = 0;
        var cnt1= 0;
        for (var i = 0; i < inp.files.length; ++i) 
        {
          var name = inp.files.item(i).name;
          var size = inp.files.item(i).size;
          var type = inp.files.item(i).type;
                
                if(type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                    cnt++;           
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }           
    })
})

$(function(){
    $('#submitHandler1').click(function(){
        var inp = document.getElementById('multiUpload1');
        var cnt = 0;
        var cnt1= 0;
        for (var i = 0; i < inp.files.length; ++i) 
        {
          var name = inp.files.item(i).name;
          var size = inp.files.item(i).size;
          var type = inp.files.item(i).type;
                
                if(type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                    cnt++;                         
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }        
    })
})
$(function(){
    $('#submitHandler2').click(function(){
        var inp = document.getElementById('multiUpload2');
        var cnt = 0;
        var cnt1= 0;
        for (var i = 0; i < inp.files.length; ++i) 
        {
          var name = inp.files.item(i).name;
          var size = inp.files.item(i).size;
          var type = inp.files.item(i).type;
                
                if(type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                    cnt++;                      
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }
               
    })
})
$(function(){
    $('#submitHandler3').click(function(){
        var inp = document.getElementById('multiUpload3');
        var cnt = 0;
        var cnt1= 0;
        for (var i = 0; i < inp.files.length; ++i) 
        {
          var name = inp.files.item(i).name;
          var size = inp.files.item(i).size;
          var type = inp.files.item(i).type;
                
                if(type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                    cnt++;  
                   
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }
             
    })
})



function mydelete(val,prod_id)
{
    var url = "<?php echo base_url() ?>user/removeimage";
    var r = confirm("Are you sure you want to delete image?");
    if (r == true) 
    {
        $.post(url, {value: val,prod_id:prod_id}, function(data)
        {           
			//alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>user/listings_edit/"+prod_id;  
        });
    }     
    return false;
}
function deletemainimg(prod_id)
{
    var url = "<?php echo base_url() ?>user/removemainimage";
    var r = confirm("Are you sure you want to delete main image?");
    if (r == true) 
    {
        $.post(url, {prod_id:prod_id}, function(data)
        {       
            //alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>user/listings_edit/"+prod_id;  
        });
    }     
    return false;
}

var config = {
    support : "image/jpg,image/png,image/bmp,image/jpeg,image/gif",     // Valid file formats
    form: "demoFiler",   // Form ID
    dragArea: "dragAndDropFiles",  // Upload Area ID
    upload_btn: "upload_btn", //upload button
    uploadUrl: "<?php echo base_url(); ?>uploads/index"             // Server side upload url
}

$("#vehicle_pro_year").datepicker({
    format: "yyyy",
    startView: 1,
    minViewMode: 2
});
var val     = $('#cat_id').val();
var subval  = $('#sub_cat1').val();
//show_sub_cat(val);
show_sub_cat_fields(subval);

$("#cat_id").each(function() {
        var $thisOption = $(this);
        $thisOption.attr("disabled", "disabled");
});
$("#sub_cat1").each(function() {
        var $thisOption = $(this);        
        $thisOption.attr("disabled", "disabled");
});



function show_sub_cat_fields(subval) {
    $("input[name='sub_cat1']").val(subval);
    var cat_text = $("#cat_id").find("option:selected").text();
    
    if(cat_text=='Real Estate'){        
        if(subval!=0){
            var sub_cat = $("#sub_cat1 option[value='"+subval+"']").text();
            if(sub_cat=='Houses - Apartments for Rent' || sub_cat=='Houses - Apartments for Sale'){
            
                $(".default_form").hide();
                $(".vehicle_form").hide();
                $(".real_estate").hide();
                $(".real_estate_houses_form").show();
                //$("#real_estate_location").select2();
                $("#form_type").val("real_estate_houses_form");
                
            }else if(sub_cat=='Rooms for Rent - Shared' || sub_cat=='Housing Swap' || sub_cat=='Land' || sub_cat=='Shops for Rent - Sale' || sub_cat=='Office - Commercial Space'){
                $(".default_form").hide();
                $(".vehicle_form").hide();
                $(".real_estate").hide();
                $(".real_estate_shared_form").show();
                //$("#shared_location").select2();
                $("#form_type").val("real_estate_shared_form");
            }
                
        }else{
            $(".default_form").hide();
            $(".vehicle_form").hide();
            $(".real_estate").hide();
        }
    }else if(cat_text=='Vehicles'){
        if(subval!=0){
            var sub_cat = $("#sub_cat1 option[value='"+subval+"']").text();
            if(sub_cat=='cars'){
                $(".default_form").hide();
                $(".real_estate").hide();
                $(".vehicle_form").show();
                $("#form_type").val("vehicle_form");
                // initMultiUploader(config);
                $("#vehicle_pro_color").colorpicker();
            }else{
                $(".real_estate").hide();
                $(".vehicle_form").hide();
                $(".default_form").show();
                $("#form_type").val("default_form");

            }
        }
    }else{
        $(".real_estate").hide();
        $(".vehicle_form").hide();
        $(".default_form").show();
        $("#form_type").val("default_form");
    }

   
}
function show_sub_cat(val) {
    /*var cat_text = $("#cat_id option[value='"+val+"']").text();
    
    if(cat_text=='Vehicles'){
        $(".default_fields").hide();
        $(".real_estate").hide();
        $(".vehicle_fields").show();
    }else{
        $(".real_estate").hide();
        $(".vehicle_fields").hide();
        $(".default_fields").show();
    }*/
    $("input[name='cat_id']").val(val);
    $(".real_estate").hide();
    $(".vehicle_form").hide();    
    $(".default_form").show();
    $("#form_type").val("default_form");
    var url = "<?php echo base_url() ?>user/show_sub_cat";
    $.post(url, {value: val}, function(data)
    {
                    //alert(data);
        $("#sub_cat_list").html(data);
        $("#sub_cat1").select2();


    });
}
</script>
        
<script>
//$("#location").select2();

var val = $('#location').val();
show_emirates(val);
function show_emirates(val) {
    var url = "<?php echo base_url() ?>user/show_emirates";
    $.post(url, {value: val}, function(data)
    {
//                            alert(data);
        $("#sub_state_list option").remove();
        $("#sub_state_list").append(data);
        //$("#sub_state_list").select2();

    });
}

/*var val1 = $('#mybrand').val();
show_model(val1);*/
function show_model(val1) 
{
	var url = "<?php echo base_url() ?>user/show_model";
	$.post(url, {value: val1}, function(data)
	{
	    //alert(data);
		$("#pro_model option").remove();
		$("#pro_model").append(data);
	});
}


//<a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm(\"Are you really want to delete ?\")">Delete</a>
function loadimage11(input,a) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#blah1'+a)
				.attr('src', e.target.result)
				.width(150)
				.height(150);
				var imgcon	=	$("#blah1"+a)[0];				
				var img = imgcon;				
				console.log(img);
				var pic_real_width, pic_real_height;
				$("<img/>") 
					.attr("src", $(img).attr("src"))
					.load(function() {
						pic_real_width = this.width;  						
						pic_real_height = this.height;
						
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							$('#upload_file'+a).val('');
							$(".file-input-name").html("");
							$(imgcon).attr("src", "");
							$(imgcon).hide();
						}
						else
						{
							$(imgcon).attr("src", $(img).attr("src"));
							$(imgcon).show();
						}
							
						//alert("Width"+pic_real_width);
						//alert("Height"+pic_real_height);
					});	
		};
		reader.readAsDataURL(input.files[0]);
	}
}

$('#blah').hide();
$('#blah1').hide();
$('#blah2').hide();
$('#blah3').hide();
function loadimage1(input) 
{
	
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {		
		$('#blah').show();
			$('#form1 #blah')
				.attr('src', e.target.result)
				.width(wid)
				.height(hei);
					var img = $("#blah")[0];
					console.log(img);
					var pic_real_width, pic_real_height;
					$("<img/>") 
					   .attr("src", $(img).attr("src"))
					   .load(function() {
						pic_real_width = this.width;   						
						pic_real_height = this.height; 
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							//kek
							$('#multiUpload').val('');							
							$(".file-input-name").html("");
							$('#form1 #blah').attr("src", "");
							$('#form1 #blah').hide();
						}						
						 // alert("1Width"+pic_real_width);
						 // alert("1Height"+pic_real_height);
				 });
			
		};
		reader.readAsDataURL(input.files[0]);
	}
	
}

function loadimage2(input)
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {		
		$('#blah1').show();
			//form 3 
			$('#form2 #blah1')
				.attr('src', e.target.result)
				.width(wid)
				.height(hei);
					var img = $("#blah1")[0];
					console.log(img);
					var pic_real_width, pic_real_height;
					$("<img/>") 
					   .attr("src", $(img).attr("src"))
					   .load(function() {
						pic_real_width = this.width;   						
						pic_real_height = this.height; 						
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							$('#multiUpload1').val('');
							$(".file-input-name").html("");
							$('#form2 #blah1').attr("src", "");
							$('#form2 #blah1').hide();
						}
						// alert("2Width"+pic_real_width);
						// alert("2Height"+pic_real_height);
				 });
			
		};
		reader.readAsDataURL(input.files[0]);
	}
}
function loadimage3(input)
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {		
		$('#blah2').show();
			//form 3 
			$('#form3 #blah2')
				.attr('src', e.target.result)
				.width(wid)
				.height(hei);
					var img = $("#blah2")[0];
					console.log(img);
					var pic_real_width, pic_real_height;
					$("<img/>") 
					   .attr("src", $(img).attr("src"))
					   .load(function() {
						pic_real_width = this.width;   
						pic_real_height = this.height; 						
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							$('#multiUpload2').val('');
							$(".file-input-name").html("");
							$('#form3 #blah2').attr("src", "");
							$('#form3 #blah2').hide();
						}
						// alert("3Height"+pic_real_height);
						// alert("3Width"+pic_real_width);
				 });
			
		};
		reader.readAsDataURL(input.files[0]);
	}
}
function loadimage4(input)
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {		
		$('#blah3').show();
			//form 3 
			$('#form4 #blah3')
				.attr('src', e.target.result)
				.width(wid)
				.height(hei);
					var img = $("#blah3")[0];
					console.log(img);
					var pic_real_width, pic_real_height;
					$("<img/>") 
					   .attr("src", $(img).attr("src"))
					   .load(function() {
						pic_real_width = this.width;   						
						pic_real_height = this.height; 						
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							$('#multiUpload3').val('');
							$(".file-input-name").html("");
							$('#form4 #blah3').attr("src", "");
							$('#form4 #blah3').hide();
						}
						// alert("4Width"+pic_real_width);
						// alert("4Height"+pic_real_height);
				 });			
		};
		reader.readAsDataURL(input.files[0]);
	}
}
function del_file(eleId,a) 
{
        var ele = document.getElementById("delete_file" +a+ eleId);
		ele.parentNode.removeChild(ele);
		if(a==1)
			mycounter1--;
		else if(a==2)	
			mycounter2--;
		else if(a==3)		
			mycounter3--;
		else if(a==4)			
			mycounter4--;
		alert("Image Removed");
}
 


var upload_number1  = 	2;
var mycounter1		=	$('#mycounter1').val();
$('#attachMore1').click(function() 
{
	if(upload_number1<=10 && mycounter1<=9)
	{
		//add more file
		var moreUploadTag = '';      
		
		moreUploadTag += '<div class="text-center"><span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i><input type="file" id="upload_file' + upload_number1 + '" name="multiUpload' + upload_number1 + '"  onchange="javascript:loadimage11(this,'+upload_number1+')"></span><div class="clearfix"></div>';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number1 + ',1)" style="cursor:pointer;" onclick=""><i class="fa fa-trash"></i></a><img id="blah1'+upload_number1+'" src="#" alt="Image" style="display:none;"/></div>';	
		
		$('<dl class="col-md-2 file_upload_btn" id="delete_file1' + upload_number1 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload1');
		upload_number1++;
		mycounter1++;
	}
});

var upload_number2  =   2;
var mycounter2		=	$('#mycounter2').val();
$('#attachMore2').click(function() 
{
	if(upload_number2<=10 && mycounter2<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i><input type="file" id="upload_file' + upload_number2 + '" name="multiUpload' + upload_number2 + '" onchange="javascript:loadimage11(this,'+upload_number2+')"></span><div class="clearfix"></div>';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number2 + ',2)" style="cursor:pointer;" onclick=""><i class="fa fa-trash"></i></a><img id="blah1'+upload_number2+'" src="#" alt="Image" style="display:none;"/></div>';
		$('<dl  class="col-md-2 file_upload_btn" id="delete_file2' + upload_number2 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload2');
		upload_number2++;
		mycounter2++;
	}
});
var upload_number3 = 2;
var mycounter3 = $('#mycounter3').val();
$('#attachMore3').click(function() 
{
	if(upload_number3<=10 && mycounter3<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i><input type="file" id="upload_file' + upload_number3 + '" name="multiUpload' + upload_number3 + '" onchange="javascript:loadimage11(this,'+upload_number3+')"></span><div class="clearfix"></div>';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number3 + ',3)" style="cursor:pointer;" onclick=""><i class="fa fa-trash"></i></a><img id="blah1'+upload_number3+'" src="#" alt="Image" style="display:none;"/></div>';
		$('<dl  class="col-md-2 file_upload_btn" id="delete_file3' + upload_number3 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload3');
		upload_number3++;
		mycounter3++;
	}
});
var upload_number4  = 2;
var mycounter4 		= $('#mycounter4').val();
$('#attachMore4').click(function() 
{
	if(upload_number4<=10 && mycounter4<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i><input type="file" id="upload_file' + upload_number4 + '" name="multiUpload' + upload_number4 + '" onchange="javascript:loadimage11(this,'+upload_number4+')"></span><div class="clearfix"></div>';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number4 + ',4)" style="cursor:pointer;" onclick=""><i class="fa fa-trash"></i></a><img id="blah1'+upload_number4+'" src="#" alt="Image" style="display:none;"/></div>';
		$('<dl class="col-md-2 file_upload_btn" id="delete_file4' + upload_number4 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload4');		
		upload_number4++;
		mycounter4++;
	}
});


/*function readURL(input) 
	{
		
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah1').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah2').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah3').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		
    }
    
    $("#multiUpload").change(function(){
        readURL(this);
    });
	$("#multiUpload1").change(function(){
        readURL(this);
    });
	$("#multiUpload2").change(function(){
        readURL(this);
    });
	$("#multiUpload3").change(function(){
        readURL(this);
    });
	*/
</script>
    </body>
</html>
