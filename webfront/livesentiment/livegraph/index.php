
<?php 
// VARS
$cur_dir='../../';
$PIE_COUNT = 4;

if (empty($_GET["coinsymbol"]))
{
  header('Location: ../');
  exit; 
} 

else{
    $coin_symbol = $_GET["coinsymbol"];
}


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
    "SELECT id,coinname,imageurl from all_coins WHERE symbol='".$coin_symbol."' ALLOW FILTERING"
);
$futureLV    = $session->executeAsync($statementLV);  
$resultLV    = $futureLV->get();    

if (empty($resultLV[0]['coinname']))
{
header('Location: ../');
exit; 
}   
$working_coin  = $resultLV[0]['coinname'];
$coin_id = $resultLV[0]['id'];

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
                            <table>
    <tr>
            <th><h4 class='rotate' >Sentiment</h4></th>
        <th><h1><?php echo $working_coin;?></h1><div id="BTCG">
        
        
        </div><h4>Number of Tweets</h4></th>
    </tr>
    
  </table>
                            </div>
                        </div>
                
            </div>
        </div>
        </div>
    </div>
    

</div>
</body>
<script src="http://d3js.org/d3.v3.min.js"></script>

<script>

    // Set the dimensions of the canvas / graph
    var margin = {top: 30, right: 20, bottom: 30, left: 50},
        width = 750 - margin.left - margin.right,
        height = 470 - margin.top - margin.bottom;
    
    // Set the ranges
    var x = d3.scale.linear().range([0, width]);
    var y = d3.scale.linear().range([height, 0]);
    
    // Define the axes
    var xAxis = d3.svg.axis().scale(x).orient("bottom");
    var yAxis = d3.svg.axis().scale(y).orient("left");
    
    // Define the line
    var valueline = d3.svg.line()
        .x(function(d) { return x(d.date); })
        .y(function(d) { return y(d.close); });
        
    // Adds the svg canvas
    var svg = d3.select("#BTCG")
        .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
        .append("g")
            .attr("transform", 
                  "translate(" + margin.left + "," + margin.top + ")");

   

    // Get the data str_replace(' ', '', $tile_current)
    <?php 

    echo ' d3.csv("'.str_replace(' ', '', str_replace('.', '', $working_coin)).'_data.csv", function(error, data)';
    ?>
    {
        data.forEach(function(d) {
            d.date = +(d.date*10);
            d.close = +d.close;
        });
    
        // Scale the range of the data
        x.domain(d3.extent(data, function(d) { return d.date; }));
        y.domain([d3.min(data, function(d) { return d.close; }), d3.max(data, function(d) { return d.close; })]);
    
        // Add the valueline path.
        svg.append("path")
            .attr("class", "line")
            .attr("d", valueline(data));
    
        // Add the X Axis
        svg.append("g").text("Date")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);
    
        // Add the Y Axis
        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis);
    
    });
    
    var svg2 = d3.select("#ETHG")
    .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .attr("id",'new')
    .append("g")
        .attr("transform", 
                "translate(" + margin.left + "," + margin.top + ")");

    var xAxis2 = d3.svg.axis().scale(x).orient("bottom");
    var yAxis2 = d3.svg.axis().scale(y).orient("left");





    var valueline2 = d3.svg.line()
        .x(function(d) { return x(d.date); })
        .y(function(d) { return y(d.close); });

    


    var lb=0;
    var cnt1 = 0;
   

    // ** Update data section (Called from the onclick)
    function updateData(filename) {
        console.log(cnt1)
        

        // Get the data again
        d3.csv(filename, function(error, data) {
               data.forEach(function(d) {
                d.date = +(d.date*10);
                d.close = +d.close;
            });
    
            // Scale the range of the data again 
            
            x.domain([lb,d3.max(data, function(d) { return d.date; })]);
            y.domain([d3.min(data, function(d) { return d.close; }), d3.max(data, function(d) { return d.close; })]);
    
        // Select the section we want to apply our changes to
        var svg = d3.select("#BTCG").transition();
            
        // Make the changes
        svg.select(".line")   // change the line
                // .duration(500)
                .attr("d", valueline(data));
                svg.select(".x.axis") // change the x axis
                // .duration(500)
                .call(xAxis);
                svg.select(".y.axis") // change the y axis
                // .duration(500)
                .call(yAxis);
    
        });
        
    };

    function updateData2(filename) {
    
    // Get the data again
    d3.csv(filename, function(error, data2) {
        data2.forEach(function(d) {
            d.date = +(d.date*10);
            d.close = +d.close;
        });

        // Scale the range of the data again 
        x.domain(d3.extent(data2, function(d) { return d.date; }));
        y.domain([d3.min(data2, function(d) { return d.close; }), d3.max(data2, function(d) { return d.close; })]);

    // Select the section we want to apply our changes to
    var svg2 = d3.select("#new").transition();
        
    // Make the changes
    svg2.select(".line")   // change the line
            // .duration(500)
            .attr("d", valueline(data2));
    svg2.select(".x.axis") // change the x axis
            // .duration(500)
            .call(xAxis);
    svg2.select(".y.axis") // change the y axis
            // .duration(500)
            .call(yAxis);

    });
};



    var mainInterval = setInterval(function (){

        <?php 

        echo "updateData('".str_replace(' ', '', str_replace('.', '', $working_coin))."_data.csv');";

?>

          
        
        // updateData2('Ethereum_data.csv');
        console.log('hello')
          },500);
    

    </script>
<?php include $cur_dir.'pages/footer.php';?>