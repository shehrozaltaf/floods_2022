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
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Entry Status</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Entry Status
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
                                            <div class="form-group">
                                                <label for="district_select" class="label-control">District</label>
                                                <select class="select2 form-control district_select"
                                                        id="district_select"
                                                        onchange="changeDistricts('district_select','ucs_select',1)">
                                                    <option value="0" disabled readonly selected>All Districts</option>
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
                                                    <option value="0" disabled readonly selected>Camp Location (Camp
                                                        Code)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="type_select" class="label-control">Type</label>
                                            <div class="form-group">
                                                <select class="select2 form-control type_select" id="type_select">
                                                    <option value="t" <?= (isset($slug_type) &&$slug_type=='t'?'selected':'') ?>>Total</option>
                                                    <option value="u5" <?= (isset($slug_type) &&$slug_type=='u5'?'selected':'') ?>>Under 5</option>
                                                    <option value="a5" <?= (isset($slug_type) &&$slug_type=='a5'?'selected':'') ?>>Above 5</option>
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
                                                    <option value="2" <?php echo(isset($slug_partner) && $slug_partner == 2 ? 'selected' : '') ?>>COE</option>
                                                </select>
                                            </div>
                                        </div>
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

            <?php if (isset($slug_filter) && $slug_filter != '' && $slug_filter != 0) {
                if(isset($slug_type) && $slug_type=='u5'){
                    $type='u5';
                    $heading='Under 5';
                }else if(isset($slug_type) && $slug_type=='a5'){
                    $type='a5';
                    $heading='Above 5';
                }else{
                    $type='total';
                    $heading='Total';
                }?>
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Diagnosis List - <span class="text-danger"><?=$heading?></span></h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>District</th>
                                                    <th>OPD</th>
                                                    <?php
                                                    if (isset($myData[0]['diagnosis']) && $myData[0]['diagnosis'] != '') {
                                                        foreach ($myData[0]['diagnosis'] as $kk => $rt) {
                                                            echo '<th>'.$rt['label'].'</th>';
                                                        }
                                                    }
                                                    ?>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <?php


                                                if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $k => $r) {
                                                        echo '<tr>';
                                                        echo '<td>'.(isset($r['district']) && $r['district']!=''?$r['district']:'-').'</td>';
                                                        echo '<td>'.(isset($r['sum_total_opd']) && $r['sum_total_opd']!=''?$r['sum_total_opd']:'-').'</td>';
                                                        foreach ($r['diagnosis'] as $kv => $rv) {
                                                            echo '<td>'.(isset($rv[$type]) && $rv[$type]!=''?$rv[$type]:'-').'</td>';
                                                        }
                                                        echo '</tr>';
                                                        ?>
                                                    <?php }
                                                } ?>
                                                </tbody>
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
<input type="hidden" id="hidden_slug_partner"  value="<?php echo(isset($slug_partner) && $slug_partner != '' ? $slug_partner : ''); ?>">
<input type="hidden" id="hidden_slug_type"  value="<?php echo(isset($slug_type) && $slug_type != '' ? $slug_type : ''); ?>">
<input type="hidden" id="hidden_slug_filter"
       value="<?php echo(isset($slug_filter) && $slug_filter != '' ? $slug_filter : ''); ?>">
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

    function changeDistricts(dist, uc, filter) {
        var data = {};
        data['district'] = $('#' + dist).val();
        data['arms'] = 1;
        data['round'] = 4;
        var items = '<option value="<?= (isset($myData[0]->di021_u5) && $myData[0]->di021_u5 != '' ? $myData[0]->di021_u5 : '') ?>" disabled readonly disabled readonly="">UCs</option>';
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Daily_reports/getUCsByDistrict'  ?>', data, 'POST', function (res) {
                if (filter == 1) {
                    items = '<option value="<?= (isset($myData[0]->di021_u5) && $myData[0]->di021_u5 != '' ? $myData[0]->di021_u5 : '') ?>" disabled readonly readonly selected>Select All</option>';
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
                $('#area_add').html('').html('<option value="<?= (isset($myData[0]->di021_u5) && $myData[0]->di021_u5 != '' ? $myData[0]->di021_u5 : '') ?>" disabled readonly>Select Area</option>');
                // $('#camp_day').html('').html('<option value="<?= (isset($myData[0]->di021_u5) && $myData[0]->di021_u5 != '' ? $myData[0]->di021_u5 : '') ?>" disabled readonly>Select Day</option>');

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
                var items = '<option value="<?= (isset($myData[0]->di021_u5) && $myData[0]->di021_u5 != '' ? $myData[0]->di021_u5 : '') ?>" disabled readonly disabled readonly >Select Area</option> ';
                if (filter == 1) {
                    items = '<option value="<?= (isset($myData[0]->di021_u5) && $myData[0]->di021_u5 != '' ? $myData[0]->di021_u5 : '') ?>" disabled readonly  readonly >Select Area</option>';
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
                $('#camp_day').html('').html('<option value="<?= (isset($myData[0]->di021_u5) && $myData[0]->di021_u5 != '' ? $myData[0]->di021_u5 : '') ?>" disabled readonly>Select Day</option>');
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
        var type_select = $('.type_select').val();
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
        if (type_select == '' || type_select == undefined || type_select == '0') {
            type_select = 't';
        }
        if (partner == '' || partner == undefined || partner == '0') {
            partner = '';
        }
        window.location.href = '<?php echo base_url() ?>index.php/diagnosis_reports_district?f=1&d=' + district + '&u=' + ucs + '&a=' + area + '&day=' + day+ '&t=' + type_select+ '&p=' + partner;
    }

</script>