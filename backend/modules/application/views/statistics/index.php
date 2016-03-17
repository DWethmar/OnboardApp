<?php

$prepared_data = [];
foreach ($completed_step_data as $key => $element) {
    $prepared_data[] = [$key, $element['duration'], 1];
}
$prepared_json_data = json_encode($prepared_data);

$prepared_data2 = [];
foreach ($unfinished_step_data as $key2 => $element) {
    $prepared_data2[] = [$key2, $element['duration'], 2];
}
$prepared_json_data2 = json_encode($prepared_data2);
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('number', 'key');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'type');

        data.addRows(<?= $prepared_json_data ?>);
        data.addRows(<?= $prepared_json_data2 ?>);

        var options = {
            title: 'Completed steps duration scatter',
            hAxis: {title: 'Index (ordered by create date)', minValue: 0, maxValue: 15},
            vAxis: {title: 'duration in sec', minValue: 0, maxValue: 15, logScale: true},
            legend: 'none'
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>

<div id="chart_div" style="width: 100%; height: 500px;"></div>