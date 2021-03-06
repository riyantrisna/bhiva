<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><?php echo MultiLang('setting'); ?></li>
                    <li class="breadcrumb-item active"><?php echo MultiLang('language'); ?></li>
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
                <div class="card-body">
                    <button type="button" class="btn btn-success mb-4" onclick="add()"><i class="fas fa-plus mr-2"></i> <?php echo MultiLang('add'); ?></button>
                    <table id="tables" class="table table-bordered table-hover dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th><?php echo MultiLang('number'); ?></th>
                                <th><?php echo MultiLang('code'); ?></th>
                                <th><?php echo MultiLang('language'); ?></th>
                                <th><?php echo MultiLang('icon'); ?></th>
                                <th><?php echo MultiLang('action'); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal Form -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_form"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="box_msg_language"></div>
				<form id="form_language">
					<div class="form-group">
						<label for="code"><?php echo MultiLang('code'); ?> *</label>
						<input type="text" id="code" name="code" class="form-control">
					</div>
					<div class="form-group">
						<label for="language"><?php echo MultiLang('language'); ?> *</label>
						<input type="text" id="language" name="language" class="form-control">
					</div>
					<div class="form-group">
                        <label for="file_icon"><?php echo MultiLang('icon'); ?> *</label>
                        <br>
                        <div class="row">
                            <div class="col" style="text-align: center; height: 125px;">
                                <label id="label_images" for="images" style="cursor: pointer;">
                                    <img style="width:80px; height:80px; border:1px dashed #C3C3C3;" src="../assets/images/upload-image.png" />
                                </label>
                                
                                <input type="file" name="images" id="images" style="display:none;" onchange="readURL(this)" accept="image/*"/>

                                <img style="width:80px; height:80px; border:1px dashed #C3C3C3; margin-bottom: 5px; display:none;" id="show_images" />
                                <br>
                                <div style="height: 40px;">
                                    <span id="remove" class="btn btn-warning" onclick="removeImage()" style="cursor: pointer; margin-bottom: 5px; display:none;">
                                        <?php echo MultiLang('delete');?>
                                    </span>
                                    <span class="msg_images" id="msg_images" style="color: red;"></span>
                                </div>

                                <input type="hidden" id="file_icon_value" name="file_icon_value"/>
                                <input type="hidden" id="file_icon_value_old" name="file_icon_value_old"/>
                                <input type="hidden" id="code_old" name="code_old"/>
                            </div>
                        </div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo MultiLang('close'); ?></button>
				<button type="button" class="btn btn-primary" id="btnSave" onclick="save()"><?php echo MultiLang('save'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_detail"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="body_detail">
                <div class="form-body">
                    <div class="form-group">
                        <label for="detail_code"><?php echo MultiLang('code'); ?></label>
                        <div id="detail_code"></div>
                    </div>
                    <div class="form-group">
                        <label for="detail_language"><?php echo MultiLang('language'); ?></label>
                        <div id="detail_language"></div>
                    </div>
                    <div class="form-group">
                        <label for="file_icon_show_detail"><?php echo MultiLang('icon'); ?></label>
                        <br>
                        <img id="file_icon_show_detail" src="#" class="mt-2"/>
                    </div>
                    <div class="form-group">
                        <label for="inserted"><?php echo MultiLang('inserted');?></label>
                        <div id="inserted"></div>
                    </div>
                    <div class="form-group">
                        <label for="updated"><?php echo MultiLang('updated');?></label>
                        <div id="updated"></div>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo MultiLang('close'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_delete"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="body_delete">
                
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnHapus"><?php echo MultiLang('delete'); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo MultiLang('close'); ?></button>
			</div>
		</div>
	</div>
</div>

<style>
.btn-files {
    position: relative;
    overflow: hidden;
}
.btn-files input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>

<script>
var table;
var save_method;

$(document).ready(function() {
    $('#show_images').hide();
    $('#remove_file').hide();
    $('#selector_file').show();

    table = $('#tables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>language/data",
            "type": "POST"
        },
        "order": [[ 1, 'asc' ]], //Initial no order.

        "columnDefs": [
            { 
                "targets": [ 0,3,4 ], //last column
                "orderable": false, //set not orderable
            },
            { "targets": 4, "width": '120px' },
            {"targets": 0, "width": '80px'}
        ],
    });
});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function readURL(input) {

    var fileTypes = ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'];

    $('.msg_images').html('');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        if(input.files[0].size <= 512000){

            var extension = input.files[0].name.split('.').pop().toLowerCase(),
            isSuccess = fileTypes.indexOf(extension) > -1;

            if(isSuccess){
                reader.onload = function (e) {
                    $('#label_images').hide();
                    $('#show_images').attr('src', e.target.result).css({"width":"80px", "height":"80px"}).fadeOut().fadeIn();
                    $('#file_icon_value').val(e.target.result);
                    $('#remove').show();
                };
                reader.readAsDataURL(input.files[0]);
            }else{
                $('#msg_images').html('<?php echo MultiLang('allowed_file_is'); ?> jpg, JPG, jpeg, JPEG, png, PNG, gif, GIF');
            }
        }else{
            $('#msg_images').html('<?php echo MultiLang('max_file_is'); ?> 512KB');
        }
    }
}

function removeImage()
{
    $('#label_images').show();
    $('#show_images').removeAttr('src').hide();
    $('#file_icon_value').val('');
    $('#remove').hide();
    $('.msg_images').html('');
}

function add()
{
    save_method = 'add';
    $('#form_language')[0].reset(); // reset form on modals
    $('[name="code"]').attr('disabled', false);
    $('#title_form').text('<?php echo MultiLang('add'); ?> <?php echo MultiLang('language'); ?>'); // Set Title to Bootstrap modal title
    $('#modal_form').modal('show'); // show bootstrap modal
    $("#box_msg_language").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);

    $('#label_images').show();
    $('#show_images').removeAttr('src').hide();
    $('#file_icon_value').val('');
    $('#remove').hide();
    $('.msg_images').html('');
   
}

function edit(id)
{
    save_method = 'edit';
    $('#form_language')[0].reset();
    $("#box_msg_language").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('edit'); ?> <?php echo MultiLang('language'); ?>');

    $('#label_images').show();
    $('#show_images').removeAttr('src').hide();
    $('#file_icon_value').val('');
    $('#remove').hide();
    $('.msg_images').html('');
    
    $.ajax({
        url : "<?php echo site_url('language/detail/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                $('[name="code_old"]').val(data.code);
                $('[name="code"]').val(data.code).attr('disabled', true);
                $('[name="language"]').val(data.language);
                var icon = data.icon_file;
                if(icon){
                    $('#remove').show();
                    $('#label_images').hide();
                    $('#file_icon_value').val(data.icon_file_b64);
                    $('#file_icon_value_old').val(data.icon_file);
                    $('#show_images').attr('src', data.icon).css({"width":"80px", "height":"80px"}).fadeOut().fadeIn();
                }

                $('#modal_form').modal('show');
            }else{
                toastr.error(xhr.statusText);
            }

        }
    });
}

function save()
{
    $('#btnSave').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('language/add')?>";
    } else {
        url = "<?php echo site_url('language/edit')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_language').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    $('#modal_form').modal('toggle');
                    $("#box_msg_language").html('').hide();
                    await reload_table();
                    await toastr.success(data.message);
                }
                else
                {
                    $('#box_msg_language').html(data.message).fadeOut().fadeIn();
                    $('#modal_form').animate({ scrollTop: 0 }, 'slow');
                }
            }else{
                $('#modal_form').modal('toggle');
                toastr.error(xhr.statusText);
            }

            $('#btnSave').text('<?php echo MultiLang('save'); ?>');
            $('#btnSave').attr('disabled',false);

        }
    });
}

function detail(id)
{
    $('#file_icon_show_detail').hide();
    $('#title_detail').text('<?php echo MultiLang('detail'); ?> <?php echo MultiLang('language'); ?>');
    
    $.ajax({
        url : "<?php echo site_url('language/detail/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                $('#detail_code').html(data.code);
                $('#detail_language').html(data.language);
                var icon = data.icon_file;
                if(icon){
                    $('#file_icon_show_detail').attr('src', data.icon).css( "maxWidth","80px").fadeOut().fadeIn();
                }
                $('#inserted').html(data.inserted);
                $('#updated').html(data.updated);

                $('#modal_detail').modal('show');
            }else{
                toastr.error(xhr.statusText);
            }

        }
    });
}

function deletes(id,name)
{
    $('#modal_delete').modal('show'); // show bootstrap modal when complete loaded
    $('#title_delete').text('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('language'); ?>'); // Set title to Bootstrap modal title
    $("#body_delete").html('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('language'); ?> <b>'+name+'</b> ?');
    $('#btnHapus').attr("onclick", "process_delete('"+id+"')");
}

function process_delete(id)
{
    $('#btnHapus').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnHapus').attr('disabled',true); //set button disable 

    $.ajax({
        url : "<?php echo site_url('language/delete/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                toastr.success(data.message);
                reload_table();
            }else{
                toastr.error(xhr.statusText);
            }

            $('#btnHapus').text('<?php echo MultiLang('delete'); ?>');
            $('#btnHapus').attr('disabled',false);
            $('#modal_delete').modal('toggle');

        }
    });
}

</script>