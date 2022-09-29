<!-- BEGIN: Content-->
<style>
    table th, td {
        padding: 8px !important;

    }
</style>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Daily Report</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Daily Report</li>
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
                                            <div class="form-group">
                                                <label for="district_select" class="label-control">District</label>
                                                <select class="select2 form-control district_select"
                                                        id="district_select"
                                                        onchange="changeDistricts('district_select','ucs_select',1)">
                                                    <option value="0" readonly disabled selected>District</option>
                                                    <?php if (isset($district) && $district != '') {
                                                        foreach ($district as $k => $d) {
                                                            echo '<option value="' . $d->dist_id . '" ' . (isset($slug_district) && $slug_district == $d->dist_id ? "selected" : "") . '>' . $d->district . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="ucs_select" class="label-control">Union Council</label>
                                            <div class="form-group">
                                                <select class="select2 form-control ucs_select" id="ucs_select"
                                                        onchange="changeUCs('ucs_select','area_select',1)">
                                                    <option value="0" readonly disabled selected>UC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="area_select" class="label-control">Camp</label>
                                            <div class="form-group">
                                                <select class="select2 form-control area_select" id="area_select"
                                                        onchange="changeAreas('area_select','day_select',1)">
                                                    <option value="0" readonly disabled selected>Camp</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="day_select" class="label-control">Day</label>
                                            <div class="form-group">
                                                <select class="select2 form-control day_select" id="day_select">
                                                    <option value="0" readonly disabled selected>Day</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary" onclick="searchData()">Get
                                                Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (isset($slug_district) && $slug_district != '' && $slug_district != 0) { ?>

                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Report</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped  dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>District</th>
                                                    <th>UC</th>
                                                    <th>Area</th>
                                                    <th>Camp</th>
                                                    <th>Camp Day</th>
                                                    <th>Under 5 Children</th>
                                                    <th>WRA</th>
                                                    <th>PW</th>
                                                    <th>Children Vaccinated</th>
                                                    <th>WRA Vaccinated</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($getData) && $getData != '') {
                                                    $Sno = 0;
                                                    foreach ($getData as $k => $r) {
                                                        $Sno++ ?>
                                                        <tr>
                                                            <td><?php echo $Sno ?></td>
                                                            <td><?php echo $r->district ?></td>
                                                            <td><?php echo $r->ucName ?></td>
                                                            <td><?php echo $r->area_name . ' (' . $r->area_no . ')' ?></td>
                                                            <td><?php echo $r->camp_day ?></td>
                                                            <td><?php echo $r->total_opd ?></td>
                                                            <td><?php echo $r->total_under5 ?></td>
                                                            <td><?php echo $r->total_wra ?></td>
                                                            <td><?php echo $r->total_pw ?></td>
                                                            <td><?php echo $r->total_children_vaccinated ?></td>
                                                            <td><?php echo $r->total_wra_vaccinated ?></td>
                                                            <td data-id="<?php echo $r->id ?>">
                                                                <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                    <a href="javascript:void(0)" title="Edit User"
                                                                       onclick="getEdit(this)"><i
                                                                            class="feather icon-edit"></i> </a>
                                                                <?php } ?>
                                                                <?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
                                                                    <a href="javascript:void(0)" title="Block User"
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
                                                    <th>District</th>
                                                    <th>UC</th>
                                                    <th>Area</th>
                                                    <th>Camp</th>
                                                    <th>Camp Day</th>
                                                    <th>Under 5 Children</th>
                                                    <th>WRA</th>
                                                    <th>PW</th>
                                                    <th>Children Vaccinated</th>
                                                    <th>WRA Vaccinated</th>
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
<input type="hidden" id="hidden_slug_area"
       value="<?php echo(isset($slug_area) && $slug_area != '' ? $slug_area : ''); ?>">
<input type="hidden" id="hidden_slug_day" value="<?php echo(isset($slug_day) && $slug_day != '' ? $slug_day : ''); ?>">


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
                    <h4 class="modal-title white" id="myModalLabel_add">Add Report</h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" autocomplete="off">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="dist_id_add" class="label-control">District</label>
                                    <select class="  form-control dist_id_add"
                                            id="dist_id_add"
                                            onchange="changeDistricts('dist_id_add','uc_add',0)">
                                        <option value="0" readonly disabled selected>District</option>
                                        <?php if (isset($district) && $district != '') {
                                            foreach ($district as $k => $d) {
                                                echo '<option value="' . $d->dist_id . '" ' . (isset($slug_district) && $slug_district == $d->dist_id ? "selected" : "") . '>' . $d->district . '</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <label for="uc_add" class="label-control">UC</label>
                                <div class="form-group">
                                    <select class="  form-control uc_add" id="uc_add"
                                            onchange="changeUCs('uc_add','area_add',0)">
                                        <option value="0" readonly disabled selected>UC</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <label for="area_add" class="label-control">Area</label>
                                <div class="form-group">
                                    <select class="  form-control area_add" id="area_add"
                                            onchange="changeAreas('area_add','camp_day',0)">
                                        <option value="0" readonly disabled selected>Area</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group required">
                                    <label class="label-control" for="camp_day">Camp Day: </label>
                                    <input type="date"
                                           class="form-control  camp_day" id="camp_day"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-control" for="opd">Total OPD: </label>
                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                           class="form-control  numberonly opd" id="opd"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-control" for="under_five_child">Total Under 5 Children: </label>
                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                           class="form-control  numberonly under_five_child" id="under_five_child"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-control" for="wra">Total WRAs: </label>
                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                           class="form-control  numberonly wra" id="wra"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-control" for="pw">Total PW: </label>
                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                           class="form-control  numberonly pw" id="pw"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-control" for="children_vaccinated">Children Vaccinated: </label>
                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                           class="form-control  numberonly children_vaccinated" id="children_vaccinated" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-control" for="wra_vaccinated">WRA Vaccinated: </label>
                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                           class="form-control  numberonly wra_vaccinated" id="wra_vaccinated" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary mybtn" onclick="addData()">Add
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_delete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete Data</h4>
                    <input type="hidden" id="delete_id" name="delete_id">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete this row?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteData()">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>

    $(document).ready(function () {
        changeDistricts('district_select', 'ucs_select', 1);
        $('.addbtn').click(function () {
            var district = $('.district_select').val();
            var ucs = $('.ucs_select').val();
            var area = $('.area_select').val();
            var day = $('.day_select').val();
            $('#dist_id_add').val(district);
            $('#uc_add').val(ucs);
            $('#area_add').val(area);
            $('#camp_day').val(day);
            setTimeout(function () {
                $('#addModal').modal('show');
            }, 300);
        });
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 50,
            "oSearch": {"sSearch": " "},
            autoFill: false,
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

        $('.numberonly').keypress(function (e) {
            var charCode = (e.which) ? e.which : event.keyCode
            if (String.fromCharCode(charCode).match(/[^0-9]/g))
                return false;
        });
    });

    function addData() {
        $('#opd').removeClass('error');
        $('#under_five_child').removeClass('error');
        $('#wra').removeClass('error');
        $('#pw').removeClass('error');
        $('#wra_vaccinated').removeClass('error');
        $('#children_vaccinated').removeClass('error');
        var flag = 0;
        var data = {};
        data['dist_id_add'] = $('#dist_id_add').val();
        data['uc_add'] = $('#uc_add').val();
        data['area_add'] = $('#area_add').val();
        data['camp_day'] = $('#camp_day').val();
        data['opd'] = $('#opd').val();
        data['under_five_child'] = $('#under_five_child').val();
        data['wra'] = $('#wra').val();
        data['pw'] = $('#pw').val();
        data['children_vaccinated'] = $('#children_vaccinated').val();
        data['wra_vaccinated'] = $('#wra_vaccinated').val();

        var validateDt = validateData(data);
        if (data['dist_id_add'] == '' || data['dist_id_add'] == undefined || data['dist_id_add'] == 0 || data['dist_id_add'] == '0') {
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }
        if (data['uc_add'] == '' || data['uc_add'] == undefined || data['uc_add'] == 0 || data['uc_add'] == '0') {
            flag = 1;
            toastMsg('UC', 'Invalid UC', 'error');
            return false;
        }
        if (data['area_add'] == '' || data['area_add'] == undefined || data['area_add'] == 0 || data['area_add'] == '0') {
            flag = 1;
            toastMsg('Area', 'Invalid Area', 'error');
            return false;
        }
        if (data['camp_day'] == '' || data['camp_day'] == undefined || data['camp_day'] == 0 || data['camp_day'] == '0') {
            flag = 1;
            toastMsg('Day', 'Invalid Day', 'error');
            return false;
        }


        if (validateDt) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Daily_reports/addData'); ?>', data, 'POST', function (result) {
                hideloader();
                $('.mybtn').removeAttr('disabled', 'disabled');
                try {
                    var response = JSON.parse(result);
                    if (response[0] == 'Success') {
                        $('#addModal').modal('hide');
                        toastMsg(response[0], response[1], 'success');
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    } else {
                        toastMsg(response[0], response[1], 'error');
                    }
                } catch (e) {
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
        data['id'] = $('#delete_id').val();
        if (data['id'] == '' || data['id'] == undefined || data['id'] == 0) {
            toastMsg('User', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Daily_reports/deleteData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    toastMsg('Success', 'Successfully Deleted', 'success');
                    $('#deleteModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Error', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('Error', 'Invalid Id', 'error');
                }

            });
        }
    }

    function changeDistricts(dist, uc, filter) {
        var data = {};
        data['district'] = $('#' + dist).val();
        data['arms'] = 1;
        data['round'] = 4;
        var items = '<option value="0" disabled readonly="">UCs</option>';
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Daily_reports/getUCsByDistrict'  ?>', data, 'POST', function (res) {
                if (filter == 1) {
                    items = '<option value="0" readonly selected>Select All</option>';
                }
                var slug_ucs = $('#hidden_slug_ucs').val();
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.ucCode + '"  ' + (slug_ucs == v.ucCode || response.length == 1 ? 'selected' : '') + '>' + v.ucName + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + uc).html('').html(items);
                $('#uc_add').html('').html(items);
                $('#area_add').html('').html('<option value="0">Select Area</option>');
                // $('#camp_day').html('').html('<option value="0">Select Day</option>');

                if (filter == 1) {
                    changeUCs('ucs_select', 'area_select', 1);
                    changeUCs('uc_add', 'area_add', 1);
                } else {
                    changeUCs('ucs_select', 'area_select', 0);
                    changeUCs('uc_add', 'area_add', 0);
                }
            });
        } else {
            $('#' + uc).html('').html(items);
        }
    }

    function changeUCs(uc, area, filter) {
        var data = {};
        data['uc'] = $('#' + uc).val();
        data['filter'] = 0;
        data['round'] = 4;
        if (data['uc'] != '' && data['uc'] != undefined && data['uc'] != '0' && data['uc'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Daily_reports/getAreaByUCs'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" disabled readonly >Select Area</option> ';
                if (filter == 1) {
                    items = '<option value="0"  readonly >Select Area</option>';
                }
                var areas = $('#hidden_slug_area').val();
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.area_no + '"  ' + (areas == v.area_no || response.length == 1 ? 'selected' : '') + '>' + v.area_name + ' (' + v.area_no + ')</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + area).html('').html(items);
                $('#area_add').html('').html(items);
                $('#camp_day').html('').html('<option value="0">Select Day</option>');
                changeAreas('area_add', 'camp_day', 0);
                if (filter == 1) {
                    changeAreas('area_select', 'day_select', 1);
                } else {
                    changeAreas('area_add', 'camp_day', 0);
                }
            });
        } else {
            $('#' + area).html('');
        }
    }

    function changeAreas(area, day, filter) {

        var data = {};
        data['area'] = $('#' + area).val();
        data['filter'] = 0;
        data['round'] = 4;
        if (data['area'] != '' && data['area'] != undefined && data['area'] != '0' && data['area'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Daily_reports/getDayByArea'  ?>', data, 'POST', function (res) {
                console.log(res);
                var items = '<option value="0" disabled readonly >Day</option>';
                if (filter == 1) {
                    items = '<option value="0" disabled readonly>Select Day</option>';
                }
                var day_slug = $('#hidden_slug_day').val();
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.execution_date + '"  ' + (day_slug == v.execution_date || response.length == 1 ? 'selected' : '') + '>' + v.execution_date + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + day).html('').html(items);
            });
        } else {
            $('#' + day).html('');
        }
    }

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        var area = $('.area_select').val();
        var day = $('.day_select').val();
        if (district == '' || district == undefined || district == '0' || district == '$1') {
            toastMsg('District', 'Invalid District', 'error');
        } else {
            if (ucs == '' || ucs == undefined || ucs == '0') {
                ucs = '';
            }
            if (area == '' || area == undefined || area == '0') {
                area = '';
            }
            if (day == '' || day == undefined || day == '0') {
                day = '';
            }
            window.location.href = '<?php echo base_url() ?>index.php/Daily_reports?d=' + district + '&u=' + ucs + '&a=' + area + '&day=' + day;
        }
    }

</script>