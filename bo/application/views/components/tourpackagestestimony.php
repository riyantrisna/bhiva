<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><?php echo MultiLang('cms'); ?></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>tourpackages"><?php echo MultiLang('tourpackages'); ?></a></li>
                    <li class="breadcrumb-item active"><?php echo MultiLang('tourpackagestestimony').' <b>('.$name.')</b>'; ?></li>
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
                    <table id="tables" class="table table-bordered table-hover dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th><?php echo MultiLang('number'); ?></th>
                                <th><?php echo MultiLang('user'); ?></th>
                                <th><?php echo MultiLang('date'); ?></th>
                                <th><?php echo MultiLang('rating'); ?></th>
                                <th><?php echo MultiLang('is_process'); ?></th>
                                <th><?php echo MultiLang('is_publish'); ?></th>
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
				<div id="box_msg_tourpackagestestimony"></div>
				<form id="form_tourpackagestestimony" autocomplete="nope">
					
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

var table;

$(document).ready(function() {
    table = $('#tables').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>tourpackagestestimony/data/<?php echo $id;?>",
            "type": "POST"
        },
        "order": [[ 2, 'asc' ]], //Initial no order.

        "columnDefs": [
            { 
                "targets": [ 0,6 ], //last column
                "orderable": false, //set not orderable
            },
            { "targets": 2, "width": '200px' },
            { "targets": 6, "width": '150px' }
            
        ],
    });
});

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function edit(id, type, name)
{
    $('#modal_delete').modal('show'); // show bootstrap modal when complete loaded
    
    if(type=='unpublished'){
        $('#btnHapus').text('<?php echo MultiLang('unpublish'); ?>');
        $('#title_delete').text('<?php echo MultiLang('unpublish'); ?> <?php echo MultiLang('testimony'); ?>'); // Set title to Bootstrap modal title
        $("#body_delete").html('<?php echo MultiLang('unpublish'); ?> <?php echo MultiLang('testimony'); ?> <b>'+name+'</b> ?');
    }else{
        $('#btnHapus').text('<?php echo MultiLang('publish'); ?>');
        $('#title_delete').text('<?php echo MultiLang('publish'); ?> <?php echo MultiLang('testimony'); ?>'); // Set title to Bootstrap modal title
        $("#body_delete").html('<?php echo MultiLang('publish'); ?> <?php echo MultiLang('testimony'); ?> <b>'+name+'</b> ?');
    }
    $('#btnHapus').attr("onclick", "save('"+id+"','"+type+"')");
}

function save(id, type)
{
    $('#btnSave').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('tourpackagestestimony/edit')?>";

    $.ajax({
        url : url,
        type: "POST",
        data: {'id': id, 'type': type},
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                toastr.success(data.message);
                reload_table();
            }else{
                toastr.error(xhr.statusText);
            }

            $('#btnHapus').attr('disabled',false);
            $('#modal_delete').modal('toggle');

        }
    });
}

function detail(id)
{
    $('#title_detail').text('<?php echo MultiLang('detail'); ?> <?php echo MultiLang('tourpackagestestimony'); ?>'); // Set Title to Bootstrap modal title

    $.ajax({
        url : "<?php echo site_url('tourpackagestestimony/detail/')?>" + id,
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
    $('#title_delete').text('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('tourpackagestestimony'); ?>'); // Set title to Bootstrap modal title
    $("#body_delete").html('<?php echo MultiLang('delete'); ?> <?php echo MultiLang('tourpackagestestimony'); ?> <b>'+name+'</b> ?');
    $('#btnHapus').attr("onclick", "process_delete('"+id+"')");
    $('#btnHapus').text('<?php echo MultiLang('delete'); ?>');
}

function process_delete(id)
{
    $('#btnHapus').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnHapus').attr('disabled',true); //set button disable 

    $.ajax({
        url : "<?php echo site_url('tourpackagestestimony/delete/')?>/" + id,
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