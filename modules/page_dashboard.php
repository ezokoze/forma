<?php require_once('lib/config.php'); ?>

    <div class="row">
        
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <h1>Bienvenue sur la page d'accueil <b><?php echo $_SESSION['utilisateurs_prenom'] . ' ' . $_SESSION['utilisateurs_nom']; ?></b></h1>
            <header>
                <h2>Inscriptions sur l'année</h2>
            </header>

            <div>

                <div class="jarviswidget-editbox">
                    <input class="form-control" type="text">
                </div>

                <div class="widget-body">
                    <canvas id="barChart" height="120"></canvas>
                </div>

            </div>

        </article>


        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

            <header>
                <h2>Taux d'inscription par catégorie</h2>
            </header>

            <div>
                <div class="jarviswidget-editbox">
                    <input class="form-control" type="text">
                </div>

                <div class="widget-body">
                    <canvas id="radarChart" height="120"></canvas>
                </div>
            </div>

        </article>

    </div>


<script type="text/javascript">
    $(document).ready(function () {

        pageSetUp();

        var myNewChart_1, myNewChart_2, myNewChart_3, myNewChart_4, myNewChart_5, myNewChart_6;

        // pagefunction

        var pagefunction = function () {

            // reference: http://www.chartjs.org/docs/

            // BAR CHART

            var barOptions = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 1,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
                //Boolean - Re-draw chart on page resize
                responsive: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
            }

            var barData = {
                labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
                datasets: [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
                        data: [65, 59, 80, 81, 56, 55, 40]
                    },
                    {
                        label: "My Second dataset",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
                        data: [28, 48, 40, 19, 86, 27, 90]
                    }
                ]
            };

            // render chart
            var ctx = document.getElementById("barChart").getContext("2d");
            myNewChart_2 = new Chart(ctx).Bar(barData, barOptions);

            // END BAR CHART

            // RADAR CHART

            var radarData = {
                labels: ["Office", "Photoshop", "Recherche internet", "Préstashop", "Sécurité", "Réseaux sociaux", "Profil"],
                datasets: [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: [65, 59, 90, 81, 56, 55, 40]
                    },
                    {
                        label: "My Second dataset",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: [28, 48, 40, 19, 96, 27, 100]
                    }
                ]
            };

            var radarOptions = {
                //Boolean - Whether to show lines for each scale point
                scaleShowLine: true,
                //Boolean - Whether we show the angle lines out of the radar
                angleShowLineOut: true,
                //Boolean - Whether to show labels on the scale
                scaleShowLabels: false,
                // Boolean - Whether the scale should begin at zero
                scaleBeginAtZero: true,
                //String - Colour of the angle line
                angleLineColor: "rgba(0,0,0,.1)",
                //Number - Pixel width of the angle line
                angleLineWidth: 1,
                //String - Point label font declaration
                pointLabelFontFamily: "'Arial'",
                //String - Point label font weight
                pointLabelFontStyle: "normal",
                //Number - Point label font size in pixels
                pointLabelFontSize: 10,
                //String - Point label font colour
                pointLabelFontColor: "#666",
                //Boolean - Whether to show a dot for each point
                pointDot: true,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 3,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a colour
                datasetFill: true,
                //Boolean - Re-draw chart on page resize
                responsive: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
            }

            // render chart
            var ctx = document.getElementById("radarChart").getContext("2d");
            myNewChart_5 = new Chart(ctx).Radar(radarData, radarOptions);

            // END RADAR CHART

        };
        loadScript("assets/js/plugin/chartjs/chart.min.js", pagefunction);
    });

</script>
