<?php
     if($this->session->userdata('category'))
        $category = $this->session->userdata('category');
    
     if($this->session->userdata('state'))
        $state = $this->session->userdata('state');
?>
<div class="col-sm-2 category no-padding">
                    	<h4>Categories</h4>
                        <ul>
                             <?php foreach ($category as $cat): ?>
                                   <li><a href="<?php echo base_url() . "home/category/" . $cat['category_id']; ?>">
                                           <i class="fa"><img alt="Category Image" style="height: 24px; width: 28px;" src="<?php echo base_url() . category . "small/" . $cat['category_image']; ?>"/></i><?php echo $cat['catagory_name'] ?></a></li>
                                   <!-- <img alt="Category Image" style="height: 40px; width: 64px;" src="<?php echo base_url() . category . "small/" . $cat['category_image']; ?>"/>-->
                             <?php endforeach; ?>
                       	 
                        </ul>
                    	<h4>Filter</h4>
                        <form class="filter" method="post" action="<?php echo base_url()?>home/search">
                        	<div class="form-group">
                            	<label>Cities</label>
                                <select class="form-control" name="city" id="city">
                                    <option value="0">Select City</option>
                                    <?php foreach ($state as $st): ?>
                                      <?php if($st['state_id'] == @$_POST['city']) {?>
                                        <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city'],TRUE); ?> ><?php echo $st['state_name'] ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city']); ?> ><?php echo $st['state_name'] ?></option>
                                        <?php } ?>
                                        
                                     <?php endforeach; ?>
                                	
                                </select>
                            </div>
                        	<div class="form-group">
                            	<label>Categories</label>
                                <select class="form-control" name="cat" name="cat" onchange="show_sub_cat(this.value);">
                                    <option value="0">Select Category</option>
                                        <?php foreach ($category as $cat): ?>
                                        <?php if($cat['category_id'] == @$_POST['cat']) {?>
                                        <option value="<?php echo $cat['category_id'] ?>" <?php echo set_select('cat', @$_POST['cat'],TRUE)?> ><?php echo $cat['catagory_name'] ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $cat['category_id'] ?>" <?php echo set_select('cat', @$_POST['cat'])?> ><?php echo $cat['catagory_name'] ?></option>
                                        <?php }endforeach; ?>
                                </select>
                                <select class="form-control" id="sub_cat" name="sub_cat">
                                    <option value="0">All</option>
                                    <?php if(@$sub_category){
                                         foreach (@$sub_category as $sub): ?>
                                        <?php if($sub['sub_category_id'] == @$_POST['sub_cat']) {?>
                                        <option value="<?php echo $sub['sub_category_id'] ?>" <?php echo set_select('sub_cat', @$_POST['sub_cat'],TRUE)?> ><?php echo $sub['sub_category_name'] ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $sub['sub_category_id'] ?>" <?php echo set_select('sub_cat', @$_POST['sub_cat'])?> ><?php echo $sub['sub_category_name'] ?></option>
                                    <?php }endforeach; }?>
                                    
                                </select>
                            </div>
                          	<div class="form-group">
                            	<label>Price</label><br />
                                <input type="text" class="form-control range"  placeholder="Min" name="min_amount" id="min_amount" value="<?php echo set_value('min_amount',@$_POST['min_amount']); ?>" onkeypress="return isNumber(event)"/> 
                                <span> To </span> 
                                <input type="text" placeholder="Max" class="form-control range" name="max_amount" id="max_amount" value="<?php echo set_value('max_amount',@$_POST['max_amount']); ?>" onkeypress="return isNumber(event)"/>
							</div>
                            <button class="btn btn-block mybtn" value="search" id="search">Search</button>
                           <!-- <a class="btn btn-block mybtn">Search</a> -->
                        </form>
                    </div>
<script type="text/javascript">
  function show_sub_cat(val) {
   
    $("input[name='cat']").val(val);
    
    var url = "<?php echo base_url() ?>home/show_sub_cat";
    $.post(url, {value: val}, function(data)
    {
        $("#sub_cat").html(data);
        //$("#sub_cat").select2();


    });
    }
    
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
    }
    
    $("#search").click(function(){ 
        min = $("#min_amount").val();
        max = $("#max_amount").val();
            if(max != "" && min != "" && (Number(max) <= Number(min))) 
            { 
                alert("Max amount should be greater than min amount.");
                $("#max_amount").val("");
                $("#max_amount").focus();
                return false;
            }else{
                return true;    
            }
        }); 
</script>
        