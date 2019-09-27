<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><?php echo MultiLang('master_data'); ?></li>
                    <li class="breadcrumb-item active"><?php echo MultiLang('ticket'); ?></li>
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
				<div id="box_msg_ticket"></div>
				<form id="form_ticket" autocomplete="nope">
					
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

var table;

$(document).ready(function() {
    table = $('#tables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>ticket/data",
            "type": "POST"
        },
        "order": [[ 1, 'asc' ]], //Initial no order.

        "columnDefs": [
            { 
                "targets": [ 0,3 ], //last column
                "orderable": false, //set not orderable
            },
            { "targets": 3, "width": '120px' }
        ],
    });
});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function add()
{
    save_method = 'add';
    $('#form_ticket')[0].reset(); // reset form on modals
    $("#box_msg_ticket").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('add'); ?> <?php echo MultiLang('ticket'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('ticket/add_view/')?>",
        type: "GET",
        dataType: "JSON",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                await $('#form_ticket').html(data.html);
                $(".curr").mask('00.000.000.000.000.000.000,00', {reverse: true});
                await $(".calendar").datepicker({
                    format: 'yyyy-mm-dd'
                });
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
    $('#form_ticket')[0].reset(); // reset form on modals
    $("#box_msg_ticket").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('edit'); ?> <?php echo MultiLang('ticket'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('ticket/edit_view/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                await $('#form_ticket').html(data.html);
                $(".curr").mask('00.000.000.000.000.000.000,00', {reverse: true});
                await $(".calendar").datepicker({
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
        url = "<?php echo site_url('ticket/add')?>";
    } else {
        url = "<?php echo site_url('ticket/edit')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_ticket').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    $('#modal_form').modal('toggle');
                    $("#box_msg_ticket").html('').hide();
                    await reload_table();
                    await toastr.success(data.message);
                }
                else
                {
                    await $('#box_msg_ticket').html(data.message).fadeOut().fadeIn();
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
    $('#title_detail').text('<?php echo MultiLang('detail'); ?> <?php echo MultiLang('ticket'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('ticket/detail/')?>/" + id,
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
    $('#title_delete').text('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('ticket'); ?>'); // Set title to Bootstrap modal title
    $("#body_delete").html('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('ticket'); ?> <b>'+name+'</b> ?');
    $('#btnHapus').attr("onclick", "process_delete('"+id+"')");
}

function process_delete(id)
{
    $('#btnHapus').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnHapus').attr('disabled',true); //set button disable 

    $.ajax({
        url : "<?php echo site_url('ticket/delete/')?>/" + id,
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

async function add_price(i){
    var visitortype = <?php echo $visitortype; ?>;
    str = '';
    str+= '<tr>';
    str+= '<td>';
    str+= '    <input type="text" name="start[]" class="form-control calendar" placeholder="yyyy-mm-dd">';
    str+= '</td>';
    str+= '<td>';
    str+= '    <input type="text" name="end[]" class="form-control calendar" placeholder="yyyy-mm-dd">';
    str+= '</td>';
    str+= '<td>';
    str+=      '<select name="visitortype[]" class="form-control">';
    str+=           '<option value="">';
    str+=               '-- <?php echo MultiLang('select'); ?> --';
    str+=           '</option>';
    if(!isEmpty(visitortype)){
        $.each( visitortype, function( key, value ) {
    str+=           '<option value="'+value.id+'">';
    str+=                value.name;
    str+=           '</option>';
        });
    }
    str+=      '</select>';
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
    await $(".curr").mask('00.000.000.000.000.000.000,00', {reverse: true});
    await $(".calendar").datepicker({
        format: 'yyyy-mm-dd'
    });
}

function delete_price(tr){
    $(tr).parent().parent().remove();
}
</script>