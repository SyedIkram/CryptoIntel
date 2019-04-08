
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;
$tile_current = 'Latest News';
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
                                <div class="letest-news mt-5">
                                <?php 
                                $statement = new Cassandra\SimpleStatement(       // also supports prepared and batch statements
                                    'SELECT id,imageurl,source_info_name,title,body,published_on,url,sentiment FROM news_cc WHERE sortmentainer=1 ORDER BY published_on DESC LIMIT 50 ALLOW FILTERING'
                                );
                                $future    = $session->executeAsync($statement);  // fully asynchronous and easy parallel execution
                                $result    = $future->get();                      // wait for the result, with an optional timeout
                                

                                foreach ($result as $row) {
                                        echo '<div class="single-post">';
                                        echo '<div class="lts-thumb">';
                                        echo '<img style = "height: 200px;"; src="'.$row['imageurl'].'" alt="post thumb">';
                                        echo '</div>';
                                        echo '<div class="lts-content">';
                                        if ((strcmp($row['sentiment'], 'Positive')) == 0){
                                            echo '<span style="color:#008000;"> Sentiment: '.$row['sentiment'].'</span><br>';
                                        }
                                        else if ((strcmp($row['sentiment'], 'Negative')) == 0){
                                            echo '<span style="color:#e50000;"> Sentiment: '.$row['sentiment'].'</span><br>';
                                        }
                                        else{
                                            echo '<span style="color:#ffdb1a;"> Sentiment: '.$row['sentiment'].'</span><br>';
                                        }
                                        echo '<span>'.$row['source_info_name'].'</span>';
                                        echo '<h2><a target="_blank" href="'.$row['url'].'">'.$row['title'].'</a></h2>';
                                        $subBody = substr($row['body'],0,275);
                                        echo '<p>'.$subBody.'...</p>';
                                        echo '</div>';
                                        echo '</div><hr>';
                                    } 
                                ?>
                                </div>
                            </div>
                        </div>
                
            </div>
        </div>
        </div>
    </div>
    

</div>
</body>

<?php include $cur_dir.'pages/footer.php';?>