<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-building'></i>
                                    <span>Logo</span>
                                </h1>               
                            </div>
                            <hr class="hr-normal">
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>                            
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Edit Logo
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <form action='<?php echo base_url() . 'admin/doukani_logo/edit/' . $logo[0]->id; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form">
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Page Name</label>
                                                <div class='col-md-5 controls'>
                                                    <input type="text" value="<?php echo $logo[0]->page_type; ?>" readonly class='form-control'>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Logo</label>
                                                <div class='col-md-5'>
                                                    <input title='Upload Logo' name='image_name' type='file' id='image_name' onchange="javascript:loadimage(this);">
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'></label>
                                                <div class='col-md-9'>
                                                    <img alt="Image" src="" id="blah1">
                                                </div>
                                            </div>
                                            <?php if (!empty($logo[0]->image_name)): ?>
                                                <div class='form-group'>
                                                    <div class="col-md-2"></div>
                                                    <div class='col-md-5'>
                                                        <img alt="category Image" src="<?php echo base_url() . doukani_logo . "original/" . $logo[0]->image_name; ?>" style="max-height:70px;max-width:260px;"/>
                                                    </div>
                                                </div>
                                            <?php endif; ?>                                            
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submit" name="submit">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>admin/doukani_logo' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script>
        $('#blah1').hide();
        function loadimage(input) {
            
            var image_name  = $("#image_name").val();
            if(image_name!='') {                    
                var file_data = $("#image_name").prop("files")[0];
                var type = file_data.type;
                if (file_data) {
                    if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif") {
                        $('#image_name').val('');
                        $(document).find('.file-input-name').html('');
                        $(".file-input-name").html("");
                        var imgcon = $("#blah1")[0];
                        $(imgcon).attr("src", "");
                        $(imgcon).hide();
                        
                        $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                        $(document).find("#search_alert").modal('show');
                        return false;
                    }
                }
            }
                
            if (input.files && input.files[0]) {
                var reader = new FileReader();                
                reader.onload = function (e) {
                    $('#blah1').attr('src', e.target.result);
                    var imgcon = $("#blah1")[0];
                    var img = imgcon;
                    
                    var pic_real_width, pic_real_height;
                    $("<img/>")
                            .attr("src", $(img).attr("src"))
                            .load(function () {
                                pic_real_width = this.width;
                                pic_real_height = this.height;
                                $(imgcon).attr("src", $(img).attr("src"));
                                $(imgcon).show();
                            });
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>       
    </body>
</html>