<style>
    .card-body {
        padding: 8px !important;
    }

    table th, td {
        padding: 8px !important;

    }

    table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tfoot th, table.table-bordered.dataTable tbody td {
        padding: 3px !important;
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
                                            <label for="ucs_select" class="label-control">Union Council</label>
                                            <div class="form-group">
                                                <select class="select2 form-control ucs_select" id="ucs_select"
                                                        onchange="changeUCs('ucs_select','area_select',1)">
                                                    <option value="0" selected>All UCs</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <label for="area_select" class="label-control">Camp Location (Camp
                                                Code)</label>
                                            <div class="form-group">
                                                <select class="select2 form-control area_select" id="area_select">
                                                    <option value="0" selected>Camp Location (Camp
                                                        Code)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="partner_code_select" class="label-control">Partner</label>
                                            <div class="form-group">
                                                <select class="select2 form-control partner_code_select"
                                                        id="partner_code_select">
                                                    <option value="0"  <?php echo(!isset($slug_partner) || $slug_partner == 0 || $slug_partner == '' ? 'selected' : '') ?>>Partner</option>
                                                    <option value="1" <?php echo(isset($slug_partner) && $slug_partner == 1 ? 'selected' : '') ?>>CHS</option>
                                                    <option value="2" <?php echo(isset($slug_partner) && $slug_partner == 2 ? 'selected' : '') ?>>COE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <label for="camp_day" class="label-control">Camp Date</label>
                                            <input type="date"
                                                   data-value="<?php echo(isset($slug_day) && $slug_day != '' ? date('d-m-Y', strtotime($slug_day)) : ''); ?>"
                                                   value="<?php echo(isset($slug_day) && $slug_day != '' ? date('d-m-Y', strtotime($slug_day)) : ''); ?>"
                                                   class="form-control mypickadat camp_day day_select" id="camp_day"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
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
            <?php if (isset($slug_filter) && $slug_filter != '' && $slug_filter != 0) { ?>
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
                                                    <th>Union Council</th>
                                                    <th>Camp Location (Camp Code)</th>
                                                    <th>Camp Exact Location</th>
                                                    <th>Camp Date</th>
                                                    <th>OPD</th>
                                                    <th>Under 5 Children</th>
                                                    <th>WRA</th>
                                                    <th>PW</th>
                                                    <th>Children Vaccinated</th>
                                                    <th>WRA Vaccinated</th>
                                                    <th>Children Received OPV</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($getData) && $getData != '') {
                                                    $Sno = 0;
                                                    $total_opd = 0;
                                                    $total_under5 = 0;
                                                    $total_wra = 0;
                                                    $total_pw = 0;
                                                    $total_children_vaccinated = 0;
                                                    $total_wra_vaccinated = 0;
                                                    $total_children_received_opv = 0;
                                                    foreach ($getData as $k => $r) {
                                                        $Sno++;
                                                        $total_opd += $r->total_opd;
                                                        $total_under5 += $r->total_under5;
                                                        $total_wra += $r->total_wra;
                                                        $total_pw += $r->total_pw;
                                                        $total_children_vaccinated += $r->total_children_vaccinated;
                                                        $total_wra_vaccinated += $r->total_wra_vaccinated;
                                                        $total_children_received_opv += $r->total_children_received_opv;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $Sno ?></td>
                                                            <td><?php echo $r->district ?></td>
                                                            <td><?php echo $r->ucName ?></td>
                                                            <td><?php echo wordwrap($r->area_name, 25, "<br>\n") . ' (' . $r->area_no . ')' ?></td>
                                                            <td><?php echo wordwrap($r->exact_location, 25, "<br>\n") ?></td>
                                                            <td><?php echo $r->camp_day ?></td>
                                                            <td><?php echo $r->total_opd ?></td>
                                                            <td><?php echo $r->total_under5 ?></td>
                                                            <td><?php echo $r->total_wra ?></td>
                                                            <td><?php echo $r->total_pw ?></td>
                                                            <td><?php echo $r->total_children_vaccinated ?></td>
                                                            <td><?php echo $r->total_wra_vaccinated ?></td>
                                                            <td><?php echo $r->total_children_received_opv ?></td>
                                                            <td data-id="<?php echo $r->id ?>">
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
                                                    <th></th>
                                                    <th>Total</th>
                                                    <th>-</th>
                                                    <th>-</th>
                                                    <th>-</th>
                                                    <th>-</th>
                                                    <th><?= $total_opd ?></th>
                                                    <th><?= $total_under5 ?></th>
                                                    <th><?= $total_wra ?></th>
                                                    <th><?= $total_pw ?></th>
                                                    <th><?= $total_children_vaccinated ?></th>
                                                    <th><?= $total_wra_vaccinated ?></th>
                                                    <th><?= $total_children_received_opv ?></th>
                                                    <th>-</th>

                                                    <!--   <th>SNo</th>
                                                    <th>District</th>
                                                    <th>Union Council</th>
                                                    <th>Camp Location (Camp Code)</th>
                                                    <th>Camp Date</th>
                                                    <th>OPD</th>
                                                    <th>Under 5 Children</th>
                                                    <th>WRA</th>
                                                    <th>PW</th>
                                                    <th>Children Vaccinated</th>
                                                    <th>WRA Vaccinated</th>
                                                    <th>Action</th>-->
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
<input type="hidden" id="hidden_slug_partner"
       value="<?php echo(isset($slug_partner) && $slug_partner != '' ? $slug_partner : ''); ?>">
<input type="hidden" id="hidden_slug_filter"
       value="<?php echo(isset($slug_filter) && $slug_filter != '' ? $slug_filter : ''); ?>">


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
        mydate();
        $('.numberonly').keypress(function (e) {
            var charCode = (e.which) ? e.which : event.keyCode
            if (String.fromCharCode(charCode).match(/[^0-9]/g))
                return false;
        });
    });

    function mydate() {
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            min: new Date(2022, 7, 1),
            max: true,
            format: 'dd-mm-yyyy'
        });
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
            });
        } else {
            $('#' + area).html('');
        }
    }

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        var area = $('.area_select').val();
        var day = $('.day_select').val();
        var partner = $('.partner_code_select').val();

        if (district == '' || district == undefined || district == '0') {
            district = '';
        }
        if (ucs == '' || ucs == undefined || ucs == '0') {
            ucs = '';
        }
        if (area == '' || area == undefined || area == '0') {
            area = '';
        }
        if (day == '' || day == undefined || day == '0') {
            day = '';
        }
        if (partner == '' || partner == undefined || partner == '0') {
            partner = '';
        }
        window.location.href = '<?php echo base_url() ?>index.php/Daily_reports?f=1&d=' + district + '&u=' + ucs + '&a=' + area + '&day=' + day + '&p=' + partner;
    }

</script>