<script>

// For the Market Cap Pie Chart
// function makePieChart(piechartid,val1,val2,val3,val4,TotalC){

    <?php 
    
    echo "function makePieChart(piechartid,";
    for ($x = 0; $x <= $PIE_COUNT; $x++){
        echo "val".$x,",";
    }
    
    echo "TotalC){";

?>
if ($('#' + piechartid).length) {

    zingchart.THEME = "classic";

    var myConfig = {
        "globals": {
            "font-family": "Roboto"
        },
        "graphset": [{
                "type": "pie",
                "background-color": "#fff",
                "legend": {
                    "background-color": "none",
                    "border-width": 0,
                    "shadow": false,
                    "layout": "float",
                    "margin": "auto auto 16% auto",
                    "marker": {
                        "border-radius": 4,
                        "border-width": 0
                    },
                    "item": {
                        "color": "%backgroundcolor"
                    }
                },
                "plotarea": {
                    "background-color": "#FFFFFF",
                    "border-color": "#DFE1E3",
                    "margin": "25% 8%"
                },
                "labels": [{
                    "x": "45%",
                    "y": "47%",
                    "width": "10%",
                    "text": "$ "+ TotalC + " B",
                    "font-size": 17,
                    "font-weight": 700
                }],
                "plot": {
                    "size": 70,
                    "slice": 90,
                    "margin-right": 0,
                    "border-width": 0,
                    "shadow": 0,
                    "value-box": {
                        "visible": true
                    },
                    "tooltip": {
                        "text": "$ %v",
                        "shadow": false,
                        "border-radius": 2
                    }
                },
                'series': [
                <?php
                    // echo 
                    $colorPallet = ['#ffa500','#246d0c','#ff4040','#05135a','#854442','#246d0c','#ff4040','#05135a','#ff4040','#fff4e6'];
                    for ($x = 0; $x <= $PIE_COUNT; $x++){

                        if ($x > 0){
                            echo ",";
                        }
                        echo "{'values': [val".$x."],";
                        echo "'text': '".$resultLV[$x]['coinname']."',";
                        echo "'background-color': '".$colorPallet[$x]."'";
                        echo "}";
                        
                    }

                ?>
                ]
            }

        ]
    };

    zingchart.render({
        id: piechartid,
        data: myConfig,
    });
}

}


function volumne24graph(coinsymbol,graphID,allPoints,allPointTimes,back_color,border_color){
    if ($("#"+graphID).length) {
    var ctx = document.getElementById(graphID).getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
        // The data for our dataset
        data: {
            labels: allPointTimes,
            datasets: [{
                label: "Volume",
                backgroundColor: back_color,
                borderColor: border_color,
                data: allPoints,
            }]
        },
        // Configuration options go here
        options: {
            legend: {
                display: false
            },
            animation: {
                // easing: "easeInOutBack"
            },
            scales: {
                yAxes: [{
                    display: !1,
                    ticks: {
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold",
                        beginAtZero: !0,
                        maxTicksLimit: 5,
                        padding: 0
                    },
                    gridLines: {
                        drawTicks: !1,
                        display: !1
                    }
                }],
                xAxes: [{
                    display: !1,
                    gridLines: {
                        zeroLineColor: "transparent"
                    },
                    ticks: {
                        padding: 0,
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "bold"
                    }
                }]
            }
        }
    });
}
}


function liveBarChart(allSymbols,allVolume,yaxisval){
    if ($('#ambarchart4').length) {
    var chart = AmCharts.makeChart("ambarchart4", {
        "type": "serial",
        "theme": "light",
        "marginRight": 70,
        "dataProvider": [
            {"CC": allSymbols[0],"visits": allVolume[0],"color": "#8918FE"},
            {"CC": allSymbols[1],"visits": allVolume[1],"color": "#7474F0"},
            {"CC": allSymbols[2],"visits": allVolume[2],"color": "#C5C5FD"},
            {"CC": allSymbols[3],"visits": allVolume[3],"color": "#952FFE"},
            {"CC": allSymbols[4],"visits": allVolume[4],"color": "#7474F0"},
            {"CC": allSymbols[5],"visits": allVolume[5],"color": "#CBCBFD"},
            {"CC": allSymbols[6],"visits": allVolume[6],"color": "#FD9C21"},
            {"CC": allSymbols[7],"visits": allVolume[7],"color": "#0D8ECF"},
            {"CC": allSymbols[8],"visits": allVolume[8],"color": "#0D52D1"},
            {"CC": allSymbols[9],"visits": allVolume[9],"color": "#2A0CD0"}
        ],
        "valueAxes": [{"axisAlpha": 0,"position": "left","title": false}],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "visits"
        }],
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": true
        },
        "categoryField": "CC",
        "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
        },
        "export": {
            "enabled": false
        },
        "allLabels": [{
            "text": "Cryptocurrency",
            "x": "!401",
            "y": "!20",
            "width": "50%",
            "size": 15,
            "bold": true,
            "align": "right"
        }, {
            "text": yaxisval,
            "rotation": 270,
            "x": "4",
            "y": "120",
            "width": "50%",
            "size": 15,
            "bold": true,
            "align": "right"
        }]

    });
}
}

</script>


<script>
$(document).ready(function() {

var currentPrice = {};
var socket = io.connect('https://streamer.cryptocompare.com/');
//Format: {SubscriptionId}~{ExchangeName}~{FromSymbol}~{ToSymbol}
//Use SubscriptionId 0 for TRADE, 2 for CURRENT, 5 for CURRENTAGG eg use key '5~CCCAGG~BTC~USD' to get aggregated data from the CCCAGG exchange 
//Full Volume Format: 11~{FromSymbol} eg use '11~BTC' to get the full volume of BTC against all coin pairs
//For aggregate quote updates use CCCAGG ags market
<?php 
$cma = 0;
echo 'var subscription = [';
for ($x = 0; $x <= 2; $x++) {
        
        if( $cma > 0){
            echo ',';
        }
        echo '"5~CCCAGG~'.$resultLV[$x]['symbol'].'~USD", "11~'.$resultLV[$x]['symbol'].'"';
        
        $cma = $cma + 1;
    } 
    echo '];';
?>
socket.emit('SubAdd', { subs: subscription });
socket.on("m", function(message) {
    var messageType = message.substring(0, message.indexOf("~"));
    if (messageType == CCC.STATIC.TYPE.CURRENTAGG) {
        dataUnpack(message);
    }
    else if (messageType == CCC.STATIC.TYPE.FULLVOLUME) {
        decorateWithFullVolume(message);
    }
});

var dataUnpack = function(message) {
    var data = CCC.CURRENT.unpack(message);

    var from = data['FROMSYMBOL'];
    var to = data['TOSYMBOL'];
    var fsym = CCC.STATIC.CURRENCY.getSymbol(from);
    var tsym = CCC.STATIC.CURRENCY.getSymbol(to);
    var pair = from + to;

    if (!currentPrice.hasOwnProperty(pair)) {
        currentPrice[pair] = {};
    }

    for (var key in data) {
        currentPrice[pair][key] = data[key];
    }

    if (currentPrice[pair]['LASTTRADEID']) {
        currentPrice[pair]['LASTTRADEID'] = parseInt(currentPrice[pair]['LASTTRADEID']).toFixed(0);
    }
    currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
    currentPrice[pair]['CHANGE24HOURPCT'] = ((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100).toFixed(2) + "%";
    displayData(currentPrice[pair], from, tsym, fsym);
};

var decorateWithFullVolume = function(message) {
    var volData = CCC.FULLVOLUME.unpack(message);
    var from = volData['SYMBOL'];
    var to = 'USD';
    var fsym = CCC.STATIC.CURRENCY.getSymbol(from);
    var tsym = CCC.STATIC.CURRENCY.getSymbol(to);
    var pair = from + to;

    if (!currentPrice.hasOwnProperty(pair)) {
        currentPrice[pair] = {};
    }

    currentPrice[pair]['FULLVOLUMEFROM'] = parseFloat(volData['FULLVOLUME']);
    currentPrice[pair]['FULLVOLUMETO'] = ((currentPrice[pair]['FULLVOLUMEFROM'] - currentPrice[pair]['VOLUME24HOUR']) * currentPrice[pair]['PRICE']) + currentPrice[pair]['VOLUME24HOURTO'];
    displayData(currentPrice[pair], from, tsym, fsym);
};

var displayData = function(messageToDisplay, from, tsym, fsym) {
    var priceDirection = messageToDisplay.FLAGS;
    var fields = CCC.CURRENT.DISPLAY.FIELDS;

    for (var key in fields) {
        if (messageToDisplay[key]) {
            if (fields[key].Show) {
                switch (fields[key].Filter) {
                    case 'String':
                        $('#' + key + '_' + from).text(messageToDisplay[key]);
                        break;
                    case 'Number':
                        var symbol = fields[key].Symbol == 'TOSYMBOL' ? tsym : fsym;
                        $('#' + key + '_' + from).text(CCC.convertValueToDisplay(symbol, messageToDisplay[key]))
                        break;
                }
            }
        }
    }

    $('#PRICE_' + from).removeClass();
    if (priceDirection & 1) {
        $('#PRICE_' + from).addClass("up");
    }
    else if (priceDirection & 2) {
        $('#PRICE_' + from).addClass("down");
    }

    if (messageToDisplay['PRICE'] > messageToDisplay['OPEN24HOUR']) {
        $('#CHANGE24HOURPCT_' + from).removeClass();
        $('#CHANGE24HOURPCT_' + from).addClass("pct-up");
    }
    else if (messageToDisplay['PRICE'] < messageToDisplay['OPEN24HOUR']) {
        $('#CHANGE24HOURPCT_' + from).removeClass();
        $('#CHANGE24HOURPCT_' + from).addClass("pct-down");
    }
};
});




function liveL2OrderBook(){

// var eLC = document.getElementById("L2orderSymbolSelector");
// var sLC = eLC.options[eLC.selectedIndex].value;



var Market = "Binance"
var fsym = "BTC";
var tsym = "USD";
var api_key="23489088ccc5e95cef763cbedd2d27588a979595edb097f53f40ad7d76239d41";
var Url = "https://min-api.cryptocompare.com/data/ob/l2/snapshot?fsym=" + fsym + "&e=" + Market + "&api_key=" + api_key;

var maxTableSize = 3;
var length = $('#l2orderBid tr').length;
var length2 = $('#l2orderAsks tr').length;

$.getJSON(Url, function(data3) {


    if(data3['Response'] == 'Success'){
        for (var i = 0 ; i<5 ; ++i){
        if (length>= (maxTableSize)) {
            $('#l2orderBid tr:last').remove();
        }
        if (length2>= (maxTableSize)) {
            $('#l2orderAsks tr:last').remove();
        }
        $('#l2orderBidBody').after("<tr>"+
        "<td class='coin-name'   style='color:#028900;'>" + Market+"</td>"+
        "<td class='attachments' style='color:#028900;'>" +fsym + "</td>"+
        "<td class='attachments' style='color:#028900;'>" +  data3['Data']['bids'][i]+  "</td>"+
        "</tr>");
        $('#l2orderAsksBody').after("<tr>"+
        "<td class='coin-name'   style='color:#cb2424;'>" + Market+"</td>"+
        "<td class='attachments' style='color:#cb2424;'>" +fsym + "</td>"+
        "<td class='attachments' style='color:#cb2424;'>" +  data3['Data']['asks'][i]+  "</td>"+
        "</tr>");
    }
}
else {
    $('#l2orderBidBody').after("<tr>"+
        "<td class='coin-name'   style='color:#028900;'>" + Market + " is not valid. </td>"+
        "<td class='attachments' style='color:#028900;'>Market does not exist</td>"+
        "<td class='attachments' style='color:#028900;'> </td>"+
        "</tr>");
        $('#l2orderAsksBody').after("<tr>"+
        "<td class='coin-name'   style='color:#028900;'>" + Market + " is not valid. </td>"+
        "<td class='attachments' style='color:#028900;'>Market does not exist</td>"+
        "<td class='attachments' style='color:#028900;'> </td>"+
        "</tr>"); 

        if (length>= (maxTableSize)) {
            $('#l2orderBid tr:last').remove();
        }
        if (length2>= (maxTableSize)) {
            $('#l2orderAsks tr:last').remove();
        }
}

    
    
    

});


}
$(document).on('change','#L2orderSymbolSelector',function(){
  
    // var eLC2 = document.getElementById("L2orderSymbolSelector");
    // var sLC2 = eLC2.options[eLC2.selectedIndex].value;
    // alert(sLC2);
    // $("#LiveTradeSymbolID").text(sLC2)
    liveL2OrderBook();
});
</script>