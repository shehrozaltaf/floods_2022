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
                        <h2 class="content-header-title float-left mb-0">Staff List</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Staff Registration
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <section class="basic-select2">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select"
                                                        id="district_select">
                                                    <option value="0" readonly disabled selected>District</option>
                                                    <?php if (isset($district) && $district != '') {
                                                        foreach ($district as $k => $d) {
                                                            echo '<option value="' . $d->dist_id . '" ' . (isset($slug_district) && $slug_district == $d->dist_id ? "selected" : "") . '>' . $d->district . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary" onclick="searchData()">Get
                                                Data
                                            </button>
                                            <?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
                                                <button type="button" class="btn btn-danger" onclick="addModal()">
                                                    Add
                                                    Staff
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (isset($slug_filter) && $slug_filter != '' && $slug_filter != 0) { ?>
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Staff List</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>District</th>
                                                    <th>Type</th>
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                    <th>Action</th>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $k => $r) { ?>
                                                        <tr>
                                                            <td><?php echo $r->name ?></td>
                                                            <td><?php echo $r->district ?></td>
                                                            <td><?php echo $r->type ?></td>
                                                            <td><?php echo $r->dept ?></td>
                                                            <td><?php echo $r->designation ?></td>
                                                            <td data-id="<?php echo $r->id ?>">
                                                                <?php
                                                                if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="getEdit(this)"><i
                                                                                class="feather icon-edit"></i> </a>
                                                                <?php } ?>
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
                                                    <th>Name</th>
                                                    <th>District</th>
                                                    <th>Type</th>
                                                    <th>Department</th>
                                                    <th>Designation</th>
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
            <?php } ?>
        </div>
    </div>
</div>

<input type="hidden" id="hidden_slug_district"
       value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : ''); ?>">
<input type="hidden" id="hidden_slug_filter"
       value="<?php echo(isset($slug_filter) && $slug_filter != '' ? $slug_filter : ''); ?>">
<!-- Modal -->
<!-- END: Content-->
<?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>

    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_add"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_add">Add Staff</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_name">Name: </label>
                        <input type="text" class="form-control" id="user_name" name="user_name"
                               autocomplete="user_name" required>
                    </div>
                    <div class="form-group">
                        <label for="dist_id">District: </label>
                        <select class="select2 form-control dist_id"
                                id="dist_id" name="dist_id">
                            <option value="0" readonly disabled selected>District</option>
                            <?php if (isset($district) && $district != '') {
                                foreach ($district as $k => $d) {
                                    echo '<option value="' . $d->dist_id . '" ' . (isset($slug_district) && $slug_district == $d->dist_id ? "selected" : "") . '>' . $d->district . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dept">Department: </label>
                        <input type="text" class="form-control" id="dept" name="dept"
                               autocomplete="dept" required>
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation: </label>
                        <input type="text" class="form-control" id="designation" name="designation"
                               autocomplete="designation" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact: </label>
                        <input type="text" class="form-control" id="contact" name="contact"
                               autocomplete="contact">
                    </div>
                    <div class="form-group">
                        <label for="type">Volunteer Type: </label>
                        <div class="form-check">
                            <input class="form-check-input" name="type" type="radio" value="AKU Staff"
                                   id="type2" checked>
                            <label class="form-check-label " for="type2">
                                AKU Staff
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input " name="type" type="radio" value="Volunteer"
                                   id="type1">
                            <label class="form-check-label" for="type1">
                                Research Staff
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input " name="type" type="radio" value="Paid Staff"
                                   id="type3">
                            <label class="form-check-label" for="type3">
                                Paid Staff
                            </label>
                        </div>
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

<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_edit"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_edit">Edit Staff</h4>

                    <input type="hidden" id="edit_idStaff" name="edit_idStaff">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_name_edit">Name: </label>
                        <input type="text" class="form-control" id="user_name_edit" name="user_name_edit"
                               autocomplete="user_name_edit" required>
                    </div>
                    <div class="form-group">
                        <label for="dist_id_edit">District: </label>
                        <select class="select2 form-control dist_id_edit"
                                id="dist_id_edit" name="dist_id_edit">
                            <option value="0" readonly disabled selected>District</option>
                            <?php if (isset($district) && $district != '') {
                                foreach ($district as $k => $d) {
                                    echo '<option value="' . $d->dist_id . '"  >' . $d->district . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dept_edit">Department: </label>
                        <input type="text" class="form-control" id="dept_edit" name="dept_edit"
                               autocomplete="dept_edit" required>
                    </div>
                    <div class="form-group">
                        <label for="designatione_edit">Designation: </label>
                        <input type="text" class="form-control" id="designation_edit" name="designation_edit"
                               autocomplete="designation_edit" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_edit">Contact: </label>
                        <input type="text" class="form-control" id="contact_edit" name="contact_edit"
                               autocomplete="contact_edit">
                    </div>
                    <div class="form-group">
                        <label for="type_edit">Volunteer Type: </label>
                        <div class="form-check">
                            <input class="form-check-input" name="type_edit" type="radio" value="AKU Staff"
                                   id="type2_edit" checked>
                            <label class="form-check-label " for="type2_edit">
                                AKU Staff
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input " name="type_edit" type="radio" value="Volunteer"
                                   id="type1_edit">
                            <label class="form-check-label" for="type1_edit">
                                Research Staff
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input " name="type_edit" type="radio" value="Paid Staff"
                                   id="type3_edit">
                            <label class="form-check-label" for="type3_edit">
                                Paid Staff
                            </label>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="editData()">Edit
                    </button>
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
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete Staff</h4>
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


    function addModal() {
        $('#addModal').modal('show');
    }

    function addData() {
        $('#dist_id').css('border', '1px solid #babfc7');
        $('#user_name').css('border', '1px solid #babfc7');
        $('#dept').css('border', '1px solid #babfc7');
        $('#designation').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['dist_id'] = $('#dist_id').val();
        data['user_name'] = $('#user_name').val();
        data['dept'] = $('#dept').val();
        data['designation'] = $('#designation').val();
        data['contact'] = $('#contact').val();
        data['type'] = $('input[name="type"]:checked').val();
        if (data['dist_id'] == '' || data['dist_id'] == undefined) {
            $('#dist_id').css('border', '1px solid red');
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['user_name'] == '' || data['user_name'] == undefined) {
            $('#user_name').css('border', '1px solid red');
            toastMsg('Name', 'Invalid Name', 'error');
            flag = 1;
        }
        if (data['dept'] == '' || data['dept'] == undefined) {
            $('#dept').css('border', '1px solid red');
            toastMsg('Department', 'Invalid Department', 'error');
            flag = 1;
        }
        if (data['designation'] == '' || data['designation'] == undefined) {
            $('#designation').css('border', '1px solid red');
            toastMsg('Designation', 'Invalid Designation', 'error');
            flag = 1;
        }
        if (data['type'] == '' || data['type'] == undefined || data['type'] == 0) {
            $('#type').css('border', '1px solid red');
            toastMsg('Type', 'Invalid Type', 'error');
            flag = 1;
        }

        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Staff/addStaff'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#addModal').modal('hide');
                    setTimeout(function () {
                        window.location.href = '<?php echo base_url() ?>index.php/Staff?f=1&d=' + data['dist_id'];
                    }, 500);
                } else if (result == 2) {
                    $('#dist_id').css('border', '1px solid red');
                    toastMsg('District', 'Invalid District', 'error');
                } else if (result == 3) {
                    $('#user_name').css('border', '1px solid red');
                    toastMsg('Name', 'Invalid Name', 'error');
                } else if (result == 4) {
                    $('#dept').css('border', '1px solid red');
                    toastMsg('Department', 'Invalid Department', 'error');
                } else if (result == 5 || result == 6) {
                    $('#type').css('border', '1px solid red');
                    toastMsg('Type', 'Invalid Type', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }


    function getEdit(obj) {
        var data = {};
        data['id'] = $(obj).parent('td').attr('data-id');
        if (data['id'] != '' && data['id'] != undefined) {
            CallAjax('<?php echo base_url('index.php/Staff/getStaffEdit')?>', data, 'POST', function (result) {
                if (result != '' && JSON.parse(result).length > 0) {
                    var a = JSON.parse(result);
                    try {
                        $('#edit_idStaff').val(data['id']);
                        $('#dist_id_edit').val(a[0]['dist_id']).select2();
                        $('#user_name_edit').val(a[0]['name']);
                        $('#dept_edit').val(a[0]['dept']);
                        $('#designation_edit').val(a[0]['designation']);
                        $('#contact_edit').val(a[0]['contact']);
                        $('#type_edit').val(a[0]['type']);
                    } catch (e) {
                    }
                    $('#editModal').modal('show');
                } else {
                    toastMsg('Staff', 'Invalid Staff', 'error');
                }
            });
        }
    }

    function editData() {
        $('#dist_id_edit').css('border', '1px solid #babfc7');
        $('#user_name_edit').css('border', '1px solid #babfc7');
        $('#dept_edit').css('border', '1px solid #babfc7');
        $('#designation_edit').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idStaff'] = $('#edit_idStaff').val();
        data['dist_id'] = $('#dist_id_edit').val();
        data['user_name'] = $('#user_name_edit').val();
        data['dept'] = $('#dept_edit').val();
        data['designation'] = $('#designation_edit').val();
        data['contact'] = $('#contact_edit').val();
        data['type'] = $('input[name="type_edit"]:checked').val();

        if (data['idStaff'] == '' || data['idStaff'] == undefined || data['idStaff'].length < 1) {
            flag = 1;
            toastMsg('Staff', 'Invalid Staff ID', 'error');
            return false;
        }
        if (data['dist_id'] == '' || data['dist_id'] == undefined) {
            $('#dist_id_edit').css('border', '1px solid red');
            toastMsg('District_edit', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['user_name'] == '' || data['user_name'] == undefined) {
            $('#user_name_edit').css('border', '1px solid red');
            toastMsg('Name', 'Invalid Name', 'error');
            flag = 1;
        }
        if (data['dept'] == '' || data['dept'] == undefined) {
            $('#dept_edit').css('border', '1px solid red');
            toastMsg('Department', 'Invalid Department', 'error');
            flag = 1;
        }
        if (data['designation'] == '' || data['designation'] == undefined) {
            $('#designation_edit').css('border', '1px solid red');
            toastMsg('Designation', 'Invalid Designation', 'error');
            flag = 1;
        }
        if (data['type'] == '' || data['type'] == undefined || data['type'] == 0) {
            $('#type_edit').css('border', '1px solid red');
            toastMsg('Type', 'Invalid Type', 'error');
            flag = 1;
        }


        if (flag === 0) {
            CallAjax('<?php echo base_url('index.php/Staff/editData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('Success', 'Successfully Edited', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (result == 8) {
                    $('#dist_id').css('border', '1px solid red');
                    toastMsg('Staff', 'Invalid Staff', 'error');
                } else if (result == 2) {
                    $('#dist_id').css('border', '1px solid red');
                    toastMsg('District', 'Invalid District', 'error');
                } else if (result == 3) {
                    $('#user_name').css('border', '1px solid red');
                    toastMsg('Name', 'Invalid Name', 'error');
                } else if (result == 4) {
                    $('#dept').css('border', '1px solid red');
                    toastMsg('Department', 'Invalid Department', 'error');
                } else if (result == 5 || result == 6) {
                    $('#type').css('border', '1px solid red');
                    toastMsg('Type', 'Invalid Type', 'error');
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
        data['idStaff'] = $('#delete_id').val();
        if (data['idStaff'] == '' || data['idStaff'] == undefined || data['idStaff'] == 0) {
            toastMsg('Area', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Staff/deleteData')?>', data, 'POST', function (res) {
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


    function searchData() {
        var district = $('.district_select').val();
        if (district == '' || district == undefined || district == '0') {
            district = '';
        }
        window.location.href = '<?php echo base_url() ?>index.php/Staff?f=1&d=' + district;
    }

</script>