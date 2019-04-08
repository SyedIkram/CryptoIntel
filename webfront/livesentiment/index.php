
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;
$tile_current = 'Live Sentiment Analysis';
?>

<?php include $cur_dir.'pages/header.php';?>

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

    
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
<style> /* set the CSS */


path { 
    stroke: orange;
    stroke-width: 2;
    fill: none;
}

.axis path,
.axis line {
    fill: none;
    stroke: grey;
    stroke-width: 1;
    shape-rendering: crispEdges;
}
.rotate {
  /* FF3.5+ */
  -moz-transform: rotate(-90.0deg);
  /* Opera 10.5 */
  -o-transform: rotate(-90.0deg);
  /* Saf3.1+, Chrome */
  -webkit-transform: rotate(-90.0deg);
  /* IE6,IE7 */
  filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
  /* IE8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
  /* Standard */
  transform: rotate(-90.0deg);
}
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
                </div>
            </div>
            <div class="main-content-inner">
                <!-- color pricing start -->
                <div class="card-body">
                                        <h1 style="text-align: center;"><?php echo $tile_current;?></h1>
                </div>
                <div class="card">
                <div class="card-body">

                  
                <?php 
                 $z = 0; 
                foreach ($resultLV as $row){
                    $z = $z + 1;
                    $statementLV5 = new Cassandra\SimpleStatement(  
                        "SELECT id,coinname,imageurl from all_coins WHERE symbol='".$row['symbol']."' ALLOW FILTERING"
                    );
                    $futureLV5   = $session->executeAsync($statementLV5);  
                    $resultLV5    = $futureLV5->get();    

                    echo '<a href="livegraph?coinsymbol='.$row['symbol'].'"><div class="media mb-5">';
                    echo '<h4 class="mb-3" style="margin-top:20px;margin-right:50px;">'.$z.'. </h4> ';
                    echo '<img style="max-height:80px !important;" class="img-fluid mr-4" src="https://www.cryptocompare.com'.$resultLV5[0]['imageurl'] .'">';
                    echo '<div class="media-body">';
                    echo '<br><h4 class="mb-3">'.$resultLV5[0]['coinname'].'</h4> ';
                    echo '</div>';
                    echo '</div></a>';
                    


                    }


                    ?>


                                
                </div>
                            
                
            </div>
        </div>
        </div>
    </div>
    

</div>
</body>
<?php include $cur_dir.'pages/footer.php';?>