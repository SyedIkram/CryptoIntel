<style>



.overlay {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: #0a0a0a;
    background: rgba(10, 10, 10, .9);
    z-index: 3
}

.loading {
    position: relative;
    top: 45%;
    font-size: 1em;
    text-align: center
}

#map-canvas {
    position: relative;
    width: 100%;
    height: 600px;
    /* background-color: #0a0a0a; */
    background-color: #FFF;
}

#chart-canvas {
    position: fixed;
    width: 300px;
    height: 300px;
    bottom: 55px;
    left: 55px
}

@media screen and (max-width:720px) {
    #chart-canvas {
        display: none
    }
}


@media screen and (max-width:1280px) {
    .user-agent {
        display: block;
        text-align: inherit
    }
}

@media screen and (max-width:720px) {
    .user-agents {
        display: none
    }
}

.footer {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%
}

.status>span {
    float: left;
    min-height: 3.8em;
    padding-top: 1.2em;
    border-left: 4px solid rgba(255, 255, 255, .1);
    padding-left: 1em;
    margin-bottom: 5px
}

.label {
    display: block;
    opacity: .9
}

.number {
    font-size: 1.4em;
    color: #fff;
    opacity: .9
}

#last-node {
    margin-left: 20px
}

#height {
    float: right;
    margin-right: 3em
}

#reachable-nodes {
    float: right;
    margin-right: 20px
}

.percentage {
    float: left;
    width: 100%;
    height: 4px
}

#completed {
    background: #00ccf3;
    width: 0;
    height: inherit
}

@media screen and (max-width:1024px) {
    #reachable-nodes,
    #height {
        display: none
    }
}

a {
    color: #d8d8d8;
    text-decoration: none
}

a:hover {
    color: #fff
}

.height {
    color: #44deb9
}

.height.stalled {
    color: #de446a
}

</style>