<div class="main_body">
    <div id="carousel-example-generic" class="carousel slide entertainer_main" data-ride="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">

            <div class="drag_drop first">
                <a href="#"   data-toggle="modal" data-target="#photo_first_dilog">
                    <p><span>DRAG <br><strong>AND</strong> <br>DROP!</span><br><strong>ClICK HERE TO <br>UPLOAD ONE OF <br>YOUR FEATURE <br>PHOTOS<br></strong></p>
                    <!--<p><span>DRAG <br><strong>AND</strong> <br>DROP </span><br>PICS FROM<br> YOUR<br> UPLOADED<br> PHOTOS</p>-->
                </a>

            </div>
            <div class="drag_drop second">
                <a href="#"   data-toggle="modal" data-target="#photo_second_dilog">
                    <p><span>DRAG <br><strong>AND</strong> <br>DROP!</span><br><strong>ClICK HERE TO <br>UPLOAD ONE OF <br>YOUR FEATURE <br>PHOTOS<br></strong></p>
                </a>
               <!--<p><span>DRAG <br><strong>AND</strong> <br>DROP </span><br>PICS FROM<br> YOUR<br> UPLOADED<br> PHOTOS</p>-->

            </div>
            <div class="item active">
                <img src="/images/upload-slider-1.png" alt="slider1">
            </div>
            <div class="item">
                <img src="/images/upload-slider-1.png" alt="slider1">
            </div>
            <div class="item">
                <img src="/images/upload-slider-1.png" alt="slider1">
            </div>
        </div>
        <!-- Controls -->

    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="jw_player">
                    <img src="/images/upload.jpg" >
                    <div class="drag_drop">
                        <a href="#"   data-toggle="modal" data-target="#video_default_dilog">
                            <div id="myplayer"></div>
                            <p><span>DRAG <br><strong>AND</strong> <br>DROP!</span><strong><br>ClICK HERE TO <br>UPLOAD YOUR <br>DEFAULT <br>VIDEO<br><br></strong></p>
                        </a>
                    </div>
                    <button  type="button" class="record_now" data-toggle="modal" data-target="#record_now" >Rec<br>Now</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="playlist_main">
                    <a href="#"  class="changename" data-toggle="modal" data-target="#namechange">
                        <div class="changename" id="change_name_data">
                            <h1 id="change_text_first"><?php echo $user['User']['firstname'] ?> <?php echo $user['User']['lastname'] ?></h1>
                        </div>  
                    </a>
                    <div class="row">
                        <div class="col-xs-6 upload_video_song">
                            <a href="#" data-toggle="modal" data-target="#video_song_dilog">
                                <div class="video_upload">
                                    <div class="upload_main_img">
                                        <img class="img-responsive" src="/images/upload_vedio_photos_under.gif">
                                    </div>  
                                    <span>VIDEO & MEDIA</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6 upload_video_song">
                            <a href="#" data-toggle="modal" data-target="#myModal">
                                <div class="video_upload">
                                    <div class="upload_main_img">
                                        <img class="img-responsive" src="/images/upload_vedio_photos_under.gif">
                                    </div>
                                    <span>PHOTOS</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 your_bio_main">
                <a href="#" data-toggle="modal" data-target="#your_bio">
                    <div class="your_bio">
                        <div class="upload_main_img">
                            <img class="img-responsive" src="/images/input_under.gif">
                        </div>
                        <span>YOUR BIO</span>                                
                    </div>
                </a>
            </div>
            <div class="col-md-6 tell_media_part">
                <div class="stats_main">
                    <div class="row">
                        <div class="col-xs-6 tell_us_main">
                            <a href="#" data-toggle="modal" data-target="#tell_us">
                                <div class="tell_us">
                                    <div class="upload_main_img">
                                        <img class="img-responsive" src="/images/input_under.gif">
                                    </div>
                                    <span>WHY ME?</span>                                            
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6 link_media_main">
                            <div class="link_media">
                                <ul>
                                    <li class="fb"><a href="/uploads/Facebook">Facebook</a></li>
                                    <li class="youtube"><a href="/uploads/youTube" >Youtube</a></li>
                                    <li class="twit"><a href="/uploads/Twitter">Twitter</a></li>
                                    <li class="sound_cloud"><a href="/uploads/soundCloud">Sound Cloud</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade upload_popup_main" id="record_now" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Record Now</h3>
                <hr>
                <div id ="record_result" >

                </div>
                <div class="clearfix"></div>                   
                <hr>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<div class="modal fade upload_popup_main" id="your_bio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Biography</h3>
                <?php echo $this->Form->input('biography', array('label' => '', 'class' => 'editor', 'type' => 'textarea', 'id' => 'editor')); ?>
                <div>
                    <h5  id='message'><font color="red">Please Fill the Biography</font></h5>
                </div>
                <?php echo $this->Form->input('Save', array('label' => false, 'div' => false, 'class' => 'btn btn-primary', 'id' => 'biography', 'type' => 'button')) ?>
            </div>                        
        </div>
    </div>
</div>        
<div class="modal fade" id="tell_us" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                <h3>Why Me?</h3>
                <?php echo $this->Form->input('short_desc', array('label' => '', 'class' => 'editor', 'type' => 'textarea', 'id' => 'editor1')); ?>
                <div>
                    <h5  id='message'><font color="red">Please Fill the Form</font></h5>
                </div>
                <?php echo $this->Form->input('Save', array('label' => false, 'div' => false, 'class' => 'btn btn-primary', 'id' => 'btnsubmit', 'type' => 'button')) ?>
            </div>                        
        </div>
    </div>
</div>   

<div class="modal fade" id="namechange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Change Your Name</h3>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?php
                        echo $this->Form->input('firstname', array('class' => 'form-control', 'placeholder' => 'FirstName', "autocomplete" => "off", "required", 'default' => $user['User']['firstname'], 'id' => 'fname'));
                        ?>
                        <div class="UserRegEmailError"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <?php
                        echo $this->Form->input('lastname', array('class' => 'form-control', 'placeholder' => 'LastName', "autocomplete" => "off", "required", 'default' => $user['User']['lastname'], 'id' => 'lname'));
                        ?>
                        <div class="UserRegEmailError"></div>
                    </div>
                </div>
                <!--<button type="submit" id="why_me_btn" class="btn btn-primary">Save</button>-->
                <?php echo $this->Form->input('Save', array('label' => false, 'div' => false, 'class' => 'btn btn-primary', 'id' => 'changenamebtn', 'type' => 'button')) ?>

            </div>                        
        </div>
    </div>
</div>      

<div class="modal fade" id="tell_us_success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup" id="tell">


                <h3>Thank you,your information has been saved! </h3>


            </div>                        
        </div>
    </div>
</div>      

<div class="modal fade" id="your_bio_success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup" id="bio">


                <h3>Thank you,your information has been saved! </h3>


            </div>                        
        </div>
    </div>
</div>   


<div class="modal fade" id="uploadimage_success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup" id="bio">


                <h3 id='succ'>This is Now Available on "My Page"</h3>


            </div>                        
        </div>
    </div>
</div>   

<div class="modal fade" id="uploadimage_error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup" id="bio">


                <h3 id='succ'>Please,select large image</h3>


            </div>                        
        </div>
    </div>
</div>   

<div class="modal fade upload_popup_main" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Choose Photos to Upload</h3>

                <?php echo $this->form->create('File', array('id' => 'fileupload', 'enctype' => 'multipart/form-data')); ?>
                <div class="row fileupload-buttonbar">
                    <div class="col-sm-12">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <div id="dropzone" class="fade well">Drop files here</div>
                        <div class="choose_file_main text-left">
                            <?php echo $this->form->input('files', array('type' => "file", 'name' => "files[]", 'multiple', 'id' => 'fileupload')) ?>
                            <!--<button type="button" class="btn">CHOOSE FILES</button>-->
                            <p><strong><b>We do not accept images 300x285 or smaller</b></strong></p>
                        </div>

                        <button type="submit" class="btn start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>UPLOAD FILES</span>
                        </button>
                        <button type="reset" class="btn cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel upload</span>
                        </button>
                        <button type="button" class="btn delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                        <div class="delete_all">
                            <span>Delete All</span>
                            <input type="checkbox" class="toggle">
                        </div>
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <!-- The global progress state -->
                    <div id="upload_error"></div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                <?php echo $this->form->end(); ?>



            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg upload_popup_main video_song_dilog" id="video_song_dilog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Choose Videos + Media</h3>

                <?php echo $this->form->create('File', array('id' => 'videoupload', 'enctype' => 'multipart/form-data')); ?>
                <div class="row fileupload-buttonbar">
                    <div class="col-sm-12">

                        <div id="dropzonevideo" class="fade well">Drop files here</div>
                        <div class="choose_file_main text-left">
                            <?php echo $this->form->input('files', array('type' => "file", 'name' => "files[]", 'multiple', 'id' => 'videoupload')) ?>
                            <!--<button type="button" class="btn">CHOOSE FILES</button>-->

                        </div>

                        <button type="submit" class="btn start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>UPLOAD FILES</span>
                        </button>
                        <button type="reset" class="btn cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel upload</span>
                        </button>
                        <button type="button" class="btn delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                       <div class="delete_all">
                            <span>Delete All</span>
                            <input type="checkbox" class="toggle">
                        </div>
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <!-- The global progress state -->

                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                <?php echo $this->form->end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg upload_popup_main video_song_dilog" id="video_default_dilog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Choose Videos + Media</h3>

                <?php echo $this->form->create('Upload', array('id' => 'videouploaddefault', 'enctype' => 'multipart/form-data')); ?>
                <div class="row fileupload-buttonbar">
                    <div class="col-sm-12">

                        <div id="dropzonedefault" class="fade well">Drop files here</div>
                        <div class="choose_file_main text-left">
                            <?php echo $this->form->input('files', array('type' => "file", 'name' => "files[]", 'multiple', 'id' => 'videouploaddefault')) ?>
                            <!--<button type="button" class="btn">CHOOSE FILES</button>-->

                        </div>

                        <button type="submit" class="btn start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>UPLOAD FILES</span>
                        </button>
                        <button type="reset" class="btn cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel upload</span>
                        </button>
                        <button type="button" class="btn delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                        <div class="delete_all">
                            <span>Delete All</span>
                            <input type="checkbox" class="toggle">
                        </div>
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <!-- The global progress state -->

                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                <?php echo $this->form->end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade upload_popup_main" id="photo_first_dilog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Choose Photos to Upload</h3>

                <?php echo $this->form->create('File', array('id' => 'fileuploadfirst', 'enctype' => 'multipart/form-data')); ?>
                <div class="row fileupload-buttonbar">
                    <div class="col-sm-12">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <div id="dropzonefirst" class="fade well">Drop files here</div>
                        <div class="choose_file_main text-left">
                            <?php echo $this->form->input('files', array('type' => "file", 'name' => "files[]", 'multiple', 'id' => 'fileuploadfirst')) ?>
                            <!--<button type="button" class="btn">CHOOSE FILES</button>-->
                            <p><strong><b>We do not accept images 300x285 or smaller</b></strong></p>
                        </div>

                        <button type="submit" class="btn start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>UPLOAD FILES</span>
                        </button>
                        <button type="reset" class="btn cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel upload</span>
                        </button>
                        <button type="button" class="btn delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                       <div class="delete_all">
                            <span>Delete All</span>
                            <input type="checkbox" class="toggle">
                        </div>
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <div id="error_first"></div>
                    <!-- The global progress state -->

                </div>
                <input id="uploadfirsthidden" type="hidden" value="yes">
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                <?php echo $this->form->end(); ?>



            </div>
        </div>
    </div>
</div>

<div class="modal fade upload_popup_main" id="photo_second_dilog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Choose Photos to Upload</h3>

                <?php echo $this->form->create('File', array('id' => 'fileuploadsecond', 'enctype' => 'multipart/form-data')); ?>
                <div class="row fileupload-buttonbar">
                    <div class="col-sm-12">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <div id="dropzonesecond" class="fade well">Drop files here</div>
                        <div class="choose_file_main text-left">
                            <?php echo $this->form->input('files', array('type' => "file", 'name' => "files[]", 'multiple', 'id' => 'fileuploadsecond')) ?>
                            <!--<button type="button" class="btn">CHOOSE FILES</button>-->
                            <p><strong><b>We do not accept images 300x285 or smaller</b></strong></p>
                        </div>

                        <button type="submit" class="btn start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>UPLOAD FILES</span>
                        </button>
                        <button type="reset" class="btn cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel upload</span>
                        </button>
                        <button type="button" class="btn delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                       <div class="delete_all">
                            <span>Delete All</span>
                            <input type="checkbox" class="toggle">
                        </div>
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <div id="error_second"></div>
                    <!-- The global progress state -->

                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                <?php echo $this->form->end(); ?>


                <!--<button class="btn" type="submit">UPLOAD FILES</button>-->

            </div>
        </div>
    </div>
</div>


<div class="modal fade upload_popup_main" id="upload_image1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Choose Photos to Upload.</h3>
                <form method="post" action="/uploads/uploadbio" id="uploadcover">
                <?php // echo $this->form->create('File',array('controller'=>'upload','action'=>'uploadbio'), array('id' => 'uploadcover', 'enctype' => 'multipart/form-data')); ?>

                <?php echo $this->form->input('files', array('type' => "file", 'name' => "files[]", 'multiple', 'id' => 'uploadcoverart')) ?>
                 <?php echo $this->Form->input('Save', array('label' => false, 'div' => false, 'class' => 'btn btn-primary', 'id' => 'coverart', 'type' => 'button')) ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade upload_popup_main" id="upload_image2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body upload_popup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h3>Choose Photos to Upload.</h3>

                <?php echo $this->form->create('File', array('id' => 'fileupload', 'enctype' => 'multipart/form-data')); ?>

                <?php echo $this->form->input('files', array('type' => "file", 'name' => "files[]", 'multiple', 'id' => 'fileupload')) ?>

            </div>
        </div>
    </div>
</div>
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}

    <tr class="template-upload fade" data={%=file.name.replace(/ /g, '-')%}>

    <td>
    {% if(file.type == "video/mp4" || file.type == "audio/mpeg" || file.type == "video/ogg" || file.type == "audio/mp3"){ var car=['avi','flv','3gp','ogg','wmv','mp4','mov'];%}
    <strong>Preview your digital content</strong>
    <br><br><br>
    {% }  %}
    <span class="preview"></span>
    </td>
    <td class="text-left">
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td class="title "><label>Content Name: <input id="title_chk" name="title[]" required class="form-control" ></label>
    <label>Uploader Name: <input name="artist[]"  id="artist_chk" required class="form-control"></label>
    <p id="name_error"></p>
    </td>
    <td class='default'><input type="hidden" name="video1" value="1" required></td>
    <td class='defaultfirst'><input type="hidden" name="photo1" value="1" required></td>
    <td class='defaultsecond'><input type="hidden" name="photo2" value="1" required></td>
    <td class='defaultcover'><input type="hidden" name="cover" value="1" required></td>
      
    {%  if(file.type.slice(0,5) == "video"){ 
                            %}
    <td class='coverart' id=chk_cover>
    <label>Set Cover Art<br>
    <input type="checkbox" name="cover_art" value="{%=file.name%}" >
    </label>
    </td>
    {% }
    else if(file.name.slice(-3) == "flv"){ %}
    <td class='coverart' id={%=file.type.slice(0,5)%}><label>Set Cover Art<br>
     <input type="checkbox" name="cover_art" value="{%=file.name%}" >
    </label></td>
   {% }
    else{ %}
    <td class='coverart' id={%=file.type.slice(0,5)%}>
    </td>
    {% } %}
    <td>
    <p class="size">Processing...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </td>
    <td width="140px">
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn start" disabled>
    <i class="glyphicon glyphicon-upload"></i> 
    <span>Upload</span>
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn cancel">
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
    <td class="text-left">
    <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
    </p>
    <div id="jw_player"></div>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td width="140px">
    {% 
    if (file.deleteUrl) { %}
    <button  class="delete" id="deletebutton" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <i class="glyphicon glyphicon-remove"></i>                    
    </button>
    <input type="checkbox" name="delete" value="{%=file.name%}" class="toggle" >
    {% } else {

    %}
    <button class="btn cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<script>
    total_image = 0, current_image = 0;
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() { 
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo $this->Html->url('/'); ?>uploads/upload',
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
        $('#fileupload').fileupload({
            dropZone: $('#dropzone'),
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(jpe?g|jpg|png|gif)$/i,
            maxFileSize: 100000000, // 5 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function(e, data) {

            console.log(data.files[0]);

            var reader = new FileReader();
            var image = new Image();

            reader.readAsDataURL(data.files[0]);
            reader.onload = function(_file) {
                image.src = _file.target.result;              // url.createObjectURL(file);
                image.onload = function() {
                    var w = parseInt(this.width),
                            h = parseInt(this.height);
                    total_image++;
                    if (h < 285 || w < 300)
                    {
                        var img_name = data.files[0].name.replace(/ /g, '-');

                        $("#myModal .modal-dialog .modal-content #fileupload .files .template-upload[data='" + img_name + "']").remove()
                        $('#upload_error').html('Sorry! We do not accept images 300x285 or smaller!').css('color', 'red');

                    }


                };

            }

            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });

        }).on('fileuploadprocessalways', function(e, data) {
            $("#myModal .modal-dialog .modal-content #fileupload .template-upload .title").remove();
            $("#myModal .modal-dialog .modal-content #fileupload .template-upload .message").remove();
            $("#myModal .modal-dialog .modal-content #fileupload .template-upload .default").remove();
            $("#myModal .modal-dialog .modal-content #fileupload .template-upload .defaultfirst").remove();
            $("#myModal .modal-dialog .modal-content #fileupload .template-upload .defaultsecond").remove();
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {

                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {


            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
            current_image++;
            if (total_image == current_image)
            {

                $('#uploadimage_success').modal("show");
                var delay = 2000; //Your delay in milliseconds
                setTimeout(function() {
                    $('#uploadimage_success').modal('hide');
                }, delay);


            }
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {
            data.context.remove();
            //            alert("hello");
            //        console.log(data);
        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>

<script>

    var total_image = 0, current_image = 0;
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo $this->Html->url('/'); ?>uploads/upload',
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
        $('#fileuploadfirst').fileupload({
            dropZone: $('#dropzonefirst'),
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(jpe?g|jpg|png|gif)$/i,
            maxFileSize: 100000000, // 5 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            maxNumberOfFiles: 1,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function(e, data) {


            readImage(data.files[0]);

            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });



            total_image++;

        }).on('fileuploadprocessalways', function(e, data) {

            $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .title").remove();
            $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .coverart").remove();
            $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .default").remove();
            $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .message").remove();
            $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .defaultsecond").remove();
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {

                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {


            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
            current_image++;
            if (total_image == current_image)
            {

                $('#uploadimage_success').modal("show");
                var delay = 2000; //Your delay in milliseconds
                setTimeout(function() {
                    $('#uploadimage_success').modal('hide');
                }, delay);


            }
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {
            data.context.remove();
            //            alert("hello");
            //        console.log(data);
        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');



    });


</script>

<script>
    var total_image = 0, current_image = 0;
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo $this->Html->url('/'); ?>uploads/upload',
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
        $('#fileuploadsecond').fileupload({
            dropZone: $('#dropzonesecond'),
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(jpe?g|jpg|png|gif)$/i,
            maxFileSize: 100000000, // 5 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            maxNumberOfFiles: 1,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function(e, data) {
            total_image++;
            readImage(data.files[0]);
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function(e, data) {
            $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .title").remove();
            $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .default").remove();
            $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .coverart").remove();
            $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .message").remove();
            $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .defaultfirst").remove();
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {

                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {


            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
            current_image++;
            if (total_image == current_image)
            {

                $('#uploadimage_success').modal("show");
                var delay = 2000; //Your delay in milliseconds
                setTimeout(function() {
                    $('#uploadimage_success').modal('hide');
                }, delay);


            }
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {
            data.context.remove();
            //            alert("hello");
            //        console.log(data);
        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
<script>
    $(document).bind('drop dragover', function(e) {
        var dropZone = $('#dropzone'),
                timeout = window.dropZoneTimeout;
        if (!timeout) {
            dropZone.addClass('in');
        } else {
            clearTimeout(timeout);
        }
        var found = false,
                node = e.target;
        do {
            if (node === dropZone[0]) {
                found = true;
                break;
            }
            node = node.parentNode;
        } while (node != null);
        if (found) {
            dropZone.addClass('hover');
        } else {
            dropZone.removeClass('hover');
        }
        window.dropZoneTimeout = setTimeout(function() {
            window.dropZoneTimeout = null;
            dropZone.removeClass('in hover');
        }, 100);
    });
</script>



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
    <span>Upload</span>
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
    {% 
    if (file.deleteUrl) { %}
    <button  class="btn btn-danger delete" id="deletebutton" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <i class="glyphicon glyphicon-trash"></i>
    <span>Delete</span>
    </button>
    <input type="checkbox" name="delete" value="{%=file.name%}" class="toggle" >
    {% } else {

    %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<script>
    var total_media = 0, current_media = 0;
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() { 
        'use strict'; 
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo $this->Html->url('/'); ?>uploads/upload',
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
        $('#videoupload').fileupload({
            dropZone: $('#dropzonevideo'),
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(mp4|mov|avi|mp3|wav|flv|ogv|3gp|wmv|mpg)$/i,
            maxFileSize: 100000000, // 5 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        })
                .on('fileuploaddestroy', function(e, data) {
            data.context.remove();
            //        console.log(data)
        })
                .on('fileuploadadd', function(e, data) {

//         readImage(data.files[0]);

//    $("#video_song_dilog .modal-dialog .modal-content #videoupload .template-upload #audio").remove();
//          $("#audio").remove();

            total_media++;
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function(e, data) {
            $("#video_song_dilog .modal-dialog .modal-content #videoupload .template-upload .default").remove();
            $("#video_song_dilog .modal-dialog .modal-content #videoupload .template-upload .defaultfirst").remove();
            $("#video_song_dilog .modal-dialog .modal-content #videoupload .template-upload .defaultsecond").remove();

            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {

                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
            current_media++;
            if (current_media == total_media)
            {

                $('#uploadimage_success').modal("show");
                var delay = 2000; //Your delay in milliseconds
                setTimeout(function() {
                    $('#uploadimage_success').modal('hide');
                }, delay);
            }
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).bind('fileuploadsubmit', function(e, data) {

            var inputs = data.context.find(':input');
            if (inputs.filter(function() {
                return !this.value && $(this).prop('required');
            }).first().focus().length) {
                data.context.find('button').prop('disabled', false);
                return false;
            }
            data.formData = inputs.serializeArray();
        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>

<script>
    var total_media = 0, current_media = 0;
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo $this->Html->url('/'); ?>uploads/upload',
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
        $('#videouploaddefault').fileupload({
            dropZone: $('#dropzonedefault'),
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(mp4|mov|mp3|avi|wav|flv|ogv|3gp|wmv|mpg)$/i,
            maxFileSize: 100000000, // 5 MB
            maxNumberOfFiles: 1,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        })
                .on('fileuploaddestroy', function(e, data) {
            data.context.remove();
            //        console.log(data)
        })
                .on('fileuploadadd', function(e, data) {
            total_media++;
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {

                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
            current_media++;
            if (current_media == total_media)
            {



            }
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).bind('fileuploadsubmit', function(e, data) {

            var inputs = data.context.find(':input');
            if (inputs.filter(function() {
                return !this.value && $(this).prop('required');
            }).first().focus().length) {
                data.context.find('button').prop('disabled', false);
                return false;
            }
            data.formData = inputs.serializeArray();
        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
<!--<script>
    $(document).bind('drop dragover', function (e) {
        var dropZone = $('#dropzonevideo'),
    timeout = window.dropZoneTimeout;
    if (!timeout) {
    dropZone.addClass('in');
   
    } else {
    clearTimeout(timeout);
    }
    var found = false,
    node = e.target;
    do {
    if (node === dropZone[0]) {
    found = true;
    
    break;
    }
    node = node.parentNode;
    } while (node !== null);
    if (found) {
     
    dropZone.addClass('hover');
    } else {
    dropZone.removeClass('hover');
    }
    window.dropZoneTimeout = setTimeout(function () {
    window.dropZoneTimeout = null;
    dropZone.removeClass('in hover');
    }, 100);
   
    });
</script>-->
<script type="text/javascript">
    CKEDITOR.config.toolbar = [
        ['Styles', 'Format', 'Font', 'FontSize'],
        '/',
        ['Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Undo', 'Redo', '-', 'Cut', 'Copy', 'Paste', 'Find', 'Replace', '-', 'Outdent', 'Indent', '-', ],
        '/'

    ];
    CKEDITOR.replace('editor');
    CKEDITOR.replace('editor1');
</script>

<script>


    $('#biography').click(function() {
        var name = CKEDITOR.instances['editor'].getData();

        if (name == '')
        {
            $('#your_bio #message').show();
        }
        var dataString = name;
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '/uploads/uploadbio',
            data: "bio=" + dataString,
            success: function(data) {

                $('#your_bio').modal('hide')
                $('#your_bio_success').modal('show')
                var delay = 2000; //Your delay in milliseconds
                setTimeout(function() {
                    $('#your_bio_success').modal('hide');
                }, delay);

            },
            error: function() {

            }
        });


    });

    $('#btnsubmit').click(function() {
        var name = CKEDITOR.instances['editor1'].getData();
        name = name.replace(/&/g, '-and-');
        alert(name);

        if (name == '')
        {
            $('#tell_us #message').show();
        }
        var dataString = name;
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '/uploads/uploadwhyme',
            data: "whyme=" + dataString,
            success: function(data) {


                $('#tell_us').modal('hide')
                $('#tell_us_success').modal('show')
                var delay = 2000; //Your delay in milliseconds
                setTimeout(function() {
                    $('#tell_us_success').modal('hide');
                }, delay);
                setTimeout(function() {
                    $('#tell_us_success').modal('hide');
                }, delay);


            },
            error: function() {

            }
        });


    });


    $('#changenamebtn').click(function() {
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '/uploads/changename',
            data: {fname: fname,
                lname: lname},
            success: function(data) {

                $("#change_text_first").html(data.firstname + ' ' + data.lastname);
                $('#namechange').modal('hide')


            },
            error: function() {
                $('#changename').modal('hide');
                $('#changename_error').modal('show')
                var delay = 2000; //Your delay in milliseconds
                setTimeout(function() {
                    $('#changename_error').modal('hide');
                }, delay);
                setTimeout(function() {
                    $('#changename_error').modal('hide');
                }, delay);
            }
        });


    });
</script>
<script>
    $(document).ready(function() {

        $('#tell_us #message').hide();
        $('#your_bio #message').hide();
    });
    $("#myModal .modal-dialog .modal-content #fileupload").change(function() {
        $("#myModal .modal-dialog .modal-content #fileupload .template-upload .title").remove();
        $("#myModal .modal-dialog .modal-content #fileupload .template-upload .coverart").remove();
        $("#myModal .modal-dialog .modal-content #fileupload .template-upload .default").remove();
        $("#myModal .modal-dialog .modal-content #fileupload .template-upload .message").remove();
        $("#myModal .modal-dialog .modal-content #fileupload .template-upload .photo1").remove();
        $("#myModal .modal-dialog .modal-content #fileupload .template-upload .photo2").remove();
        $("#myModal .modal-dialog .modal-content #fileupload .template-upload .defaultcover").remove();
    });
    $('#record_now').on('hidden.bs.modal', function() {
        timer.stop();

    });


    $("#photo_first_dilog .modal-dialog .modal-content #fileupload").change(function() {
        $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .title").remove();
        $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .coverart").remove();
        $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .default").remove();
        $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .message").remove();
        $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .photo2").remove();
         $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .photo2").remove();
          $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload .defaultcover").remove();
    });

    $("#photo_second_dilog .modal-dialog .modal-content #fileupload").change(function() {
        $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .title").remove();
        $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .coverart").remove();
        $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .default").remove();
        $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .message").remove();
        $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload .defaultcover").remove();
    });



    $("#video_song_dilog .modal-dialog .modal-content #videoupload").change(function() {

        $("#video_song_dilog .modal-dialog .modal-content #videoupload .template-upload .default").remove();
    });

    $("#video_default_dilog .modal-dialog .modal-content #videouploaddefault").change(function() {
        $("#video_default_dilog .modal-dialog .modal-content #videouploaddefault .template-upload .photo1").remove();
        $("#video_default_dilog .modal-dialog .modal-content #videouploaddefault .template-upload .photo2").remove();
    });

    $('#myModal').on('hidden.bs.modal', function() {
        $('#myModal .modal-content #fileupload table tr.template-upload ').empty();
        $('#myModal .modal-content #fileupload table tr.template-download ').empty();
        $('#upload_error').empty();
    });

    $('#photo_first_dilog').on('hidden.bs.modal', function() {
        $('#photo_first_dilog .modal-content #fileuploadfirst table tr.template-upload ').remove();
        $('#photo_first_dilog .modal-content #fileuploadfirst table tr.template-download ').remove();

        $('#error_first').empty();

    });

    $('#photo_second_dilog').on('hidden.bs.modal', function() {
        $('#photo_second_dilog .modal-content #fileuploadsecond table tr.template-upload ').remove();
        $('#photo_second_dilog .modal-content #fileuploadsecond table tr.template-download ').remove();

        $('#error_second').empty();

    });

    $('#video_song_dilog').on('hidden.bs.modal', function() {
        $('#video_song_dilog .modal-content #videoupload table tr.template-upload ').remove();
        $('#video_song_dilog .modal-content #videoupload table tr.template-download ').remove();

    });

    $('#video_default_dilog').on('hidden.bs.modal', function() {
        $('#video_default_dilog .modal-content #videouploaddefault table tr.template-upload ').remove();
        $('#video_default_dilog .modal-content #videouploaddefault table tr.template-download ').remove();

    });
    $('#your_bio').on('hidden.bs.modal', function() {
        $('#your_bio #message ').hide();
    });

    $('#tell_us').on('hidden.bs.modal', function() {
        $('#tell_us #message').hide();
    });

    /*  Audio video Recording functionality  */




    /* Start  Detect  compitability -------------------------------------------*/
    var device = '';
    var record_support = false;


    function hasGetUserMedia() {
        return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia || navigator.msGetUserMedia);
    }
    /* Detect device desktop or mobile  */
    if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)
            || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i)
            || navigator.userAgent.match(/Windows Phone/i))
    {
        device = 'mobile';
    } else
    {
        device = 'desktop';
    }
    /* Detect browser support recording feature or not */
    if (hasGetUserMedia())
    {
        record_support = true;
    }
    /* End  Detect  compitability -------------------------------------------------*/


    $(".record_now").click(function() {

        if ((device == 'desktop' && record_support == true) || device == 'mobile')
        {

            $('#record_result').html('<a id="audio" class="pull-left" href="#" onclick="return record_option(&#39;audio&#39;);">Record Audio</a><a id="videos" class="pull-right" href="#" onclick="return record_option(&#39;video&#39;);">Record Video</a>');
        } else
        {
            $('#record_result').html('<h4>Your browser does not support this feature. Kindly use Chrome / Firefox.</h4>');
        }


        $('#record_now').modal('toggle');
        return false;
    });


    /* Called when user click on 'Record Now btn'*/
    function record_option(value)
    {
        //$('#record_result').html('<img  src="/images/black-loder.gif" >');
        if (device == 'desktop')
        {
            if (hasGetUserMedia())
            {

                /* Execute when browser support recording feature.*/
                if (value == "audio")
                {

                    $('#record_result').load('/uploads/record_audio', function() {
                        $('#loading_server').css('display', 'none');
                    });
                    $('#audio').css('display', 'none');
                    $('#videos').css('display', 'block');

                } else {

                    $('#record_result').load('/uploads/record_video', function() {
                        $('#loading_server').css('display', 'none');
                    });
                    $('#videos').css('display', 'none');
                    $('#audio').css('display', 'block');

                }
            } else {

                $('#record_result').html('<h4>Your browser doesn`t support Recording Feature. Kindly use Chrome/Firefox browser. </h4>');

                $('#loading_server').css('display', 'none');

            }

        } else if (device == 'mobile')
        {
            $('#loading_server').css('display', 'block');
            $('#record_result').load('/uploads/mobile_record/' + value, function() {
                $('#loading_server').css('display', 'none');
            });

        } else
        {
            alert('Device Not detected.');
        }

        return false;
    }


</script>
<script type="text/javascript">
    window.msg = "yes";



    function readImage(file) {
        var reader = new FileReader();
        var image = new Image();
        reader.readAsDataURL(file);
        reader.onload = function(_file) {
            image.src = _file.target.result;              // url.createObjectURL(file);
            image.onload = function() {
                var w = parseInt(this.width),
                        h = parseInt(this.height),
                        t = file.type, // ext only: // file.type.split('/')[1],
                        n = file.name,
                        s = ~~(file.size / 1024) + 'KB';

                if (h < 285 || w < 300)
                {
                    $("#photo_first_dilog .modal-dialog .modal-content #fileuploadfirst .template-upload").remove();
                    $("#photo_second_dilog .modal-dialog .modal-content #fileuploadsecond .template-upload").remove();
                    $('#error_first').html('Sorry! We do not accept images 300x285 or smaller!').css('color', 'red');
                    $('#error_second').html('Sorry! We do not accept images 300x285 or smaller!').css('color', 'red');
                } else {
                    $('#error_first').html('').css('color', 'red');
                    $('#error_second').html('').css('color', 'red');
                }
            };

        };
        // alert(msg);
        return msg;

    }

    /*
     $(document).on('keyup','#title_chk',function(){
     
     var content_name = $('#title_chk').val().trim();
     
     if(content_name.length > 10){
     content_name =  content_name.slice(0,10);
     $('#title_chk').val(content_name);
     $('#name_error').html('<span style="color:red">* Only 10 characters allowed<span>');
     }
     });
     
     $(document).on('blur','#title_chk',function(){
     $('#name_error').html('');
     });
     
     
     $(document).on('keyup','#artist_chk',function(){
     var content_name = $('#artist_chk').val().trim();
     
     if(content_name.length > 10){
     content_name =  content_name.slice(0,10);
     $('#artist_chk').val(content_name);
     $('#name_error').html('<span style="color:red">* Only 10 characters allowed<span>');
     }
     });
     
     $(document).on('blur','#artist_chk',function(){
     $('#name_error').html('');
     });
     */
     
     
     $(document).on('change','#chk_cover',function(){
    
        $('#upload_image1').modal('show');
        $('#uploadcoverart').change(function(){
       
        var data=$('#uploadcoverart').val();
        $('#uploadcover').on('submit',function(){
             var formData = new FormData($(this)[0]);
//
//    $.ajax({
//        url: <?php ?>,
//        type: 'POST',
//        data: formData,
//        async: false,
//        success: function (data) {
//            alert(data)
//        },
//        cache: false,
//        contentType: false,
//        processData: false
//    });
//
//    return false;
      
        });
        });
        });
       
        
 

</script>


