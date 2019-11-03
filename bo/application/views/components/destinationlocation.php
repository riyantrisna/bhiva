<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><?php echo MultiLang('setting'); ?></li>
                    <li class="breadcrumb-item active"><?php echo MultiLang('destination_location'); ?></li>
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
                                <th><?php echo MultiLang('name'); ?></th>
                                <th><?php echo MultiLang('order'); ?></th>
                                <th><?php echo MultiLang('is_show_home'); ?></th>
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
				<div id="box_msg_destinationlocation"></div>
				<form id="form_destinationlocation" autocomplete="nope">
					
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

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ( (charCode > 31 && charCode < 48) || charCode > 57) {
        return false;
    }
    return true;
}

var table;

$(document).ready(function() {
    table = $('#tables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>destinationlocation/data",
            "type": "POST"
        },
        "order": [[ 1, 'asc' ]], //Initial no order.

        "columnDefs": [
            { 
                "targets": [ 0,4 ], //last column
                "orderable": false, //set not orderable
            },
            { "targets": 4, "width": '120px' }
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
                    $('#show_images').attr('src', e.target.result).fadeOut().fadeIn();
                    $('#file_photo_value').val(e.target.result);
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
    $('#file_photo_value').val('');
    $('#remove').hide();
    $('.msg_images').html('');
}

function add()
{
    save_method = 'add';
    $('#form_destinationlocation')[0].reset(); // reset form on modals
    $("#box_msg_destinationlocation").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('add'); ?> <?php echo MultiLang('destination_location'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('destinationlocation/add_view/')?>",
        type: "GET",
        dataType: "JSON",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                await $('#form_destinationlocation').html(data.html);
                await $("#birthday").datepicker({
                    format: 'yyyy-mm-dd'
                });
                //image
                await $('#remove_file').hide();
                await $('#selector_file').show();
                await $('#file_photo_show').hide();
            }else{
                toastr.error(xhr.statusText);
            }
            $('#modal_form').modal('show'); // show bootstrap modal
        }
    });
}

function edit(id)
{
    save_method = 'edit';
    $('#form_destinationlocation')[0].reset(); // reset form on modals
    $("#box_msg_destinationlocation").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('edit'); ?> <?php echo MultiLang('destination_location'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('destinationlocation/edit_view/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                await $('#form_destinationlocation').html(data.html);
                await $("#birthday").datepicker({
                    format: 'yyyy-mm-dd'
                });
            }else{
                toastr.error(xhr.statusText);
            }

            $('#modal_form').modal('show'); // show bootstrap modal

        }
    });
}

function save()
{
    $('#btnSave').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('destinationlocation/add')?>";
    } else {
        url = "<?php echo site_url('destinationlocation/edit')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_destinationlocation').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    $('#modal_form').modal('toggle');
                    $("#box_msg_destinationlocation").html('').hide();
                    await reload_table();
                    await toastr.success(data.message);
                }
                else
                {
                    await $('#box_msg_destinationlocation').html(data.message).fadeOut().fadeIn();
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
    $('#title_detail').text('<?php echo MultiLang('detail'); ?> <?php echo MultiLang('destination_location'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('destinationlocation/detail/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                $('#body_detail').html(data.html);
            }else{
                toastr.error(xhr.statusText);
            }

            $('#modal_detail').modal('show'); // show bootstrap modal

        }
    });
}

function deletes(id,name)
{
    $('#modal_delete').modal('show'); // show bootstrap modal when complete loaded
    $('#title_delete').text('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('destination_location'); ?>'); // Set title to Bootstrap modal title
    $("#body_delete").html('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('destination_location'); ?> <b>'+name+'</b> ?');
    $('#btnHapus').attr("onclick", "process_delete('"+id+"')");
}

function process_delete(id)
{
    $('#btnHapus').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnHapus').attr('disabled',true); //set button disable 

    $.ajax({
        url : "<?php echo site_url('destinationlocation/delete/')?>/" + id,
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