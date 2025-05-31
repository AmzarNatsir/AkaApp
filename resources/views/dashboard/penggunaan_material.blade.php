<div class="col-sm-12 col-xl-6 box-col-6">
    <div class="card">
        <div class="card-header">
            <h4>Pie Chart </h4>
        </div>
        <div class="card-body apex-chart">
            <div id="piechart"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    // pie chart
    var options8 = {
    chart: {
        width: 380,
        type: "pie",
    },
    labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
    series: [44, 55, 13, 43, 22],
    responsive: [
        {
        breakpoint: 480,
        options: {
            chart: {
            width: 200,
            },
            legend: {
            show: false,
            },
        },
        },
    ],
    colors: [
        RihoAdminConfig.primary,
        RihoAdminConfig.secondary,
        "#51bb25",
        "#173878",
        "#f8d62b",
    ],
    };

    var chart8 = new ApexCharts(document.querySelector("#piechart"), options8);

    chart8.render();

});
</script>
