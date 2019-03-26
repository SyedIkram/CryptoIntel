<footer>
            <div class="footer-area">
                <p><?php echo $title; ?> © Copyright 2019. All right reserved</p>
            </div>
        </footer>
        

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
<?php 

        $scripts = array("assets/js/vendor/jquery-2.2.4.min.js","assets/js/popper.min.js",
        "assets/js/popper.min.js",
        "assets/js/bootstrap.min.js",
        "assets/js/popper.min.js",
        "assets/js/owl.carousel.min.js",
        "assets/js/metisMenu.min.js",
        "assets/js/jquery.slimscroll.min.js",
        "assets/js/jquery.slicknav.min.js",
        "assets/js/line-chart.js",
        "assets/js/pie-chart.js",
        "assets/js/plugins.js",
        "assets/js/bar-chart.js",
        "assets/js/plugins.js",
        "assets/js/ccc-streamer-utilities.js",
        "assets/js/scripts.js",
        
    "assets/js/jquery.slicknav.min.js");

        foreach ($scripts as $scVal) {
            echo '<script src="'.$cur_dir.$scVal.'"></script>';
        }

    ?>

</html>