<form id="fileupload" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
					<h4><i class="fa fa-image"></i>Upload Media</h4>
                    <hr />		
					<span id="error_img" style="color:red"></span>		
					<div class='form-group'>                        						
					
							<?php if (!empty($product[0]['product_image'])): ?>
							<div class='form-group img-div005' style="display: inline-block;vertical-align: top;">
								
								
									<div class='gallery'>                                                   
										<ul class='list-unstyled list-inline'>
										<li>                                                  
											<div class='picture'>         
											  <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $product[0]['product_image']; ?>'>
												<img alt="product Image" src="<?php echo base_url() . product . "medium/" . $product[0]['product_image']; ?>" width="150px" height="150px"/>
											  </a>
											  <div class='tags'>
												<div class='label label-important'>
													<input type="radio" name="cov_img" id="cov_img" title="Set Image as Cover Image" onclick="javascript:selet_cover_img('<?php echo $product[0]['product_image']; ?>');"  checked>
													<a  class="delete_btn1" style="cursor:pointer;" onclick="javascript:deletemainimg('<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash" ></i></a>
												</div>
												</div>  
											</div>                          
										  </li >
										</ul>                       
									</div>                                                              
								
							
						<?php endif; ?>												
						</div>                                              
					
					<div class="form-group img-div006" >                                                
						
						  <div class='gallery'>                                                 
							<ul class='list-unstyled list-inline'>
							<?php  foreach($images as $i):  ?>  
							  <li>                                                  
								<div class='picture'>
								                                
									<a data-lightbox='flatty' href="<?php echo base_url() . product . "original/" . $i['product_image']; ?>">
									<img alt="product Image" src="<?php echo base_url() . product . "medium/" . $i['product_image']; ?>" width="150px" height="150px">
								  </a>
								  <div class='tags'>
									<div class='label label-important'><a style="cursor:pointer;" class="delete_btn2" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>','<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
								  </div>
								</div>                          
							  </li>      
								<?php   endforeach; ?>                        
							</ul>                       
						  </div>
					</div>
					
					<div class="clearfix"></div>

					<div class='form-group'>  
					<div class="fileupload-buttonbar row">
						<div class="col-md-2 col-sm-3">Upload Images</div>     
						<div class="col-md-6 col-sm-8">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<div class="upload-div ">
								<span class="btn btn-success fileinput-button">
									<i class="glyphicon glyphicon-plus"></i>
									<span>Add files...</span>
									<input type="file" name="files[]" multiple >
								</span> [Maximum 10 Images are allowed]
							</div>							
							<div class="upload-div" style="display:none;" id="update_div">
								<button type="button" class="btn btn-danger delete">
									<i class="glyphicon glyphicon-trash"></i>
									<span>Delete</span>
								</button>
							</div>
							<div class="toggel-div01" id="chk_del" style="display:none;">
								<input type="checkbox" class="toggle">
							</div>	
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
					</div>
					<!-- The table listing the files available for upload/download -->
					
					<div class="col-md-8">
					<table role="presentation" class="table table-striped"><tbody class="files" id="table_image"></tbody></table>					
					</div>
					<div class="clearfix"></div>
				</form>
				<form  class='form form-horizontal validate-form'>
					<div class='form-group'>     
						<div class="col-md-2 col-sm-3">Video</div>                      
						<div class="col-md-6 col-sm-8">
							<input type="radio" name="video_selection" id="youtube_form" onclick="javascript:show_hide(1);"/>&nbsp;&nbsp;Youtube Link &nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio"  name="video_selection" id="video_form" onclick="javascript:show_hide(2);"/>&nbsp;&nbsp;Upload Video
						</div>					
					</div>
					<div class="row form-group" style="margin-top:20px; display:none;" id="youtube_div">
						<div class="col-md-2 col-sm-3">Youtube Link</div>
						<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="my_youtube_link" name="my_youtube_link"/></div>
					</div>
				</form>
				<form id="fileupload1" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
						<span id="error_span"></span>						
						<div class="row form-group" style="margin-top:20px; display:none;" >
							<div class="col-md-2 col-sm-3">Upload Video</div>
							<div class="col-md-6 col-sm-8"><input type="file" class="form-control" id="video" name="video" /></div>							
						</div>
						<div  id="video_div" style="display:none;">
						<div class="fileupload-buttonbar row">
							<div class="col-sm-offset-2 col-lg-8 ">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<div class="upload-div ">
								<span class="btn btn-success fileinput-button">
									<i class="glyphicon glyphicon-plus"></i>
									<span>Upload Video</span>
									<input type="file" name="files">
								</span>
							</div>							
							<div class="upload-div" style="display:none;" id="update_div">
								<button type="button" class="btn btn-danger delete">
									<i class="glyphicon glyphicon-trash"></i>
									<span>Delete</span>
								</button>
							</div>
							<div class="toggel-div01" id="chk_del" style="display:none;">
								<input type="checkbox" class="toggle">
							</div>	
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
					<!-- The table listing the files available for upload/download -->
					<div class="col-md-8">
					<table role="presentation" class="table table-striped"><tbody class="files" id="table_image1"></tbody></table>
					
					</div>
					</div>					
				</form>
				<form class="col-sm-offset-2 data-div" method="post">
					<input type="hidden" name="app_id" value="" />
					<div class="form-group">
						<div class="col-md-6 col-sm-8">
							<input type="hidden" name="images_arr" class="form-control" />
						</div>	
					</div>	
					<div class="form-group">
						<div class="col-md-6 col-sm-8">
							<input type="hidden" name="page" value="add" class="form-control" />
						</div>	
					 </div>		
				<!--<button class="btn btn-primary" type="submit" id="btnContinue" name="btnContinue" disabled="disabled">Continue</button> -->
				</form>
		  
			<script id="template-upload" type="text/x-tmpl">
				{% for (var i=0, file; file=o.files[i]; i++) { %} 
				<tr class="template-upload fade"> 
				<td>
				<span class="preview">
				<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
				<button class="btn btn-warning cancel" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
				<i class="glyphicon glyphicon-ban-circle"></i>
				</button>
				</td>
				<td style="display:none;">
				<p class="name">{%=file.name%}</p>
				<strong class="error text-danger" style="color:red;"></strong>
				<p class="size">Processing...</p>
				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
				</span>
				</td>
				<td style="display:none;"></td>
				<td style="display:none;">
				{% if (!i && !o.options.autoUpload) { %}
				<!--<button class="btn btn-primary start" disabled>
				<i class="glyphicon glyphicon-upload"></i>
				<span>Start</span>
				</button> -->
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
			
			<script id="template-download" type="text/x-tmpl">	
				

            {% for (var i=0, file; file=o.files[i]; i++) {  
				var url= '<?php echo base_url() . product . "medium/" ; ?>';
			%}
            <tr class="template-download fade" id="{%=btoa(file.name)%}">
            <td>
            <span class="preview"> 
            {% if (file.thumbnailUrl) { %} 
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" ></a><input type="radio" name="cov_img" id="cov_img" title="Set Image as Cover Image" onclick="javascript:selet_cover_img('{%=file.name%}');"  >
            {% } else { %} 
			<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo site_url();  ?>assets/upload/dummyy-img.png"></a>
			{% } %}		
			{% if (file.deleteUrl) { %} 
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="glyphicon glyphicon-trash"></i>
            <span style="display:none">Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %} 
            <button class="btn btn-warning delete">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span style="display:none;">Cancel</span>
            </button>
			<!--<button class="btn btn-warning delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span style="display:none">Cancel</span>
            </button> -->
            {% } %}					
            </span>   
            </td>  
            <td style="display:none">
            <p class="name">   
            {% if (file.url) {  %}      
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            {% } else { %} 
            <span>{%=file.name%}</span>
            {% } %} 
            </p>
            {% if (file.error) { %}
            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
            </td>
            <td style="display:none">
            <span class="size" >{%=o.formatFileSize(file.size)%}</span>
            </td> 
            
            </tr>
            {% } %}
        </script>
                                </div>
            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div> 
        <?php //$this->load->view('admin/include/footer-script'); ?>
<script type="text/javascript">
                
var base_url = "<?php echo base_url(); ?>admin/";

</script>
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/javascripts/multiupload.js"></script>-->
	
<script type="text/javascript">
function isNumber1(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		
		if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=45) {
			return false;
		}
		return true;
	}
	
$("#vehicle_pro_year").datepicker({
    format: "yyyy",
    startView: 1,
    minViewMode: 2
});


	function selet_cover_img(a)
	{		
		$("#cov_img_form1").val("");
		$("#cov_img_form2").val("");
		$("#cov_img_form3").val("");
		$("#cov_img_form4").val("");
		
		$("#cov_img_form1").val(a);
		$("#cov_img_form2").val(a);
		$("#cov_img_form3").val(a);
		$("#cov_img_form4").val(a);
		return false;
	}
	function del_video()
	{
		var img_arr='';
			
		if($("#video_form1").val()!='')
			img_arr	=	$("#video_form1").val();
		else if($("#video_form2").val()!='')
			img_arr	=	$("#video_form2").val();
		else if($("#video_form3").val()!='')
			img_arr	=	$("#video_form3").val();
		else if($("#video_form4").val()!='')
			img_arr	=	$("#video_form4").val();
		if(img_arr!='') {
			var url = "<?php echo base_url() ?>user/remove_image_selected";
			$.post(url, {value: img_arr}, function(response) { 
				$("#video_form1").val("");
				$("#video_form2").val("");
				$("#video_form3").val("");
				$("#video_form4").val("");
			});		
		}
	}
	function show_hide(a)
	{		
		if(a==1) {
			//alert("1");						
			del_video();			
			$("#youtube_div").show();
			$("#video_div").hide();
			$("#error_span").hide();
			$("#table_image1").html("");
		}
		else {
			del_video();
			//alert("2");
			$("#table_image1").html("");			
			$("#youtube_div").hide();
			$("#video_div").show();
			$("#my_youtube_link").val("");
		}	
	}
	$("#form1_images_arr").val("");
	$("#form2_images_arr").val("");
	$("#form3_images_arr").val("");
	$("#form4_images_arr").val("");
	
	$("#video_form1").val("");
	$("#video_form2").val("");
	$("#video_form3").val("");
	$("#video_form4").val("");
	
	
	/*jslint unparam: true, regexp: true */
	 total_image = 0, current_image = 0;
    /*global window, $ */
    $(function() {     
	'use strict'; 
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo base_url() . 'admin/uploads/index/'; ?>',
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function() {
            var $this = $(this),
                    data = $this.data();
            $this
                    .off('click')
                    .text('Abort')
                    .on('click', function() {
                $this.remove();
                data.abort();
            });
            data.submit().always(function() {
                $this.remove();
            });
        });
		
		
        var img_arr = []; 
        $('#fileupload').fileupload({
            dropZone: $('#dropzone'),
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(jpe?g|jpg|png|gif)$/i,
            maxFileSize: 100000000, // 5 MB						
            maxNumberOfFiles: 10,								
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
			messages: {
                maxNumberOfFiles: 'Sorry, You can upload 10 Images,Please remove unneccessary files',                
            },
            previewCrop: true,
            success: function(response) {						
				$("#error_img").html("");				
				console.log(response.files[0].name);						  
				var table_content	=	$(".table .table-striped").html();
				if(table_content!='') {
					$("#update_div").show();
					$("#chk_del").show();
				}
				
                img_arr.push(window.btoa(response.files[0].name));
				//console.log(img_arr);
				$("#form1_images_arr").val(img_arr);
				$("#form2_images_arr").val(img_arr);
				$("#form3_images_arr").val(img_arr);
				$("#form4_images_arr").val(img_arr);
                //$("input[name='images_arr']").val(img_arr);              
            },
            error: function() {
                console.log("Error");
            }
        }).on('fileuploadadd', function(e, data) {	
			$("#error_img").html("");				
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                //node.appendTo(data.context);
            }); 			

        }).on('fileuploadprocessalways', function(e, data) {
			$("#error_img").html("");				
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
				<!--.prepend('<br>')-->
                        .prepend(file.preview);
            }
            if (file.error) {

                node
                        .append('<br>')
                        //.append($('<span class="text-danger"/>').text(file.error));
                        .append($('<span class="text-danger"/>').text(''));
				$("#error_img").html(file.error);		
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
			$("#error_img").html("");				
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
			$("#error_img").html("");				
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
					$("#error_img").html(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
			$("#error_img").html("");				
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
				$("#error_img").html('File upload failed.');					
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {						
			$("#error_img").html("");
				
            var index = img_arr.indexOf(data.context[0].id);
            if (index > -1) {
				var url = "<?php echo base_url() ?>admin/classifieds/remove_image_uploaded";
				$.post(url, {value: img_arr}, function(response)
				{ });				
				
                img_arr.splice(index, 1);
				$("#form1_images_arr").val(img_arr);
				$("#form2_images_arr").val(img_arr);
				$("#form3_images_arr").val(img_arr);
				$("#form4_images_arr").val(img_arr);  							
            }
				data.context.remove();				
				var table_content	=	$("#table_image").html();							
				if(table_content=='') {
					$("#update_div").hide();
					$("#chk_del").hide();
				}
				return false;
        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }); 
	
	
	//video upload
	$(function() {     
	'use strict'; 
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo base_url() . 'admin/uploads/index/'; ?>',
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function() {
            var $this = $(this),
                    data = $this.data();
            $this
                    .off('click')
                    .text('Abort')
                    .on('click', function() {
                $this.remove();
                data.abort();
            });
            data.submit().always(function() {
                $this.remove();
            });
        });
		
		
        var img_arr = []; 
        $('#fileupload1').fileupload({
            dropZone: $('#dropzone'),
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(mp4|flv|avi)$/i,
            maxFileSize: 100000000, // 5 MB						
            maxNumberOfFiles: 1,								
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
			messages: {
                maxNumberOfFiles: 'Sorry, You can upload only 1 video, Please remove unneccessary file',
			},
            previewCrop: true,
            success: function(response) {							
				console.log(response.files[0].name);
				$("#error_span").html("");				
				var table_content	=	$(".table .table-striped").html();
				if(table_content!='') {
					//$("#update_div").show();
					//$("#chk_del").show();
				}
				//alert("here");
				//$(".error text-danger").html()
                img_arr.push(window.btoa(response.files[0].name));
				//console.log(img_arr);
				$("#video_form1").val(img_arr);
				$("#video_form2").val(img_arr);
				$("#video_form3").val(img_arr);
				$("#video_form4").val(img_arr);
                //$("input[name='images_arr']").val(img_arr);              
            },
            error: function() {
				//alert("here");
                console.log("Error");
            }
        }).on('fileuploadadd', function(e, data) {	
			$("#error_span").html("");		
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                //node.appendTo(data.context);
            }); 			

        }).on('fileuploadprocessalways', function(e, data) {
			$("#error_span").html("");		
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
				<!--.prepend('<br>')-->
                        .prepend(file.preview);
            }
            if (file.error) {
                node
                        .append('<br>')
                        //.append($('#error_span').text(file.error));
                        .append($('<span class="text-danger"/>').text(''));						
				$("#error_span").html("");
				$("#error_span").html(file.error);	
				$("#video_div").show();						
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
			$("#error_span").html("");		
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    ); 
        }).on('fileuploaddone', function(e, data) {	
			$("#error_span").html("");		
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
					$("#error_span").html(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
			$("#error_span").html("");		
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
				$("#error_span").html('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {	
			$("#error_span").html("");				
            var index = img_arr.indexOf(data.context[0].id);
            if (index > -1) {
				var url = "<?php echo base_url() ?>admin/classifieds/remove_image_uploaded";
				$.post(url, {value: img_arr}, function(response)
				{ });				
				
                img_arr.splice(index, 1);
				$("#video_form1").val(img_arr);
				$("#video_form2").val(img_arr);
				$("#video_form3").val(img_arr);
				$("#video_form4").val(img_arr);  							
            }
				data.context.remove();				
				var table_content	=	$("#table_image1").html();							
				if(table_content=='') {
					//$("#update_div").hide();
					//$("#chk_del").hide();
				}
				return false;
        })		
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }); 

	
	
		

var val     = $('#cat_id').val();
var subval  = $('#sub_cat').val();
show_sub_cat(val);
show_sub_cat_fields(subval);
var val = $('#cat_id').val();
//show_sub_cat(val);
var q=0;
function show_sub_cat(val) {
   
    $("input[name='cat_id']").val(val);
    $(".real_estate").hide();
    $(".vehicle_form").hide();    
    $(".default_form").show();
    $("#form_type").val("default_form");
	
	$("#sub_cat_form1").val("");
	$("#sub_cat_form2").val("");
	$("#sub_cat_form3").val("");
	$("#sub_cat_form4").val("");
	
	if($("#cat_id")!='')
		$("#cat_id_err").hide();				
		
	if($("#show_sub_category")=='')
		$("#subcat_id_err").show();				
	
    var url = "<?php echo base_url() ?>admin/classifieds/show_sub_cat";
    $.post(url, {value: val,sub_cat_id:<?php echo $product[0]['sub_category_id']; ?>,q:q}, function(data)
    {        
        $("#sub_cat_list").html(data);
        //$("#sub_cat").select2();
    });
	 q	=	q+1;
}
/*
$("#cat_id").each(function() {
        var $thisOption = $(this);
        $thisOption.attr("disabled", "disabled");
});
$("#sub_cat").each(function() {
        var $thisOption = $(this);        
        $thisOption.attr("disabled", "disabled");
});
*/

var val = $('#cat_id').val();
//show_sub_cat(val);
//$("#shared_location").select2();
function show_sub_cat_fields(subval) {

    $("input[name='sub_cat']").val(subval);
    var cat_text = $("#cat_id").find("option:selected").text();
    
    if(cat_text=='Real Estate'){        
        if(subval!=0){
            var sub_cat = $("#sub_cat option[value='"+subval+"']").text();
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
            var sub_cat = $("#sub_cat option[value='"+subval+"']").text();
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

</script>
<script>

var url 	= 	"<?php echo base_url() ?>admin/classifieds/show_emirates_postadd";
	//for form 1
	//var val1	=	$("#location_con_form1").val();
	//show_emirates_form1(val1);
	function show_emirates_form1(val) {
		var sel_city	=	$("#city_form1").val();		
		if(val>0) {
			$.post(url, {value: val,sel_city:sel_city}, function(data)
			{	
				$("#city_form1").html("");
				$("#city_form1 option").remove();
				$("#city_form1").append(data);
			});
		}
	}
	
	 //for form 2
	//var val2	=	$("#location_con_form2").val();
	//show_emirates_form2(val2);
	function show_emirates_form2(val) {
		var sel_city	=	$("#city_form2").val();		
		if(val>0) {
			$.post(url, {value: val,sel_city:sel_city}, function(data)
			{	
				$("#city_form2").html("");
				$("#city_form2 option").remove();
				$("#city_form2").append(data);
			});
		}
	}
	
	//for form 3
	//var val3	=	$("#location_con_form3").val();
	//show_emirates_form3(val3);
	function show_emirates_form3(val) {
		var sel_city	=	$("#city_form3").val();		
		if(val>0) {
			$.post(url, {value: val,sel_city:sel_city}, function(data)
			{	
				$("#city_form3").html("");
				$("#city_form3 option").remove();
				$("#city_form3").append(data);
			});
		}
	}
	
	//for form 4
	//var val4	=	$("#location_con_form4").val();
	//show_emirates_form4(val4);
	function show_emirates_form4(val) {
		var sel_city	=	$("#city_form4").val();		
		if(val>0) {	
			$.post(url, {value: val,sel_city:sel_city}, function(data)
			{	
				$("#city_form4").html("");
				$("#city_form4 option").remove();
				$("#city_form4").append(data);
			});
		}
	}

	function show_model(val1) 
	{
		var url = "<?php echo base_url() ?>admin/classifieds/show_model";
		$.post(url, {value: val1}, function(data)
		{                            
			$("#pro_model option").remove();
			$("#pro_model").append(data);

		});
	}
	$(function(){
    $('#form1_submit').click(function(){		
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form1").val(link);
		} 
				
		var cat_id		=	$("#cat_id_form1").val();
		var subcat_id	=	$("#sub_cat_form1").val();
		
        if(cat_id=='')	
		{			
			$("#cat_id_err").show();				
			return false;
		}
		else			
			$("#cat_id_err").hide();
		
	
		if(subcat_id=='')
		{		
			$("#subcat_id_err").show();					
			return false;
		}
			$("#subcat_id_err").hide();		
		
		
    })
	$('#form2_submit').click(function(){
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form2").val(link);
		}
		var cat_id		=	$("#cat_id_form2").val();
		var subcat_id	=	$("#sub_cat_form2").val();
		
        if(cat_id=='')				
		{
			$("#cat_id_err").show();
			return false;			
		}
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
		{
			$("#subcat_id_err").show();			
			return false;
		}
		else
			$("#subcat_id_err").hide();
    })
	$('#form3_submit').click(function(){
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form3").val(link);
		}
		var cat_id		=	$("#cat_id_form3").val();
		var subcat_id	=	$("#sub_cat_form3").val();
		
        if(cat_id=='')			
		{		
			$("#cat_id_err").show();			
			return false;
		}
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
		{
			$("#subcat_id_err").show();			
			return false;
		}
		else
			$("#subcat_id_err").hide();
    })
	$('#form4_submit').click(function(){
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form4").val(link);
		}
		var cat_id		=	$("#cat_id_form4").val();
		var subcat_id	=	$("#sub_cat_form4").val();
		
        if(cat_id=='')			
		{		
			$("#cat_id_err").show();			
			return false;
		}
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
		{
			$("#subcat_id_err").show();			
			return false;
		}
		else
			$("#subcat_id_err").hide();
    })	
})
function deletemainimg(prod_id)
{
    var url = "<?php echo base_url() ?>admin/classifieds/removemainimage";
    var r = confirm("Are you sure you want to delete main image?");
    if (r == true) 
    {
        $.post(url, {prod_id:prod_id}, function(data)
        {
        
            //alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>admin/classifieds/listings_edit/"+prod_id;  
        });
    }     
    return false;
}
function mydelete(val,prod_id)
{
    var url = "<?php echo base_url() ?>admin/classifieds/removeimage";
    var r = confirm("Are you sure you want to delete image?");
    if (r == true) 
    {
        $.post(url, {value: val,prod_id:prod_id}, function(data)
        {          
			//alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>admin/classifieds/listings_edit/"+prod_id;  
        });
    }     
    return false;
}
</script>        
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / theme file [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
    </body>
</html>