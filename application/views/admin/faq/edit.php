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
                                            <i class=' icon-question-sign '></i>
                                            <span>FAQ</span>
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
                                <form action="<?php echo base_url(); ?>admin/faq/edit/<?php echo $faq[0]->faq_id; ?>" class="form validate-form" role="form" enctype="multipart/form-data" novalidate="novalidate" id="ContentAdminContentsForm" method="post" accept-charset="utf-8">	
                                    <div class="col-sm-12 box" style="margin-bottom: 0">
                                        <div class="box-header orange-background">
                                            <div class="title">
                                                <div class='icon-edit'></div>
                                                Edit FAQ
                                            </div>
                                        </div>
                                        <div class="box-content">											
                                            <div class="form-group row controls">
                                                <div class="col-md-7">
                                                    <label>Question</label>
                                                    <input name="question" class="form-control" placeholder="" maxlength="250" type="text" id="ContentTitle" data-rule-required='true' value="<?php echo $faq[0]->question ?>">			
                                                </div>	
                                            </div>											                                            
                                            <div class="tabbable" style="margin-top: 20px">
                                                <ul class="nav nav-responsive nav-tabs">
                                                    <li class="active"><a data-toggle="tab" href="#retab1">Content</a></li>
                                                    <li class=""><a data-toggle="tab" href="#retab2">Metas</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="retab1" class="tab-pane active">
                                                        <textarea class='form-control ckeditor' id='wysiwyg1' name="answer" rows='10'><?php echo $faq[0]->answer; ?></textarea>
                                                    </div>
                                                    <div id="retab2" class="tab-pane">
                                                        <div class="form-group">
                                                            <label>Meta Title</label>
                                                            <input name="meta_title" class="form-control" placeholder="" type="text" id="ContentMetaTitle" value="<?php echo $faq[0]->meta_title; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta Description</label>
                                                            <input name="meta_desc" class="form-control" placeholder="" type="text" id="ContentMetaDescription" value="<?php echo $faq[0]->meta_desc; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Meta Keywords</label>
                                                            <input name="meta_keyword" class="form-control" placeholder="" type="text" id="ContentMetaKeywords" value="<?php echo $faq[0]->meta_keyword ?>">
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
                                                <a href="<?php echo base_url(); ?>admin/faq" class="btn">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>        
    </body>
</html>