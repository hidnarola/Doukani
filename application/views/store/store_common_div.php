<?php $this->load->view('common/send_message_form'); ?>
<div class="modal fade center" id="replyModal1" tabindex="-1" role="dialog"  aria-hidden="true">
    <form id="img_upload" name="img_upload" method="post">
        <div class="modal-dialog appup modal-md">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-info-circle"></i>About Us</h4>
                </div>
                <div class="modal-body text-center">               
                    <p>
                        <?php echo $store[0]->store_description; ?>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).on("click", "#about_us", function (e) {
        $("#replyModal1").modal('show');
    });

    $(document).ready(function () {

        $('.store-individual-user-social-toggle').click(function () {
            $('.store-individual-user-social ul').slideToggle();
        });
        $('.store-individual-user-right-toggle').click(function () {
            $('.store-individual-user-right > ul').slideToggle();
        });
    });

</script>