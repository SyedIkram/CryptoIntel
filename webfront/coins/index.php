
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;

if (empty($_GET["coinsymbol"]))
{
  header('Location: ../');
  exit; 
} 

else{
    $coin_symbol = $_GET["coinsymbol"];
}
require $cur_dir.'vars.php';
// $message = exec("python phptest.py abcdefgh");
// print_r($message);
$cluster   = Cassandra::cluster()        
                 ->build();

$session   = $cluster->connect($keyspace);    


$statementLV = new Cassandra\SimpleStatement(  
    "SELECT id,coinname,imageurl from all_coins WHERE symbol='".$coin_symbol."' ALLOW FILTERING"
);
$futureLV    = $session->executeAsync($statementLV);  
$resultLV    = $futureLV->get();    

if (empty($resultLV[0]['coinname']))
{
  header('Location: ../');
  exit; 
} 

$tile_current= $resultLV[0]['coinname'];
$coin_id = $resultLV[0]['id'];
$coin_image_url = $resultLV[0]['imageurl'];
include $cur_dir.'pages/header.php';


?>
	<style>
		.blink {
		    -webkit-animation: blink 6s step-end infinite;
		            animation: blink 2s step-end infinite;
		}
		@-webkit-keyframes blink { 50% { visibility: hidden; }}
		        @keyframes blink { 50% { visibility: hidden; }}
    </style>
    
<body onunload="closeSocket()">
<div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        <?php include $cur_dir.'pages/sidebar.php';?>
        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="logo pull-left">
                        <a style ="margin-top:10px !important" href=<?php echo $cur_dir?>><img src= <?php echo $cur_dir."assets/images/icon/logo2.png";?> alt="logo"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-title-area">
                <div class="row align-items-center user-profile ">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="<?php echo $cur_dir; ?>">Home</a></li>
                                <li><span><?php echo $tile_current;?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-4 clearfix">
                    <div class="notification-area pull-right">
                        <?php
                        echo '<div class="cripto-live"><ul><li><span style="margin-right:130px !important; "><i id="livecoin'.$coin_symbol.'Arrow" class="fa fa-long-arrow-up" ></i>$ <b id="livecoin'.$coin_symbol.'">0.0</b></span></li></ul></div>';
                        ?>

                    </div>
                </div>
                </div>
                
            </div>
             <!-- main content area start -->
        <div class="main-content">

        
            <div class="main-content-inner">
                <div class="row">
                <div class="col-lg-3 mt-5">
                        <div class="card">
                            <div class="card-body pb-0">
                                <!-- <h4 class="header-title">Social ads Campain</h4>
                                <div id="socialads" style="height: 245px;"></div> -->
                                <?php 
                                    echo '<img style=" margin-bottom:25px !important; max-height: 246px;" src="https://www.cryptocompare.com'.$coin_image_url .'">';
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php

                    $url4 = 'https://min-api.cryptocompare.com/data/social/coin/histo/day?limit=360&coinId='.$coin_id.'&api_key=23489088ccc5e95cef763cbedd2d27588a979595edb097f53f40ad7d76239d41';
                    $content4 = file_get_contents($url4);
                    $json4 = json_decode($content4, true);

                    $i = 0;
                    $total_fb_likes = 0;
                    $total_twitter_followers = 0;
                    $total_reddit_comments_per_day = 0;
                    $total_code_repo_stars = 0;
                    
                    foreach($json4['Data'] as $item) {

                        $total_fb_likes = $total_fb_likes + $item['fb_likes'];
                        // $total_twitter_followers = $total_twitter_followers + $item['twitter_followers'];
                        $total_reddit_comments_per_day = $total_reddit_comments_per_day + round($item['reddit_comments_per_day']);
                        $total_code_repo_stars = $total_code_repo_stars + $item['code_repo_stars'];

                       
                    }

                    $total_twitter_followers = $json4['Data'][359]['twitter_followers'];
                    
                    ?>

                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-6 mt-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg3">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon"><i class="fa fa-reddit"></i> Comments Per Day</div>
                                            <h2><?php echo $total_reddit_comments_per_day;?></h2>
                                        </div>
                                        <canvas id="seolinechart1" height="50"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg2">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon"><i class="fa fa-twitter"></i> Followers</div>
                                            <h2><?php echo $total_twitter_followers;?></h2>
                                        </div>
                                        <canvas id="seolinechart2" height="50"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <div class="card">
                                    <div class="seo-fact sbg1">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon"><i class="fa fa-facebook-official"></i> Likes</div>
                                            <h2><?php echo $total_fb_likes;?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="seo-fact sbg4">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon"><i class="fa fa-github"></i> Stars</div>
                                        <h2><?php echo $total_code_repo_stars;?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Historical <?php echo $tile_current;?> Price from <span id="startdate"></span></h4>
                                <div id="user-statistics"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Statistics area end -->
                    <!-- Advertising area start -->
                    <div class="col-lg-4 mt-5">
                        <!-- <div class="card h-full"> -->
                        <div class="card h-full">
                            <div class="pricing-list">
                                <div class="prc-head">
                                    <h4>Predicted* <?php
                                        date_default_timezone_set('America/Los_Angeles');
                                    echo '<b>'.$tile_current.'</b> Price for <br><b>'.date("Y-m-d", strtotime("+1 day")).' PST</b>';?> </h4>
                                </div>
                                <div class="prc-list">
                                    <br>
                                    <br>
                                    <?php
                                        $statementLV2 = new Cassandra\SimpleStatement(  
                                            "SELECT price from predictedprice WHERE id=".$coin_id
                                        );
                                        $futureLV2    = $session->executeAsync($statementLV2);  
                                        $resultLV2    = $futureLV2->get();    
                                    ?>
                                    <ul>
                                        <li class="bold"><h1 class="blink">$ <?php  echo number_format((float)$resultLV2[0]['price'], 4, '.', '');?></h1></li>
                                    </ul>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <hr>
                                    <span class="pull-left" style="font-size:0.8em;">* 1. Based on historical OHLCV data.</span><br>
                                    <span class="pull-left" style="font-size:0.8em; margin-left:8px;">  2. This is not a claim, just a prediction based on Deep Neural Networks.</span><br>
                                    <span class="pull-left" style="font-size:0.8em; margin-left:8px;">  3. Updates daily at 00:00 am.</span>
                                </div>
                            </div>
                        <!-- </div> -->
                        </div>
                    </div>
                    <!-- Advertising area end -->
                    <!-- sales area start -->
                    <div class="col-xl-8 col-ml-8 col-lg-8 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Google Trends of <?php echo $tile_current;?> (2015/01/01 - <?php date_default_timezone_set('America/Los_Angeles'); echo date('Y/m/d');?>)</h4>
                                <div id="salesanalytic"></div>
                            </div>
                        </div>
                    </div>
                    <!-- sales area end -->
                    <!-- timeline area start -->
                    <div class="col-xl-4 col-ml-4 col-lg-4 mt-5">
                    <div class="card h-full">
                            <div class="card-body">
                                <h4 class="header-title">OHLC <span id="OHLCrange"></span></h4>
                                <!-- <canvas id="seolinechart8" height="233"></canvas> -->
                                <div id="socialads" style="height: 345px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- timeline area end -->
                    <!-- map area start -->
                    <div class="col-xl-5 col-lg-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Marketing Area</h4>
                                <div id="seomap"></div>
                            </div>
                        </div>
                    </div>
                    <!-- map area end -->
                    <!-- testimonial area start -->
                    <div class="col-xl-7 col-lg-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="header-title">Latest News on <?php echo $tile_current;?></h4>
                                <div class="letest-news mt-5">
                                <?php 
                                $all_keys = ['847446b32283474fafd2aec7f95e502b','4465f10054b142bc9a8caa115c677a77','40d53e49ee3543a3b162e6a453e2e373',
                                '211fc2107848473e99c1f235b400a07f','c0f99eab932d4cabb61c23239f3f482d','8ba091b7a47b4c9a9162a83ca72eb1ca',
                                '2bc85776a0c14af6b9937366ad683e2f','22e5c3a8f0ee4fa59aaf384ba9395a86','c554f8fb27ca4be1862192b44ee4425d'];
                                
                                $url3 = 'https://newsapi.org/v2/everything?q='.str_replace(' ', '', $tile_current).'&apiKey='.$all_keys[mt_rand(0,8)].'&pageSize=2&language=en';
                                $content3 = file_get_contents($url3);
                                $json3 = json_decode($content3, true);
                        
                                // $i = 0;
                                foreach($json3['articles'] as $item) {                               
                                        echo '<div class="single-post mb-xs-40 mb-sm-40">';
                                        echo '<div class="lts-thumb">';
                                        echo '<img src="'.$item['urlToImage'].'" alt="post thumb">';
                                        echo '</div>';
                                        echo '<div class="lts-content">';
                                        echo '<span>'.$item['source']['name'].'</span>';
                                        echo '<h2><a target="_blank" href="'.$item['url'].'">'.$item['title'].'</a></h2>';
                                        $subBody = substr($item['description'],0,175);
                                        echo '<p>'.$subBody.'...</p>';
                                        echo '</div>';
                                        echo '</div>';
                                    } 
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- testimonial area end -->
                </div>
            </div>
        </div>
        <!-- main content area end -->
        </div>
        </div>
    </div>
    

</div>
<script>


<?php 
    echo "var prevCP = LivecoinPrices('".$coin_symbol."','USD','#livecoin".$coin_symbol."',0,'#livecoin".$coin_symbol."Arrow');";

?>
  var mainInterval = setInterval(function (){
    <?php
    echo "var prevCP = LivecoinPrices('".$coin_symbol."','USD','#livecoin".$coin_symbol."',prevCP,'#livecoin".$coin_symbol."Arrow');";      
     ?>
  },2000);

function LivecoinPrices(fysm,tysm,toId,prevP,arrowClass){

var url = 'https://min-api.cryptocompare.com/data/price?fsym=' +fysm +'&tsyms='+tysm

$.getJSON(url, function(data) {
    $.each(data, function(i, field){
        if (parseFloat($(toId).text()) < parseFloat(field)){
            $(arrowClass).attr('class', 'fa fa-long-arrow-up');
        }
        else if (parseFloat($(toId).text()) == parseFloat(field)){
            $(arrowClass).attr('class', $(arrowClass).attr('class'));
        }
        else{
            $(arrowClass).attr('class', 'fa fa-long-arrow-down');
        }
        $(toId).text(field)                   
    });
});

return 0
}



window.onload = function() {
    mainChart();
    last7day();
    socialFB();
    trendsGraph();
   
}
function mainChart(){
    if ($('#user-statistics').length) {
    var chart = AmCharts.makeChart("user-statistics", {
        "type": "serial",
        "theme": "dark",
        "marginRight": 50,
        "marginLeft": 70,
        "autoMarginOffset": 20,
        "dataDateFormat": "YYYY-MM-DD",
        "valueAxes": [{
            "id": "v1",
            "axisAlpha": 0,
            "position": "left",
            "ignoreAxisWidth": true
        }],
        "balloon": {
            "borderThickness": 1,
            "shadowAlpha": 10
        },
        "graphs": [{
            "id": "g1",
            "balloon": {
                "drop": true,
                "adjustBorderColor": false,
                "color": "#ffffff",
                "type": "smoothedLine"
            },
            "fillAlphas": 0.2,
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletSize": 5,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "title": "red line",
            "useLineColorForBulletBorder": true,
            "valueField": "value",
            "balloonText": "<span style='font-size:10px;'>[[value]]</span>"
        }],
        "chartCursor": {
            "valueLineEnabled": true,
            "valueLineBalloonEnabled": true,
            "cursorAlpha": 10,
            "zoomable": true,
            "valueZoomable": true,
            "valueLineAlpha": 0.5
        },
        "valueScrollbar": {
            "autoGridCount": true,
            "color": "#FF4500",
            "scrollbarHeight": 45
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "dashLength": 1,
            "minorGridEnabled": true
        },
        "export": {
            "enabled": false
        },
        "allLabels": [{
            "text": "Time",
            "x": "!401",
            "y": "!20",
            "width": "50%",
            "size": 15,
            "bold": true,
            "align": "right"
        }, {
            "text": "Price (USD)",
            "rotation": 270,
            "x": "4",
            "y": "120",
            "width": "50%",
            "size": 15,
            "bold": true,
            "align": "right"
        }],
        "dataProvider": [
        <?php

        $url = 'https://min-api.cryptocompare.com/data/histoday?&fsym='.$coin_symbol.'&tsym=USD&limit=1513';
        $content = file_get_contents($url);
        $json = json_decode($content, true);

        $i = 0;
        foreach($json['Data'] as $item) {
            if ($i >0){
                print ',';
            }
                

            print '{"date": "'.date("Y-m-d", $item['time']).'","value": '.$item['close'].'}';
            $i = $i + 1;

            
        }?>
    
    
    ]
    });
}
<?php

    echo '$("#startdate").text("'.date("Y-m-d", $json['TimeFrom']).'");'
?>

}

<?php

    $url2 = 'https://min-api.cryptocompare.com/data/histoday?&fsym='.$coin_symbol.'&tsym=USD&limit=7';
    $content2 = file_get_contents($url2);
    $json2 = json_decode($content2, true);

    
?>

<?php

    echo '$("#OHLCrange").text( "('.date("Y-m-d", $json['TimeFrom']).' - '.date("Y-m-d", $json['TimeTo']).' )");';
?>

function last7day(){


if ($('#socialads').length) {

Highcharts.chart('socialads', {
    chart: {
        type: 'column'
    },
    title: false,
    xAxis: {
        categories: [
            
            <?php
        $i2 = 0;
        foreach($json2['Data'] as $item) {
            
            if ($i2 >0){
                    echo ',';
            }
                

            print '"'.date("l", $item['time']).'"';
            $i2 = $i2 + 1;

        
    } ?> ]
    
    
    },
    colors: ['#F5CA3F', '#E5726D', '#12C599', '#5F73F2'],
    yAxis: {
        min: 0,
        title: true
    },
    tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
        shared: true
    },
    series: [{
            name: 'Close',
            data: [
                
                <?php
        $i2 = 0;
        foreach($json2['Data'] as $item) {
            
            if ($i2 >0){
                    echo ',';
            }
                

            print $item['close'];
            $i2 = $i2 + 1;

        
    } ?>
            ]
        }, {
            name: 'Open',
            data: [
                <?php
        $i2 = 0;
        foreach($json2['Data'] as $item) {
            
            if ($i2 >0){
                    echo ',';
            }
                

            print $item['open'];
            $i2 = $i2 + 1;

        
    } ?>

            ]
        }, {
            name: 'High',
            data: [
                <?php
        $i2 = 0;
        foreach($json2['Data'] as $item) {
            
            if ($i2 >0){
                    echo ',';
            }
                

            print $item['high'];
            $i2 = $i2 + 1;

        
    } ?>
            ]
        },
        {
            name: 'Low',
            data: [

                <?php
        $i2 = 0;
        foreach($json2['Data'] as $item) {
            
            if ($i2 >0){
                    echo ',';
            }
                

            print $item['low'];
            $i2 = $i2 + 1;

        
    } ?>
            ]
        }
    ]
});
}
}
function socialFB(){
    if ($('#seolinechart1').length) {
    var ctx = document.getElementById("seolinechart1").getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
        // The data for our dataset
        data: {
            
            labels: [

                <?php 

                $arrLast30 = array_slice($json4['Data'], -12);
                $i5 = 0;

                foreach($arrLast30  as $item ){
                    
                    if ($i5 >0){
                        echo ',';
                    }
                    echo '"'.date("Y-m-d", $item['time']).'"';
                    $i5 = $i5 + 1;
                }
                

                ?>
                

                
                ],
            datasets: [{
                label: "Per Hour Average",
                backgroundColor: "rgba(255,64,64, 0.3)",
                borderColor: '#ffabab',
                data: [

            <?php
            $i6 = 0;
                foreach($arrLast30  as $item ){
                    
                    if ($i6 >0){
                        echo ',';
                    }
                    echo $item['reddit_comments_per_hour'];
                    $i6 = $i6 + 1;
                }


            ?>

                ],
            }]
        },
        // Configuration options go here
        options: {
            legend: {
                display: false
            },
            animation: {
                easing: "easeInOutBack"
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
            },
            elements: {
                line: {
                    tension: 0, // disables bezier curves
                }
            }
        }
    });
}
if ($('#seolinechart2').length) {
    var ctx = document.getElementById("seolinechart2").getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
        // The data for our dataset
        data: {
            labels: [

                <?php 

                $i7 = 0;

                foreach($arrLast30  as $item ){
                    
                    if ($i7 >0){
                        echo ',';
                    }
                    echo '"'.date("Y-m-d", $item['time']).'"';
                    $i7 = $i7 + 1;
                }
                

                ?>
            ],
            datasets: [{
                label: "Following",
                backgroundColor: "rgba(96, 241, 205, 0.2)",
                borderColor: '#3de5bb',
                data: [
                    <?php
                $i8 = 0;
                foreach($arrLast30  as $item ){
                    
                    if ($i8 >0){
                        echo ',';
                    }
                    echo ($item['twitter_following']-mt_rand(0,30));
                    $i8 = $i8 + 1;
                }


            ?>

                ],
            }]
        },
        // Configuration options go here
        options: {
            legend: {
                display: false
            },
            animation: {
                easing: "easeInOutBack"
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
            },
            elements: {
                line: {
                    tension: 0, // disables bezier curves
                }
            }
        }
    });
}
}

function trendsGraph(){
    if ($('#salesanalytic').length) {

    var chart = AmCharts.makeChart("salesanalytic", {
        "type": "serial",
        "theme": "light",
        "dataDateFormat": "YYYY-MM-DD",
        "precision": 2,
        "valueAxes": [{
            "id": "v1",
            "title": "Interest Over Time",
            "position": "left",
            "autoGridCount": true,
            "maximum": 100
        }],
        "graphs": [
            
        
        {
            "id": "g1",
            "valueAxis": "v1",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletSize": 5,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "lineColor": "#815FF6",
            "type": "smoothedLine",
            "title": "Interest Over Time",
            "useLineColorForBulletBorder": true,
            "valueField": "gtrends",
            "legendValueText": "[[value]]",
            "balloonText": "[[title]]<br /><small style='font-size: 130%'>[[value]]</small>"
        }
    
    ],
        "chartScrollbar": {
            "graph": "g1",
            "oppositeAxis": false,
            "offset": 50,
            "scrollbarHeight": 45,
            "backgroundAlpha": 0,
            "selectedBackgroundAlpha": 0.5,
            "selectedBackgroundColor": "#f9f9f9",
            "graphFillAlpha": 0.1,
            "graphLineAlpha": 0.4,
            "selectedGraphFillAlpha": 0,
            "selectedGraphLineAlpha": 1,
            "autoGridCount": true,
            "color": "#95a1f9"
        },
        "chartCursor": {
            "pan": true,
            "valueLineEnabled": true,
            "valueLineBalloonEnabled": true,
            "cursorAlpha": 0,
            "valueLineAlpha": 0.2
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "dashLength": 1,
            "minorGridEnabled": true,
            "color": "#5C6DF4"
        },
        "legend": {
            "useGraphSettings": true,
            "position": "top"
        },
        "balloon": {
            "borderThickness": 1,
            "shadowAlpha": 0
        },
        "export": {
            "enabled": false
        },
        "dataProvider": [

            <?php

            $message = exec("/anaconda3/bin/python3 phptest.py ".str_replace(' ', '', $tile_current)." ".date("Y-m-d"));
            $message2 = json_decode($message, true);
            // echo $message;

        $i9 = 0;
        foreach($message2 as $item) {
            
            if ($i9 >0){
                    echo ',';
            }
                

            print '{"date":"'.$item['date'].'","gtrends":'.$item[str_replace(' ', '', $tile_current)].'}';


            $i9 = $i9 + 1;

        
    } 
    
    ?>

            
        //     {
        //     "date": "2013-01-16",
        //     "market1": 51,
        //     "market2": 55,
        //     "sales1": 5,
        //     "sales2": 8
        // }
    
    
    ]
    });
    }
}
</script>
</body>

<?php include $cur_dir.'pages/footer.php';?>