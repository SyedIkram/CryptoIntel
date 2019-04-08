
<?php 
// VARS
$cur_dir='../';
$PIE_COUNT = 4;
$tile_current = 'Live Bitcoin Transaction Volume';
?>

<?php include $cur_dir.'pages/header.php';?>

  <script src="three.min.js"></script>
  <script src="oimo.min.js"></script>
<style>
#key {
  width:200px;
}
#title { position: absolute;
  left: 20px;
  top: 20px;
  right: 20px;
  line-height: 1.1em;
  /*text-shadow: 0 1px 0 rgba(0,0,0,.4);*/
}

#right{
  position: absolute;
  text-align:right;
  right: 0;
  top: 0;
}

#right p, #right h4 {
  text-align: right;
}

#right a {
  color: white;
  opacity: .75;
  transition: opacity 150ms ease-out;
  padding: 10px 20px;
  border: 1px solid white;
  line-height: 45px;
}

#right a:hover,
#close-button {
  text-decoration: none;
}
@media only screen and (max-width: 1680px) {
.framesize{
    max-height: 798px;
    max-width: 1300px;
}
}
@media only screen and (max-width: 1366px) {
.framesize{
    max-height: 698px;
    max-width: 200px;
}
}
@media only screen and (max-width: 1440px) {
.framesize{
    max-height: 698px;
    max-width: 1100px;
}
}
@media only screen and (max-width: 640px) {
.framesize{
    max-height: 798px;
    max-width: 350px;
}
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
    <canvas id="canvas" class ="framesize"></canvas>

 

    <div id="title">
      

      <div id="key">
      <h4 class="header-title">Key (BTC)</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table text-center">
                                            <thead class="text-uppercase bg-primary">
                                                <tr class="text-white">
                                                    <th scope="col">Color</th>
                                                    <th scope="col">Range</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                    <th scope="row">Yellow Cube</th>
                                                    <td>Last Mined Block (KB)</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Purple</th>
                                                    <td>&gt; 1000</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Blue</th>
                                                    <td>100 - 1000</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Yellow</th>
                                                    <td>50 - 100</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Orange</th>
                                                    <td>10 - 50</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Green</th>
                                                    <td>1 - 10</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Red</th>
                                                    <td>&lt; 1 BTC</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
      </div>

      <div id="right">
      <h4 class="header-title">Values</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table text-center">
                                            <thead class="text-uppercase bg-info">
                                                <tr class="text-white">
                                                    <th scope="col">BTC</th>
                                                    <th scope="col">Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Current</th>
                                                    <td id="currentTransactions">Ƀ 0</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Total</th>
                                                    <td id="totalTransactions">Ƀ 0</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Biggest</th>
                                                    <td id="biggestTransaction">Ƀ 0</td>
                                                </tr>
                                                <!-- <tr>
                                                    <th scope="row">Selected</th>
                                                    <td id="selectedTransaction">Ƀ 0</td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script>
  "use strict";

function init() {
    var e = document.createElement("canvas");
    e.width = 16, e.height = 16;
    var t = e.getContext("2d");
    t.font = "900 26px Lato", t.fillText("A", 0, 0);
    var n = navigator.userAgent;
    (n.match(/Android/i) || n.match(/webOS/i) || n.match(/iPhone/i) || n.match(/iPad/i) || n.match(/iPod/i) || n.match(/BlackBerry/i) || n.match(/Windows Phone/i)) && (isMobile = !0), e = document.getElementById("canvas"), camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 5e3), camera.position.set(0, 160, 360), controls = new THREE.OrbitControls(camera, e), controls.target.set(0, 20, 0), controls.minDistance = 300, controls.maxDistance = 1e3, controls.update(), scene = new THREE.Scene, renderer = new THREE.WebGLRenderer({
        canvas: e,
        precision: "mediump",
        antialias: !0
    }), renderer.setSize(window.innerWidth, window.innerHeight), scene.add(new THREE.AmbientLight(4014403)), light = new THREE.DirectionalLight(16777215, 1), light.position.set(500, 1e3, 500), light.target.position.set(0, 0, 0), light.castShadow = !0, light.shadow.camera.near = 500, light.shadow.camera.far = 1600, light.shadow.camera.fov = 70, light.shadow.bias = 1e-4;
    var o = 300;
    light.shadow.camera.left = -o, light.shadow.camera.right = o, light.shadow.camera.top = o, light.shadow.camera.bottom = -o, light.shadow.mapSize.width = light.shadow.mapSize.height = 1024, scene.add(light), isMobile || (light1 = new THREE.DirectionalLight(16777215, .5), light1.position.set(-500, 1e3, -500), light1.target.position.set(0, 0, 0), light1.castShadow = !0, light1.shadow.camera.near = 500, light1.shadow.camera.far = 1600, light1.shadow.camera.fov = 70, light1.shadow.bias = 1e-4, light1.shadow.camera.left = -o, light1.shadow.camera.right = o, light1.shadow.camera.top = o, light1.shadow.camera.bottom = -o, light1.shadow.mapSize.width = light1.shadow.mapSize.height = 1024, scene.add(light1));
    var a = "MeshStandardMaterial";
    if (renderer.shadowMap.enabled = !0, renderer.shadowMap.type = THREE.PCFSoftShadowMap, renderer.setClearColor(16777215), geos.sphere = (new THREE.BufferGeometry).fromGeometry(new THREE.SphereGeometry(1, 24, 24)), geos.box = (new THREE.BufferGeometry).fromGeometry(new THREE.BoxGeometry(1, 1, 1)), isMobile) {
        var s = .5,
            i = .5,
            r = bitcoinLogoTexture();
        mats.btc1000 = new THREE[a]({
            map: basicTexture(1),
            name: "btc1000",
            roughness: i,
            metalness: s,
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2
        }), mats.btc100 = new THREE[a]({
            map: basicTexture(1),
            name: "btc100",
            roughness: i,
            metalness: s,
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2
        }), mats.btc50 = new THREE[a]({
            map: basicTexture(2),
            name: "btc50",
            roughness: i,
            metalness: s,
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2
        }), mats.btc10 = new THREE[a]({
            map: basicTexture(3),
            name: "btc10",
            roughness: i,
            metalness: s,
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2
        }), mats.btc1 = new THREE[a]({
            map: basicTexture(4),
            name: "btc1",
            roughness: i,
            metalness: s,
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2
        }), mats.btc0 = new THREE[a]({
            map: basicTexture(5),
            name: "btc0",
            roughness: i,
            metalness: s,
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2
        }), mats.ground = new THREE[a]({
            color: 6710886,
            roughness: i,
            metalness: s,
            name: "ground"
        })
    } else {
        var s = .8,
            i = 1,
            r = bitcoinLogoTexture(),
            c = roughTexture();
        mats.btc1000 = new THREE[a]({
            map: basicTexture(0),
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2,
            name: "btc1000",
            roughnessMap: c,
            roughness: i,
            metalness: s
        }), mats.btc100 = new THREE[a]({
            map: basicTexture(1),
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2,
            name: "btc100",
            roughnessMap: c,
            roughness: i,
            metalness: s
        }), mats.btc50 = new THREE[a]({
            map: basicTexture(2),
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2,
            name: "btc50",
            roughnessMap: c,
            roughness: i,
            metalness: s
        }), mats.btc10 = new THREE[a]({
            map: basicTexture(3),
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2,
            name: "btc10",
            roughnessMap: c,
            roughness: i,
            metalness: s
        }), mats.btc1 = new THREE[a]({
            map: basicTexture(4),
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2,
            name: "btc1",
            roughnessMap: c,
            roughness: i,
            metalness: s
        }), mats.btc0 = new THREE[a]({
            map: basicTexture(5),
            emissiveMap: r,
            emissive: 16777215,
            emissiveIntensity: .2,
            name: "btc0",
            roughnessMap: c,
            roughness: i,
            metalness: s
        }), mats.ground = new THREE[a]({
            map: gradientMap(),
            roughnessMap: c,
            roughness: i,
            metalness: s,
            name: "ground",
            bumpMap: c,
            bumpScale: .5
        })
    }
    var d = (new THREE.BufferGeometry).fromGeometry(new THREE.CylinderGeometry(6, 0, 30, 4)),
        m = new THREE[a]({
            color: 16777215,
            emissive: 16777215,
            emissiveIntensity: .5,
            roughness: .5,
            metalness: .5,
            transparent: !0,
            opacity: .5
        });
    // marker = new THREE.Mesh(d, m), marker.position.set(0, -4e3, 0), scene.add(marker), raycaster = new THREE.Raycaster, mouse = new THREE.Vector2, this.innerHTML = "UN-MUTE"
    var l = document.getElementById("info"),
        u = document.getElementById("key"),
        h = document.getElementById("right"),
        g = document.getElementById("address");
  
   
    document.addEventListener("keydown", function(e) {
        32 === e.keyCode && (jumbleScene(), e.preventDefault())
    }), mainGain.gain.exponentialRampToValueAtTime(.1, context.currentTime + 1), mainGain.gain.value = .1, window.addEventListener("resize", onWindowResize, !1), document.getElementById("canvas").addEventListener("mousedown", onDocumentMouseDown, !1), document.getElementById("canvas").addEventListener("touchstart", onDocumentTouchStart, !1), stage(), startWebSocket(), loop()
}

function loop() {
    updatePhysics(), renderer.render(scene, camera), requestAnimationFrame(loop)
}

function loop() {
    controls.update();
    var e = Date.now() - start;
    selected && (marker.position.copy(selected.position), marker.position.y += 10 * Math.abs(Math.sin(.002 * e)) + (selected.scale.x + 40)), updatePhysics(), renderer.render(scene, camera), requestAnimationFrame(loop)
}

function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight, camera.updateProjectionMatrix(), renderer.setSize(window.innerWidth, window.innerHeight)
}

function addStaticBox(e, t, n) {
    var o = new THREE.Mesh(geos.box, mats.ground);
    o.scale.set(e[0], e[1], e[2]), o.position.set(t[0], t[1], t[2]), o.rotation.set(n[0] * ToRad, n[1] * ToRad, n[2] * ToRad), scene.add(o), grounds.push(o), o.receiveShadow = !0
}

function stage() {
    world = new OIMO.World(1 / 60, 2, 8, !1);
    world.add({
        size: [400, 20, 400],
        pos: [0, -10, 0],
        world: world
    });
    addStaticBox([400, 20, 400], [0, -10, 0], [0, 0, 0])
}

function addTransaction(e) {
    var t, n, o, a, s = bodys.length,
        i = e;
    totalBitcoin += i;
    var r, c;
    t = -100 + 200 * Math.random(), o = -100 + 200 * Math.random(), n = tabFocus ? 1e3 : 500 + 1e3 * Math.random(), i > 1e3 ? (r = mats.btc1000, a = 100, c = 5) : i > 100 ? (r = mats.btc100, a = 75, c = 4) : i > 50 ? (r = mats.btc50, a = 50, c = 3) : i > 10 ? (r = mats.btc10, a = 25, c = 2) : i > 1 ? (r = mats.btc1, a = 15, c = 1) : (r = mats.btc0, a = 10, c = 0), bodys[s] = world.add({
        type: "sphere",
        size: [.5 * a],
        pos: [t, n, o],
        move: !0,
        world: world
    }), bodys[s].currentContacts = 0, bodys[s].name = c, meshs[s] = new THREE.Mesh(geos.sphere, r), meshs[s].scale.set(.5 * a, .5 * a, .5 * a), meshs[s].value = i, meshs[s].name = "transaction";
    var d = Math.floor(360 * Math.random() + 1) * ToRad,
        m = Math.floor(360 * Math.random() + 1) * ToRad,
        l = Math.floor(360 * Math.random() + 1) * ToRad,
        u = new THREE.Euler;
    u.set(d, m, l);
    var h = new THREE.Quaternion;
    h.setFromEuler(u), bodys[s].setQuaternion(h), meshs[s].castShadow = !0, meshs[s].receiveShadow = !0, scene.add(meshs[s])
}

function addBlock(e, t) {
    block = e;
    var n, o, a, s, i = blockTextures(block);
    n = -100 + 200 * Math.random(), a = -100 + 200 * Math.random(), o = tabFocus ? 1e3 : 500 + 1e3 * Math.random(), s = t / 5e3, 50 > s && (s = 50);
    var r = bodys.length;
    bodys[r] = world.add({
        type: "box",
        size: [.5 * s, .5 * s, .5 * s],
        pos: [n, o, a],
        move: !0,
        world: world
    }), currentBlock = bodys[r], bodys[r].currentContacts = 0, bodys[r].name = block, meshs[r] = new THREE.Mesh(geos.box, i), meshs[r].scale.set(.5 * s, .5 * s, .5 * s), meshs[r].name = "block", meshs[r].castShadow = !0, meshs[r].receiveShadow = !0, scene.add(meshs[r])
}

function updatePhysics() {
    if (null !== world) {
        for (var e, t, n, o, a, s = bodys.length, i = 0; s--;) {
            if (a = bodys[s], o = meshs[s], o.value && (i += o.value), o.value > biggestTransaction && (biggestTransaction = o.value), a.numContacts > a.currentContacts && 1 === a.numContacts) {
                var r = .4 * Math.random();
                0 === bodys[s].name ? playSound(sound[0], .5 + r, 0) : 1 === bodys[s].name ? playSound(sound[0], .45 + r, 1) : 2 === bodys[s].name ? playSound(sound[0], .4 + r, 2) : 3 === bodys[s].name ? playSound(sound[1], .4 + r, 3) : 4 === bodys[s].name ? playSound(sound[1], .4 + r, 4) : 5 === bodys[s].name ? playSound(sound[1], .4 + r, 5) : playSound(sound[1], .4 + r, 5)
            }
            a.currentContacts = a.numContacts, a.sleeping || (o.position.copy(a.getPosition()), o.quaternion.copy(a.getQuaternion()), o.position.y < -1e3 && (bodys[s].name === block ? (e = -100 + 200 * Math.random(), n = -100 + 200 * Math.random(), t = 200 + 1e3 * Math.random(), a.resetPosition(e, t, n), a.numContacts = 0, a.currentContacts = 0) : (scene.remove(meshs[s]), a.remove(), bodys.splice(s, 1), meshs.splice(s, 1))))
        }
        world.step(), document.getElementById("totalTransactions").innerHTML = "" + totalBitcoin.toFixed(4), document.getElementById("currentTransactions").innerHTML = "" + i.toFixed(4), document.getElementById("biggestTransaction").innerHTML = "" + biggestTransaction.toFixed(4)
    }
}

function basicTexture(e) {
    var t = 1024,
        n = 512,
        o = document.createElement("canvas");
    o.width = t, o.height = n;
    var a, s = o.getContext("2d");
    0 === e && (a = "#7b38aa"), 1 === e && (a = "#3884AA"), 2 === e && (a = "#AAAA38"), 3 === e && (a = "#AA6538"), 4 === e && (a = "#38aa65"), 5 === e && (a = "#aa3838"), s.fillStyle = a, s.fillRect(0, 0, t, n), s.drawImage(img, n / 4, n / 4, n / 2, n / 2);
    var i = new THREE.Texture(o);
    return i.anisotropy = 16, i.needsUpdate = !0, i
}

function bitcoinLogoTexture() {
    var e = 1024,
        t = 512,
        n = document.createElement("canvas");
    n.width = e, n.height = t;
    var o = n.getContext("2d");
    o.fillStyle = "#000000", o.fillRect(0, 0, e, t), o.drawImage(img, t / 4, t / 4, t / 2, t / 2);
    var a = new THREE.Texture(n);
    return a.anisotropy = 16, a.needsUpdate = !0, a
}

function roughTexture() {
    var e = 512,
        t = 512,
        n = document.createElement("canvas");
    n.width = e, n.height = t;
    var o = n.getContext("2d");
    o.drawImage(img2, 0, 0, e, t);
    var a = new THREE.Texture(n);
    return a.wrapS = THREE.RepeatWrapping, a.wrapT = THREE.RepeatWrapping, a.repeat.set(2, 2), a.anisotropy = 16, a.needsUpdate = !0, a
}

function gradientMap() {
    var e = 1024,
        t = 1024,
        n = document.createElement("canvas");
    n.width = e, n.height = t;
    var o = n.getContext("2d"),
        a = o.createRadialGradient(512, 512, 512, 512, 512, 100);
    a.addColorStop(0, "#4e43f2"), a.addColorStop(1, "#574bf4"), o.fillStyle = a, o.fillRect(0, 0, e, t);
    var s = new THREE.Texture(n);
    return s.anisotropy = 16, s.needsUpdate = !0, s
}

function blockTextures(e) {
    var t = 1024,
        n = 1024,
        o = document.createElement("canvas");
    o.width = t, o.height = n;
    var a = o.getContext("2d");
    if (isMobile) a.fillStyle = "#cdad00";
    else {
        var s = a.createRadialGradient(512, 512, 512, 512, 512, 100);
        s.addColorStop(0, "#cdad00"), s.addColorStop(1, "#b8860b"), a.fillStyle = s
    }
    a.fillRect(0, 0, t, n), a.fillStyle = "white", a.textAlign = "center", a.font = "900 200px Lato";
    var i = t / 2,
        r = n / 2 + 80;
    a.fillText(e, i, r);
    var c = new THREE.Texture(o);
    c.needsUpdate = !0, c.anisotropy = 16;
    var d, m, l;
    return isMobile || (o = document.createElement("canvas"), o.width = t, o.height = n, a = o.getContext("2d"), a.drawImage(img2, 0, 0, n, t), a.fillStyle = "black", a.textAlign = "center", a.font = "900 200px Lato", i = t / 2, r = n / 2 + 80, a.fillText(e, i, r), d = new THREE.Texture(o), d.needsUpdate = !0, d.anisotropy = 16), o = document.createElement("canvas"), o.width = t, o.height = n, a = o.getContext("2d"), a.fillStyle = "black", a.fillRect(0, 0, t, n), a.fillStyle = "white", a.textAlign = "center", a.font = "900 200px Lato", i = t / 2, r = n / 2 + 80, a.fillText(e, i, r), m = new THREE.Texture(o), m.needsUpdate = !0, m.anisotropy = 16, l = isMobile ? new THREE.MeshStandardMaterial({
        map: c,
        name: "block",
        roughness: 1,
        metalness: .8,
        emissiveMap: m,
        emissive: 16777215,
        emissiveIntensity: .3
    }) : new THREE.MeshStandardMaterial({
        map: c,
        bumpMap: d,
        bumpScale: .5,
        name: "block",
        roughnessMap: roughTexture(),
        roughness: 1,
        metalness: .8,
        emissiveMap: m,
        emissive: 16777215,
        emissiveIntensity: .3
    })
}

function jumbleScene() {
    for (var e = bodys.length, t = 0; e > t; t++) randomizeAngularVelocity(bodys[t])
}

function randomizeAngularVelocity(e) {
    var t = 40;
    e.angularVelocity.x = (.5 - Math.random()) * t, e.angularVelocity.y = Math.random() * t, e.angularVelocity.z = (.5 - Math.random()) * t, e.linearVelocity.x = (.5 - Math.random()) * t, e.linearVelocity.y = (.5 - Math.random()) * t, e.linearVelocity.z = (.5 - Math.random()) * t
}

function onDocumentTouchStart(e) {
    e.preventDefault(), e.clientX = e.touches[0].clientX, e.clientY = e.touches[0].clientY, onDocumentMouseDown(e)
}

function onDocumentMouseDown(e) {
    e.preventDefault(), mouse.x = e.clientX / window.innerWidth * 2 - 1, mouse.y = 2 * -(e.clientY / window.innerHeight) + 1, raycaster.setFromCamera(mouse, camera);
    var t = raycaster.intersectObjects(meshs, !0);
    if (t.length > 0 && "transaction" === t[0].object.name) {
        console.log("Transaction amount: " + t[0].object.value), selected = t[0].object;
        var n = t[0].object.value;
        // document.getElementById("selectedTransaction").innerHTML = "Selected Ƀ " + n.toFixed(4)
    }
}

function onBlur() {
    document.body.className = "blurred", tabFocus = !1
}

function onFocus() {
    document.body.className = "focused", tabFocus = !0
}

function loadSound(e, t) {
    var n = new XMLHttpRequest;
    n.open("GET", e, !0), n.responseType = "arraybuffer", n.onload = function() {
        context.decodeAudioData(n.response, function(e) {
            sound.push(e)
        }, function() {
            console.log("error")
        })
    }, n.send()
}

function playSound(e, t, n) {
    if (e) {
        var o = context.createBufferSource();
        o.buffer = e, o.playbackRate.value = t, o.connect(gainNodes[n]), o.start(0)
    }
}

function muteSound(e) {
    return mute = !mute, mainGain.gain.exponentialRampToValueAtTime(mute ? .001 : .5, context.currentTime + 1), e.preventDefault(), !1
}

function startWebSocket() {
    websocket = new WebSocket(wsUri), websocket.onopen = function(e) {
        onOpen(e)
    }, websocket.onclose = function(e) {
        onClose(e)
    }, websocket.onmessage = function(e) {
        onMessage(e)
    }, websocket.onerror = function(e) {
        onError(e)
    }
}

function closeConnection() {
    websocket.close()
}

function onOpen(e) {
    console.log("CONNECTED"), doSend('{"op":"ping_block"}{"op":"blocks_sub"}{"op":"unconfirmed_sub"}')
}

function onClose(e) {
    console.log("DISCONNECTED")
}

function onMessage(e) {
    var t = JSON.parse(e.data);
    if ("utx" === t.op) {
        for (var n = t.x.out.length, o = 0, a = 0; n > a; a++) o += t.x.out[a].value;
        o /= 1e8, addTransaction(o)
    }
    "block" === t.op && addBlock(t.x.height, t.x.size)
}

function onError(e) {
    console.log(e)
}

function doSend(e) {
    websocket.send(e)
}
var camera, scene, light, light1, renderer, canvas, controls, meshs = [],
    grounds = [],
    outline, raycaster, mouse, selected, marker, start = Date.now(),
    tabFocus = !0,
    isMobile = !1,
    antialias = !0,
    geos = {},
    mats = {},
    world = null,
    bodys = [],
    blocks = [],
    fps = [0, 0, 0, 0],
    ToRad = .017453292519943295,
    type = 1,
    block, currentBlock, totalBitcoin = 0,
    biggestTransaction = 0,
    mute = !1,
    img = new Image;
img.onload = function() {
  // img2.crossOrigin = "*";
    img2.src = "rough.jpg"
    img2.crossOrigin = "Anonymous";
}, img.src = "bitcoin.svg";
var img2 = new Image;
img2.onload = function() {
    init()
}, window.onfocus = onFocus, window.onblur = onBlur;
var sound = [],
    soundNo = 0,
    mute = !1,
    gainNodes = [],
    AudioContext = AudioContext || webkitAudioContext,
    context = new AudioContext,
    delayNode = context.createDelay(1),
    mainGain = context.createGain();
gainNodes.push(context.createGain()), gainNodes.push(context.createGain()), gainNodes.push(context.createGain()), gainNodes.push(context.createGain()), gainNodes.push(context.createGain()), gainNodes.push(context.createGain()), gainNodes[0].gain.value = .1, gainNodes[1].gain.value = .3, gainNodes[2].gain.value = .5, gainNodes[3].gain.value = .7, gainNodes[4].gain.value = .9, gainNodes[5].gain.value = 1;
for (var i = 0; i < gainNodes.length; i++) gainNodes[i].connect(delayNode);
delayNode.delayTime.value = .05, delayNode.connect(mainGain), mainGain.connect(context.destination), loadSound("bitbonk.mp3"), loadSound("bitbonk.mp3");
var websocket, wsUri = "wss://ws.blockchain.info/inv";
! function() {
    function e(e) {
        this.object = e, this.target = new THREE.Vector3, this.minDistance = 0, this.maxDistance = 1 / 0, this.minZoom = 0, this.maxZoom = 1 / 0, this.minPolarAngle = 0, this.maxPolarAngle = Math.PI, this.minAzimuthAngle = -(1 / 0), this.maxAzimuthAngle = 1 / 0, this.enableDamping = !1, this.dampingFactor = .25;
        var t, n, o = this,
            a = 1e-6,
            s = 0,
            i = 0,
            r = 1,
            c = new THREE.Vector3,
            d = !1;
        this.getPolarAngle = function() {
            return n
        }, this.getAzimuthalAngle = function() {
            return t
        }, this.rotateLeft = function(e) {
            i -= e
        }, this.rotateUp = function(e) {
            s -= e
        }, this.panLeft = function() {
            var e = new THREE.Vector3;
            return function(t) {
                var n = this.object.matrix.elements;
                e.set(n[0], n[1], n[2]), e.multiplyScalar(-t), c.add(e)
            }
        }(), this.panUp = function() {
            var e = new THREE.Vector3;
            return function(t) {
                var n = this.object.matrix.elements;
                e.set(n[4], n[5], n[6]), e.multiplyScalar(t), c.add(e)
            }
        }(), this.pan = function(e, t, n, a) {
            if (o.object instanceof THREE.PerspectiveCamera) {
                var s = o.object.position,
                    i = s.clone().sub(o.target),
                    r = i.length();
                r *= Math.tan(o.object.fov / 2 * Math.PI / 180), o.panLeft(2 * e * r / a), o.panUp(2 * t * r / a)
            } else o.object instanceof THREE.OrthographicCamera ? (o.panLeft(e * (o.object.right - o.object.left) / n), o.panUp(t * (o.object.top - o.object.bottom) / a)) : console.warn("WARNING: OrbitControls.js encountered an unknown camera type - pan disabled.")
        }, this.dollyIn = function(e) {
            o.object instanceof THREE.PerspectiveCamera ? r /= e : o.object instanceof THREE.OrthographicCamera ? (o.object.zoom = Math.max(this.minZoom, Math.min(this.maxZoom, this.object.zoom * e)), o.object.updateProjectionMatrix(), d = !0) : console.warn("WARNING: OrbitControls.js encountered an unknown camera type - dolly/zoom disabled.")
        }, this.dollyOut = function(e) {
            o.object instanceof THREE.PerspectiveCamera ? r *= e : o.object instanceof THREE.OrthographicCamera ? (o.object.zoom = Math.max(this.minZoom, Math.min(this.maxZoom, this.object.zoom / e)), o.object.updateProjectionMatrix(), d = !0) : console.warn("WARNING: OrbitControls.js encountered an unknown camera type - dolly/zoom disabled.")
        }, this.update = function() {
            var o = new THREE.Vector3,
                m = (new THREE.Quaternion).setFromUnitVectors(e.up, new THREE.Vector3(0, 1, 0)),
                l = m.clone().inverse(),
                u = new THREE.Vector3,
                h = new THREE.Quaternion;
            return function() {
                var e = this.object.position;
                o.copy(e).sub(this.target), o.applyQuaternion(m), t = Math.atan2(o.x, o.z), n = Math.atan2(Math.sqrt(o.x * o.x + o.z * o.z), o.y), t += i, n += s, t = Math.max(this.minAzimuthAngle, Math.min(this.maxAzimuthAngle, t)), n = Math.max(this.minPolarAngle, Math.min(this.maxPolarAngle, n)), n = Math.max(a, Math.min(Math.PI - a, n));
                var g = o.length() * r;
                return g = Math.max(this.minDistance, Math.min(this.maxDistance, g)), this.target.add(c), o.x = g * Math.sin(n) * Math.sin(t), o.y = g * Math.cos(n), o.z = g * Math.sin(n) * Math.cos(t), o.applyQuaternion(l), e.copy(this.target).add(o), this.object.lookAt(this.target), this.enableDamping === !0 ? (i *= 1 - this.dampingFactor, s *= 1 - this.dampingFactor) : (i = 0, s = 0), r = 1, c.set(0, 0, 0), d || u.distanceToSquared(this.object.position) > a || 8 * (1 - h.dot(this.object.quaternion)) > a ? (u.copy(this.object.position), h.copy(this.object.quaternion), d = !1, !0) : !1
            }
        }()
    }
    THREE.OrbitControls = function(t, n) {
        function o(e, t) {
            var n = b.domElement === document ? b.domElement.body : b.domElement;
            p.pan(e, t, n.clientWidth, n.clientHeight)
        }

        function a() {
            return 2 * Math.PI / 60 / 60 * b.autoRotateSpeed
        }

        function s() {
            return Math.pow(.95, b.zoomSpeed)
        }

        function i(e) {
            if (b.enabled !== !1) {
                if (e.preventDefault(), e.button === b.mouseButtons.ORBIT) {
                    if (b.enableRotate === !1) return;
                    O = H.ROTATE, E.set(e.clientX, e.clientY)
                } else if (e.button === b.mouseButtons.ZOOM) {
                    if (b.enableZoom === !1) return;
                    O = H.DOLLY, R.set(e.clientX, e.clientY)
                } else if (e.button === b.mouseButtons.PAN) {
                    if (b.enablePan === !1) return;
                    O = H.PAN, w.set(e.clientX, e.clientY)
                }
                O !== H.NONE && (document.addEventListener("mousemove", r, !1), document.addEventListener("mouseup", c, !1), document.addEventListener("mouseout", c, !1), b.dispatchEvent(L))
            }
        }

        function r(e) {
            if (b.enabled !== !1) {
                e.preventDefault();
                var t = b.domElement === document ? b.domElement.body : b.domElement;
                if (O === H.ROTATE) {
                    if (b.enableRotate === !1) return;
                    v.set(e.clientX, e.clientY), f.subVectors(v, E), p.rotateLeft(2 * Math.PI * f.x / t.clientWidth * b.rotateSpeed), p.rotateUp(2 * Math.PI * f.y / t.clientHeight * b.rotateSpeed), E.copy(v)
                } else if (O === H.DOLLY) {
                    if (b.enableZoom === !1) return;
                    M.set(e.clientX, e.clientY), x.subVectors(M, R), x.y > 0 ? p.dollyIn(s()) : x.y < 0 && p.dollyOut(s()), R.copy(M)
                } else if (O === H.PAN) {
                    if (b.enablePan === !1) return;
                    y.set(e.clientX, e.clientY), T.subVectors(y, w), o(T.x, T.y), w.copy(y)
                }
                O !== H.NONE && b.update()
            }
        }

        function c() {
            b.enabled !== !1 && (document.removeEventListener("mousemove", r, !1), document.removeEventListener("mouseup", c, !1), document.removeEventListener("mouseout", c, !1), b.dispatchEvent(A), O = H.NONE)
        }

        function d(e) {
            if (b.enabled !== !1 && b.enableZoom !== !1 && O === H.NONE) {
                e.preventDefault(), e.stopPropagation();
                var t = 0;
                void 0 !== e.wheelDelta ? t = e.wheelDelta : void 0 !== e.detail && (t = -e.detail), t > 0 ? p.dollyOut(s()) : 0 > t && p.dollyIn(s()), b.update(), b.dispatchEvent(L), b.dispatchEvent(A)
            }
        }

        function m(e) {
            if (b.enabled !== !1 && b.enableKeys !== !1 && b.enablePan !== !1) switch (e.keyCode) {
                case b.keys.UP:
                    o(0, b.keyPanSpeed), b.update();
                    break;
                case b.keys.BOTTOM:
                    o(0, -b.keyPanSpeed), b.update();
                    break;
                case b.keys.LEFT:
                    o(b.keyPanSpeed, 0), b.update();
                    break;
                case b.keys.RIGHT:
                    o(-b.keyPanSpeed, 0), b.update()
            }
        }

        function l(e) {
            if (b.enabled !== !1) {
                switch (e.touches.length) {
                    case 1:
                        if (b.enableRotate === !1) return;
                        O = H.TOUCH_ROTATE, E.set(e.touches[0].pageX, e.touches[0].pageY);
                        break;
                    case 2:
                        if (b.enableZoom === !1) return;
                        O = H.TOUCH_DOLLY;
                        var t = e.touches[0].pageX - e.touches[1].pageX,
                            n = e.touches[0].pageY - e.touches[1].pageY,
                            o = Math.sqrt(t * t + n * n);
                        R.set(0, o);
                        break;
                    case 3:
                        if (b.enablePan === !1) return;
                        O = H.TOUCH_PAN, w.set(e.touches[0].pageX, e.touches[0].pageY);
                        break;
                    default:
                        O = H.NONE
                }
                O !== H.NONE && b.dispatchEvent(L)
            }
        }

        function u(e) {
            if (b.enabled !== !1) {
                e.preventDefault(), e.stopPropagation();
                var t = b.domElement === document ? b.domElement.body : b.domElement;
                switch (e.touches.length) {
                    case 1:
                        if (b.enableRotate === !1) return;
                        if (O !== H.TOUCH_ROTATE) return;
                        v.set(e.touches[0].pageX, e.touches[0].pageY), f.subVectors(v, E), p.rotateLeft(2 * Math.PI * f.x / t.clientWidth * b.rotateSpeed), p.rotateUp(2 * Math.PI * f.y / t.clientHeight * b.rotateSpeed), E.copy(v), b.update();
                        break;
                    case 2:
                        if (b.enableZoom === !1) return;
                        if (O !== H.TOUCH_DOLLY) return;
                        var n = e.touches[0].pageX - e.touches[1].pageX,
                            a = e.touches[0].pageY - e.touches[1].pageY,
                            i = Math.sqrt(n * n + a * a);
                        M.set(0, i), x.subVectors(M, R), x.y > 0 ? p.dollyOut(s()) : x.y < 0 && p.dollyIn(s()), R.copy(M), b.update();
                        break;
                    case 3:
                        if (b.enablePan === !1) return;
                        if (O !== H.TOUCH_PAN) return;
                        y.set(e.touches[0].pageX, e.touches[0].pageY), T.subVectors(y, w), o(T.x, T.y), w.copy(y), b.update();
                        break;
                    default:
                        O = H.NONE
                }
            }
        }

        function h() {
            b.enabled !== !1 && (b.dispatchEvent(A), O = H.NONE)
        }

        function g(e) {
            e.preventDefault()
        }
        var p = new e(t);
        this.domElement = void 0 !== n ? n : document, Object.defineProperty(this, "constraint", {
            get: function() {
                return p
            }
        }), this.getPolarAngle = function() {
            return p.getPolarAngle()
        }, this.getAzimuthalAngle = function() {
            return p.getAzimuthalAngle()
        }, this.enabled = !0, this.center = this.target, this.enableZoom = !0, this.zoomSpeed = 1, this.enableRotate = !0, this.rotateSpeed = 1, this.enablePan = !0, this.keyPanSpeed = 7, this.autoRotate = !1, this.autoRotateSpeed = 2, this.enableKeys = !0, this.keys = {
            LEFT: 37,
            UP: 38,
            RIGHT: 39,
            BOTTOM: 40
        }, this.mouseButtons = {
            ORBIT: THREE.MOUSE.LEFT,
            ZOOM: THREE.MOUSE.MIDDLE,
            PAN: THREE.MOUSE.RIGHT
        };
        var b = this,
            E = new THREE.Vector2,
            v = new THREE.Vector2,
            f = new THREE.Vector2,
            w = new THREE.Vector2,
            y = new THREE.Vector2,
            T = new THREE.Vector2,
            R = new THREE.Vector2,
            M = new THREE.Vector2,
            x = new THREE.Vector2,
            H = {
                NONE: -1,
                ROTATE: 0,
                DOLLY: 1,
                PAN: 2,
                TOUCH_ROTATE: 3,
                TOUCH_DOLLY: 4,
                TOUCH_PAN: 5
            },
            O = H.NONE;
        this.target0 = this.target.clone(), this.position0 = this.object.position.clone(), this.zoom0 = this.object.zoom;
        var S = {
                type: "change"
            },
            L = {
                type: "start"
            },
            A = {
                type: "end"
            };
        this.update = function() {
            this.autoRotate && O === H.NONE && p.rotateLeft(a()), p.update() === !0 && this.dispatchEvent(S)
        }, this.reset = function() {
            O = H.NONE, this.target.copy(this.target0), this.object.position.copy(this.position0), this.object.zoom = this.zoom0, this.object.updateProjectionMatrix(), this.dispatchEvent(S), this.update()
        }, this.dispose = function() {
            this.domElement.removeEventListener("contextmenu", g, !1), this.domElement.removeEventListener("mousedown", i, !1), this.domElement.removeEventListener("mousewheel", d, !1), this.domElement.removeEventListener("MozMousePixelScroll", d, !1), this.domElement.removeEventListener("touchstart", l, !1), this.domElement.removeEventListener("touchend", h, !1), this.domElement.removeEventListener("touchmove", u, !1), document.removeEventListener("mousemove", r, !1), document.removeEventListener("mouseup", c, !1), document.removeEventListener("mouseout", c, !1), window.removeEventListener("keydown", m, !1)
        }, this.domElement.addEventListener("contextmenu", g, !1), this.domElement.addEventListener("mousedown", i, !1), this.domElement.addEventListener("mousewheel", d, !1), this.domElement.addEventListener("MozMousePixelScroll", d, !1), this.domElement.addEventListener("touchstart", l, !1), this.domElement.addEventListener("touchend", h, !1), this.domElement.addEventListener("touchmove", u, !1), window.addEventListener("keydown", m, !1), this.update()
    }, THREE.OrbitControls.prototype = Object.create(THREE.EventDispatcher.prototype), THREE.OrbitControls.prototype.constructor = THREE.OrbitControls, Object.defineProperties(THREE.OrbitControls.prototype, {
        object: {
            get: function() {
                return this.constraint.object
            }
        },
        target: {
            get: function() {
                return this.constraint.target
            },
            set: function(e) {
                console.warn("THREE.OrbitControls: target is now immutable. Use target.set() instead."), this.constraint.target.copy(e)
            }
        },
        minDistance: {
            get: function() {
                return this.constraint.minDistance
            },
            set: function(e) {
                this.constraint.minDistance = e
            }
        },
        maxDistance: {
            get: function() {
                return this.constraint.maxDistance
            },
            set: function(e) {
                this.constraint.maxDistance = e
            }
        },
        minZoom: {
            get: function() {
                return this.constraint.minZoom
            },
            set: function(e) {
                this.constraint.minZoom = e
            }
        },
        maxZoom: {
            get: function() {
                return this.constraint.maxZoom
            },
            set: function(e) {
                this.constraint.maxZoom = e
            }
        },
        minPolarAngle: {
            get: function() {
                return this.constraint.minPolarAngle
            },
            set: function(e) {
                this.constraint.minPolarAngle = e
            }
        },
        maxPolarAngle: {
            get: function() {
                return this.constraint.maxPolarAngle
            },
            set: function(e) {
                this.constraint.maxPolarAngle = e
            }
        },
        minAzimuthAngle: {
            get: function() {
                return this.constraint.minAzimuthAngle
            },
            set: function(e) {
                this.constraint.minAzimuthAngle = e
            }
        },
        maxAzimuthAngle: {
            get: function() {
                return this.constraint.maxAzimuthAngle
            },
            set: function(e) {
                this.constraint.maxAzimuthAngle = e
            }
        },
        enableDamping: {
            get: function() {
                return this.constraint.enableDamping
            },
            set: function(e) {
                this.constraint.enableDamping = e
            }
        },
        dampingFactor: {
            get: function() {
                return this.constraint.dampingFactor
            },
            set: function(e) {
                this.constraint.dampingFactor = e
            }
        },
        noZoom: {
            get: function() {
                return console.warn("THREE.OrbitControls: .noZoom has been deprecated. Use .enableZoom instead."), !this.enableZoom
            },
            set: function(e) {
                console.warn("THREE.OrbitControls: .noZoom has been deprecated. Use .enableZoom instead."), this.enableZoom = !e
            }
        },
        noRotate: {
            get: function() {
                return console.warn("THREE.OrbitControls: .noRotate has been deprecated. Use .enableRotate instead."), !this.enableRotate
            },
            set: function(e) {
                console.warn("THREE.OrbitControls: .noRotate has been deprecated. Use .enableRotate instead."), this.enableRotate = !e
            }
        },
        noPan: {
            get: function() {
                return console.warn("THREE.OrbitControls: .noPan has been deprecated. Use .enablePan instead."), !this.enablePan
            },
            set: function(e) {
                console.warn("THREE.OrbitControls: .noPan has been deprecated. Use .enablePan instead."), this.enablePan = !e
            }
        },
        noKeys: {
            get: function() {
                return console.warn("THREE.OrbitControls: .noKeys has been deprecated. Use .enableKeys instead."), !this.enableKeys
            },
            set: function(e) {
                console.warn("THREE.OrbitControls: .noKeys has been deprecated. Use .enableKeys instead."), this.enableKeys = !e
            }
        },
        staticMoving: {
            get: function() {
                return console.warn("THREE.OrbitControls: .staticMoving has been deprecated. Use .enableDamping instead."), !this.constraint.enableDamping
            },
            set: function(e) {
                console.warn("THREE.OrbitControls: .staticMoving has been deprecated. Use .enableDamping instead."), this.constraint.enableDamping = !e
            }
        },
        dynamicDampingFactor: {
            get: function() {
                return console.warn("THREE.OrbitControls: .dynamicDampingFactor has been renamed. Use .dampingFactor instead."), this.constraint.dampingFactor
            },
            set: function(e) {
                console.warn("THREE.OrbitControls: .dynamicDampingFactor has been renamed. Use .dampingFactor instead."), this.constraint.dampingFactor = e
            }
        }
    })
}();
  
  </script>
<?php include $cur_dir.'pages/footer.php';?>