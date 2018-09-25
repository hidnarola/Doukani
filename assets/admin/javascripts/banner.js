$('#loading').hide();

if (cat_value == 'offer' || cat_value == 'feature') {
    $('#cat_section').hide();
}

function hide_show_cat(val) {

    var ban_name_0 = $("#ban_type").val();
    //if (val == 'content_page' && ban_name_0!='sidebar') {
    if (val == 'content_page' || val == 'off_cat_cont') {
        $('.cat_section_').prop('selectedIndex', 0);
        $('.sub_cat_section_').prop('selectedIndex', 0);
        
        showCategory();
        
        if(val == 'off_cat_cont')
            $('.sub_cat_section_').hide();
        
        $('#cat_section').show();
        $('#company_section').hide();
        $('#store_section').hide();
    } else if (val == 'off_comp_cont') {
        $('#cat_section').hide();
        $('#company_section').show();
        $('#store_section').hide();
    } else if (val == 'store_content_page' || val == 'specific_store_page') {
        $('#cat_section').hide();
        $('#company_section').hide();
        $('#store_section').show();
    } else {
        $('#cat_section').hide();
        $('#company_section').hide();
        $('#store_section').hide();
    }
}

$(document).ready(function () {

    $("#display_page option[value='after_splash_screen']").hide();
    $("#display_page option[value='before_latest_ads']").hide();
    $("#display_page option[value='before_featured_items']").hide();

    $("#display_page optgroup option[value='store_all_page']").hide();
    $("#display_page optgroup option[value='specific_store_page']").hide();
    $("#display_page optgroup option[value='store_content_page']").hide();

    $("#display_page optgroup option[value='off_all_page']").hide();

    $("#display_page optgroup option[value='off_home_page']").hide();
    $("#display_page optgroup option[value='off_catent_page']").hide();
    $("#display_page optgroup option[value='off_cat_cont']").hide();
    $("#display_page optgroup option[value='off_comp_cont']").hide();
    $("#display_page optgroup option[value='off_cat_side']").hide();
    $("#display_page optgroup option[value='off_comp_side']").hide();

    $("#display_page optgroup option[value='bw_home_page_ban1']").hide();
    $("#display_page optgroup option[value='bw_home_page_ban2']").hide();
    $("#display_page optgroup option[value='latest_ads_page']").hide();

    //hide_mobile_val(1);

    //$('#big_img').show();
    //$('#small_img').hide();

    //$('#text_val').hide();
    //$('#site_url').hide();

    if ($('.mobile-radio').is(':checked')) {
        $(".mobile").show();
    }

    $('#text_banner').click(function () {
        $('#img_banner').prop('checked', false);
        $('#text_banner').prop('checked', true);

        $('#text_1').hide();
        $('#img_2').hide();
        $('#img_3').hide();
        $('#site_url_hide').hide();
        $('#big_img').hide();
        $('#small_img').hide();
        $('#text_val').show();
        $('#site_url').hide();
    });


    $('#img_banner').click(function () {
        $('#img_banner').prop('checked', true);
        $('#text_banner').prop('checked', false);

        $('#text_val').hide();
        $('#text_1').hide();
        $('#img_2').show();
        $('#img_3').show();
        $('#site_url_hide').hide();
        var ban_for = $('#ban_for').val();
        //alert(ban_for);
        //alert(ban_type);
        if (ban_for == 'web') {
            $('#big_img').show();
            $('#small_img').hide();
        } else if (ban_for == 'mobile') {
            $('#big_img').hide();
            $('#small_img').show();
        } else {
            $('#big_img').show();
            $('#small_img').hide();
        }
        $('#text_val').hide();
        $('#site_url').show();
    });



    $('#st_cust').click(function () {
        $('#start_dt').show();
    });
    $('#end_cust').click(function () {
        $('#end_dt').show();
    });
    $('#st_now').click(function () {
        $('#start_dt').hide();
    });
    $('#end_never').click(function () {
        $('#end_dt').hide();
    });
});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
        return false;
    }
    return true;
}

function hide_mobile_val(val) {
    //to hide
    //alert(val+ "value");
    if (val == 1) {
        $("#ban_type option[value='intro']").hide();
        $("#ban_type option[value='feature']").hide();
        $("#ban_type option[value='footer']").hide();
        $("#ban_type option[value='between_app']").hide();
    }
    //to show
    else if (val == 2) {
        $("#ban_type option[value='intro']").show();
        $("#ban_type option[value='feature']").show();
        $("#ban_type option[value='footer']").show();
        $("#ban_type option[value='between_app']").show();
    }
}

function hide_web_val(val) {
    //to hide
    if (val == 1) {
        $("#ban_type option[value='header']").hide();
        $("#ban_type option[value='sidebar']").hide();
        $("#ban_type option[value='between']").hide();
    }
    //to show
    else if (val == 2) {
        $("#ban_type option[value='header']").show();
        $("#ban_type option[value='sidebar']").show();
        $("#ban_type option[value='between']").show();
    }
}

$("#ban_for").change(function () {
    $('#ban_type').prop('selectedIndex', 0);
    var ban_for = $("#ban_for").val();
    get_banner_type(ban_for);
});

function get_banner_type(ban_for) {
    var display_div = $("input[name=ban_txt_img_0]:checked").val();

    if (ban_for == 'mobile') {
        $('#mobile').show();
        hide_mobile_val(2);
        hide_web_val(1);
        if (display_div == 'image') {
            $('#big_img').hide();
            $('#small_img').show();
            $('#text_val').hide();
        } else
        {
            $('#text_val').show();
            $('#big_img').hide();
            $('#small_img').hide();
        }
    } else {
        $('#mobile').hide();
        hide_mobile_val(1);
        hide_web_val(2);

        if (display_div == 'image') {
            $('#big_img').show();
            $('#small_img').hide();
            $('#text_val').hide();
        } else if (display_div == 'text')
        {
            $('#text_val').show();
            $('#big_img').hide();
            $('#small_img').hide();
        }

    }

    $('#display_page').prop('selectedIndex', 0);
    var ban_t = $("#ban_type").val();

    if (ban_t == 'intro') {
        $("#display_page optgroup option[value='home_page']").hide();
        $("#display_page optgroup option[value='all_page']").hide();

        $("#display_page optgroup option[value='store_all_page']").hide();
        $("#display_page optgroup option[value='specific_store_page']").hide();
        $("#display_page optgroup option[value='store_content_page']").hide();

        $("#display_page optgroup option[value='off_all_page']").hide();
        $("#display_page optgroup option[value='off_home_page']").hide();
        $("#display_page optgroup option[value='off_catent_page']").hide();
        $("#display_page optgroup option[value='off_cat_cont']").hide();
        $("#display_page optgroup option[value='off_comp_cont']").hide();
        $("#display_page optgroup option[value='off_cat_side']").hide();
        $("#display_page optgroup option[value='off_comp_side']").hide();

        $("#display_page option[value='after_splash_screen']").show();
        $("#display_page option[value='before_latest_ads']").show();
        $("#display_page option[value='before_featured_items']").show();
    } else {
        $("#display_page optgroup option[value='home_page']").show();
        $("#display_page optgroup option[value='all_page']").show();

        $("#display_page optgroup option[value='store_all_page']").show();
        $("#display_page optgroup option[value='specific_store_page']").show();
        $("#display_page optgroup option[value='store_content_page']").show();

        $("#display_page optgroup option[value='off_all_page']").show();
        $("#display_page optgroup option[value='off_home_page']").show();
        $("#display_page optgroup option[value='off_catent_page']").show();
        $("#display_page optgroup option[value='off_cat_cont']").show();
        $("#display_page optgroup option[value='off_comp_cont']").show();
        $("#display_page optgroup option[value='off_cat_side']").show();
        $("#display_page optgroup option[value='off_comp_side']").show();

        $("#display_page option[value='after_splash_screen']").hide();
        $("#display_page option[value='before_latest_ads']").hide();
        $("#display_page option[value='before_featured_items']").hide();
    }
}

$("#ban_type").change(function () {

    $('#display_page').prop('selectedIndex', 0);
    var display_div = $("input[name=ban_txt_img_0]:checked").val();

    var ban_t = $("#ban_type").val();
    //alert(ban_t);
//    if (ban_t != '' && (ban_t == 'header' || ban_t == 'between' || ban_t == 'sidebar')) {
    if (ban_t != '' && (ban_t == 'header' || ban_t == 'between' || ban_t == 'sidebar')) {

        if (display_div == 'image') {
            $('#text_val').hide();
            $('#big_img').show();
            $('#small_img').hide();
        } else {
            $('#text_val').show();
            $('#big_img').hide();
            $('#small_img').hide();
        }
        $("#display_page option[value='after_splash_screen']").hide();
        $("#display_page option[value='before_latest_ads']").hide();
        $("#display_page option[value='before_featured_items']").hide();
        $("#display_page optgroup option[value='all_page']").show();


        if (ban_t == 'between') {
            $("#display_page optgroup option[value='home_page']").hide();
            $("#display_page optgroup option[value='store_content_page']").hide();
            $("#display_page optgroup option[value='off_catent_page']").hide();
            $("#display_page optgroup option[value='store_page_content']").hide();
            $("#display_page optgroup option[value='bw_home_page_ban1']").show();
            $("#display_page optgroup option[value='bw_home_page_ban2']").show();
        } else {
            $("#display_page optgroup option[value='home_page']").show();
            $("#display_page optgroup option[value='store_content_page']").show();
            $("#display_page optgroup option[value='off_catent_page']").show();
            $("#display_page optgroup option[value='store_page_content']").show();
            $("#display_page optgroup option[value='bw_home_page_ban1']").hide();
            $("#display_page optgroup option[value='bw_home_page_ban2']").hide();
        }

        if (ban_t == 'sidebar') {
            $("#display_page optgroup option[value='off_cat_side']").show();
            $("#display_page optgroup option[value='off_comp_side']").show();
            $("#display_page optgroup option[value='specific_store_page']").hide();
            $("#display_page optgroup option[value='off_cat_cont']").hide();
            $("#display_page optgroup option[value='off_comp_cont']").hide();
            $("#display_page optgroup option[value='latest_ads_page']").hide();
            $("#display_page optgroup option[value='store_page_content']").show();

        } else {
            $("#display_page optgroup option[value='off_cat_side']").hide();
            $("#display_page optgroup option[value='off_comp_side']").hide();
            $("#display_page optgroup option[value='store_page_content']").hide();
            $("#display_page optgroup option[value='specific_store_page']").show();
            $("#display_page optgroup option[value='off_cat_cont']").show();
            $("#display_page optgroup option[value='off_comp_cont']").show();
            $("#display_page optgroup option[value='latest_ads_page']").show();
        }

        if (ban_t == 'between' || ban_t == 'sidebar')
            $("#display_page optgroup option[value='off_home_page']").hide();
        else
            $("#display_page optgroup option[value='off_home_page']").show();

        $("#display_page optgroup option[value='off_all_page']").show();
        $("#display_page optgroup option[value='store_all_page']").show();

    } else if (ban_t != '' && (ban_t == 'intro' || ban_t == 'feature' || ban_t == 'footer' || ban_t == 'between_app')) {
        if (ban_t == 'intro') {
            $("#display_page option[value='after_splash_screen']").show();
            $("#display_page option[value='before_latest_ads']").show();
            $("#display_page option[value='before_featured_items']").show();
            $("#display_page option[value='home_page']").hide();
            $("#display_page option[value='all_page']").hide();

            $("#display_page optgroup option[value='store_all_page']").hide();
            $("#display_page optgroup option[value='specific_store_page']").hide();
            $("#display_page optgroup option[value='store_content_page']").hide();

            $("#display_page optgroup option[value='offer_all_page']").hide();
            $("#display_page optgroup option[value='offer_home_page']").hide();
            $("#display_page optgroup option[value='off_catent_page']").hide();
            $("#display_page optgroup option[value='off_cat_cont']").hide();
            $("#display_page optgroup option[value='off_comp_cont']").hide();
            $("#display_page optgroup option[value='off_cat_side']").hide();
            $("#display_page optgroup option[value='off_comp_side']").hide();

        } else
        {
            $("#display_page option[value='after_splash_screen']").hide();
            $("#display_page option[value='before_latest_ads']").hide();
            $("#display_page option[value='before_featured_items']").hide();
            $("#display_page option[value='home_page']").show();
            $("#display_page option[value='all_page']").show();

            $("#display_page optgroup option[value='store_all_page']").hide();
            $("#display_page optgroup option[value='specific_store_page']").hide();
            $("#display_page optgroup option[value='store_content_page']").hide();

            $("#display_page optgroup option[value='off_all_page']").hide();
            $("#display_page optgroup option[value='off_home_page']").hide();
            $("#display_page optgroup option[value='off_catent_page']").hide();
            $("#display_page optgroup option[value='off_cat_cont']").hide();
            $("#display_page optgroup option[value='off_comp_cont']").hide();
            $("#display_page optgroup option[value='off_cat_side']").hide();
            $("#display_page optgroup option[value='off_comp_side']").hide();
        }

        if (display_div == 'image') {
            $('#text_val').hide();
            $('#small_img').show();
            $('#big_img').hide();
        } else if (display_div == 'text') {
            $('#text_val').show();
            $('#big_img').hide();
            $('#small_img').hide();
        }

    }
    if ($("#blah1")[0] != '') {
        var imgcon = $("#blah1")[0];

        $('#uploadedlargefile').val('');
        $(".file-input-name").html("");
        $(imgcon).attr("src", "");
        $(imgcon).hide();
    }
    if ($("#blah2")[0] != '') {
        var imgcon = $("#blah2")[0];

        $('#uploadedfile').val('');
        $(".file-input-name").html("");
        $(imgcon).attr("src", "");
        $(imgcon).hide();
    }
});

$('#blah2').hide();

//for Mobile App banner	
function loadimage_small(input) {

    var uploadedfile = $("#uploadedfile").val();
    if (uploadedfile != '') {
        var file_data = $("#uploadedfile").prop("files")[0];
        var type = file_data.type;
        if (file_data) {
            if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif") {
                $('#uploadedfile').val('');
                $(document).find('.file-input-name').html('');
                var imgcon = $("#blah2")[0];
                $(imgcon).attr("src", "");
                $(imgcon).hide();

                $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                $(document).find("#search_alert").modal('show');
                return false;
            }
        }
    }

    var height = '';
    var width = '';

    var intro_height = 510;
    var intro_width = 960;

    var feature_height = 510;
    var feature_width = 960;

    var footer_height = 100;
    var footer_width = 960;

    var ban_type = $('#ban_type').val();

    var dip = $('#display_page').val();

    if (ban_type == "intro") {
        cheight = intro_height;
        cwidth = intro_width;
    } else if (ban_type == "feature") {
        cheight = feature_height;
        cwidth = feature_width;
    } else if (ban_type == "footer") {
        cheight = footer_height;
        cwidth = footer_width;
    }
    //alert("call");			
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah2')
                    .attr('src', e.target.result);
//                    .width(wid)
//                    .height(hei);
            var imgcon = $("#blah2")[0];
            var img = imgcon;
            //console.log(img);
            var pic_real_width, pic_real_height;
            $("<img/>")
                    .attr("src", $(img).attr("src"))
                    .load(function () {

                        pic_real_width = this.width;
                        pic_real_height = this.height;

                        /*if(ban_type=='intro' && (intro_height!=pic_real_height ||  intro_width!=pic_real_width)) {
                         var err_msg	=	"Image Dimension must be between "+intro_width+" X "+intro_height+ " pixels in Width and Height for Intro Banner";
                         alert(err_msg);
                         $('#uploadedfile').val('');
                         $(".file-input-name").html("");
                         $(imgcon).attr("src", "");
                         $(imgcon).hide();
                         } 										
                         else*/
                        /*if(ban_type=='feature' && (feature_height!=pic_real_height ||  feature_width!=pic_real_width)) {
                         var err_msg	=	"Image Dimension must be between "+feature_width+" X "+feature_height+ " pixels in Width and Height for Feature Banner";
                         alert(err_msg);
                         $('#uploadedfile').val('');
                         $(".file-input-name").html("");
                         $(imgcon).attr("src", "");
                         $(imgcon).hide();
                         }
                         else if(ban_type=='footer' && (footer_height!=pic_real_height ||  footer_width!=pic_real_width)) {
                         var err_msg	=	"Image Dimension must be between "+footer_width+" X "+footer_height+ " pixels in Width and Height for Footer Banner";
                         alert(err_msg);
                         $('#uploadedfile').val('');
                         $(".file-input-name").html("");
                         $(imgcon).attr("src", "");
                         $(imgcon).hide();
                         }																		
                         else {	*/
                        $(imgcon).attr("src", $(img).attr("src"));
                        $(imgcon).show();
                        //}
                    });
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$('#blah1').hide();

var hei = 150;
var wid = 150;

//intro header banner
//var intro_width		=	1600;
var intro_width = 1599;
var intro_height = 133;

//feature banner or sidebar banner			
var feature_width = 409;
var feature_height = 332;

//between banner			
var between_width = 1228;
var between_height = 224;

//for website banner
function loadimage(input) {

    var uploadedlargefile = $("#uploadedlargefile").val();
    if (uploadedlargefile != '') {
        var file_data = $("#uploadedlargefile").prop("files")[0];
        var type = file_data.type;
        if (file_data) {
            if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif") {
                $('#uploadedlargefile').val('');
                $(document).find('.file-input-name').html('');
                var imgcon = $("#blah1")[0];
                $(imgcon).attr("src", "");
                $(imgcon).hide();

                $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                $(document).find("#search_alert").modal('show');
                return false;
            }
        }
    }

    var dip = $('#display_page').val();
    var cheight = '';
    var cwidth = '';
    var ban_type = $('#ban_type').val();

    if (ban_type == 'header' || ban_type == 'sidebar' || ban_type == 'between') {

        if (ban_type == "header") {
            cwidth = intro_width;
            cheight = intro_height;
        } else if (ban_type == "sidebar" && dip != 'content_page') {
            cheight = feature_height;
            cwidth = feature_width;
        } else if (ban_type == "sidebar" && dip == 'content_page') {
            cwidth = feature_width;
            cwidth = feature_width;
        } else if (ban_type == "between") {
            cheight = between_height;
            cwidth = between_width;
        }

        if (ban_type == "header")
            var err_msg = "Image Dimension must be " + cwidth + " X " + cheight + " pixels in width*height";
        else if (ban_type == "sidebar" && dip == 'content_page') {
            var err_msg = "Image Dimension must be " + cwidth + " pixels in width";
        } else if (ban_type == "sidebar" && dip == 'all_page') {
            var err_msg = "Image Dimension must be " + cwidth + " X " + cheight + " pixels in width*height";
        } else if (ban_type == "between")
            var err_msg = "Image Dimension must be " + cwidth + " X " + cheight + " pixels in width*height";

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah1')
                        .attr('src', e.target.result);
//                        .width(wid)
//                        .height(hei);
                var imgcon = $("#blah1")[0];
                var img = imgcon;
                //console.log(img);
                var pic_real_width, pic_real_height;
                $("<img/>")
                        .attr("src", $(img).attr("src"))
                        .load(function () {
                            pic_real_width = this.width;
                            pic_real_height = this.height;
                            /*alert(pic_real_width+"=>"+min_width);
                             alert(pic_real_height+"=>"+min_height);
                             alert(ban_type);
                             alert(dip);*/

                            /*if(ban_type=="header" && (pic_real_width != cwidth || pic_real_height != cheight)) {
                             alert(err_msg);
                             $('#uploadedlargefile').val('');
                             $('#uploadedlargefile').val('');
                             $(".file-input-name").html("");
                             $(imgcon).attr("src", "");
                             $(imgcon).hide();
                             }											
                             else if(ban_type=="sidebar" && dip=='content_page' && (pic_real_width != cwidth)) {
                             alert(err_msg);
                             $('#uploadedlargefile').val('');
                             $(".file-input-name").html("");
                             $(imgcon).attr("src", "");
                             $(imgcon).hide();
                             }	
                             else if(ban_type=="sidebar" && dip=='all_page' && (pic_real_width != cwidth || pic_real_height != cheight)) {
                             alert(err_msg);
                             $('#uploadedlargefile').val('');
                             $(".file-input-name").html("");
                             $(imgcon).attr("src", "");
                             $(imgcon).hide();
                             }				
                             else if(ban_type=="between" && (pic_real_width != cwidth || pic_real_height != cheight)) {
                             alert(err_msg);
                             $('#uploadedlargefile').val('');
                             $(".file-input-name").html("");
                             $(imgcon).attr("src", "");
                             $(imgcon).hide();
                             }	
                             else
                             {		*/
                            $(imgcon).attr("src", $(img).attr("src"));
                            $(imgcon).show();
                            //}
                        });
            };
            reader.readAsDataURL(input.files[0]);
        }
    } else
    {
        alert("This banner type is not available for Website.");
        $('#blah1')
                .attr('src', e.target.result);
//                .width(wid)
//                .height(hei);

        var imgcon = $("#blah1")[0];
        $(imgcon).attr("src", "");
    }
}