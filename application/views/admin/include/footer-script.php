<div class="modal fade sure" id="search_alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">  
                <h4 class="modal-title">Alert
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </h4>                   
            </div>
            <div class="modal-body">
                <p class="response_message"></p>
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<a href="#" class="scrollup"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
<!-- / jquery [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
<!-- / jquery mobile (for touch events) -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
<!-- / jquery migrate (for compatibility with new jquery) [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
<!-- / jquery ui -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / jQuery UI Touch Punch -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<!-- / bootstrap [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
<!-- / modernizr -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
<!-- / retina -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
<!-- / theme file [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script> 
<!-- / demo file [not required!] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/demo.js" type="text/javascript"></script>
<!-- / wysihtml5 -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/wysihtml5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/bootstrap-wysihtml5.js" type="text/javascript"></script>
<!-- / Data table-->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/datatables/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
<!-- / select2-->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/select2/select2.js" type="text/javascript"></script>
<!-- / file input-->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<!-- / light box -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/lightbox/lightbox.min.js" type="text/javascript"></script>
<!-- / CK Editor-->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<!-- / Switch button--> 
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_switch/bootstrapSwitch.min.js" type="text/javascript"></script>
<!-- / Date range-->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
<!-- / validation --> 
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script>
<!-- / password strength-->
<script src=" <?php echo base_url(); ?>assets/admin/javascripts/plugins/pwstrength/pwstrength.js" type="text/javascript"></script>
<!-- / autosize textarea-->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/autosize/jquery.autosize-min.js" type="text/javascript"></script>

<!-- / SLim Scrollbar -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/timeago/jquery.timeago.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/javascripts/jquery.fonticonpicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/javascripts/jquery.multiple.select.js"></script>

<script src="<?php echo site_url(); ?>assets/googleMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete"
async defer></script>
<script type="text/javascript">
    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    $('.table-responsive').on('shown.bs.dropdown', function (e) {
        var t = $(this),
                m = $(e.target).find('.dropdown-menu'),
                tb = t.offset().top + t.height(),
                mb = m.offset().top + m.outerHeight(true),
                d = 20; // Space for shadow + scrollbar.
        if (t[0].scrollWidth > t.innerWidth()) {
            if (mb + d > tb) {
                t.css('padding-bottom', ((mb + d) - tb));
            }
        } else {
//            t.css('overflow', 'visible');
            t.css('overflow', 'scroll');
        }
    }).on('hidden.bs.dropdown', function () {
        $(this).css({'padding-bottom': '', 'overflow': ''});
    });
</script>
