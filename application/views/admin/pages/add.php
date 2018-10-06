<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb store'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>
                                            <i class='icon-book'></i>
                                            <span>Pages</span>
                                        </h1>

                                    </div>
                                </div>
                            </div>
                            <hr class="hr-normal">
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <form action="<?php echo base_url(); ?>admin/pages/add" class="form validate-form" role="form" novalidate="novalidate" enctype="multipart/form-data" method="post" accept-charset="utf-8">	
                                    <div class="col-sm-12 box" style="margin-bottom: 0">
                                        <div class="box-header orange-background">
                                            <div class="title">Add Page</div>			
                                        </div>
                                        <div class="box-content">											
                                            <div class="form-group row controls">
                                                <div class="col-md-7">
                                                    <label>Title</label>
                                                    <input name="page_title" class="form-control" placeholder="" maxlength="250" type="text" id="ContentTitle" data-rule-required='true'>			
                                                </div>
                                            </div>
                                            <div class="form-group row controls">
                                                <div class="col-md-7">
                                                    <label>Sub Title</label>
                                                    <input name="sub_title" class="form-control" placeholder="" maxlength="250" type="text" id="ContentsubTitle"
                                                           data-rule-required='true'>			
                                                </div>	
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-5">
                                                    <label>Parent Page</label>
                                                    <select class="select2 form-control" name="parent_id">
                                                        <option value="0">-None-</option>
                                                        <?php foreach ($pages as $page) { ?>
                                                            <option value="<?php echo $page['page_id']; ?>"><?php echo $page['page_title']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>State</label><br>
                                                <div data-on-label="On" data-off-label="Off" class="make-switch switch-small switch" style="height:26px;" data-on='success'>
                                                    <input checked type='checkbox' name="page_state" value="1">
                                                </div>						
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-7">
                                                    <label>Link To Another URL</label>
                                                    <input name="direct_url" class="form-control" placeholder="https://www.facebook.com" type="text">          
                                                </div>
                                            </div>
                                            <div class='form-group row'>                        
                                                <div class='col-md-5'>
                                                    <label>Icon</label>                                                        
                                                    <select class="select2 form-control" name="select_icons">
                                                        <option value=''>No icon</option>
                                                        <?php foreach ($icons as $icon) { ?>
                                                            <option class="fa <?php echo $icon; ?>" value="<?php echo $icon; ?>" name="<?php echo $icon; ?>"><?php echo $icon; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group row'>                        
                                                <div class='col-md-5'>                       
                                                    <label>Choose color</label>                                                    
                                                    <input class='colorpicker-hex form-control' name="color" placeholder='Pick a color' style='margin-bottom: 0;' type='text'>       
                                                </div>
                                            </div>
                                            <div class="tabbable" style="margin-top: 20px">
                                                <ul class="nav nav-responsive nav-tabs">
                                                    <li class="active"><a data-toggle="tab" href="#retab1">Content</a></li>
                                                    <li class=""><a data-toggle="tab" href="#retab2">Metas</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="retab1" class="tab-pane active">
                                                        <textarea class='form-control ckeditor' id='wysiwyg1' name="page_content" rows='10'></textarea>
                                                    </div>
                                                    <div id="retab2" class="tab-pane">
                                                        <div class="form-group">
                                                            <label>Meta Title</label>
                                                            <input name="page_meta_title" class="form-control" placeholder="" type="text" id="ContentMetaTitle">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta Description</label>
                                                            <input name="page_meta_desc" class="form-control" placeholder="" type="text" id="ContentMetaDescription">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta Keywords</label>
                                                            <input name="page_meta_keyword" class="form-control" placeholder="" type="text" id="ContentMetaKeywords">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions form-actions-padding-sm">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-2">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-floppy-o"></i>
                                                    Save
                                                </button>
                                                <a href="<?php echo base_url(); ?>admin/pages" class="btn">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
</div>
<?php $this->load->view('admin/include/footer-script'); ?>        
</body>
</html>