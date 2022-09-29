<style>
    table th, td {
        padding: 8px !important;

    }
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Diagnosis List</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Diagnosis Registration
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Diagnosis List</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Variable</th>
                                                <th>Label</th>
                                                <th>Action</th>
                                            </tr>

                                            </thead>
                                            <tbody>
                                            <?php
                                            $Sno = 1;
                                            if (isset($myData) && $myData != '') {
                                                foreach ($myData as $k => $r) { ?>
                                                    <tr>
                                                        <td><?php echo $Sno++ ?></td>
                                                        <td><?php echo $r->variable ?></td>
                                                        <td><?php echo $r->label ?></td>
                                                        <td data-id="<?php echo $r->id ?>">
                                                            <?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
                                                                <a href="javascript:void(0)"
                                                                   onclick="getDelete(this)">
                                                                    <i class="feather icon-trash"></i>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Variable</th>
                                                <th>Label</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Modal -->
<!-- END: Content-->
<?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
    <div class="md-fab-wrapper addbtn">
        <a class="md-fab md-fab-accent md-fab-wave-light waves-effect waves-button waves-light"
           href="javascript:void(0)" data-uk-modal="{target:'#addModal'}" id="add">
            <i class="feather icon-plus-circle"></i>
        </a>
    </div>
    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_add"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_add">Add Diagnosis</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="variable_d">Variable: </label>
                        <input type="text" class="form-control" id="variable_d" name="variable_d"
                               autocomplete="variable_d" required>
                    </div>
                    <div class="form-group">
                        <label for="label_d">Label: </label>
                        <input type="text" class="form-control" id="label_d" name="label_d"
                               autocomplete="label_d" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger mybtn" onclick="addData()">Add</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel_delete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete Diagnosis</h4>
                    <input type="hidden" id="delete_id" name="delete_id">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="deleteData()">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function () {
        $('.addbtn').click(function () {
            $('#addModal').modal('show');
        });
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 50,
            "oSearch": {"sSearch": " "},
            autoFill: false,
            attr: {
                autocomplete: 'off'
            },
            initComplete: function () {
                $(this.api().table().container()).find('input[type="search"]').parent().wrap('<form>').parent().attr('autocomplete', 'off').css('overflow', 'hidden').css('margin', 'auto');
            },
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    text: 'JSON',
                    action: function (e, dt, button, config) {
                        var data = dt.buttons.exportData();

                        $.fn.dataTable.fileSave(
                            new Blob([JSON.stringify(data)]),
                            'Export.json'
                        );
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
    });

    function addData() {
        $('#variable_d').css('border', '1px solid #babfc7');
        $('#label_d').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['variable_d'] = $('#variable_d').val();
        data['label_d'] = $('#label_d').val();
        if (data['variable_d'] == '' || data['variable_d'] == undefined) {
            $('#variable_d').css('border', '1px solid red');
            toastMsg('Variable', 'Invalid Variable', 'error');
            flag = 1;
        }
        if (data['label_d'] == '' || data['label_d'] == undefined) {
            $('#label_d').css('border', '1px solid red');
            toastMsg('Label', 'Invalid Label', 'error');
            flag = 1;
        }
        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Diagnosis/addDiagnosis'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#addModal').modal('hide');
                } else if (result == 2) {
                    $('#variable_d').css('border', '1px solid red');
                    toastMsg('Variable', 'Invalid Variable', 'error');
                } else if (result == 3) {
                    $('#label_d').css('border', '1px solid red');
                    toastMsg('Label', 'Invalid Label', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }


    function getDelete(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#delete_id').val(id);
        $('#deleteModal').modal('show');
    }

    function deleteData() {
        var data = {};
        data['idDiagnosis'] = $('#delete_id').val();
        if (data['idDiagnosis'] == '' || data['idDiagnosis'] == undefined || data['idDiagnosis'] == 0) {
            toastMsg('Area', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Diagnosis/deleteData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#deleteModal').modal('hide');
                    toastMsg('Area', 'Successfully Deleted', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Area', 'Something went wrong', 'error');
                } else {
                    toastMsg('Area', 'Invalid Area', 'error');
                }

            });
        }
    }


</script>