=
<style>
    td {
        padding: 0px 10px;
    }

    .myLabel {
        font-size: 10px;
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
                        <h2 class="content-header-title float-left mb-0">Add - Daily Report</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Add - Daily Report</li>
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
                                <h4 class="card-title">Add Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form action="javascript:void(0)" autocomplete="off">
                                        <div class="row">
                                            <div class="col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="dist_id_add" class="label-control">District</label>
                                                    <select class="select2  form-control dist_id_add"
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
                                                <label for="uc_add" class="label-control">Union Council</label>
                                                <div class="form-group">
                                                    <select class=" select2 form-control uc_add" id="uc_add"
                                                            onchange="changeUCs('uc_add','area_add',0)">
                                                        <option value="0" readonly disabled selected>UC</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-12">
                                                <label for="area_add" class="label-control">Camp Location (Camp
                                                    Code)</label>
                                                <div class="form-group">
                                                    <select class="select2  form-control area_add" id="area_add">
                                                        <option value="0" readonly disabled selected>Area</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group required">
                                                    <label class="label-control" for="camp_day">Camp Date: </label>
                                                    <input type="date"
                                                           class="form-control mypickadat camp_day" id="camp_day"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-12">
                                                <div class="form-group required">
                                                    <label class="label-control" for="exact_location">Camp Exact
                                                        Location: </label>
                                                    <input type="text"
                                                           class="form-control   exact_location" id="exact_location"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-control" for="opd">Total OPD: </label>
                                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                                           class="form-control  numberonly opd" id="opd"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-control" for="under_five_child">Total Under 5
                                                        Children: </label>
                                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                                           class="form-control  numberonly under_five_child"
                                                           id="under_five_child"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-control" for="wra">Total WRAs: </label>
                                                    <input type="text" min="1" minlength="1" max="4" maxlength="4"
                                                           class="form-control  numberonly wra" id="wra"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-control" for="pw">Total PWs: </label>
                                                    <input type="text" data-allow-zero="1" min="1" minlength="1" max="4" maxlength="4"
                                                           class="form-control  numberonly pw" id="pw"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-control" for="children_vaccinated">Children
                                                        Vaccinated: </label>
                                                    <input type="text" data-allow-zero="1" min="1" minlength="1" max="4"
                                                           maxlength="4"
                                                           class="form-control  numberonly children_vaccinated"
                                                           id="children_vaccinated" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-control" for="wra_vaccinated">WRA
                                                        Vaccinated: </label>
                                                    <input type="text" data-allow-zero="1" min="1" minlength="1" max="4"
                                                           maxlength="4"
                                                           class="form-control  numberonly wra_vaccinated"
                                                           id="wra_vaccinated" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-12">
                                                <label for="resources" class="label-control">Camp
                                                    HR</label>
                                                <div class="form-group">
                                                    <select class="selectss2 form-control " name="resources[]"
                                                            id="resources" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="label-control" for="children_received_opv">Children Received OPV: </label>
                                                    <input type="text" data-allow-zero="1" min="1" minlength="1" max="4"
                                                           maxlength="4"
                                                           class="form-control  numberonly children_received_opv"
                                                           id="children_received_opv" required>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">

                                                <h3 class="text-primary text-center mb-1">Diagnosis</h3>
                                            </div>
                                            <?php if (isset($diagnosis) && $diagnosis != '') {
                                                foreach ($diagnosis as $dk => $dv) {
                                                    ?>
                                                    <div class="col-4 mydiv">
                                                        <h6 class=""><?php echo $dv->label ?></h6>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label class="label-control text-sm myLabel"
                                                                           for="diagnosis_<?php echo $dv->variable ?>_u5">Under
                                                                        5</label>
                                                                    <input type="text" data-allow-zero="1" min="1"
                                                                           minlength="1" max="4"
                                                                           maxlength="4" value="0" placeholder="Under 5"
                                                                           data-key="<?php echo $dv->variable ?>_u5"
                                                                           class="form-control input-sm numberonly u5 diagnosis diagnosis_<?php echo $dv->variable ?>_u5"
                                                                           id="diagnosis_<?php echo $dv->variable ?>_u5"
                                                                           required>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label class="label-control text-sm-left myLabel"
                                                                           for="diagnosis_<?php echo $dv->variable ?>_a5">Above
                                                                        5</label>
                                                                    <input type="text" data-allow-zero="1" min="1"
                                                                           minlength="1" max="4"
                                                                           maxlength="4" value="0" placeholder="Above 5"
                                                                           data-key="<?php echo $dv->variable ?>_a5"
                                                                           class="form-control input-sm numberonly a5 diagnosis <?php echo $dv->variable ?>_a5 diagnosis_<?php echo $dv->variable ?>_a5"
                                                                           id="diagnosis_<?php echo $dv->variable ?>_a5"
                                                                           required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }
                                            } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary mybtn col-12"
                                                        onclick="addData()">
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        changeDistricts('district_select', 'ucs_select', 1);
        $('.addbtn').click(function () {
            $('#addModal').modal('show');
        });
        mydate();
        $('.numberonly').keypress(function (e) {
            var charCode = (e.which) ? e.which : event.keyCode
            if (String.fromCharCode(charCode).match(/[^0-9]/g))
                return false;
        });

        $(function () {
            $("#resources").select2({
                maximumSelectionLength: 4,
                formatSelectionTooBig: function (limit) {

                    // Callback

                    return 'You can only choose 4 vaccinators';
                }
            });
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

    function addData() {
        $('#opd').removeClass('error');
        $('#under_five_child').removeClass('error');
        $('#wra').removeClass('error');
        $('#pw').removeClass('error');
        $('#wra_vaccinated').removeClass('error');
        $('#children_vaccinated').removeClass('error');
        $('#exact_location').removeClass('error');
        $('#children_received_opv').removeClass('error');
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
        data['exact_location'] = $('#exact_location').val();
        data['children_received_opv'] = $('#children_received_opv').val();
        data['resources'] = $('#resources').val();


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

        var arr_diagnosis = {};
        var diagnosis = $('.diagnosis');
        for (i = 0; i < diagnosis.length; i++) {
            var key = $(diagnosis[i]).attr('data-key');
            var value = $(diagnosis[i]).val();
            if (value == undefined || value == '') {
                $(diagnosis[i]).addClass('error');
                toastMsg('Error', 'Invalid Diagnosis Number', 'error');
                return false;
            } else {
                $(diagnosis[i]).removeClass('error');
            }
            arr_diagnosis[key] = value;
        }
        data['diagnosis'] = arr_diagnosis;

        if (validateDt) {
            var tot = parseInt(data['under_five_child']) + parseInt(data['wra']);
            if (parseInt(tot) > parseInt(data['opd'])) {
                flag = 1;
                $('#opd').addClass('error');
                toastMsg('Error', 'Total - recorded should not be greater than Total OPD', 'error');
                return false;
            }
            if (parseInt(data['children_vaccinated']) > parseInt(data['under_five_child'])) {
                flag = 1;
                $('#under_five_child').addClass('error');
                $('#children_vaccinated').addClass('error');
                toastMsg('Error', 'Children Vaccinated should not be greater than Children under 5', 'error');
                return false;
            }

            if (parseInt(data['wra_vaccinated']) > parseInt(data['wra'])) {
                flag = 1;
                $('#wra').addClass('error');
                $('#wra_vaccinated').addClass('error');
                toastMsg('Error', 'WRA Vaccinated should not be greater than WRA', 'error');
                return false;
            }

            if (flag == 0) {
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
    }

    function changeDistricts(dist, uc, filter) {
        var data = {};
        data['district'] = $('#' + dist).val();
        data['round'] = 0;
        var items = '<option value="0" disabled readonly="">UCs</option>';
        var items_staff = '';
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
            CallAjax('<?php echo base_url() . 'index.php/Daily_reports/getStaffByDistrict'  ?>', data, 'POST', function (res) {

                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items_staff += '<option value="' + v.id + '" >' + v.name + ' (' + v.designation + '-' + v.type + ')</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#resources').html('').html(items_staff);
            });
        } else {
            $('#resources').html('');
        }
    }

    function changeUCs(uc, area, filter) {
        var data = {};
        data['uc'] = $('#' + uc).val();
        data['filter'] = 0;
        data['round'] = 0;
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


</script>