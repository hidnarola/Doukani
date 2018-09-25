<h2>Shipping Address</h2>
    <?php $this->load->view('cart/address_list'); ?>
    <div class="input-one">
        <a id="create_new" href="javascript:void(0);" class="btn btn-success">Create New Address</a>
        <a id="cancel_new" href="javascript:void(0);" class="btn btn-success" style="display:none;">Cancel</a>
    </div>
<div class="cart_address_form">
<form name="shipping_form" id="shipping_form" method='post' style="<?php if(sizeof($shipping_addresses)>0) echo 'display:none;'; ?>">
    <div class="input-one">
        <label>Customer Name <span>* </span> </label>
        <input type="text" id="customer_name" name="customer_name" placeholder="Customer Name" class="form-control"/>
    </div>
    <div class="input-two">
        <div class="input-two-div">
            <label>Contact Number <span>* </span> </label>
            <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Contact Number" />
        </div>
        <div class="input-two-div">
            <label>Email Id <span>* </span> </label>
            <input type="text" id="email_id" name="email_id" class="form-control" placeholder="Email Id" />
        </div>
    </div>                               
    <div class="input-one">
        <label>Address 1 <span>* </span> </label>
        <input type="text" id="address_1" name="address_1" class="form-control" data-rule-required='true' placeholder="Address 1" class="form-control">
    </div>
    <div class="input-one">
        <label>Address 2</label>
        <input type="text" id="address_2" name="address_2" placeholder="Address 2" class="form-control">
    </div>                                
    <div class="input-two">
        <div class="input-two-div">
            <label>Emirate<span>* </span> </label>
            <select id="state_id" name="state_id" class="form-control">
                <option value="" >Select Emirate</option>
                <?php if(sizeof($state) > 0) {
                    foreach($state as $st) { ?>
                    <option value="<?php echo $st['state_id']; ?>"><?php echo $st['state_name']; ?></option>
                <?php }
                    } 
                ?>
            </select>
        </div>
        <div class="input-two-div">
            <label>PO Box</label>
            <input type="text" name="po_box" id="po_box">
            <input type="hidden" name="request_address_id" id="request_address_id">
        </div>        
        <div class="input-one">
            <button type="submit" name="shipping_submit" id="shipping_submit" class="form-control btn btn-success">Save</button>
        </div>
    </div>
</form>
</div>