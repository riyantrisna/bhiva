<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item active"><?php echo MultiLang('transaction'); ?></li>
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
                    <form action="#" id="form-filter" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-4" style="text-align: left;"><?php echo MultiLang('transaction_id'); ?></label>
                                <div class="col-md-4">
                                    <input name="number" id="number" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" style="text-align: left;"><?php echo MultiLang('type'); ?></label>
                                <div class="col-md-4">
                                    <select name="type" id="type" class="form-control">
                                        <option value="">
                                            -- <?php echo MultiLang('all'); ?> --
                                        </option>
                                        <option value="1">
                                            <?php echo MultiLang('tourpackages'); ?>
                                        </option>
                                        <option value="2">
                                            <?php echo MultiLang('ticket'); ?>
                                        </option>
                                    </select>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" style="text-align: left;"><?php echo MultiLang('status'); ?></label>
                                <div class="col-md-4">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">
                                            -- <?php echo MultiLang('all'); ?> --
                                        </option>
                                        <option value="1">
                                            <?php echo MultiLang('waiting_for_payment'); ?>
                                        </option>
                                        <option value="2">
                                            <?php echo MultiLang('payment_successful'); ?>
                                        </option>
                                        <option value="3">
                                            <?php echo MultiLang('expired_order'); ?>
                                        </option>
                                        <option value="4">
                                            <?php echo MultiLang('on_hold'); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4"></label>
                                <div class="col-md-4">
                                    <button type="button" id="btn-filter" class="btn btn-primary"><?php echo MultiLang('search'); ?></button>
                                    <button type="button" id="btn-reset" class="btn btn-default"><?php echo MultiLang('reset'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card col-sm-12">
                <div class="card-body">
                    <table id="tables" class="table table-bordered table-hover dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th><?php echo MultiLang('number'); ?></th>
                                <th><?php echo MultiLang('transaction_id'); ?></th>
                                <th><?php echo MultiLang('transaction_date'); ?></th>
                                <th><?php echo MultiLang('type'); ?></th>
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
				<div id="box_msg_transaction"></div>
				<form id="form_transaction" enctype="multipart/form-data">
					
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo MultiLang('close'); ?></button>
				<button type="button" class="btn btn-primary" id="btnSave" onclick="send()"><?php echo MultiLang('send_ticket'); ?></button>
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
<style>
.file-upload input[type='file'] {
  display: none;
}

.rounded-lg {
  border-radius: 1rem;
}

.custom-file-label.rounded-pill {
  border-radius: 50rem;
}

.custom-file-label.rounded-pill::after {
  border-radius: 0 50rem 50rem 0;
}
</style>
<script>
var table;

$(document).ready(function() {
    table = $('#tables').DataTable({
        "searching" : false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>transaction/data",
            "type": "POST",
            "data": function(d){
                d.number = $('#number').val();
                d.type = $('#type').val();
                d.status = $('#status').val();
            }
        },
        "order": [[ 2, 'desc' ]], //Initial no order.

        "columnDefs": [
            { 
                "targets": [ 0,5 ], //last column
                "orderable": false, //set not orderable
            },
            { "targets": 5, "width": '120px' }
        ],
    });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });

    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table
    });

    $('input[type=text]').on('keydown', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            table.ajax.reload();
        }
    });

});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function detail(id)
{
    $('#title_detail').text('<?php echo MultiLang('detail'); ?> <?php echo MultiLang('transaction'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('transaction/detail/')?>" + id,
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

function send_ticket(id)
{
    save_method = 'edit';
    // $('#form_transaction')[0].reset(); // reset form on modals
    $("#box_msg_transaction").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('send_ticket'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('send_ticket'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('transaction/send_ticket/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                $('#form_transaction').html(data.html);
            }else{
                toastr.error(xhr.statusText);
            }

            $('#modal_form').modal('show'); // show bootstrap modal

        }
    });
}

function upload_file_ticket(){
    var fd = new FormData(); 
    var files = $('#file_ticket')[0].files[0]; 
    var ticket_code = $('#ticket_code').val(); 
    var transaction_id = $('#transaction_id').val(); 
    fd.append('file_ticket', files); 
    fd.append('ticket_code', ticket_code); 
    fd.append('transaction_id', transaction_id); 

    $.ajax({ 
        url: '<?php echo base_url(); ?>transaction/upload_file_ticket', 
        type: 'post', 
        data: fd, 
        contentType: false, 
        processData: false, 
        dataType: "JSON",
        success: function(data, textStatus, xhr){ 
            console.log(data);
            if(xhr.status == '200'){
                if(data.status_upload){ 
                    $('#result_ticket_file').fadeOut().fadeIn().html(data.msg +' '+data.file_download);
                }else{ 
                    $('#result_ticket_file').fadeOut().fadeIn().html(data.msg);
                } 
            }else{
                toastr.error(xhr.statusText);
            }
        }, 
    });
}

function status_ticket(){
    var status =  $('#ticket_status').val();
    var transaction_id =  $('#transaction_id').val();
    $.ajax({
        url : '<?php echo base_url(); ?>transaction/update_status_ticket',
        type: "POST",
        data: {'status': status, 'transaction_id': transaction_id},
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                $('#result_ticket_status').fadeOut().fadeIn().html(data.msg);
            }else{
                toastr.error(xhr.statusText);
            }

        }
    });
}

function add_ticket_number(){

    var number =  $('#input_ticket_number').val();
    var transaction_id =  $('#transaction_id').val();
    var ticket_id =  $('#ticket_id').val();

    str = '';
    str+= '<tr>';
    str+= '<td>';
    str+= number;
    str+= '</td>';
    str+= '<td class="text-center">';
    str+= '    <button type="button" class="btn btn-danger" onclick="delete_ticket_number(this, \''+number+'\')"><i class="fas fa-trash-alt"></i></button>';
    str+= '</td>';
    str+= '</tr>';

    
    $.ajax({
        url : '<?php echo base_url(); ?>transaction/add_number_ticket',
        type: "POST",
        data: {'number': number, 'transaction_id': transaction_id, 'ticket_id': ticket_id},
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status_add){
                    await $('#tr_no_data').remove();
                    await $('#table_number_ticket').append(str);
                    $('#input_ticket_number').val('').focus();
                }
                $('#result_ticket_number').fadeOut().fadeIn().html(data.msg);
            }else{
                toastr.error(xhr.statusText);
            }

        }
    });

}

function delete_ticket_number(tr, number){

    var transaction_id =  $('#transaction_id').val();
    $.ajax({
        url : '<?php echo base_url(); ?>transaction/delete_number_ticket',
        type: "POST",
        data: {'number': number, 'transaction_id': transaction_id},
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status_delete){
                    $(tr).parent().parent().remove();
                }
                if(data.tr_content != ''){
                    await $('#table_number_ticket').append(data.tr_content);
                }
                $('#result_ticket_number').fadeOut().fadeIn().html(data.msg);
            }else{
                toastr.error(xhr.statusText);
            }

        }
    });
    
}

function send()
{
    $('#btnSave').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('transaction/send_mail')?>";

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_transaction').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    $('#modal_form').modal('toggle');
                    await reload_table();
                    await toastr.success(data.message);
                }
                else
                {
                    toastr.error(data.message);
                }
            }else{
                $('#modal_form').modal('toggle');
                await reload_table();
                toastr.error(xhr.statusText);
            }

            $('#btnSave').text('<?php echo MultiLang('send_ticket'); ?>');
            $('#btnSave').attr('disabled',false);

        }
    });
}

</script>