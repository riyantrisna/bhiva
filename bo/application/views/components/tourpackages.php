<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><?php echo MultiLang('master_data'); ?></li>
                    <li class="breadcrumb-item active"><?php echo MultiLang('tourpackages'); ?></li>
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
                                <th><?php echo MultiLang('status'); ?></th>
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
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_form"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="box_msg_tourpackages"></div>
				<form id="form_tourpackages" autocomplete="nope">
					
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
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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

<script>

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ( (charCode > 31 && charCode < 48) || charCode > 57) {
        return false;
    }
    return true;
}

function isNumberText(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ( (charCode > 31 && charCode < 48) || charCode > 57) {
        if(charCode == 44 || charCode == 46){
            return true;
        }else{
            return false;
        }
    }
    return true;
}

var table;

$(document).ready(function() {
    table = $('#tables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>tourpackages/data",
            "type": "POST"
        },
        "order": [[ 1, 'asc' ]], //Initial no order.

        "columnDefs": [
            { 
                "targets": [ 0, 3 ], //last column
                "orderable": false, //set not orderable
            },
            { "targets": 3, "width": '120px' }
        ],
    });
});

function cek_total_night(){
    $('#total_night').on('keyup', function(){
        if($('#total_night').val() > $('#total_day').val()){
            
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function readURL(input, i) {

    var fileTypes = ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'];

    $('.msg_images').html('');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        if(input.files[0].size <= 1024000){

            var extension = input.files[0].name.split('.').pop().toLowerCase(),
            isSuccess = fileTypes.indexOf(extension) > -1;

            if(isSuccess){
                reader.onload = function (e) {
                    $('#label_images_'+i).hide();
                    $('#show_images_'+i).attr('src', e.target.result).fadeOut().fadeIn();
                    $('#file_image_value_'+i).val(e.target.result);
                    $('#remove_'+i).show();
                };
                reader.readAsDataURL(input.files[0]);
            }else{
                $('#msg_images_'+i).html('<?php echo MultiLang('allowed_file_is'); ?> jpg, JPG, jpeg, JPEG, png, PNG, gif, GIF');
            }
        }else{
            $('#msg_images_'+i).html('<?php echo MultiLang('max_file_is'); ?> 1024KB');
        }

        
    }
}

function removeImage(i)
{
    $('#label_images_'+i).show();
    $('#show_images_'+i).removeAttr('src').hide();
    $('#file_image_value_'+i).val('');
    $('#remove_'+i).hide();
    $('.msg_images').html('');
}

async function add()
{
    save_method = 'add';
    $('#modal_form').modal('show'); // show bootstrap modal
    await $('#form_tourpackages').html('');
    $('#form_tourpackages')[0].reset(); // reset form on modals
    $("#box_msg_tourpackages").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('add'); ?> <?php echo MultiLang('tourpackages'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('tourpackages/add_view/')?>",
        type: "GET",
        dataType: "JSON",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                
                await $('#form_tourpackages').html(data.html);
                //image
                await $('#remove_file').hide();
                await $('#selector_file').show();
                await $('#file_image_show').hide();
                await $('.textarea').summernote({
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
                await $(".calendar").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $(".curr").mask('00.000.000.000.000.000.000', {reverse: true});
                $(".ratting").mask('0,0', {reverse: true});
            }else{
                toastr.error(xhr.statusText);
            }
            
        }
    });
}

async function edit(id)
{
    save_method = 'edit';
    $('#modal_form').modal('show'); // show bootstrap modal
    await $('#form_tourpackages').html('');
    $('#form_tourpackages')[0].reset(); // reset form on modals
    $("#box_msg_tourpackages").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('edit'); ?> <?php echo MultiLang('tourpackages'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('tourpackages/edit_view/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                await $('#form_tourpackages').html(data.html);
                await $('.textarea').summernote({
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
                await $(".calendar").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $(".curr").mask('00.000.000.000.000.000.000', {reverse: true});
                $(".ratting").mask('0,0', {reverse: true});
            }else{
                toastr.error(xhr.statusText);
            }

        }
    });
}

async function save()
{
    await $('#btnSave').text('<?php echo MultiLang('process'); ?>...'); //change button text
    await $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('tourpackages/add')?>";
    } else {
        url = "<?php echo site_url('tourpackages/edit')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_tourpackages').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    $('#modal_form').modal('toggle');
                    $("#box_msg_tourpackages").html('').hide();
                    await reload_table();
                    await toastr.success(data.message);
                }
                else
                {
                    await $('#box_msg_tourpackages').html(data.message).fadeOut().fadeIn();
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
    $('#title_detail').text('<?php echo MultiLang('detail'); ?> <?php echo MultiLang('tourpackages'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('tourpackages/detail/')?>/" + id,
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
    $('#title_delete').text('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('tourpackages'); ?>'); // Set title to Bootstrap modal title
    $("#body_delete").html('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('tourpackages'); ?> <b>'+name+'</b> ?');
    $('#btnHapus').attr("onclick", "process_delete('"+id+"')");
}

function process_delete(id)
{
    $('#btnHapus').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnHapus').attr('disabled',true); //set button disable 

    $.ajax({
        url : "<?php echo site_url('tourpackages/delete/')?>/" + id,
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

function isEmpty(str) {
    return (!str || 0 === str.length);
}

async function add_price(){
    str = '';
    str+= '<tr>';
    str+= '<td>';
    str+= '    <input type="text" name="start[]" class="form-control calendar" placeholder="yyyy-mm-dd">';
    str+= '</td>';
    str+= '<td>';
    str+= '    <input type="text" name="end[]" class="form-control calendar" placeholder="yyyy-mm-dd">';
    str+= '</td>';
    str+= '<td>';
    str+= '   <input type="text" class="form-control curr" name="price_local[]">';
    str+= '</td>';
    str+= '<td>';
    str+= '    <input type="text" class="form-control curr" name="price_foreign[]">';
    str+= '</td>';
    str+= '<td>';
    str+= '    <button type="button" class="btn btn-danger" onclick="delete_price(this)"><i class="fas fa-trash-alt"></i></button>';
    str+= '</td>';
    str+= '</tr>';
    
    await $('#table_price').append(str);
    await $(".curr").mask('00.000.000.000.000.000.000', {reverse: true});
    await $(".calendar").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
}

function delete_price(tr){
    $(tr).parent().parent().remove();
}

async function add_destination(){
    var destination = <?php echo $destination; ?>;
    str = '';
    str+= '<tr>';
    str+= '<td>';
    str+=      '<select name="destination[]" class="form-control">';
    str+=           '<option value="">';
    str+=               '-- <?php echo MultiLang('select'); ?> --';
    str+=           '</option>';
    if(!isEmpty(destination)){
        $.each( destination, function( key, value ) {
    str+=           '<option value="'+value.id+'">';
    str+=                value.name;
    str+=           '</option>';
        });
    }
    str+=      '</select>';
    str+= '</td>';
    str+= '<td>';
    str+= '    <input type="number" name="day[]" class="form-control" onkeypress="return isNumber(event)">';
    str+= '</td>';
    str+= '<td>';
    str+= '    <input type="number" name="order[]" class="form-control" onkeypress="return isNumber(event)">';
    str+= '</td>';
    str+= '<td style="text-align: center;">';
    str+= '    <button type="button" class="btn btn-danger" onclick="delete_destination(this)"><i class="fas fa-trash-alt"></i></button>';
    str+= '</td>';
    str+= '</tr>';
    
    await $('#table_destination').append(str);
}

function delete_destination(tr){
    $(tr).parent().parent().remove();
}

function totestimony(id)
{
    $.ajax({
        url : "<?php echo base_url(); ?>tourpackages/setid",
        type: "POST",
        data: {"id": id},
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    window.location.href = "<?php echo base_url(); ?>tourpackagestestimony";
                }
                else
                {
                    window.location.href = "<?php echo base_url(); ?>tourpackages";
                }
            }else{
                
            }

        }
    });
}
</script>