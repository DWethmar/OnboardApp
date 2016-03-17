<?php
$set1 = json_encode($data1);
$set2 = json_encode($data2);

//var_dump($data1);
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Key');
        data.addColumn('number', 'Duration');
        data.addColumn({ type: 'string', role: 'style' });
        data.addColumn({ type: 'string', role: 'tooltip' });

        data.addRows(<?= $set1 ?>);
        data.addRows(<?= $set2 ?>);

        var options = {
            title: 'Completed Chains duration scatter (key, duration)',
            hAxis: {title: 'Chains'},
            vAxis: {title: 'duration in sec', logScale: true},
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>

<div id="chart_div" style="width: 100%; height: 500px;"></div>