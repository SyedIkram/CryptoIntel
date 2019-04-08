
<?php 
// VARS
$cur_dir='../../';
$PIE_COUNT = 4;
$tile_current = 'Live Word Cloud Generator of News Articles';

$cluster   = Cassandra::cluster()        
                 ->build();

$session   = $cluster->connect('crypton');    
?>
<style>
.center1 {
        margin: 0 auto;
        margin-left: 150px;
}
.center2 {
        margin: 0 auto;
        margin-left: 100px;
}
.center3 {
        margin: 0 auto;
        margin-left: 10px;
}
.center4 {
        margin: 0 auto;
        margin-left: 60px;
}
 </style>
<?php include $cur_dir.'pages/header.php';?>
<script type='text/javascript' src='http://d3js.org/d3.v3.min.js'></script>
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
                        <div style="float: center; text-align: center; font-size:2em;margin-bottom:20px">
 Number of words: <input type="number" value="800" min="1" id="max" size="35" style="width: 90px;" >
</div>       
<div id="vis" ></div>

<form id="form">

<p style="position: absolute; right: 0; top: 0" id="status"></p>

<div style="text-align: center">
  <div id="presets"></div>
  <div id="custom-area">
    <p><textarea hidden disabled id="text">

    <?php function removeCommonWords($input){
 
        // EEEEEEK Stop words
        $commonWords = array('lot','1','a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero',"a","about","above","after","again","against","ain","all","am","an","and","any","are","aren","aren't","as","at","be","because","been","before","being","below","between","both","but","by","can","couldn","couldn't","d","did","didn","didn't","do","does","doesn","doesn't","doing","don","don't","down","during","each","few","for","from","further","had","hadn","hadn't","has","hasn","hasn't","have","haven","haven't","having","he","her","here","hers","herself","him","himself","his","how","i","if","in","into","is","isn","isn't","it","it's","its","itself","just","ll","m","ma","me","mightn","mightn't","more","most","mustn","mustn't","my","myself","needn","needn't","no","nor","not","now","o","of","off","on","once","only","or","other","our","ours","ourselves","out","over","own","re","s","same","shan","shan't","she","she's","should","should've","shouldn","shouldn't","so","some","such","t","than","that","that'll","the","their","theirs","them","themselves","then","there","these","they","this","those","through","to","too","under","until","up","ve","very","was","wasn","wasn't","we","were","weren","weren't","what","when","where","which","while","who","whom","why","will","with","won","won't","wouldn","wouldn't","y","you","you'd","you'll","you're","you've","your","yours","yourself","yourselves","could","he'd","he'll","he's","here's","how's","i'd","i'll","i'm","i've","let's","ought","she'd","she'll","that's","there's","they'd","they'll","they're","they've","we'd","we'll","we're","we've","what's","when's","where's","who's","why's","would","able","abst","accordance","according","accordingly","across","act","actually","added","adj","affected","affecting","affects","afterwards","ah","almost","alone","along","already","also","although","always","among","amongst","announce","another","anybody","anyhow","anymore","anyone","anything","anyway","anyways","anywhere","apparently","approximately","arent","arise","around","aside","ask","asking","auth","available","away","awfully","b","back","became","become","becomes","becoming","beforehand","begin","beginning","beginnings","begins","behind","believe","beside","besides","beyond","biol","brief","briefly","c","ca","came","cannot","can't","cause","causes","certain","certainly","co","com","come","comes","contain","containing","contains","couldnt","date","different","done","downwards","due","e","ed","edu","effect","eg","eight","eighty","either","else","elsewhere","end","ending","enough","especially","et","etc","even","ever","every","everybody","everyone","everything","everywhere","ex","except","f","far","ff","fifth","first","five","fix","followed","following","follows","former","formerly","forth","found","four","furthermore","g","gave","get","gets","getting","give","given","gives","giving","go","goes","gone","got","gotten","h","happens","hardly","hed","hence","hereafter","hereby","herein","heres","hereupon","hes","hi","hid","hither","home","howbeit","however","hundred","id","ie","im","immediate","immediately","importance","important","inc","indeed","index","information","instead","invention","inward","itd","it'll","j","k","keep","keeps","kept","kg","km","know","known","knows","l","largely","last","lately","later","latter","latterly","least","less","lest","let","lets","like","liked","likely","line","little","'ll","look","looking","looks","ltd","made","mainly","make","makes","many","may","maybe","mean","means","meantime","meanwhile","merely","mg","might","million","miss","ml","moreover","mostly","mr","mrs","much","mug","must","n","na","name","namely","nay","nd","near","nearly","necessarily","necessary","need","needs","neither","never","nevertheless","new","next","nine","ninety","nobody","non","none","nonetheless","noone","normally","nos","noted","nothing","nowhere","obtain","obtained","obviously","often","oh","ok","okay","old","omitted","one","ones","onto","ord","others","otherwise","outside","overall","owing","p","page","pages","part","particular","particularly","past","per","perhaps","placed","please","plus","poorly","possible","possibly","potentially","pp","predominantly","present","previously","primarily","probably","promptly","proud","provides","put","q","que","quickly","quite","qv","r","ran","rather","rd","readily","really","recent","recently","ref","refs","regarding","regardless","regards","related","relatively","research","respectively","resulted","resulting","results","right","run","said","saw","say","saying","says","sec","section","see","seeing","seem","seemed","seeming","seems","seen","self","selves","sent","seven","several","shall","shed","shes","show","showed","shown","showns","shows","significant","significantly","similar","similarly","since","six","slightly","somebody","somehow","someone","somethan","something","sometime","sometimes","somewhat","somewhere","soon","sorry","specifically","specified","specify","specifying","still","stop","strongly","sub","substantially","successfully","sufficiently","suggest","sup","sure","take","taken","taking","tell","tends","th","thank","thanks","thanx","thats","that've","thence","thereafter","thereby","thered","therefore","therein","there'll","thereof","therere","theres","thereto","thereupon","there've","theyd","theyre","think","thou","though","thoughh","thousand","throug","throughout","thru","thus","til","tip","together","took","toward","towards","tried","tries","truly","try","trying","ts","twice","two","u","un","unfortunately","unless","unlike","unlikely","unto","upon","ups","us","use","used","useful","usefully","usefulness","uses","using","usually","v","value","various","'ve","via","viz","vol","vols","vs","w","want","wants","wasnt","way","wed","welcome","went","werent","whatever","what'll","whats","whence","whenever","whereafter","whereas","whereby","wherein","wheres","whereupon","wherever","whether","whim","whither","whod","whoever","whole","who'll","whomever","whos","whose","widely","willing","wish","within","without","wont","words","world","wouldnt","www","x","yes","yet","youd","youre","z","zero","a's","ain't","allow","allows","apart","list","appear","appreciate","appropriate","associated","best","better","c'mon","c's","cant","changes","clearly","concerning","consequently","consider","considering","corresponding","course","currently","definitely","described","despite","entirely","exactly","example","going","greetings","hello","help","hopefully","ignored","inasmuch","indicate","indicated","indicates","inner","insofar","it'd","keep","keeps","novel","presumably","reasonably","second","secondly","sensible","serious","seriously","sure","t's","third","thorough","thoroughly","three","well","wonder","1","2","3","4","5","6","7","8","9","10","15","2019",",","(",")",'“','the','The','8230The','area','send','Troubling','appeared','Town','post','team','cat','hall','users8217',"you've", 'again', 'mustn', "you're", 'such', "mightn't", 'once', 'being', 'should', 'during', 'for', "weren't", 'about', 'be', 'of', 'with', 'after', 'were', 'was', 'is', 'having', 'there', 'just', 'been', 'ain', 'hasn', 'or', 'ours', 'am', 'him', 'i', 'won', 'wasn', 'o', 'she', 'can', 'here', "haven't", 'below', 'now', 'haven', 'before', 'needn', 'our', 'have', 'into', 'why', 'doesn', "it's", "should've", 'y', 'so', "hadn't", 'too', 'through', 'ma', 'isn', 'very', 'out', 'who', 'at', 'their', 'wouldn', 'each', 'yours', 'these', 'doing', 'when', 'than', 'whom', 'in', 'same', "couldn't", "shouldn't", 'up', 'only', "you'll", 'shan', 'shouldn', 'but', 'weren', 'yourselves', 'does', 'didn', 'its', 'itself', 'against', 'them', 'we', 'his', 'those', 'a', 'own', "needn't", 'further', 'off', 'all', 't', "shan't", 'few', 'had', 'mightn', 'themselves', "doesn't", 's', "mustn't", 'down', 'the', 'and', 'not', 'it', 'they', 'd', 've', 'has', 'both', 'me', 'do', 'hadn', 'above', 'he', 'under', 'yourself', "won't", "don't", 'on', "wasn't", 'her', 'this', 'll', 'm', 'while', 'which', 'my', "you'd", "hasn't", 'any', 'because', "wouldn't", 'you', 'where', 'hers', 'how', 'no', "didn't", 'then', 'aren', 'myself', "that'll", 'most', "aren't", 'himself', 'from', "isn't", 'theirs', 'more', 'did', 'as', 'between', 'to', 'if', 'until', 'don', 'other', 'will', 'are', 'over', 'what', 'that', 'an', 're', "she's", 'herself', 'by', 'nor', 'ourselves', 'some', 'couldn', 'your');

        return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
        }
                                
                                $statement = new Cassandra\SimpleStatement(       // also supports prepared and batch statements
                                    'SELECT body FROM news_cc WHERE sortmentainer=1 ORDER BY published_on DESC LIMIT 50 ALLOW FILTERING'
                                );
                                $future    = $session->executeAsync($statement);  // fully asynchronous and easy parallel execution
                                $result    = $future->get();                      // wait for the result, with an optional timeout
                                

                                foreach ($result as $row) {
                                        echo removeCommonWords(preg_replace("/(?![.=$'€%-])\p{P}/u", "", $row['body']));
                                    } 
                                ?>
    

    </textarea>
    <button id="go" type="submit" type="button" class="btn btn-flat btn-primary btn-lg mb-3">Shuffle</button>
  </div>
</div>




<div id="angles" hidden>
  <p><input type="number" id="angle-count" value="5" min="1"> <label for="angle-count">orientations</label>
    <label for="angle-from">from</label> <input type="number" id="angle-from" value="-60" min="-90" max="90"> °
    <label for="angle-to">to</label> <input type="number" id="angle-to" value="60" min="-90" max="90"> °
</div>


</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>
<style>
#presets a { border-left: solid #666 1px; padding: 0 10px; }
#presets a.first { border-left: none; }
#keyword { width: 300px; }
#fetcher { width: 500px; }
#keyword, #go { font-size: 1.5em; }
#text { width: 100%; height: 100px; }
p.copy { font-size: small; }
#form { font-size: small; position: relative; }
hr { border: none; border-bottom: solid #ccc 1px; }
a.active { text-decoration: none; color: #000; font-weight: bold; cursor: text; }
#angles line, #angles path, #angles circle { stroke: #666; }
#angles text { fill: #333; }
#angles path.drag { fill: #666; cursor: move; }
#angles { text-align: center; margin: 0 auto; width: 350px; }
#angles input, #max { width: 42px; }
</style>

<?php include 'jshelper.php';?>   

<?php include $cur_dir.'pages/footer.php';?>