<div class="modal fade sure" id="view_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">  
                <h4 class="modal-title" id="title_info">Request Form
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </h4>                   
            </div>
            <div class="modal-body">                
                <form name="request_from" id="request_from" method="post" class="form form-horizontal " enctype="multipart/form-data" action="<?php echo base_url(); ?>user/send_store_details">

                    <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label>Store Name <span style="color:red;">*</span></label>
                            </div>
                            <div class="col-sm-8">
                                <input placeholder='Store Name' class="form-control" name="store_name" id="store_name" type='text' value="" data-rule-required='true' maxlength="50" >
                                <span class="store_name_status"></span>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="col-sm-4">
                                <label>Store Sub-domain <span style="color:red;">*</span></label>
                            </div>                            
                            <div class='col-sm-8'>
                                <input placeholder='Store Domain' class="form-control" name="store_domain" id="store_domain" type='text' value="" data-rule-required='true' onkeypress="return isNumber1(event);" maxlength="15">
                                <span id="full_domain">.doukani.com</span>
                                <br>
                                <span class="store_domain_status"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label>Category</label>
                            </div>
                            <div class="col-sm-8">                                
                                <select class="form-control" id="category_id" name="category_id" onchange="show_sub_cat(this.value);">
                                    <option value="0">Store Website</option>  
                                    <?php foreach ($category1 as $cat): ?>
                                        <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>                                                
                        </div>
                        <div class="form-group row sub_cat_block">
                            <div class="col-sm-4">
                                <label>Sub Category</label>
                            </div>
                            <div class="col-sm-8">                                
                                <select class="form-control" id="sub_category_id" name="sub_category_id">
                                    <option value="0">Store Website</option>
                                </select>
                            </div>  
                        </div>
                        <div class="form-group row new_webiste">
                            <div class="col-sm-4">
                                <label>Website URL <span style="color:red;">*</span></label>
                            </div>
                            <div class="col-sm-8">
                                <input type="url" class="form-control" placeholder="Website URL"  name="webiste_link" id="webiste_link" />                                
                            </div>  
                        </div>
                        <div class="form-group row store_desc_grp">
                            <div class="col-sm-4">
                                <label>Store Description </label>
                            </div>
                            <div class="col-sm-8">
                                <textarea cols="78" rows="5" class="form-control" name="store_description" id="store_description" ></textarea>                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button name="submit" class="btn btn-blue red-btn" id="">Send Request</button>
                            </div>  
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">                
            </div>
        </div>
    </div>
</div>