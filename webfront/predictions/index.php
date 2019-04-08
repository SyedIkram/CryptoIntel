
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;
$tile_current = 'Predictions';
$keyspace = 'crypton';
$cluster   = Cassandra::cluster()        
                 ->build();

$session   = $cluster->connect($keyspace);  
?>

<?php include $cur_dir.'pages/header.php';?>

<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/bmabey/pyLDAvis/files/ldavis.v1.0.0.css">
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
                    </div>
                </div>
                <div class="main-content-inner">
                    <div class="card-body">
                        <h1 style="text-align: center;"><?php echo $tile_current;?></h1>
                    </div>
                    <div class="card">
                    <div class="card-body">
                                <h4 class="header-title">Predictions* Table</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-hover progress-table text-center">
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th scope="col">S. No.</th>
                                                    <th scope="col">Symbol</th>
                                                    <th scope="col">Date (dd/mm/YYYY)</th>
                                                    <th scope="col">Predicted Price</th>
                                                    <th scope="col">Current Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php 

                                            date_default_timezone_set('America/Los_Angeles');

                                            $statementLV2 = new Cassandra\SimpleStatement(  
                                                "SELECT * from predictedprice "
                                            );
                                            $futureLV2    = $session->executeAsync($statementLV2);  
                                            $resultLV2    = $futureLV2->get();   

                                            $i7 = 0;
                                            foreach($resultLV2 as $row){
                                                $i7 = $i7 + 1;
                                                echo '<tr>';
                                             echo '<th scope="row">'.$i7.'</th>';
                                             echo '<td>'.$row['symbol'].'</td>';
                                             echo '<td>'.date("d/m/Y", strtotime("+1 day")).'</td>';
                                             echo '<td><span id="PP'.$row['symbol'].'" class="status-p bg-warning">'.number_format((float)$row['price'], 4, '.', '').'</span></td>';

                                             echo '<td><div class="cripto-live"><ul><li><span style="margin-right:130px !important; "><i id="livecoin'.$row['symbol'].'Arrow" class="fa fa-long-arrow-up" ></i>$ <b id="livecoin'.$row['symbol'].'">0.0</b></span></li></ul></div></td>';
                                             echo '<td>';
                                           
                                             echo '</td>';
                                             echo '</tr>';

                                            }
                                             


                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                    <span class="pull-left" style="font-size:0.8em;">* 1. Based on historical OHLCV data.</span><br>
                                    <span class="pull-left" style="font-size:0.8em; margin-left:8px;">  2. This is not a claim, just a prediction based on Deep Neural Networks.</span><br>
                                    <span class="pull-left" style="font-size:0.8em; margin-left:8px;">  3. Updates daily at 00:00 am.</span><br>
                                    <span class="pull-left" style="font-size:0.8em; margin-left:8px;">  4. Prices are in USD.</span>
                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script type="text/javascript">
window.onload = function() {
<?php foreach ($resultLV2 as $row){

echo "var prevBTC = LivecoinPrices('".$row['symbol']."' ,'USD','#livecoin".$row['symbol']."' ,0,'#livecoin".$row['symbol']."Arrow','PP".$row['symbol']."');";
}
?>

}


  var mainInterval = setInterval(function (){
      
      <?php foreach ($resultLV2 as $row){

echo "var prevBTC = LivecoinPrices('".$row['symbol']."' ,'USD','#livecoin".$row['symbol']."' ,prevBTC,'#livecoin".$row['symbol']."Arrow','#PP".$row['symbol']."');";
      }
?>
  },2000);
function LivecoinPrices(fysm,tysm,toId,prevP,arrowClass,PPid){

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

        if (parseFloat($(PPid).text()) > parseFloat(field)){
            $(PPid).attr('class', 'status-p bg-success');
        }
        else{
            $(PPid).attr('class', 'status-p bg-danger');
        }
        
    });
});

return 0
}
     


</script>
<?php include $cur_dir.'pages/footer.php';?>