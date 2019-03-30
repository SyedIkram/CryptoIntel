
<?php 
// VARS
$cur_dir='../../';
$PIE_COUNT = 4;
$tile_current = 'Correlational Matrix';
?>

<?php include $cur_dir.'pages/header.php';?>
<script type='text/javascript' src='http://d3js.org/d3.v3.min.js'></script>
<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/bmabey/pyLDAvis/files/ldavis.v1.0.0.css">
<style>

.pixel:hover
{ 
  stroke: #000;
  stroke-width: 1px;
}
.tick:hover
{ 
  fill: #aaa;
/* stroke: #000;  
stroke-width: 1px;*/
}
div.tooltip
{
	position: absolute;
	text-align: left;
	padding: 8px;
	font: 12px sans-serif;
	background: #000;
    color: #ddd;
	border: solid 1px #aaa;
	border-radius: 4px;
	pointer-events: none;
}
    </style>
<body >
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
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-Pearson" role="tab" aria-controls="pills-home" aria-selected="true">Pearson</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-Spearman" role="tab" aria-controls="pills-profile" aria-selected="false">Spearman</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-Kendall" role="tab" aria-controls="pills-contact" aria-selected="false">Kendall</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">

                                <?php

                                    $profile_list = ['pills-Pearson','pills-Spearman','pills-Kendall'];
                                    $acL = ['active','',''];
                                    $csv_file = ['Pearcoin.csv','Spmcoin.csv','Kendcoin.csv'];
                                    $svg_list = ['svgPear','svgSPm','svgKend'];
                                    $svg_list2 = ['svgPear2','svgSPm2','svgKend2'];

                                    $id_list = ['file_pathPear','file_pathSpm','file_pathKend'];
                                    $sortfn_list = ['sort_funcPear','sort_funcSpm','sort_funcKend'];
                                    $ks_list = ['keep_symmetryPear','keep_symmetrySpm','keep_symmetryKend'];
                                    $zoom_list = ['zoomPear','zoomSpm','zoomKend'];

                                    for($i = 0 ; $i < 3 ; $i++){

                                      echo '<div class="tab-pane '.$acL[$i].' fade show " id="'.$profile_list[$i].'" role="tabpanel" aria-labelledby="pills-home-tab">';
                                      // echo '<p>';
                                      echo '<input type="text" hidden value="'.$csv_file[$i].'" id="'.$id_list[$i].'">';
                                      echo '<label class="custom-control-label" for="'.$sortfn_list[$i].'">Sort By</label>';
                                      echo '<select style="width: 150px;" class="form-control" id="'.$sortfn_list[$i].'">';
                                      echo '<option value="abs_value">by Absolute Value</option><option value="value">by Value</option><option value="similarity">by Similarity</option><option value="alphabetic">Alphabetic</option><option value="original">Original</option></select>';
                                      // echo 'Keep symmetry?';
                                      // echo '<input class="custom-control-label" type="checkbox" id="'.$ks_list[$i].'" checked="true">';
                                      // echo '</p>';
                                      echo '<div class="custom-control custom-checkbox">';
                                      echo '<input type="checkbox" checked="" class="custom-control-input" id="'.$ks_list[$i].'">';
                                      echo '<label class="custom-control-label" for="'.$ks_list[$i].'">Keep Symmetry</label></div>';
                                      echo '<div id="'.$svg_list[$i].'">';
                                      echo '<svg id="'.$svg_list2[$i].'" width="800" height="600" style="padding: 0px;"></svg>';
                                      echo '<div class="tooltip" style="opacity: 0.01"></div></div>';
                                      echo '</div>';
                                  }

                                ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script type="text/javascript">



window.onload=function(){

  CORRMAKER('file_pathPear','#svgPear','sort_funcPear','keep_symmetryPear','purple');
  CORRMAKER('file_pathSpm','#svgSPm','sort_funcSpm','keep_symmetrySpm','green');
  CORRMAKER('file_pathKend','#svgKend','sort_funcKend','keep_symmetryKend','red');

};
function CORRMAKER(filePath,svgID,sortFn,Ks,Color){

  var load_all = function(){
  d3.csv(d3.select("input#"+filePath)[0][0].value, function(data){
    var label_col_full = Object.keys(data[0]);
    var label_row = [];
    var rows = [];
    var row = [];
    for(var i = 0; i < data.length; i++){
      label_row.push(data[i][label_col_full[0]]);
      row = [];
      for(var j = 1; j < label_col_full.length; j++){
        row.push(parseFloat(data[i][label_col_full[j]]));
      }
      rows.push(row);
    }
    // d3.select("svg").remove();

    main(rows, label_col_full.slice(1), label_row);
  });
};

load_all();  // not to start with nothing


var main = function(corr, label_col, label_row){

var transition_time = 1500;

var body = d3.select(svgID);
var svg = d3.select(svgID+'2');
var tooltip = body.select('div.tooltip')
   .style("opacity", 1e-6);

// var svg = body.append('svg')
//   .attr('width', 800)
//   .attr('height', 800);

// Autodetect symmetric tables
d3.select("input#"+Ks)
  .each(function(){ this.checked = JSON.stringify(label_col) === JSON.stringify(label_row); });

var keep_symmetry = d3.select("input#"+Ks)[0][0].checked;
d3.select("input#"+Ks).on("change", function() {
    if (corr.length !== corr[0].length) {
      this.checked = false;
      // or I can disable it
    }
    keep_symmetry = this.checked;
    if(keep_symmetry){ reorder_matrix(last_k, last_what); }
});

var sort_process = d3.select("select#"+sortFn)[0][0].value;
d3.select("select#"+sortFn).on("change", function() {
    sort_process = this.value;
    reorder_matrix(last_k, last_what);
});


var row = corr;
var col = d3.transpose(corr);


// converts a matrix into a sparse-like entries
// maybe 'expensive' for large matrices, but helps keeping code clean
var indexify = function(mat){
    var res = [];
    for(var i = 0; i < mat.length; i++){
        for(var j = 0; j < mat[0].length; j++){
            res.push({i:i, j:j, val:mat[i][j]});
        }
    }
    return res;
};

var corr_data = indexify(corr);
var order_col = d3.range(label_col.length + 1);
var order_row = d3.range(label_row.length + 1);

var color = d3.scale.linear()
    .domain([-1,0,1])
    .range(['blue','white',Color]);

var scale = d3.scale.linear()
    .domain([0, d3.min([50, d3.max([label_col.length, label_row.length, 4])])])
    .range([0, parseFloat(0.7) * 600]);

var label_space = 85;
// I will make it also a function of scale and max label length

var matrix = svg.append('g')
    .attr('class','matrix')
    .attr('transform', 'translate(' + (label_space + 90) + ',' + (label_space + 10) + ')');

var pixel = matrix.selectAll('rect.pixel').data(corr_data);

// as of now, data not changable, only sortable
pixel.enter()
    .append('rect')
        .attr('class', 'pixel')
        .attr('width', scale(0.9))
        .attr('height', scale(0.9))
        .style('fill',function(d){ return color(d.val);})
        .on('mouseover', function(d){pixel_mouseover(d);})
        .on('mouseout', function(d){mouseout(d);});

tick_col = svg.append('g')
    .attr('class','ticks')
    .attr('transform', 'translate(' + (label_space + 90) + ',' + (label_space) + ')')
    .selectAll('text.tick')
    .data(label_col);

tick_col.enter()
    .append('text')
        .attr('class','tick')
        .style('text-anchor', 'start')
        .attr('transform', function(d, i){return 'rotate(270 ' + scale(order_col[i] + 0.7) + ',0)';})
        .attr('font-size', scale(0.8))
        .text(function(d){ return d; })
        .on('mouseover', function(d, i){tick_mouseover(d, i, col[i], label_row);})
        .on('mouseout', function(d){mouseout(d);})
        .on('click', function(d, i){reorder_matrix(i, 'col');});

tick_row = svg.append('g')
    .attr('class','ticks')
    .attr('transform', 'translate(' + (label_space+80) + ',' + (label_space + 10) + ')')
    .selectAll('text.tick')
    .data(label_row);

tick_row.enter()
    .append('text')
        .attr('class','tick')
        .style('text-anchor', 'end')
        .attr('font-size', scale(0.8))
        .text(function(d){ return d; })
        .on('mouseover', function(d, i){tick_mouseover(d, i, row[i], label_col);})
        .on('mouseout', function(d){mouseout(d);})
        .on('click', function(d, i){reorder_matrix(i, 'row');});

var pixel_mouseover = function(d){
  tooltip.style("opacity", 0.8)
  
    .style("left", (d3.event.pageX -275) + "px")
    .style("top", (d3.event.pageY -280) + "px")
    .html(d.i + ": " + label_row[d.i] + "<br>" + d.j + ": " + label_col[d.j] + "<br>" + "Value: " + (d.val > 0 ? "+" : "&nbsp;") + d.val.toFixed(3));
};

var mouseout = function(d){
  tooltip.style("opacity", 1e-6);
};

var tick_mouseover = function(d, i, vec, label){
  // below can be optimezed a lot
  var indices = d3.range(vec.length);
  // also value/abs val?
  indices.sort(function(a, b){ return Math.abs(vec[b]) - Math.abs(vec[a]); });
  res_list = [];
  for(var j = 0; j < Math.min(vec.length, 10); j++) {
    res_list.push((vec[indices[j]] > 0 ? "+" : "&nbsp;") + vec[indices[j]].toFixed(3) + "&nbsp;&nbsp;&nbsp;" + label[indices[j]]);
  }
  
  tooltip.style("opacity", 0.8)
    .style("left", (d3.event.pageX -275) + "px")
    .style("top", (d3.event.pageY  -275) + "px")
    .html("" + i + ": " + d + "<br><br>" + res_list.join("<br>"));
};


var refresh_order = function(){
    tick_col.transition()
        .duration(transition_time)
            .attr('transform', function(d, i){return 'rotate(270 ' + scale(order_col[i] + 0.7) + ',0)';})
            .attr('x', function(d, i){return scale(order_col[i] + 0.7);});

    tick_row.transition()
        .duration(transition_time)
            .attr('y', function(d, i){return scale(order_row[i] + 0.7);});

    pixel.transition()
        .duration(transition_time)
            .attr('y', function(d){return scale(order_row[d.i]);})
            .attr('x', function(d){return scale(order_col[d.j]);});
};

refresh_order();

var last_k = 0;
var last_what = 'col';
var reorder_matrix = function(k, what){
    last_k = k;
    last_what = what;
    var order = [];
    var vec = [];
    var labels = [];
    var vecs = [];
    if(what === 'row'){  //yes, we are sorting counterpart
        vec = row[k];
        vecs = row;
        labels = label_col;  //test is if it ok
    } else if ( what === 'col' ) {
        vec = col[k];
        vecs = col;
        labels = label_row;
    }
    var indices = d3.range(vec.length);
    switch (sort_process) {
      case "value":
        indices = indices.sort(function(a,b){return vec[b] - vec[a];});
        break;
      case "abs_value":
        indices = indices.sort(function(a,b){return Math.abs(vec[b]) - Math.abs(vec[a]);});
        break;
      case "original":
        break;
      case "alphabetic":
        indices = indices.sort(function(a,b){return Number(labels[a] > labels[b]) - 0.5;});
        break;
      case "similarity":
        // Ugly, but sometimes we want to sort the coordinate we have clicked
        // Also, as of now with no normalization etc
        indices = d3.range(vecs.length);
        indices = indices.sort(function(a,b){
          var s = 0;
          for(var i = 0; i < vec.length; i++){
            s += (vecs[b][i] - vecs[a][i]) * vec[i];
          }
          return s;
        });
        if(what === 'col' || keep_symmetry){
            order_col = reverse_permutation(indices);
        } //not else if!
        if ( what === 'row' || keep_symmetry) {
            order_row = reverse_permutation(indices);
        }
        refresh_order();
        return undefined;
    }
    if(what === 'row' || keep_symmetry){
        order_col = reverse_permutation(indices);
    } //not else if!
    if ( what === 'col' || keep_symmetry) {
        order_row = reverse_permutation(indices);
    }
    refresh_order();
};

var reverse_permutation = function(vec){
    var res = [];
    for(var i = 0; i < vec.length; i++){
        res[vec[i]] = i;
    }
    return res;
};

};
}
</script>
<?php include $cur_dir.'pages/footer.php';?>