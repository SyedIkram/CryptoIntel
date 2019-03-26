
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;
$tile_current = 'Live Global Transaction Nodes';
?>

<?php include $cur_dir.'pages/header.php';?>
<!-- <link href="https://bitnodes.earn.com/static/css/live-map.css?v=1455326580" rel="stylesheet"> -->

<link href="https://bitnodes.earn.com/static/css/font-awesome.min.css" rel="stylesheet">

<?php include 'csshelper.php';?>  
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
                        
                        
                        <div id="map-canvas"></div>
                        <div id="chart-canvas"></div>
                        
                        
                        <script type="text/javascript" nonce="1RzJhKAVumezIIOQztgiBk4dyeieRHT5" src="https://bitnodes.earn.com/static/compressed/js/760a24a6b3d3.js">
                        
                        
                        </script>
                        <script type="text/javascript" nonce="1RzJhKAVumezIIOQztgiBk4dyeieRHT5" src="37d90590b35f.js"></script>
                        
                       
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