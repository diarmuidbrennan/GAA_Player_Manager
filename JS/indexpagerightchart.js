

$(function () {
  var chart;
  $(document).ready(function() {
    chart = new Highcharts.Chart({




        chart: {
            renderTo: 'chart',
            plotBackgroundColor: '#A3BDDA',
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Injuries 2016'
        },
        tooltip: {
            
            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            percentageDecimals: 2
        },




        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Player Injuries',
            data: [
                ['Head', 8.33],
                ['Shoulder', 8.33],
                {
                    name: 'Hand',
                    y: 8.33,
                    sliced: true,
                    selected: true
                },
                ['Knee', 8.33],
                ['Back', 8.33],
                ['Hip', 8.33],
                ['Groin', 8.33],
                ['Hamstring', 8.33],
                ['Quad', 8.33],
                ['Calf', 8.33],
                ['Ankle', 8.33],
                ['Foot', 8.33]
            ]
        }]
    });
});

});