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
                                                <select class="select2 form-control ucs_select" id="ucs_select" >
                                                    <option value="0" selected>All UCs</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-6 col-12">
                                            <label for="user_select" class="label-control">Users</label>
                                            <div class="form-group">
                                                <select class="select2 form-control user_select" id="user_select">
                                                    <option value="0" selected>Users</option>
                                                    <?php if (isset($users) && $users != '') {
                                                        foreach ($users as $k => $u) {
                                                            echo '<option value="' .$u->username . '" ' . (isset($slug_username) && $slug_username == $u->username ? "selected" : "") . '>' . $u->full_name . ' ('.$u->username.')</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="camp_day" class="label-control">Entry Date</label>
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
                 ?>
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Entry Status </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>District</th>                                                                                              
                                                    <th>UC</th>                                                   
                                                    <th>Camp</th> 
                                                    <th>Username</th>
                                                    <th>Entry Date</th> 
                                                    <th>Number of records</th> 
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <?php
                                                $total_nn=0;
                                                if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $k => $r) {
                                                        $total_nn+=$r->nn;
                                                        echo '<tr>'; 
                                                        echo '<td>'.(isset($r->full_name) && $r->full_name!=''?$r->full_name:'-').'</td>';
                                                        echo '<td>'.(isset($r->camp_no) && $r->camp_no!=''?$r->camp_no:'-').'</td>';
                                                        echo '<td>'.(isset($r->district) && $r->district!=''?$r->district:'-').'</td>';
                                                        echo '<td>'.(isset($r->ucname) && $r->ucname !=''?$r->ucname :'-').'</td>';
                                                        echo '<td>'.(isset($r->entdt)  && $r->entdt!=''?$r->entdt:'-').'</td>';
                                                        echo '<td>'.(isset($r->nn) && $r->nn!=''?$r->nn:'-').'</td>'; 
                                                        echo '</tr>';
                                                        ?>
                                                    <?php }
                                                } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Total</th>                                                                                              
                                                    <th>-</th>                                                   
                                                    <th>-</th> 
                                                    <th>-</th>
                                                    <th>-</th> 
                                                    <th><?php echo $total_nn ?></th> 
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

<input type="hidden" id="hidden_slug_district" value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : ''); ?>">
<input type="hidden" id="hidden_slug_ucs" value="<?php echo(isset($slug_ucs) && $slug_ucs != '' ? $slug_ucs : ''); ?>">
<input type="hidden" id="hidden_slug_user" value="<?php echo(isset($slug_user) && $slug_user != '' ? $slug_user : ''); ?>">
<input type="hidden" id="hidden_slug_day" value="<?php echo(isset($slug_day) && $slug_day != '' ? $slug_day : ''); ?>">
<input type="hidden" id="hidden_slug_filter" value="<?php echo(isset($slug_filter) && $slug_filter != '' ? $slug_filter : ''); ?>">
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
            });

            CallAjax('<?php echo base_url() . 'index.php/Daily_reports/getUserByDistrict'  ?>', data, 'POST', function (res_user) {
                var items_user = '<option value="0">Select All</option>'; 
                var slug_user = $('#hidden_slug_user').val();
                if (res_user != '' && JSON.parse(res_user).length > 0) {
                    var response_user = JSON.parse(res_user);
                    try {
                        $.each(response_user, function (i, v) {
                            items_user += '<option value="' + v.username + '"  ' + (slug_user == v.username  ? 'selected' : '') + '>' + v.full_name + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#user_select').html('').html(items_user); 
            });
        } else {
            $('#' + uc).html('').html(items);
        }
    }

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        var username = $('.user_select').val();
        var day = $('.day_select').val();
       
       

        if (district == '' || district == undefined || district == '0') {
            district = '';
        }
        if (ucs == '' || ucs == undefined || ucs == '0') {
            ucs = '';
        }
    
        if (username == '' || username == undefined || username == '0') {
            username = '';
        }
        if (day == '' || day == undefined || day == '0') {
            day = '';
        }
        
        
        window.location.href = '<?php echo base_url() ?>index.php/entry_status?f=1&d=' + district + '&u=' + ucs+ '&us=' + username +  '&day=' + day ;
    }

</script>