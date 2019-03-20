
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;
?>

<?php include $cur_dir.'pages/header.php';?>



    
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
                                <li><span>Team</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content-inner">
                <!-- color pricing start -->
                <div class="card-body">
                                        <h1 style="text-align: center;">The Team</h1>
                </div>
                <div class="row">
                <div class="col-xl-4 col-ml-6 col-mdl-4 col-sm-6 mt-5">
                        <div class="card">
                            <div class="pricing-list">
                                <div class="prc-head">
                                    <h4>Platinum</h4>
                                </div>
                                <div class="prc-list">
                                    <ul>
                                        <li><a href="#">Term Finnacing & Line of Credit</a></li>
                                        <li><a href="#">Access up to $10,000</a></li>
                                        <li><a href="#">Get: Ad Hoc Currency Selection</a></li>
                                        <li><a href="#">Metered Terms</a></li>
                                        <li class="bold"><a href="#">Contact for Pricing</a></li>
                                    </ul>
                                    <a href="#">Buy Package</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-ml-6 col-mdl-4 col-sm-6 mt-5">
                        <div class="card">
                            <div class="pricing-list">
                                <div class="prc-head">
                                    <h4>Platinum</h4>
                                </div>
                                <div class="prc-list">
                                    <ul>
                                        <li><a href="#">Term Finnacing & Line of Credit</a></li>
                                        <li><a href="#">Access up to $10,000</a></li>
                                        <li><a href="#">Get: Ad Hoc Currency Selection</a></li>
                                        <li><a href="#">Metered Terms</a></li>
                                        <li class="bold"><a href="#">Contact for Pricing</a></li>
                                    </ul>
                                    <a href="#">Buy Package</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-ml-6 col-mdl-4 col-sm-6 mt-5">
                        <div class="card">
                            <div class="pricing-list">
                                <div class="prc-head">
                                    <h4>Platinum</h4>
                                </div>
                                <div class="prc-list">
                                    <ul>
                                        <li><a href="#">Term Finnacing & Line of Credit</a></li>
                                        <li><a href="#">Access up to $10,000</a></li>
                                        <li><a href="#">Get: Ad Hoc Currency Selection</a></li>
                                        <li><a href="#">Metered Terms</a></li>
                                        <li class="bold"><a href="#">Contact for Pricing</a></li>
                                    </ul>
                                    <a href="#">Buy Package</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- color pricing end -->
                
            </div>
        </div>
        </div>
    </div>
    

</div>
</body>

<?php include $cur_dir.'pages/footer.php';?>