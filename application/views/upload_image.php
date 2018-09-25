<!-- Bootstrap styles -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/blueimp/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/blueimp/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/blueimp/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/blueimp/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo base_url(); ?>css/blueimp/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo base_url(); ?>css/blueimp/jquery.fileupload-ui-noscript.css"></noscript>


<script src="<?php echo base_url(); ?>js/blueimp/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>js/blueimp/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo base_url(); ?>js/blueimp/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo base_url(); ?>js/blueimp/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="<?php echo base_url(); ?>js/blueimp/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url(); ?>js/blueimp/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url(); ?>js/blueimp/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url(); ?>js/blueimp/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url(); ?>js/blueimp/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url(); ?>js/blueimp/jquery.fileupload-validate.js"></script>
<script src="<?php echo base_url(); ?>js/blueimp/jquery.fileupload-ui.js"></script>
<!--<script src="<?php echo base_url(); ?>js/blueimp/main.js"></script>-->
<div class="container">
    <div class="login_form upload_images_main">
        <div class="steps_main">
            <ul>
                <li><div class="step_round">1</div><a href="#">App Details</a></li>
                <li class="active"><div class="step_round">2</div><a href="#">Screenshots</a></li>
                <?php if ($this->session->userdata("group_name") != "admin") { ?>
                    <li><div class="step_round">3</div><a href="#">Payment</a></li>
                <?php } ?>
                <div class="line"></div>
            </ul>
        </div>
        <h2>Upload Images</h2>
        <br/>


        <?php
        if ($error != "") {
            echo "<h4>" . $error . "</h4>";
        }
        $aid = ($this->session->userdata("group_name") != "admin") ? $this->uri->segment(3) : $this->uri->segment(4);
        ?>
        <form id="fileupload" action="<?php echo base_url() . 'uploads/index/' . $aid; ?>" method="POST" enctype="multipart/form-data">
            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <!--<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>-->
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="col-sm-12">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <div class="col-sm-6">
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Add files...</span>
                            <input type="file" name="files[]" multiple >
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>Start upload</span>
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button type="reset" class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel upload</span>
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-danger delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                    </div>
                    <input type="checkbox" class="toggle">
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>
                <!-- The global progress state -->
                <div class="col-lg-5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
        </form>

        <form class="col-sm-6 col-sm-offset-3" method="post" action="<?php echo base_url(); ?>app_details/saveImage" >
            <input type="hidden" name="app_id" value="<?php echo ($this->session->userdata("group_name") != "admin") ? $this->uri->segment(3) : $this->uri->segment(4); ?>" />
            <input type="hidden" name="images_arr"  />
            <input type="hidden" name="page" value="add"  />
            <button class="btn btn-primary" type="submit" id="btnContinue" name="btnContinue" disabled="disabled">Continue</button>
        </form>

        <!-- The template to display files available for upload -->
        <script id="template-upload" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade">
            <td>
            <span class="preview"></span>
            </td>
            <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
            </td>
            <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
            {% if (!i && !o.options.autoUpload) { %}
            <button class="btn btn-primary start" disabled>
            <i class="glyphicon glyphicon-upload"></i>
            <span>Start</span>
            </button>
            {% } %}
            {% if (!i) { %}
            <button class="btn btn-warning cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancel</span>
            </button>
            {% } %}
            </td>
            </tr>
            {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">

            {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade" id="{%=btoa(file.name)%}">
            <td>
            <span class="preview">
            {% if (file.thumbnailUrl) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
            {% } %}
            </span>
            </td>
            <td>
            <p class="name">
            {% if (file.url) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            {% } else { %}
            <span>{%=file.name%}</span>
            {% } %}
            </p>
            {% if (file.error) { %}
            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
            </td>
            <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td>
            {% if (file.deleteUrl) { %}
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="glyphicon glyphicon-trash"></i>
            <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
            <button class="btn btn-warning cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancel</span>
            </button>
            {% } %}
            </td>
            </tr>
            {% } %}
        </script>
    </div>
</div>
<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo base_url() . 'uploads/index/' . $this->uri->segment(3); ?>',
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function() {
            var $this = $(this),
                    data = $this.data();
            $this
                    .off('click')
                    .text('Abort')
                    .on('click', function() {
                $this.remove();
                data.abort();
            });
            data.submit().always(function() {
                $this.remove();
            });
        });

        var img_arr = [];
        $('#fileupload').fileupload({
            dropZone: $('#dropzone'),
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(jpe?g|jpg|png|gif)$/i,
            maxFileSize: 100000000, // 5 MB
            maxNumberOfFiles: 5,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,
            success: function(response) {
                img_arr.push(window.btoa(response.files[0].name));
                $("input[name='images_arr']").val(img_arr);
                displayContinue();
                /*$.ajax({
                 type: 'POST',
                 url: '<?php // echo base_url()."app_details/saveImage"             ?>',
                 datatype: 'json',
                 cache: false,
                 data: {filename : window.btoa(response.files[0].name), app_id : "<?php // echo $this->uri->segment(3);             ?>" }
                 });*/
            },
            error: function() {
                console.log("Error");
            }
        }).on('fileuploadadd', function(e, data) {

            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });

        }).on('fileuploadprocessalways', function(e, data) {

            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
<!--.prepend('<br>')-->
                        .prepend(file.preview);
            }
            if (file.error) {

                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {


            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {
            var index = img_arr.indexOf(data.context[0].id);
            if (index > -1) {
                img_arr.splice(index, 1);
                $("input[name='images_arr']").val(img_arr);
                displayContinue();
            }
            data.context.remove();

        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });


    function displayContinue() {
        var img = $("input[name='images_arr']").val();
        if (img != "") {
            $("#btnContinue").prop("disabled", false)
        } else {
            $("#btnContinue").prop("disabled", true)
        }
    }

    displayContinue();


</script>