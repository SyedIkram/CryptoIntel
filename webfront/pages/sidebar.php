<div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href=<?php echo $cur_dir?>><img src= <?php echo $cur_dir."assets/images/icon/logo.png";?> alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                    
                        <ul class="metismenu" id="menu">
                        <?php
                                if(strcmp($tile_current, 'Home')== 0){
                                    echo '<li class ="active" ><a href="'.$cur_dir.'"><i class="fas fa-home"></i><span>Home</span></a></li>';
                                }else{
                                    echo '<li ><a href="'.$cur_dir.'"><i class="fas fa-home"></i><span>Home</span></a></li>';
                                }
                            ?>
                            <li>
                                <a href="<?php echo $cur_dir.'livesentiment'; ?>"><i class="far fa-surprise"></i><span>Live Sentiment Analysis</span></a>
                            </li>
                            <?php
                                if(strcmp($tile_current, 'Topic Modeling')== 0 || strcmp($tile_current, 'Correlational Matrix')== 0 || strcmp($tile_current, 'Live Word Cloud Generator of News Articles')== 0){
                                    echo '<li class ="active" >';
                                }else{
                                    echo '<li >';
                                }
                                echo '<a href="javascript:void(0)" aria-expanded="true"><i class="far fa-chart-bar"></i><span>Analysis</span></a>';
                                echo '<ul class="collapse">';
                                if(strcmp($tile_current, 'Topic Modeling')== 0){
                                    echo '<li class ="active" ><a href="'.$cur_dir.'analysis/topicmodeling"><i class="fas fa-shapes"></i><span> Topic Modeling</span></a></li>';
                                }else{
                                    echo '<li ><a href="'.$cur_dir.'analysis/topicmodeling"><i class="fas fa-shapes"></i><span> Topic Modeling</span></a></li>';
                                }
                            
                                if(strcmp($tile_current, 'Correlational Matrix')== 0){
                                    echo '<li class ="active" ><a href="'.$cur_dir.'analysis/corr"><i class="fas fa-th"></i><span>Correlational Matrix</span></a></li>';
                                }else{
                                    echo '<li ><a href="'.$cur_dir.'analysis/corr"><i class="fas fa-th"></i><span>Correlational Matrix</span></a></li>';
                                }

                                if(strcmp($tile_current, 'Live Word Cloud Generator of News Articles')== 0){
                                    echo '<li class ="active" ><a href="'.$cur_dir.'analysis/livewordcloud"><i class="fab fa-cloudversify"></i><span>Live Word Cloud</span></a></li>';
                                }else{
                                    echo '<li ><a href="'.$cur_dir.'analysis/livewordcloud"><i class="fab fa-cloudversify"></i><span>Live Word Cloud</span></a></li>';
                                }
                                echo '</ul>';
                                echo '</li>';

                            
                                echo '<li ><a href="'.$cur_dir.'predictions"><i class="fas fa-external-link-square-alt"></i><span>Predictions</span></a></li>';
                            
                                if(strcmp($tile_current, 'Live Global Transaction Nodes')== 0){
                                    echo '<li class ="active" ><a href="'.$cur_dir.'globaltransactions"><i class="fas fa-map-marked"></i><span>Live Global Transactions</span></a></li>';
                                }else{
                                    echo '<li ><a href="'.$cur_dir.'globaltransactions"><i class="fas fa-map-marked"></i><span>Live Global Transactions</span></a></li>';
                                }
                            
                                if(strcmp($tile_current, 'Latest News')== 0){
                                    echo '<li class ="active" ><a href="'.$cur_dir.'latestnews"><i class="fas fa-newspaper"></i><span>Latest News</span></a></li>';
                                }else{
                                    echo '<li ><a href="'.$cur_dir.'latestnews"><i class="fas fa-newspaper"></i><span>Latest News</span></a></li>';
                                }

                                if(strcmp($tile_current, 'The Team')== 0){
                                    echo '<li class ="active" ><a href="'.$cur_dir.'team"><i class="fas fa-users"></i><span>The Team</span></a></li>';
                                }else{
                                    echo '<li ><a href="'.$cur_dir.'team"><i class="fas fa-users"></i><span>The Team</span></a></li>';
                                }


                            ?>
                            
                           
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- class="active" -->