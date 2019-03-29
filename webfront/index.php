
<?php 
// VARS
$cur_dir='';
$PIE_COUNT = 4;
$tile_current = 'Home';
?>

<?php include 'pages/header.php';?>



    
<?php
$cluster   = Cassandra::cluster()        
                 ->build();

$session   = $cluster->connect($keyspace);    


$statementLV = new Cassandra\SimpleStatement(  
    'select * from top10data limit 10;'
);
$futureLV    = $session->executeAsync($statementLV);  
$resultLV    = $futureLV->get();    


?>
<body onunload="closeSocket()">
<div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        <?php include 'pages/sidebar.php';?>
        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
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
                                <li><span>Dashboard</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content-inner">
                <div class="sales-report-area mt-5 mb-5">
                    <div class="row">
                        <?php 
                        for ($x = 0; $x <= 2; $x++){
                            echo "<div class='col-md-4'>";
                            echo "<div class='single-report mb-xs-30'>";
                            echo "<div class='s-report-inner pr--20 pt--30 mb-3'>";
                            echo "<div class='icon'><img style='height: 20px;' src='assets/images/icon/market-value/icon".($x+1).".png'></div>";
                            echo "<div class='s-report-title d-flex justify-content-between'>";
                            echo "<h4 class='header-title mb-0'>".$resultLV[$x]['coinname']."</h4>";
                            echo "<p>24 H</p>";
                            echo "</div>";
                            echo "<div class='d-flex justify-content-between pb-2'>";
                            echo "<h5 id='FULLVOLUMETO_".$resultLV[$x]['symbol']."'></h5>";
                            echo "<span id='CHANGE24HOUR_".$resultLV[$x]['symbol']."'></span>";
                            echo "</div>";
                            echo "</div>";
                            echo "<canvas id='".$resultLV[$x]['symbol']."24VOLGRAPH' height='100'></canvas>";
                            echo "</div>";
                            echo "</div>";
                        } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                    <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="header-title mb-0"><span id="titleExtender"></span></h4>
                                    <select id="LiveBarChartSelctor" class="custome-select border-0 pr-3">
                                        <?php 
                                            $dropDownLiveChartList = ['TOTALVOLUME24H','VOLUMEHOUR','LASTVOLUME','PRICE','SUPPLY','CHANGE24HOUR'];
                                            $dropDownLiveChartListVal = ['Total Volume (24 H)','Total Volume (1 H)','Last Volume','Price','Total Supply','Change (24 H)'];
                                            echo "<option selected val='".$dropDownLiveChartListVal[0]."'>".$dropDownLiveChartList [0]."</option>";

                                            for ($i=1; $i<count($dropDownLiveChartList);$i++){
                                                echo "<option val='".$dropDownLiveChartListVal[$i]."'>".$dropDownLiveChartList [$i]."</option>";
                                            }
                                            
                                        ?>
                                    </select>
                                </div>
                                <div id="ambarchart4"></div>
                            </div>
                    </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 coin-distribution">
                        <div class="card h-full">
                            <div class="card-body">
                                <h4 class="header-title mb-0">Market Cap</h4>
                                <div id="coin_distribution"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- overview area end -->
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <h4 class="header-title mb-0"><span id="LiveTradeSymbolID">BTC</span>-USD Market Trades</h4>
                                    <select id="liveTradesStreamSelector" class="custome-select border-0 pr-3">
                                    <?php foreach ($resultLV as $row){
                                                if ($row['symbol'] == "BTC"){
                                                    echo "<option selected val='".$row['symbol']."'>".$row['symbol']."</option>";
                                                }
                                                else{
                                                    echo "<option val='".$row['symbol']."'>".$row['symbol']."</option>";
                                                }
                                            }
                                            
                                        ?>
                                    </select>
                                    
                                </div>
                                <div class="market-status-table mt-4">
                                    <div class="table-responsive table">
                                        <table class="table dbkit-table" id = "tableMain">
                                        <thead>
                                            <tr style="border-bottom: 1px solid #7a7a7a;">
                                                <td><h6 style="color:#000;">Market</h5></td>
                                                <td><h6 style="color:#000;">Type</h6></td>
                                                <td><h6 style="color:#000;">Trading ID</h6></td>
                                                <td><h6 style="color:#000;">Price</h6></td>
                                                <td><h6 style="color:#000;">Quantity</h6></td>
                                                <td><h6 style="color:#000;">Total</h6></td>
                                            </tr>
                                        
                                        <tbody id="trades1">
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- market value area end -->
                <!-- row area start -->
                <div class="row">
                    <!-- Live Crypto Price area start -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Live Crypto Price</h4>
                                <div class="cripto-live mt-5">
                                    <ul>
                                        <!--  -->

                                <?php                   // wait for the result, with an optional timeout
                                

                                for ($x = 0; $x <= 6; $x++) {
                                    echo '<li><a style="color:#000 !important;" href="coins/?coinsymbol='.$resultLV[$x]['symbol'].'">';
                                    echo '<div class="icon '.$resultLV[$x]['firstalpha'].'">'.$resultLV[$x]['firstalpha'].'</div> '.$resultLV[$x]['coinname'].'<span><i id="livecoin'.$resultLV[$x]['symbol'].'Arrow" class="fa fa-long-arrow-up" ></i>$ <b id="livecoin'.$resultLV[$x]['symbol'].'">0.0</b></span></li>';

                                    echo '</a></li>';
                                    } 
                                ?>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Live Crypto Price area end -->
                    <!-- trading history area start -->
                    <div class="col-lg-8 mt-sm-30 mt-xs-30">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <h4 class="header-title">L2 Order Book (BTC - USD)</h4>
                                    <div class="trd-history-tabs">
                                        <ul class="nav" role="tablist">
                                            <li>
                                                <a class="active" data-toggle="tab" href="#buy_order" role="tab">Bids</a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#sell_order" role="tab">Asks</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="#">Click Here for More</a>
                                    <!-- <select id="L2orderSymbolSelector" class="custome-select border-0 pr-3"> -->
                                    <?php 
                                    // foreach ($resultLV as $row){
                                    //             if ($row['symbol'] == "BTC"){
                                    //                 echo "<option selected val='".$row['symbol']."'>".$row['symbol']."</option>";
                                    //             }
                                    //             else{
                                    //                 echo "<option val='".$row['symbol']."'>".$row['symbol']."</option>";
                                    //             }
                                    //         }
                                            
                                        ?>
                                    <!-- </select> -->
                                </div>
                                <div class="trad-history mt-4">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="buy_order" role="tabpanel">
                                            <div class="table-responsive">
                                            <table class="table dbkit-table" id = "l2orderBid">
                                        <thead>
                                            <tr style="border-bottom: 1px solid #7a7a7a;">
                                                <td><h6 style="color:#000;">Market</h5></td>
                                                <td><h6 style="color:#000;">Coin</h6></td>
                                                <td><h6 style="color:#000;">Bid</h6></td>
                                            </tr>
                                        
                                        <tbody id="l2orderBidBody">
                                        </tbody>
                                    </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="sell_order" role="tabpanel">
                                            <div class="table-responsive">
                                            <table class="table dbkit-table" id = "l2orderAsks">
                                        <thead>
                                            <tr style="border-bottom: 1px solid #7a7a7a;">
                                                <td><h6 style="color:#000;">Market</h5></td>
                                                <td><h6 style="color:#000;">Coin</h6></td>
                                                <td><h6 style="color:#000;">Ask</h6></td>
                                            </tr>
                                        
                                        <tbody id="l2orderAsksBody">
                                        </tbody>
                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- trading history area end -->
                </div>
                <!-- row area end -->
                <div class="row mt-5">
                    <!-- latest news area start -->

                    

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Latest News</h4>
                                <div class="letest-news mt-5">
                                <?php 
                                $statement = new Cassandra\SimpleStatement(       // also supports prepared and batch statements
                                    'SELECT id,imageurl,source_info_name,title,body,published_on,url FROM news_cc WHERE sortmentainer=1 ORDER BY published_on DESC LIMIT 2 ALLOW FILTERING'
                                );
                                $future    = $session->executeAsync($statement);  // fully asynchronous and easy parallel execution
                                $result    = $future->get();                      // wait for the result, with an optional timeout
                                

                                foreach ($result as $row) {
                                        echo '<div class="single-post mb-xs-40 mb-sm-40">';
                                        echo '<div class="lts-thumb">';
                                        echo '<img src="'.$row['imageurl'].'" alt="post thumb">';
                                        echo '</div>';
                                        echo '<div class="lts-content">';
                                        echo '<span>'.$row['source_info_name'].'</span>';
                                        echo '<h2><a target="_blank" href="'.$row['url'].'">'.$row['title'].'</a></h2>';
                                        $subBody = substr($row['body'],0,175);
                                        echo '<p>'.$subBody.'...</p>';
                                        echo '</div>';
                                        echo '</div>';
                                    } 
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- latest news area end -->
                    <!-- exchange area start -->
                    <div class="col-xl-6 mt-md-30 mt-xs-30 mt-sm-30">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Exchange</h4>
                                <div class="exhcange-rate mt-5">
                                    <form action="#">
                                        <div class="input-form">
                                            <input type="text" id='cryptVal' value="1">
                                            <span class="btn btn-flat btn-primary dropdown-toggle" id="fromExchange" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >BTC</span>
                                            <div class="dropdown-menu" aria-labelledby="fromExchange">
                                                <?php 
                                                foreach ($resultLV as $row) {
                                                        echo '<a class="dropdown-item" onClick="changeToVal(this.text);">'.$row['symbol'].'</a>';
                                                    } 
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <div class="exchange-devider">To</div>
                                        <div class="input-form">
                                            <input type="text"  id='currtVal' value="">
                                            <span class="btn btn-flat btn-primary dropdown-toggle" id="toExchange" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >USD</span>
                                            <div class="dropdown-menu" aria-labelledby="toExchange">
                                                <?php
                                                $topCurrency = ['USD','CAD','INR','KWD','JPY','CNY','EUR','AUD'];
                                                $topCurrencyName = ['United States Dollar','Canadian Dollar','Indian National Rupee','Kuwaiti Dinar','Japanese Yen','Renminbi','Euro','Australian Dollar'];
                                                foreach ($topCurrency as $row) {
                                                        echo '<a class="dropdown-item" onClick="changeFromVal(this.text);">'.$row.'</a>';
                                                    } 
                                                ?>
                                            </div>
                                        </div>
                                        <div class="exchange-btn">
                                            <!-- <button id="exchangeButton" onclick="refreshExchange()" type="button">Refresh</button>
                                            </div> -->
                                        <div class="exchange-devider">
                                            <!-- <button type="button" 
                                            data-toggle="modal" data-target="#exampleModalCenter"
                                            class="btn btn-outline-info mb-3">Info (Symbols' Name)</button> -->
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- exchange area end -->
                </div>
                <!-- row area start-->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
       
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
    

</div>
<style>
.tablecust {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.tablecust :td, .tablecust :th {
  border: 1px solid #000000;
  text-align: left;
  padding: 8px;
}

.tablecust :tr:first-child {
  background-color: #dddddd;
}
.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#0C9;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:16px;
}

    </style>
<div class="modal fade" id="exampleModalCenter">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Symbols' - Name</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
            <table class="tablecust">
                <tr>
                    <th>Symbol</th>
                    <th>Name</th>
                </tr>
                <?php 
                foreach ($resultLV as $row) {
                        echo '<tr><th>'.$row['symbol'].'</th><th>'.$row['coinname'].'</th></tr>';
                    } 
                ?>
            </table>
            <hr>
            <table class="tablecust">
                <tr>
                    <th>Symbol</th>
                    <th>Name</th>
                </tr>
                <?php 
                for($i = 0; $i < count($topCurrency); ++$i) {
                        echo '<tr><th>'.$topCurrency[$i].'</th><th>'.$topCurrencyName[$i].'</th></tr>';
                    } 
                ?>
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<a href="#" class="float" data-toggle="modal" data-target="#exampleModalCenter">
<i class="fa fa-question-circle fa-2x my-float"></i>
</a>
</body>

<style>
    tr {
        overflow-x: auto; /* Use horizontal scroller if needed */
        white-space: pre-wrap; /* css-3 */
        white-space: -moz-pre-wrap !important; /* Mozilla, since 1999 */
        word-wrap: break-word; /* Internet Explorer 5.5+ */
        white-space : normal;
    }
</style>


<script>


$(document).on('change','#LiveBarChartSelctor',function(){
    livechartController();
});


function livechartController(){
    
    var eLC = document.getElementById("LiveBarChartSelctor");
    var sLC = eLC.options[eLC.selectedIndex].value;

    if (sLC == "TOTALVOLUME24H"){
        var today = new Date();
        var yesterday = new Date(new Date(today).getTime() - (60 * 60 * 24 * 1000))
        
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        var HH = today.getHours();
        var MM = today.getMinutes();
        var SS = today.getSeconds();

        var dd2 = String(yesterday.getDate()).padStart(2, '0');
        var mm2 = String(yesterday.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy2 = yesterday.getFullYear();

        var HH2 = yesterday.getHours();
        var MM2 = yesterday.getMinutes();
        var SS2 = yesterday.getSeconds();

        today = mm + '/' + dd + '/' + yyyy + ' ' + HH + ':'+ MM + ':'+ SS;
        yesterday = mm2 + '/' + dd2 + '/' + yyyy2 + ' ' + HH2 + ':'+ MM2 + ':'+ SS2;
        $("#titleExtender").text("Volume (24 H): " + yesterday  + "  -  " + today + " (PDT)");
    }
    else if (sLC == "VOLUMEHOUR"){
        var today = new Date();
        var yesterday = new Date(new Date(today).getTime() - (60 * 60 * 1 * 1000))
        
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        var HH = today.getHours();
        var MM = today.getMinutes();
        var SS = today.getSeconds();

        var dd2 = String(yesterday.getDate()).padStart(2, '0');
        var mm2 = String(yesterday.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy2 = yesterday.getFullYear();

        var HH2 = yesterday.getHours();
        var MM2 = yesterday.getMinutes();
        var SS2 = yesterday.getSeconds();

        today = mm + '/' + dd + '/' + yyyy + ' ' + HH + ':'+ MM + ':'+ SS;
        yesterday = mm2 + '/' + dd2 + '/' + yyyy2 + ' ' + HH2 + ':'+ MM2 + ':'+ SS2;
        $("#titleExtender").text("Volume (1 H): " + yesterday  + "  -  " + today + " (PDT)");
    }
    else if(sLC == "PRICE"){
        $("#titleExtender").text("Current Price");
    }
    else if(sLC == "SUPPLY"){
        $("#titleExtender").text("Current Supply");
    }
    else if (sLC == "LASTVOLUME"){
        $("#titleExtender").text("Volume Last Updated: ");
    }
    else if (sLC == "CHANGE24HOUR"){
        $("#titleExtender").text("Change in Price (24 H): ");
    }
    else{
        $("#titleExtender").text("");
    }
    
    var url = "https://min-api.cryptocompare.com/data/pricemultifull?fsyms=BTC,XRP,ETH,LTC,BCH,EOS,ADA,XLM,IOT,NEO&tsyms=USD";

    $.getJSON(url, function(data) {
        var allSymbols = [];
        var allVolume = [];
                <?php 
            $listNamesLiveSym=array();
            
                echo "var listNamesLiveSym = ['";
            $counter5 = 0;


            foreach ($resultLV as $row) {

                $counter5 = $counter5 + 1;

                if ($counter5 >1){
                    echo "','".$row['coinname'];
                }else{
                    echo $row['coinname'];
                }
            } 
            echo "'];";
        
            ?>


        var p=0;
        var syms = Object.keys(data.RAW);

        if (sLC == "LASTVOLUME"){
            $("#titleExtender").text("Volume Last Updated: " + Unix_timestamp(data.RAW.BTC.USD.LASTUPDATE));
        }
        else if (sLC == "CHANGE24HOUR"){
            $("#titleExtender").text("Change in Price (24 H): " + Unix_timestamp(data.RAW.BTC.USD.LASTUPDATE));
        }
        $.each(data.RAW, function(i, field){
            allVolume.push(field['USD'][sLC]);
            allSymbols.push(listNamesLiveSym[p]);
            p = p+1;
        });
        liveBarChart(allSymbols,allVolume,sLC);
        // console.log(allVolume);
    });


    
}



var ms500intr = setInterval(function (){
             <?php for ($x = 0; $x <= 2; $x++){
                // echo "updateVolumeMain('#FULLVOLUMETO_".$resultLV[$x]['symbol']."','#CHANGE24HOUR_".$resultLV[$x]['symbol']."','".$resultLV[$x]['symbol']."');";
            } ?>
    
       
    },500);



    var nf = new Intl.NumberFormat();
    function updateVolumeMain(volID,changeID,fsym){
        var url3 = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms='+fsym+'&tsyms=USD'
                $.getJSON(url3, function(data3) {
                            BTC_VOLTO = parseFloat(data3.RAW[fsym].USD.TOTALVOLUME24HTO).toFixed(2);
                            BTC_CHANGE = parseFloat(data3.RAW[fsym].USD.CHANGE24HOUR).toFixed(2);
                            $(volID).text('$ ' + nf.format(BTC_VOLTO));
                            $(changeID).text('$ ' + nf.format(BTC_CHANGE));

            });
    }

    // fetchforPie('coin_distribution');
    var prevBTC = LivecoinPrices('BTC','USD','#livecoinBTC',0,'#livecoinBTCArrow');
    var prevLTC = LivecoinPrices('LTC','USD','#livecoinLTC',0,'#livecoinLTCArrow');
    var prevETH = LivecoinPrices('ETH','USD','#livecoinETH',0,'#livecoinETHArrow');
    var prevXRP = LivecoinPrices('XRP','USD','#livecoinXRP',0,'#livecoinXRPArrow');
    var prevBCH = LivecoinPrices('BCH','USD','#livecoinBCH',0,'#livecoinBCHArrow');
    var prevEOS = LivecoinPrices('EOS','USD','#livecoinEOS',0,'#livecoinEOSArrow');
    var prevADA = LivecoinPrices('ADA','USD','#livecoinADA',0,'#livecoinADAArrow');

    window.onload = function() {
        liveTrades();
        liveL2OrderBook();
        livechartController();
        <?php 
        $colorPalletMainVolGraphBack = ["rgba(240, 180, 26, 0.1)",'rgba(117, 19, 246, 0.1)',"rgba(247, 163, 58, 0.1)"];
        $colorPalletMainVolGraphBorder = ['#F0B41A','#0b76b6','#fd9d24'];
        
        for ($x = 0; $x <= 2; $x++){
            echo "graphController('".$resultLV[$x]['symbol']."','".$resultLV[$x]['symbol']."24VOLGRAPH','".$colorPalletMainVolGraphBack[$x]."','".$colorPalletMainVolGraphBorder[$x]."');";
        } ?>
    };

    function Unix_timestamp(t)
    {
        var dt = new Date(t*1000);
        var hr = dt.getHours();
        var m = "0" + dt.getMinutes();
        var s = "0" + dt.getSeconds();
        // return dt.getYear() + " "+ hr+ ':' + m.substr(-2) + ':' + s.substr(-2);  
        return dt;
    }

// Interval for L2 Snapshot
var l2orderinterval = setInterval(function(){
    liveL2OrderBook();
},120000);



var livebarchartinterval = setInterval(function(){
    liveL2OrderBook();
    livechartController();


},10000);
    var int24graph = setInterval(function (){  
        <?php
        
        for ($x = 0; $x <= 2; $x++){
                echo "graphController('".$resultLV[$x]['symbol']."','".$resultLV[$x]['symbol']."24VOLGRAPH','".$colorPalletMainVolGraphBack[$x]."','".$colorPalletMainVolGraphBorder[$x]."');";
            } ?>
        },40000);



    function graphController(coinsymbol,graphID,back_color,border_color){
        var url = "https://min-api.cryptocompare.com/data/histominute?fsym="+coinsymbol+"&tsym=GBP&limit=13";

        $.getJSON(url, function(data) {
            var allPoints = [];
            var allPointTimes = [];

            $.each(data.Data, function(i, field){
                allPoints.push(field.volumeto);
                allPointTimes.push(Unix_timestamp(field.time));
            });
            allPoints.pop();
            allPointTimes.pop();
            volumne24graph(coinsymbol,graphID,allPoints,allPointTimes,back_color,border_color);
        });
    }

  var mainInterval = setInterval(function (){
      

        fetchforPie('coin_distribution');
        
        prevBTC = LivecoinPrices('BTC','USD','#livecoinBTC',prevBTC,'#livecoinBTCArrow');
        prevLTC = LivecoinPrices('LTC','USD','#livecoinLTC',prevLTC,'#livecoinLTCArrow');
        prevETH = LivecoinPrices('ETH','USD','#livecoinETH',prevETH,'#livecoinETHArrow');
        prevXRP = LivecoinPrices('XRP','USD','#livecoinXRP',prevXRP,'#livecoinXRPArrow');
        prevBCH = LivecoinPrices('BCH','USD','#livecoinBCH',prevBCH,'#livecoinBCHArrow');
        prevEOS = LivecoinPrices('EOS','USD','#livecoinEOS',prevEOS,'#livecoinEOSArrow');
        prevADA = LivecoinPrices('ADA','USD','#livecoinADA',prevADA,'#livecoinADAArrow');

        
       
    },2000);

    <?php 
    $listMrktCapCall=array();
    
    for ($x = 0; $x <= $PIE_COUNT; $x++){
            array_push($listMrktCapCall,$resultLV[$x]['symbol']);
        }
    
        echo "var listOfSymbolsTop10 = '";
    $counter1 = 0;

    foreach ($listMrktCapCall as $row) {
        $counter1 = $counter1 + 1;

        if ($counter1 >1){
            echo ",",$row;
        }else{
            echo $row;
        }
        
    }
    echo "';";
   
    ?>


function fetchforPie(chartID){
    var url = ('https://min-api.cryptocompare.com/data/pricemultifull?fsyms=').concat(listOfSymbolsTop10).concat('&tsyms=USD');
    $.getJSON(url, function(data) {

        <?php 
        $listPieCallMKT = array();

        for ($x = 0; $x <= $PIE_COUNT; $x++) {
            echo $resultLV[$x]['symbol']."_MKTCAP = parseFloat(data.RAW.".$resultLV[$x]['symbol'].".USD.MKTCAP);";
            array_push($listPieCallMKT,$resultLV[$x]['symbol']."_MKTCAP");
        }
        echo "TotalC = ( ";
        $counter2 = 0;
        foreach ($listPieCallMKT as $row) {
            $counter2 = $counter2 + 1;
    
            if ($counter2 >1){
                echo " + ",$row;
            }else{
                echo $row;
            }
            
        }
        echo " ) / 100000000;";

        echo "makePieChart(chartID,";
        
        for ($x = 0; $x <= $PIE_COUNT; $x++) {
            echo $resultLV[$x]['symbol']."_MKTCAP".",";
        }

        echo "TotalC.toFixed(2));";
        
        ?>

        // TotalC = ( BTC_MKTCAP + ETH_MKTCAP + XRP_MKTCAP + LTC_MKTCAP ) / 100000000;

        // makePieChart(chartID,BTC_MKTCAP,ETH_MKTCAP,XRP_MKTCAP,LTC_MKTCAP,TotalC.toFixed(2));
    });
    // makePieChart(chartID);

}

    function refreshExchange(){
        exchangerLive($('#fromExchange').text(),$('#toExchange').text(),'#cryptVal','#currtVal');
    }
    function changeToVal(changed){
        $('#fromExchange').text(changed)
        exchangerLive($('#fromExchange').text(),$('#toExchange').text(),'#cryptVal','#currtVal');
    }

    function changeFromVal(changed){
        $('#toExchange').text(changed)
        exchangerLive($('#fromExchange').text(),$('#toExchange').text(),'#cryptVal','#currtVal');
    }

    $('#cryptVal').keyup(function(){
        var fysm = $('#fromExchange').text()
        var tysm = $('#toExchange').text()
        exchangerLive(fysm,tysm,'#cryptVal','#currtVal');
    });
    $('#currtVal').keyup(function(){
        var fysm = $('#toExchange').text()
        var tysm = $('#fromExchange').text()
        exchangerLive(fysm,tysm,'#currtVal','#cryptVal');
    });

    function exchangerLive(fysm,tysm,fromId,toId){
        var crypCount = $(fromId).val()
        var url = 'https://min-api.cryptocompare.com/data/price?fsym=' +fysm +'&tsyms='+tysm
        
        $.getJSON(url, function(data) {
            $.each(data, function(i, field){
                $(toId).val(field*crypCount)
            });
        });
    }
    
    exchangerLive($('#fromExchange').text(),$('#toExchange').text(),'#cryptVal','#currtVal');

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
</script>

<script>

function liveTrades(){
var streamUrl = "https://streamer.cryptocompare.com/";
var fsym = "BTC";
var tsym = "USD";
var currentSubs;
var currentSubsText = "";
var dataUrl = "https://min-api.cryptocompare.com/data/subs?fsym=" + fsym + "&tsyms=" + tsym;
var socket = io(streamUrl);

$.getJSON(dataUrl, function(data) {
	currentSubs = data['USD']['TRADES'];
	for (var i = 0; i < currentSubs.length; i++) {
		currentSubsText += currentSubs[i] + ", ";
    }
    
	$('#sub-exchanges').text(currentSubsText);
	socket.emit('SubAdd', { subs: currentSubs });
});

socket.on('m', function(currentData) {
	var tradeField = currentData.substr(0, currentData.indexOf("~"));
	if (tradeField == CCC.STATIC.TYPE.TRADE) {
		transformData(currentData);
	}
});

var transformData = function(data) {
	var coinfsym = CCC.STATIC.CURRENCY.getSymbol(fsym);
	var cointsym = CCC.STATIC.CURRENCY.getSymbol(tsym)
	var incomingTrade = CCC.TRADE.unpack(data);
	
	var newTrade = {
		Market: incomingTrade['M'],
		Type: incomingTrade['T'],
		ID: incomingTrade['ID'],
		Price: CCC.convertValueToDisplay(cointsym, incomingTrade['P']),
		Quantity: CCC.convertValueToDisplay(coinfsym, incomingTrade['Q']),
		Total: CCC.convertValueToDisplay(cointsym, incomingTrade['TOTAL'])
	};

	if (incomingTrade['F'] & 1) {
		newTrade['Type'] = "SELL";
	}
	else if (incomingTrade['F'] & 2) {
		newTrade['Type'] = "BUY";
	}
	else {
		newTrade['Type'] = "UNKNOWN";
	}

	displayData(newTrade);
};

var displayData = function(dataUnpacked) {
	var maxTableSize = 7;
    var length = $('#tableMain tr').length;
    // console.log("Hello" + dataUnpacked);
    if(dataUnpacked.Type == "BUY" && dataUnpacked.Type != "UNKNOWN"){
        $('#trades1').after("<tr >"+
        "<td class='coin-name'   style='color:#028900;'>" + dataUnpacked.Market + "</td>"+
        "<td class='attachments' style='color:#028900;'>" + dataUnpacked.Type + "</td>"+
        "<td class='attachments' style='color:#028900;'>" + dataUnpacked.ID + "</td>"+
        "<td class='attachments' style='color:#028900;'>" + dataUnpacked.Price + "</td>"+
        "<td class='attachments' style='color:#028900;'>" + dataUnpacked.Quantity + "</td>"+
        "<td class='attachments' style='color:#028900;'>" + dataUnpacked.Total + "</td>"+
        "</tr>");
    }
    else if (dataUnpacked.Type == "SELL" &&dataUnpacked.Type != "UNKNOWN"){
        $('#trades1').after("<tr >"+
        "<td class='coin-name'   style='color:#cb2424;'>" + dataUnpacked.Market + "</td>"+
        "<td class='attachments' style='color:#cb2424;'>" + dataUnpacked.Type + "</td>"+
        "<td class='attachments' style='color:#cb2424;'>" + dataUnpacked.ID + "</td>"+
        "<td class='attachments' style='color:#cb2424;'>" + dataUnpacked.Price + "</td>"+
        "<td class='attachments' style='color:#cb2424;'>" + dataUnpacked.Quantity + "</td>"+
        "<td class='attachments' style='color:#cb2424;'>" + dataUnpacked.Total + "</td>"+
        "</tr>");
    }

	if (length>= (maxTableSize)) {
		$('#tableMain tr:last').remove();
	}
};
}
window.onbeforeunload = popup;

function popup() {
    socket.emit('SubRemove', { subs: currentSubs });
}


</script>

<?php include 'assets/jshelper.php';?>   

<?php include 'pages/footer.php';?>