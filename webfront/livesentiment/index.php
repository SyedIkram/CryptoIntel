
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;
$tile_current = 'Live Sentiment Analysis';
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
                            <div class="letest-news mt-5">
                                <!-- <div id="ldavis_el1411406631771971524024477905">
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script type="text/javascript">

</script>
<?php include $cur_dir.'pages/footer.php';?>