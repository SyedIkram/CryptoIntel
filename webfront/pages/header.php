<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require $cur_dir.'vars.php';?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title.' - '.$tile_current; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">

    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <?php 
        $stylesheets = array("assets/css/bootstrap.min.css", "assets/css/font-awesome.min.css",
                             "assets/css/owl.carousel.min.css","assets/css/slicknav.min.css",
                             "assets/css/themify-icons.css", "assets/css/metisMenu.css",
                             "assets/css/typography.css","assets/css/default-css.css",
                             "assets/css/styles.css","assets/css/responsive.css",
                             "assets/css/responsive.css"); 

        foreach ($stylesheets as $ssVal) {
            echo '<link rel="stylesheet" href="'.$cur_dir.$ssVal.'" type="text/css" media="all" >';
        }

        $scripts = array("assets/js/vendor/modernizr-2.8.3.min.js");

        foreach ($scripts as $scVal) {
            echo '<script src="'.$cur_dir.$scVal.'"></script>';
        }

    ?>

</head>