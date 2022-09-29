<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Camp Registration</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Camp Registration
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
                                                        id="district_select"
                                                        onchange="changeDistrict('district_select','ucs_select',1)">
                                                    <option value="0"  selected>All Districts</option>
                                                    <?php if (isset($district) && $district != '') {
                                                        foreach ($district as $k => $d) {
                                                            echo '<option value="' . $d->dist_id . '" ' . (isset($slug_district) && $slug_district == $d->dist_id ? "selected" : "") . '>' . $d->district . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                UC
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control ucs_select" id="ucs_select">
                                                    <option value="0"   selected>All UCs</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-sm-6 col-12">
                                            <label for="partner_code_select" class="label-control">Partner</label>
                                            <div class="form-group">
                                                <select class="select2 form-control partner_code_select"
                                                        id="partner_code_select">
                                                    <option value="0" <?php echo(!isset($slug_partner) || $slug_partner == 0 || $slug_partner == '' ? 'selected' : '') ?>>Partner</option>
                                                    <option value="1" <?php echo(isset($slug_partner) && $slug_partner == 1 ? 'selected' : '') ?>>CHS</option>
                                                    <option value="2" <?php echo(isset($slug_partner) && $slug_partner == 2 ? 'selected' : '') ?>>AKU</option>
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
                                                    Camp
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
                                    <h4 class="card-title">Camp Registration</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>District</th>
                                                    <th>UC</th>
                                                    <th>Camp/Area No</th>
                                                    <th>Camp/Area</th>
                                                    <th>Remarks</th>
                                                    <th>Partner</th>
                                                    <th>Action</th>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $k => $r) { ?>
                                                        <tr>
                                                            <td><?php echo $r->district ?></td>
                                                            <td><?php echo $r->ucName ?></td>
                                                            <td><?php echo $r->area_no ?></td>
                                                            <td><?php echo $r->area_name ?></td>
                                                            <td><?php echo $r->remarks ?></td>
                                                            <td><?php if(isset($r->partner_code) && $r->partner_code==1){
                                                                echo 'CHS';
                                                                }elseif(isset($r->partner_code) && $r->partner_code==2){
                                                                    echo 'AKU';
                                                                }else{
                                                                echo '-';
                                                                }?></td>
                                                            <td data-id="<?php echo $r->idCampArea ?>">
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
                                                    <th>District</th>
                                                    <th>UC</th>
                                                    <th>Camp/Area No</th>
                                                    <th>Camp/Area</th>
                                                    <th>Remarks</th>
                                                    <th>Partner</th>
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

<input type="hidden" id="hidden_slug_ucs" value="<?php echo(isset($slug_ucs) && $slug_ucs != '' ? $slug_ucs : ''); ?>">
<input type="hidden" id="hidden_slug_partner"
       value="<?php echo(isset($slug_partner) && $slug_partner != '' ? $slug_partner : ''); ?>">
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
                    <h4 class="modal-title white" id="myModalLabel_add">Add Camp</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="area_no">Camp/Area No: </label>
                        <input type="text" class="form-control" readonly disabled id="area_no" name="area_no"
                               autocomplete="area_no" required>
                    </div>
                    <div class="form-group">
                        <label for="area_name">Camp/Area Name: </label>
                        <input type="text" class="form-control" id="area_name" name="area_name"
                               autocomplete="area_name" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks/Sub Location: </label>
                        <input type="text" class="form-control" id="remarks" name="remarks" autocomplete="remarks">
                    </div>
                    <div class="form-group">
                        <label for="partner_code">Partner: </label>
                        <select class="sel ect2 form-control partner_code"
                                id="partner_code" required>
                            <option value="0" readonly
                                    disabled selected>Partner</option>
                            <option value="1" <?php echo(isset($slug_partner) && $slug_partner == 1 ? 'selected' : '') ?>>CHS</option>
                            <option value="2" <?php echo(isset($slug_partner) && $slug_partner == 2 ? 'selected' : '') ?>>AKU</option>
                        </select>
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
                    <h4 class="modal-title white" id="myModalLabel_edit">Edit Area</h4>

                    <input type="hidden" id="edit_idCampArea" name="edit_idCampArea">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_area_no">Camp/Area No: </label>
                        <input type="text" class="form-control" id="edit_area_no" name="edit_area_no" readonly disabled
                               autocomplete="edit_area_no" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_area_name">Camp/Area Name: </label>
                        <input type="text" class="form-control" id="edit_area_name" name="edit_area_name"
                               autocomplete="edit_area_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_remarks">Remarks/Sub Location: </label>
                        <input type="text" class="form-control" id="edit_remarks" name="edit_remarks"
                               autocomplete="edit_remarks">
                    </div>

                    <div class="form-group">
                        <label for="edit_partner_code">Partner: </label>
                        <select class="selecst2 form-control edit_partner_code"
                                id="edit_partner_code" required>
                            <option value="0" readonly
                                    disabled selected >Partner</option>
                            <option value="1" >CHS</option>
                            <option value="2">AKU</option>
                        </select>
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
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete Area</h4>
                    <input type="hidden" id="delete_idCampArea" name="delete_idCampArea">
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
        changeDistrict('district_select', 'ucs_select', 1);
        setTimeout(function () {
            getMaxArea(1);
        }, 1000);
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
        var flag = 0;
        var data = {};
        data['district'] = $('#district_select').val();
        data['ucs'] = $('#ucs_select').val();

        if (data['district'] == '' || data['district'] == undefined || data['district'] == '0' || data['district'] == '$1') {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucs'] == '' || data['ucs'] == undefined || data['ucs'] == '0' || data['ucs'] == '$1') {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (flag == 0) {
            getMaxArea(0);
            $('#addModal').modal('show');
        }

    }

    function addData() {
        $('#dist_id').css('border', '1px solid #babfc7');
        $('#ucCode').css('border', '1px solid #babfc7');
        $('#area_name').css('border', '1px solid #babfc7');
        $('#area_no').css('border', '1px solid #babfc7');
        $('#partner_code').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['dist_id'] = $('#district_select').val();
        data['ucCode'] = $('#ucs_select').val();
        data['area_no'] = $('#area_no').val();
        data['area_name'] = $('#area_name').val();
        data['remarks'] = $('#remarks').val();
        data['partner_code'] = $('#partner_code').val();
        if (data['dist_id'] == '' || data['dist_id'] == undefined) {
            $('#dist_id').css('border', '1px solid red');
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucCode'] == '' || data['ucCode'] == undefined) {
            $('#ucCode').css('border', '1px solid red');
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (data['area_name'] == '' || data['area_name'] == undefined) {
            $('#area_name').css('border', '1px solid red');
            toastMsg('Area', 'Invalid Area', 'error');
            flag = 1;
        }
        if (data['area_no'] == '' || data['area_no'] == undefined) {
            $('#area_no').css('border', '1px solid red');
            toastMsg('Area No', 'Invalid Area No', 'error');
            flag = 1;
        }
        if (data['partner_code'] == '' || data['partner_code'] == undefined || data['partner_code'] == 0 || data['partner_code'] == '0') {
            $('#partner_code').css('border', '1px solid red');
            toastMsg('Partner', 'Invalid Partner Code', 'error');
            flag = 1;
        }

        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Camps/addCampArea'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#addModal').modal('hide');
                    setTimeout(function () {
                        window.location.href = '<?php echo base_url() ?>index.php/Camps?d=' + data['dist_id'] + '&u=' + data['ucCode'];
                    }, 500);
                } else if (result == 2) {
                    $('#dist_id').css('border', '1px solid red');
                    toastMsg('District', 'Invalid District', 'error');
                } else if (result == 3) {
                    $('#ucCode').css('border', '1px solid red');
                    toastMsg('UC', 'Invalid UC', 'error');
                } else if (result == 4) {
                    $('#area_name').css('border', '1px solid red');
                    toastMsg('Area', 'Invalid Area', 'error');
                } else if (result == 5 || result == 6) {
                    $('#area_no').css('border', '1px solid red');
                    toastMsg('Area No', 'Invalid Area No', 'error');
                } else if (result == 10) {
                    $('#partner_code').css('border', '1px solid red');
                    toastMsg('Partner', 'Invalid Partner Code', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getMaxArea(filter) {
        if (filter != 1) {
            $('#dist_id').css('border', '1px solid #babfc7');
            $('#ucCode').css('border', '1px solid #babfc7');
            var data = {};
            data['dist_id'] = $('#district_select').val();
            data['ucCode'] = $('#ucs_select').val();
            if (data['dist_id'] == '' || data['dist_id'] == undefined) {
                $('#dist_id').css('border', '1px solid red');
                toastMsg('District', 'Invalid District', 'error');
            }
            if (data['ucCode'] == '' || data['ucCode'] == undefined) {
                $('#ucCode').css('border', '1px solid red');
                toastMsg('UC', 'Invalid UC', 'error');
            } else {
                CallAjax('<?php echo base_url('index.php/Camps/getMaxArea'); ?>', data, 'POST', function (result) {
                    if (result == '' || result == undefined) {
                        $('#area_no').val(0);
                    } else {
                        $('#area_no').val(result);
                    }

                });
            }
        }
    }

    function getEdit(obj) {
        $('#edit_ucCode').html('');
        var data = {};
        data['id'] = $(obj).parent('td').attr('data-id');
        if (data['id'] != '' && data['id'] != undefined) {
            changeDistrict('edit_district', 'edit_ucCode', 0);
            CallAjax('<?php echo base_url('index.php/Camps/getAreaEdit')?>', data, 'POST', function (result) {
                if (result != '' && JSON.parse(result).length > 0) {
                    var a = JSON.parse(result);
                    try {
                        $('#edit_idCampArea').val(data['id']);
                        $('#edit_area_no').val(a[0]['area_no']);
                        $('#edit_area_name').val(a[0]['area_name']);
                        $('#edit_remarks').val(a[0]['remarks']);
                        $('#edit_partner_code').val(a[0]['partner_code']);
                    } catch (e) {
                    }
                    $('#editModal').modal('show');
                } else {
                    toastMsg('Area', 'Invalid Area', 'error');
                }
            });
        }
    }

    function editData() {
        $('#edit_area_name').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idCampArea'] = $('#edit_idCampArea').val();
        data['dist_id'] = $('#district_select').val();
        data['ucCode'] = $('#ucs_select').val();
        data['area_name'] = $('#edit_area_name').val();
        data['remarks'] = $('#edit_remarks').val();
        data['partner_code'] = $('#edit_partner_code').val();
        if (data['idCampArea'] == '' || data['idCampArea'] == undefined || data['idCampArea'].length < 1) {
            flag = 1;
            toastMsg('Area', 'Invalid Area', 'error');
            return false;
        }
        if (data['dist_id'] == '' || data['dist_id'] == undefined) {
            $('#edit_dist_id').css('border', '1px solid red');
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucCode'] == '' || data['ucCode'] == undefined) {
            $('#edit_ucCode').css('border', '1px solid red');
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (data['area_name'] == '' || data['area_name'] == undefined) {
            $('#edit_area_name').css('border', '1px solid red');
            toastMsg('Area', 'Invalid Area', 'error');
            flag = 1;
        }


        if (data['partner_code'] == '' || data['partner_code'] == undefined || data['partner_code'] == 0 || data['partner_code'] == '0') {
            $('#partner_code').css('border', '1px solid red');
            toastMsg('Partner', 'Invalid Partner Code', 'error');
            flag = 1;
        }
        if (flag === 0) {
            CallAjax('<?php echo base_url('index.php/Camps/editData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('Area', 'Successfully Edited', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 3) {
                    $('#dist_id').css('border', '1px solid red');
                    toastMsg('District', 'Invalid District', 'error');
                } else if (res == 4) {
                    $('#ucCode').css('border', '1px solid red');
                    toastMsg('UC', 'Invalid UC', 'error');
                } else if (res == 5) {
                    $('#area_name').css('border', '1px solid red');
                    toastMsg('Area', 'Invalid Area', 'error');
                }else if (result == 10) {
                    $('#partner_code').css('border', '1px solid red');
                    toastMsg('Partner', 'Invalid Partner Code', 'error');
                } else {
                    toastMsg('Area', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getDelete(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#delete_idCampArea').val(id);
        $('#deleteModal').modal('show');
    }

    function deleteData() {
        var data = {};
        data['idCampArea'] = $('#delete_idCampArea').val();
        if (data['idCampArea'] == '' || data['idCampArea'] == undefined || data['idCampArea'] == 0) {
            toastMsg('Area', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Camps/deleteData')?>', data, 'POST', function (res) {
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

    function changeDistrict(dist, uc, filter) {
        $('#' + uc).html('');
        var data = {};
        data['district'] = $('#' + dist).val();
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getUCsByDistrict'  ?>', data, 'POST', function (res) {
                var items = '<option value="0"  >Select UC</option>';
                var dist = $('#hidden_slug_ucs').val();

                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.ucCode + '"  ' + (dist == v.ucCode || response.length == 1 ? 'selected' : '') + '>' + v.ucName + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + uc).html('').html(items);
                if (filter != 1) {
                    getMaxArea(0);
                }
            });
        } else {
            $('#' + uc).html('');
        }
    }

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        var partner = $('.partner_code_select').val();
        if (district == '' || district == undefined || district == '0') {
            district = '';
        }
        if (ucs == '' || ucs == undefined || ucs == '0') {
            ucs = '';
        }
        if (partner == '' || partner == undefined || partner == '0') {
            partner = '';
        }
        window.location.href = '<?php echo base_url() ?>index.php/camps?f=1&d=' + district + '&u=' + ucs + '&p=' + partner;
    }

</script>