<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item active"><?php echo MultiLang('venue_schedule'); ?></li>
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
                                <label class="control-label col-md-4" style="text-align: left;"><?php echo MultiLang('venue'); ?></label>
                                <div class="col-md-4">
                                    <select name="venue_id" id="venue_id" class="form-control">
                                        <option value="">
                                            -- <?php echo MultiLang('all'); ?> --
                                        </option>
                                        <?php
                                        if(!empty($list_venue)){
                                            foreach ($list_venue as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id;?>">
                                            <?php echo $value->name;?>
                                        </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4" style="text-align: left;"><?php echo MultiLang('schedule_date'); ?></label>
                                <div class="col-md-4">
                                    <input type="text" id="schedule_date" name="schedule_date" class="form-control dates">
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
                    <button type="button" class="btn btn-success mb-4" onclick="add()"><i class="fas fa-plus mr-2"></i> <?php echo MultiLang('add'); ?></button>
                    <table id="tables" class="table table-bordered table-hover dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th><?php echo MultiLang('number'); ?></th>
                                <th><?php echo MultiLang('venue'); ?></th>
                                <th><?php echo MultiLang('start_date'); ?></th>
                                <th><?php echo MultiLang('end_date'); ?></th>
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
				<div id="box_msg_venueschedule"></div>
				<form id="form_venueschedule" autocomplete="nope">
					
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
$(document).ready(function() {
    $(".dates").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    
});
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
        "searching" : false,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>venueschedule/data",
            "type": "POST",
            "data": function(d){
                d.venue_id = $('#venue_id').val();
                d.schedule_date = $('#schedule_date').val();
            }
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

    $('#date_start, #date_end').click(function(){
        if($('#date_end').val() != ''){
            var date_end = new Date($('#date_end').val());
            date_end.setDate(date_end.getDate() + 1);
            $(".dates_start").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                endDate: date_end
            });
        }else{
            $(".dates_start").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }

        if($('#date_start').val() != ''){
            var date_start = new Date($('#date_start').val());
            date_start.setDate(date_start.getDate() + 1);
            $(".dates_end").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                startDate: date_start
            });
        }else{
            $(".dates_end").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }
    });
});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function add()
{
    save_method = 'add';
    $('#form_venueschedule')[0].reset(); // reset form on modals
    $("#box_msg_venueschedule").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('add'); ?> <?php echo MultiLang('venue_schedule'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('venueschedule/add_view/')?>",
        type: "GET",
        dataType: "JSON",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                await $('#form_venueschedule').html(data.html);

                $(".dates_start").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $(".dates_end").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });

                // $('#date_start, #date_end').click(function(){
                //     if($('#date_end').val() != ''){
                //         var date_end = new Date($('#date_end').val());
                //         date_end.setDate(date_end.getDate() + 1);
                //         $(".dates_start").datepicker({
                //             format: 'yyyy-mm-dd',
                //             autoclose: true,
                //             endDate: date_end
                //         });
                //     }else{
                //         $(".dates_start").datepicker({
                //             format: 'yyyy-mm-dd',
                //             autoclose: true
                //         });
                //     }

                //     if($('#date_start').val() != ''){
                //         var date_start = new Date($('#date_start').val());
                //         date_start.setDate(date_start.getDate() + 1);
                //         $(".dates_end").datepicker({
                //             format: 'yyyy-mm-dd',
                //             autoclose: true,
                //             startDate: date_start
                //         });
                //     }else{
                //         $(".dates_end").datepicker({
                //             format: 'yyyy-mm-dd',
                //             autoclose: true
                //         });
                //     }
                // });
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
    $('#form_venueschedule')[0].reset(); // reset form on modals
    $("#box_msg_venueschedule").html('').hide();
    $('#btnSave').text('<?php echo MultiLang('save'); ?>');
    $('#btnSave').attr('disabled',false);
    $('#title_form').text('<?php echo MultiLang('edit'); ?> <?php echo MultiLang('venue_schedule'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('venueschedule/edit_view/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                await $('#form_venueschedule').html(data.html);
                $(".dates_start").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $(".dates_end").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
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
        url = "<?php echo site_url('venueschedule/add')?>";
    } else {
        url = "<?php echo site_url('venueschedule/edit')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_venueschedule').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    $('#modal_form').modal('toggle');
                    $("#box_msg_venueschedule").html('').hide();
                    await reload_table();
                    await toastr.success(data.message);
                }
                else
                {
                    await $('#box_msg_venueschedule').html(data.message).fadeOut().fadeIn();
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
    $('#title_detail').text('<?php echo MultiLang('detail'); ?> <?php echo MultiLang('venue_schedule'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('venueschedule/detail/')?>/" + id,
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
    $('#title_delete').text('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('venue_schedule'); ?>'); // Set title to Bootstrap modal title
    $("#body_delete").html('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('venue_schedule'); ?> <b>'+name+'</b> ?');
    $('#btnHapus').attr("onclick", "process_delete('"+id+"')");
}

function process_delete(id)
{
    $('#btnHapus').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnHapus').attr('disabled',true); //set button disable 

    $.ajax({
        url : "<?php echo site_url('venueschedule/delete/')?>/" + id,
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