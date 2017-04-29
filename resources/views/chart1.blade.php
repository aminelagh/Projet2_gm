
<!--link href="{{ asset('charts/examples.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('charts/jquery.js') }}"></script>
<script src="{{ asset('charts/jquery.flot.js') }}"></script>
<script src="{{ asset('charts/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('charts/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('charts/jquery.flot.time.js') }}"></script>
<script src="{{ asset('charts/jquery.flot.tooltip.js') }}"></script-->







<!DOCTYPE HTML>
<html>
<head>
    <title>column basic</title>

</head>
<body>
<script src="charts/highcharts.js"></script>
<script src="charts/exporting.js"></script>

<div id="container" style="min-width: 310px; width: 100%;height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
    Highcharts.chart('container', {
        chart: {type: 'column'},
        title: {text: 'Title'},
        subtitle: {text: 'SourceText'},
        xAxis: {
            categories: [
                @foreach( $data1 as $item )
                '{{ $item->designation_c }}',
                @endforeach
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {text: 'Ventes'}
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: false,
            useHTML: true
        },
        plotOptions: { column: {pointPadding: 0.2,borderWidth: 0} },
        series: [
            {
                name: 'prix_vente',
                dataLabels: {align: "center",enabled: true},
                data: [
                    @foreach( $data1 as $item )
                    {{ $item->prix_vente }},
                    @endforeach
                ],

            },
            {
                name: 'prix_achat', //dataLabels: {align: "right",enabled: true},
                data: [{
                    x: 12,
                    y: 350,
                    name: "Point2",
                    color: "#00FF00"
                }, {
                    x: 12,
                    y: 200,
                    name: "Point1",
                    color: "#FF00FF"
                }],

            },
            {
                name: 'promotions',dataLabels: {align: "center",enabled: true},
                data: [
                    @foreach( $data2 as $item )
                    {{ $item->taux }},
                    @endforeach
                ],

            }

        ]
    });
</script>
</body>
</html>
