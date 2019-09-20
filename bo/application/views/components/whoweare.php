<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><?php echo MultiLang('cms'); ?></li>
                    <li class="breadcrumb-item active"><?php echo MultiLang('who_we_are'); ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="card col-sm-12">
                <div class="card-header">
                    <button type="button" class="btn btn-primary float-right" id="btnSave" onclick="save()"><?php echo MultiLang('save'); ?></button>
                </div>
                <div class="card-body">
                    <div id="box_msg_whoweare"></div>
                    <form id="form_whoweare" autocomplete="nope">
                        <?php echo $html; ?>
                    </form>
                </div>
                <div class="card-header" style="border-top: 1px solid rgba(0,0,0,.125) !important;">
                    <button type="button" class="btn btn-primary float-right" id="btnSave2" onclick="save()"><?php echo MultiLang('save'); ?></button>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script>


var table;

$(document).ready(function() {
    $("#box_msg_whoweare").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#btnSave2').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave2').attr('disabled',false);
    
    $('.textarea').summernote({
        height: 150,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'view', [ 'fullscreen', 'codeview' ] ]
        ]
    });
            
});


function readURL(input) {

    var fileTypes = ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'];

    $('.msg_images').html('');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        if(input.files[0].size <= 1024000){

            var extension = input.files[0].name.split('.').pop().toLowerCase(),
            isSuccess = fileTypes.indexOf(extension) > -1;

            if(isSuccess){
                reader.onload = function (e) {
                    $('#label_images').hide();
                    $('#show_images').attr('src', e.target.result).fadeOut().fadeIn();
                    $('#file_image_value').val(e.target.result);
                    $('#remove').show();
                };
                reader.readAsDataURL(input.files[0]);
            }else{
                $('#msg_images').html('<?php echo MultiLang('allowed_file_is'); ?> jpg, JPG, jpeg, JPEG, png, PNG, gif, GIF');
            }
        }else{
            $('#msg_images').html('<?php echo MultiLang('max_file_is'); ?> 1024KB');
        }
    }
}

function removeImage()
{
    $('#label_images').show();
    $('#show_images').removeAttr('src').hide();
    $('#file_image_value').val('');
    $('#remove').hide();
    $('.msg_images').html('');
}

function save()
{
    $('#btnSave').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    $('#btnSave2').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnSave2').attr('disabled',true); //set button disable 
    var url = "<?php echo site_url('whoweare/edit')?>";
    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_whoweare').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    $("#box_msg_whoweare").html('').hide();
                    $("#file_image_value_old").val(data.new_file);
                    await toastr.success(data.message);
                }
                else
                {
                    await $('#box_msg_whoweare').html(data.message).fadeOut().fadeIn();
                    $('html').animate({ scrollTop: 0 }, 'slow');
                }
            }else{
                toastr.error(xhr.statusText);
            }

            $('#btnSave').text('<?php echo MultiLang('save'); ?>');
            $('#btnSave').attr('disabled',false);
            $('#btnSave2').text('<?php echo MultiLang('save'); ?>');
            $('#btnSave2').attr('disabled',false);

        }
    });
}

</script>