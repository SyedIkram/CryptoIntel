
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;
$tile_current = 'The Team';
?>

<?php include $cur_dir.'pages/header.php';?>



    
<?php
$cluster   = Cassandra::cluster()        
                 ->build();

$session   = $cluster->connect($keyspace);    


$statementLV = new Cassandra\SimpleStatement(  
    'select * from team;'
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
                <div class="row">

                <?php
                foreach ($resultLV as $row) {

                    echo '<div class="col-xl-4 col-ml-6 col-mdl-4 col-sm-6 mt-5">';
                    echo '<div class="card">';
                    echo '<div class="pricing-list">';
                    echo '<div class="prc-head">';
                    echo '<h4>'.$row['name'].'</h4>';
                    echo '</div>';
                    echo '<div class="prc-list">';
                    echo '<ul>';
                    echo '<img style="height: 250px;display: block;margin-left: auto;margin-right: auto;" src="'.$cur_dir.'assets/images/team/'.$row['imgurl'].'" class="d-block rounded-circle" alt="">';

                    
                    echo '<li class="bold"><a href="mailto:'.$row['email'].'"><i class="far fa-envelope"></i> : '.$row['email'].'</li>';
                    echo '<li><a href="#">SFU - Big Data</a></li>';
                    echo '</ul>';
                    echo '<a target="_blank" style="background: #0084bf !important;" href="'.$row['linkedin'].'"><i class="fab fa-linkedin"></i></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                }
                ?>
                </div>
                <!-- color pricing end -->
                
            </div>
        </div>
        </div>
    </div>
    

</div>
</body>

<?php include $cur_dir.'pages/footer.php';?>