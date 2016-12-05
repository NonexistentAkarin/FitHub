<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Athletics
        <small>See your own Athletics data</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Athletics</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-android-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Athletics For</span>
                    <span class="info-box-number">
                        <?php echo $info->count; ?>
                    </span>
                    <span class="info-box-text">
                        Days
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-fireball"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Burned</span>
                    <span class="info-box-number">
                        <?php echo $info->calSum; ?>
                    </span>
                    <span class="info-box-text">
                        Calories
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-android-walk"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Walked</span>
                    <span class="info-box-number">
                        <?php echo $info->stpSum; ?>
                    </span>
                    <span class="info-box-text">
                        Steps
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-android-car"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Far from</span>
                    <span class="info-box-number">
                        <?php echo $info->disSum; ?>
                    </span>
                    <span class="info-box-text">
                        Kilometers
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Weekly Report</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-wrench"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-center">
                                <strong>Sleep: Time on bed</strong>
                            </p>

                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="salesChart" style="height: 180px;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <p class="text-center">
                                <strong>Goal Completion</strong>
                            </p>

                            <div class="progress-group">
                                <span class="progress-text">Days with enough sleeop</span>
                                <span class="progress-number"><b><?php echo $sleep_count->count?></b>/7</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-aqua" style="width:<?php echo round(($sleep_count->count)/7*100)?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Days with enough steps</span>
                                <span class="progress-number"><b><?php echo $stp_count->count?></b>/7</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-red" style="width:<?php echo round(($stp_count->count)/7*100)?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Days with enough distance</span>
                                <span class="progress-number"><b><?php echo $dis_count->count?></b>/7</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-green" style="width:<?php echo round(($dis_count->count)/7*100)?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Days with upload</span>
                                <span class="progress-number"><b><?php echo $count_count->count?></b>/7</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-yellow" style="width:<?php echo round(($count_count->count)/7*100)?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <?php
                                $differ=$week_info->sleepSum-$last_week_info->sleepSum;
                                if($differ!=null&&$last_week_info->sleepSum!=0){
                                    $differ=$differ/$last_week_info->sleepSum;
                                    if($differ<0){
                                        echo "<span class=\"description-percentage text-red\"><i class=\"fa fa-caret-down\"></i> ";
                                    }elseif($differ>0){
                                        echo "<span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> ";
                                    }else{
                                        echo "<span class=\"description-percentage text-yellow\"><i class=\"fa fa-caret-left\"></i> ";
                                    }
                                    echo abs(round($differ*100))."%</span>";
                                }else{
                                    echo "<span class=\"description-percentage text-yellow invisible\"><i class=\"fa fa-caret-left\"></i> ";
                                    echo "0%</span>";
                                }
                                ?>
                                <h5 class="description-header"><?php echo $week_info->sleepSum; ?> MINUTES</h5>
                                <span class="description-text">TOTAL SLEEP TIME</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <?php
                                $differ=$week_info->calSum-$last_week_info->calSum;
                                if($differ!=null&&$last_week_info->calSum!=0){
                                    $differ=$differ/$last_week_info->calSum;
                                    if($differ<0){
                                        echo "<span class=\"description-percentage text-red\"><i class=\"fa fa-caret-down\"></i> ";
                                    }elseif($differ>0){
                                        echo "<span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> ";
                                    }else{
                                        echo "<span class=\"description-percentage text-yellow\"><i class=\"fa fa-caret-left\"></i> ";
                                    }
                                    echo abs(round($differ*100))."%</span>";
                                }else{
                                    echo "<span class=\"description-percentage text-yellow invisible\"><i class=\"fa fa-caret-left\"></i> ";
                                    echo "0%</span>";
                                }
                                ?>
                                <h5 class="description-header"><?php echo $week_info->calSum; ?> CALORIES</h5>
                                <span class="description-text">TOTAL CALORIES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <?php
                                $differ=$week_info->stpSum-$last_week_info->stpSum;
                                if($differ!=null&&$last_week_info->stpSum!=0){
                                    $differ=$week_info->stpSum-$last_week_info->stpSum;
                                    $differ=$differ/$last_week_info->stpSum;
                                    if($differ<0){
                                        echo "<span class=\"description-percentage text-red\"><i class=\"fa fa-caret-down\"></i> ";
                                    }elseif($differ>0){
                                        echo "<span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> ";
                                    }else{
                                        echo "<span class=\"description-percentage text-yellow\"><i class=\"fa fa-caret-left\"></i> ";
                                    }
                                    echo abs(round($differ*100))."%</span>";
                                }else{
                                    echo "<span class=\"description-percentage text-yellow invisible\"><i class=\"fa fa-caret-left\"></i> ";
                                    echo "0%</span>";
                                }
                                ?>
                                <h5 class="description-header"><?php echo $week_info->stpSum; ?> STEPS</h5>
                                <span class="description-text">TOTAL STEPS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block">
                                <?php
                                $differ=$week_info->disSum-$last_week_info->disSum;
                                if($differ!=null&&$last_week_info->disSum!=0){
                                        $differ=$differ/$last_week_info->disSum;
                                        if($differ<0){
                                            echo "<span class=\"description-percentage text-red\"><i class=\"fa fa-caret-down\"></i> ";
                                        }elseif($differ>0){
                                            echo "<span class=\"description-percentage text-green\"><i class=\"fa fa-caret-up\"></i> ";
                                        }else{
                                            echo "<span class=\"description-percentage text-yellow\"><i class=\"fa fa-caret-left\"></i> ";
                                        }
                                        echo abs(round($differ*100))."%</span>";
                                    }else{
                                        echo "<span class=\"description-percentage text-yellow invisible\"><i class=\"fa fa-caret-left\"></i> ";
                                        echo "</span>";
                                    }
                                ?>
                                <h5 class="description-header"><?php echo $week_info->disSum; ?> KILOMETERS</h5>
                                <span class="description-text">TOTAL DISTANCES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->
<script src="<?php echo base_url(); ?>resource/adminlte/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>resource/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>resource/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resource/adminlte/plugins/chartjs/Chart.min.js"></script>
<script>
    $(function () {

        'use strict';

        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //-----------------------
        //- MONTHLY SALES CHART -
        //-----------------------

        // Get context with jQuery - using jQuery's .get() method.
        var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var salesChart = new Chart(salesChartCanvas);

        var salesChartData = {
            labels: <?php echo json_encode($date); ?>,
            datasets: [
                {
                    label: "Time Asleep",
                    fillColor: "rgb(210, 214, 222)",
                    strokeColor: "rgb(210, 214, 222)",
                    pointColor: "rgb(210, 214, 222)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgb(220,220,220)",
                    data: <?php echo json_encode($minAsleep); ?>
                },
                {
                    label: "Time Awake",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: <?php echo json_encode($minAwake); ?>
                }
            ]
        };

        var salesChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };

        //Create the line chart
        salesChart.Line(salesChartData, salesChartOptions);

        //---------------------------
        //- END MONTHLY SALES CHART -
        //---------------------------

    });
</script>
