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
                                    <i class='icon-list'></i>
                                    <span>Category</span>
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
                                            Edit Category
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <form action='<?php echo base_url() . 'admin/classifieds/categories_edit/' . $category[0]->category_id; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form">
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Category Name</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Category Name' class="form-control" name="cat_name" type='text' data-rule-required='true' value="<?php echo str_replace('\n', " ", $category[0]->catagory_name); ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="inputTextArea1">Description</label>
                                                <div class="col-md-5">
                                                    <textarea class="form-control" name="description" placeholder="Description" rows="3"><?php echo $category[0]->description; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Category Image</label>
                                                <div class='col-md-5'>
                                                    <input title='Category Image' name='cat_image' type='file' id='cat_image'>                        
                                                </div>
                                            </div>
                                            <div class='form-group'>  
                                                <?php if (!empty($category[0]->category_image)): ?>
                                                    <div class="col-md-2"></div>
                                                    <div class='col-md-5'>
                                                        <img alt="category Image" src="<?php echo base_url() . category . "medium/" . $category[0]->category_image; ?>" onError="this.src='<?php echo base_url() . 'assets/upload/No_Image.png' ?>'" alt="Image"/>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Category Icon</label>
                                                <div class='col-md-5'>

                                                    <select class="select2 form-control" name="select_icons">
                                                        <option value=''>No icon</option>
                                                        <?php foreach ($icons as $icon) { ?>
                                                            <option <?php echo ($icon == $category[0]->icon) ? 'selected' : ''; ?> class="fa <?php echo $icon; ?>" value="<?php echo $icon; ?>" name="<?php echo $icon; ?>"><?php echo $icon; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Choose color</label>
                                                <div class='col-md-5'>
                                                    <input value="<?php echo $category[0]->color; ?>" class='colorpicker-hex form-control' name="cat_color" placeholder='Pick a color' style='margin-bottom: 0;' type='text'>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Category For</label>
                                                <div class='col-md-5'>                                                    
                                                    <label class="checkbox-inline">
                                                        <input id="inlineCheckbox1" type="checkbox" value="0" name="category_type[]" data-rule-required='true' <?php echo (in_array(0, explode(',', $category[0]->category_type))) ? 'checked=checked' : ''; ?>>
                                                        Classified Products
                                                    </label>
                                                    <label class="checkbox-inline">
                                                        <input id="inlineCheckbox2" type="checkbox" value="1" name="category_type[]" <?php echo (in_array(1, explode(',', $category[0]->category_type))) ? 'checked=checked' : ''; ?>>
                                                        Store Products
                                                    </label>
                                                    <label class="checkbox-inline">
                                                        <input id="inlineCheckbox3" type="checkbox" value="2" name="category_type[]" <?php echo (in_array(2, explode(',', $category[0]->category_type))) ? 'checked=checked' : ''; ?>>
                                                        Offer Products
                                                    </label>                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label  class='col-md-2 control-label' for='inputText1'>Meta Title</label>
                                                <div class='col-md-5'>
                                                    <textarea class="form-control" name="meta_title" placeholder="Meta Title" rows="3"><?php echo $category[0]->meta_title; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label  class='col-md-2 control-label' for='inputText1'>Meta Description</label>
                                                <div class='col-md-5'>
                                                    <textarea class="form-control" name="meta_description" placeholder="Meta Description" rows="3"><?php echo $category[0]->meta_description; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label  class='col-md-2 control-label' for='inputText1'>Meta Keywords</label>
                                                <div class='col-md-5'>
                                                    <textarea class="form-control" name="meta_keywords" placeholder="Meta Keywords" rows="3"><?php echo $category[0]->meta_keywords; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submit">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>admin/classifieds/categories' title="Cancel" class="btn">Cancel</a>
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
            $(function () {
                $('#submit').click(function () {
                    // function call_validation()
                    // {

                    var file_data = $("#cat_image").prop("files")[0];
                    var type = file_data.type;
                    if (file_data) {
                        var file_size = file_data.size / 1024;

                        if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                        {
                            $(document).find('.file-input-name').html('');
                            $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                            $(document).find("#search_alert").modal('show');
                            return false;
                        } else
                        {
                            jQuery('#form').attr('action', "<?php echo base_url() . 'admin/classifieds/categories_edit/' . $category[0]->category_id; ?>").submit();
                        }
                    }
                })
            })
        </script>       
    </body>
</html>