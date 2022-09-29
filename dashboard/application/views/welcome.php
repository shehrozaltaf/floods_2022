<style>
    .card-body {
        padding: 8px !important;
    }

    table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tfoot th, table.table-bordered.dataTable tbody td {
        padding: 3px !important;
    }
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body ">

            <section id="statistics-card">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="card text-white bg-gradient-danger text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <h2 class="card-title text-white">
                                        <?= $total_opd ?>
                                    </h2>
                                    <p class="card-text">Total Beneficiaries</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="card text-white bg-gradient-success text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <h2 class="card-title text-white">
                                        <?= $total_daily_reports ?>
                                    </h2>
                                    <p class="card-text">Total Camp Days</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xl-3">
                        <div class="card text-white bg-gradient-primary text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <h2 class="card-title text-white">
                                        <?= $total_u5 ?>
                                    </h2>
                                    <p class="card-text">Under 5 Children</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xl-3">
                        <div class="card text-white bg-gradient-success text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <h2 class="card-title text-white">
                                        <?= $total_wra ?>
                                    </h2>
                                    <p class="card-text">WRAs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xl-3">
                        <div class="card text-white bg-gradient-warning text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <h2 class="card-title text-white">
                                        <?= $total_pw ?>
                                    </h2>
                                    <p class="card-text">PWs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xl-3">
                        <div class="card text-white bg-gradient-light text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <h2 class="card-title text-white">
                                        <?= $total_children_vaccinated ?>
                                    </h2>
                                    <p class="card-text">Children Vaccinated</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-sm-6 col-md-3 col-xl-3">
                        <div class="card text-white bg-gradient-info text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <h2 class="card-title text-white">
                                        < ?/*= $total_wra_vaccinated */?>
                                    </h2>
                                    <p class="card-text">WRA Vaccinated </p>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <!--<div class="row">
                    <div class="col-12">
                        <iframe  style="height:800px;width:100%;" src="https://worldview.earthdata.nasa.gov/?v=60.46276597891948,21.51266097452747,77.04582817310704,29.69191092134811&l=Reference_Labels_15m,Reference_Features_15m,Coastlines_15m,MODIS_Aqua_CorrectedReflectance_Bands721,MODIS_Aqua_CorrectedReflectance_TrueColor&lg=true&l1=Reference_Labels_15m,Reference_Features_15m,Coastlines_15m,MODIS_Combined_Flood_3-Day,MODIS_Aqua_CorrectedReflectance_Bands721,MODIS_Aqua_CorrectedReflectance_TrueColor&lg1=true&ca=false&t=2022-08-30-T14%3A38%3A55Z&t1=2022-08-30-T15%3A08%3A55Z" title="description"></iframe>
                    </div>
                </div>-->
            </section>
            <section id="column-selectors2">
                <div class="row">
                    <div class="col-sm-12 col-md-6 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Top Diagnosis (Under 5 years) </h4>
                                <br>
                                <p class="text-danger">Total Under 5 years: <?= $total_u5_d ?></p>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped ">
                                            <thead>
                                            <tr>
                                                <th>Diagnosis</th>
                                                <th>Numbers</th>
                                                <th>Percentage</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($diagnosis['u5']) && $diagnosis['u5'] != '') {
                                                arsort($diagnosis['u5']);
                                                $i = 0;
                                                foreach ($diagnosis['u5'] as $k => $r) {
                                                    $i++;
                                                    $diag_var = trim($k);
                                                    $diag_num = (isset($r['numbers']) && $r['numbers'] != '' ? $r['numbers'] : 0);
                                                    $diag_perc = (isset($r['percentage']) && $r['percentage'] != '' ? $r['percentage'] : 0);
                                                    if ($i <= 5) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $diag_var ?></td>
                                                            <td><?php echo $diag_num ?></td>
                                                            <td><?php echo number_format($diag_perc, 1) ?>%</td>

                                                        </tr>
                                                    <?php }
                                                }
                                            } ?>


                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Diagnosis</th>
                                                <th>Numbers</th>
                                                <th>Percentage</th>
                                            </tr>

                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Top Diagnosis (5 years & Above) </h4>
                                <br>
                                <p class="text-danger">Total 5 years & Above: <?= $total_a5_d ?></p>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped ">
                                            <thead>
                                            <tr>
                                                <th>Diagnosis</th>
                                                <th>Numbers</th>
                                                <th>Percentage</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($diagnosis['a5']) && $diagnosis['a5'] != '') {
                                                arsort($diagnosis['a5']);
                                                $j= 0;
                                                foreach ($diagnosis['a5'] as $k2 => $r2) {
                                                    $j++;
                                                    $diag_var2 = trim($k2);

                                                    $diag_num2 = (isset($r2['numbers']) && $r2['numbers'] != '' ? $r2['numbers'] : 0);
                                                    $diag_perc2 = (isset($r2['percentage']) && $r2['percentage'] != '' ? $r2['percentage'] : 0);
                                                    if ($j <= 5) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $diag_var2 ?></td>
                                                            <td><?php echo $diag_num2 ?></td>
                                                            <td><?php echo number_format($diag_perc2, 1) ?>%</td>
                                                        </tr>
                                                    <?php }
                                                }
                                            } ?>


                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Diagnosis</th>
                                                <th>Numbers</th>
                                                <th>Percentage</th>
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
            <section id="column-selectors">
                <div class="row">
                    <div class="col-sm-12 col-md-12 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Districts Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped  dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>District</th>
                                                <th>Camp Days</th>
                                                <th>OPD</th>
                                                <th>WRA</th>
                                                <th>Under 5 Children</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($getDistrict_DT) && $getDistrict_DT != '') {
                                                $Sno = 0;
                                                $num_of_days = 0;
                                                $sum_total_opd = 0;
                                                $sum_total_wra = 0;
                                                $sum_total_children = 0;
                                                foreach ($getDistrict_DT as $k => $r) {
                                                    $Sno++;
                                                    $num_of_days += (isset($r->num_of_days) && $r->num_of_days != '' ? $r->num_of_days : 0);
                                                    $sum_total_opd += (isset($r->sum_total_opd) && $r->sum_total_opd != '' ? $r->sum_total_opd : 0);
                                                    $sum_total_wra += (isset($r->sum_total_wra) && $r->sum_total_wra != '' ? $r->sum_total_wra : 0);
                                                    $sum_total_children += (isset($r->sum_total_children) && $r->sum_total_children != '' ? $r->sum_total_children : 0);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $Sno ?></td>
                                                        <td><?php echo $r->district ?></td>
                                                        <td><?php echo(isset($r->num_of_days) && $r->num_of_days != '' ? $r->num_of_days : 0) ?></td>
                                                        <td><?php echo(isset($r->sum_total_opd) && $r->sum_total_opd != '' ? $r->sum_total_opd : 0) ?></td>
                                                        <td><?php echo(isset($r->sum_total_wra) && $r->sum_total_wra != '' ? $r->sum_total_wra : 0) ?></td>
                                                        <td><?php echo(isset($r->sum_total_children) && $r->sum_total_children != '' ? $r->sum_total_children : 0) ?></td>

                                                    </tr>
                                                <?php }
                                            } ?>


                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Total</th>
                                                <th><?= $num_of_days ?></th>
                                                <th><?= $sum_total_opd ?></th>
                                                <th><?= $sum_total_wra ?></th>
                                                <th><?= $sum_total_children ?></th>
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
            <section id="map">
                <div class="row">
                    <div class="col-sm-12 col-md-6  ">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h4 class="card-title">Daily Progress</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6  ">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="<?php echo base_url() ?>assets/images/Flood Data Map_v2-min.jpg"
                                             class="img-fluid product-img" alt="product image">

                                    </div>

                                    <p class="ml-1">To View Complete Map at Worldview earthdata (NASA): <a
                                                href="https://worldview.earthdata.nasa.gov/?v=60.46276597891948,21.51266097452747,77.04582817310704,29.69191092134811&l=Reference_Labels_15m,Reference_Features_15m,Coastlines_15m,MODIS_Aqua_CorrectedReflectance_Bands721,MODIS_Aqua_CorrectedReflectance_TrueColor&lg=true&l1=Reference_Labels_15m,Reference_Features_15m,Coastlines_15m,MODIS_Combined_Flood_3-Day,MODIS_Aqua_CorrectedReflectance_Bands721,MODIS_Aqua_CorrectedReflectance_TrueColor&lg1=true&ca=false&t=2022-08-30-T14%3A38%3A55Z&t1=2022-08-30-T15%3A08%3A55Z"
                                                target="_blank">Click here</a></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


        </div>
    </div>
</div>
<!-- END: Content-->

<script src="<?php echo base_url() ?>assets/vendors/js/charts/chart.min.js"></script>

<script src="<?php echo base_url() ?>assets/vendors/js/charts/highcharts/highcharts.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/charts/highcharts/series-label.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/charts/highcharts/exporting.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/charts/highcharts/export-data.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/charts/highcharts/accessibility.js"></script>

<script>

    $(document).ready(function () {
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

    });

    $(function () {


        $.ajax({
            url: '<?php echo base_url()?>index.php/dashboard/dailyGraph',
            complete: function (json) {
                data = JSON.parse(json.responseText);
                console.log(data);
                // set some variable to host data
                var arrayString = [],
                    year_list = [],
                    array_final = []

                $.each(data, function (i, data) {
                    // fill the date array
                    year_list.push(data.camp_day);
                    // fill the string data array
                    arrayString.push(data.opd);
                });

                // querry send string that we need to convert into numbers
                for (var i = 0; i < arrayString.length; i++) {
                    if (arrayString[i] != null) {
                        array_final.push(parseInt(arrayString[i]))
                    } else {
                        array_final.push(null)
                    }
                    ;
                }

                var chart = new Highcharts.Chart({
                    chart: {
                        type: 'spline',
                        renderTo: 'container',
                        height: (11 / 16 * 100) + '%' // 16:9 ratio
                    },
                    title: {
                        text: 'Number of Beneficiaries'
                    },
                    tooltip: {
                        valueDecimals: 0,
                        pointFormat: '<span style="color:{point.color}">\u25CF</span>{series.name}:<b>{point.y}</b><br/>'
                    },
                    plotOptions: {
                        spline: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: true
                        },
                        series: {
                            marker: {
                                enabled: true
                            }
                        }
                    },
                    xAxis: {
                        categories: year_list.reverse() //.reverse() to have the min year on the left
                    },
                    series: [{
                        name: 'Beneficiaries',
                        data: array_final.reverse() //
                    }]
                });

            },
        });

    });
</script>