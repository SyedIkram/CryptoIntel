var map;
var mapRedrawCounter = 0;
var nodes = [];
var reachableNodes = 9206;
var snapshotLen = 0;
var snapshotTimestamp = 0;
var percentage;
var shiftNodes = false;
var chart;
var userAddress = '174.6.76.213';
var userNode = null;
var userNodeTimestamp = 0;
$(function() {
    var isMobile = ($(window).width() <= 640);
    var isDesktop = !isMobile;
    var mapMargin = 30;
    var markerRadius = 7;
    var mapBorderColor = '#FFF';
    var mapColor = '#769fff';
    if (isMobile) {
        mapMargin = 0;
        markerRadius = 3;
        mapBorderColor = '#FFF';
        mapColor = '#769fff';
    }
    map = new Highcharts.Map({
        chart: {
            renderTo: 'map-canvas',
            animation: false,
            margin: [mapMargin * 1.5, mapMargin, mapMargin, mapMargin]
        },
        mapNavigation: {
            enabled: false,
            enableButtons: false
        },
        tooltip: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            mapData: Highcharts.maps['custom/world-highres'],
            borderColor: mapBorderColor,
            nullColor: mapColor
        }, {
            type: 'mappoint',
            enableMouseTracking: false,
            color: 'rgba(127,0,0, 0.6)',
            marker: {
                lineWidth: 0,
                radius: markerRadius,
                symbol: 'circle'
            },
            dataLabels: {
                enabled: isDesktop,
                align: 'left',
                formatter: function() {
                    if (this.point.city && this.point.country) {
                        return this.point.name + '<br>' + this.point.city + '/' + this.point.country;
                    } else if (this.point.country) {
                        return this.point.name + '<br>' + this.point.country;
                    } else {
                        return this.point.name;
                    }
                },
                style: {
                    color: '#000',
                    opacity: '1',
                    fontSize: '1em',
                    fontWeight: 'normal'
                }
            },
            data: []
        }, {
            type: 'mappoint',
            enableMouseTracking: false,
            color: 'rgba(1, 3, 57, 1.0)',
            marker: {
                lineWidth: 0,
                radius: markerRadius,
                symbol: 'circle'
            },
            dataLabels: {
                enabled: isDesktop,
                align: 'left',
                formatter: function() {
                    if (this.point.city && this.point.country) {
                        return this.point.name + '<br>' + this.point.city + '/' + this.point.country;
                    } else if (this.point.country) {
                        return this.point.name + '<br>' + this.point.country;
                    } else {
                        return this.point.name;
                    }
                },
                style: {
                    color: '#00f3a1',
                    opacity: '0.9',
                    fontSize: '1em',
                    fontWeight: 'bold'
                },
                allowOverlap: true
            },
            data: []
        }]
    });
    // chart = new Highcharts.Chart({
    //     chart: {
    //         renderTo: 'chart-canvas',
    //         margin: [20, 60, 20, 60],
    //         polar: true
    //     },
    //     xAxis: {
    //         categories: ['AS16509', 'AS24940', 'AS16276', 'AS14061', 'AS7922', 'AS51167'],
    //         tickmarkPlacement: 'on',
    //         lineWidth: 30,
    //         lineColor: 'rgba(224, 224, 224, 0.03)'
    //     },
    //     yAxis: {
    //         tickInterval: 1,
    //         lineWidth: 60,
    //         lineColor: 'rgba(1, 3, 57, 2)',
    //         min: 0
    //     },
    //     title: {
    //         text: 'Top ASNs'
    //     },
    //     tooltip: {
    //         enabled: true,
    //         formatter: function() {
    //             return this.x + '<br><strong>' + this.y + '%</strong>';
    //         }
    //     },
    //     legend: {
    //         enabled: false
    //     },
    //     series: [{
    //         name: 'Nodes',
    //         data: [12.8, 9.5, 5.6, 5.0, 3.1, 2.2],
    //         pointPlacement: 'on',
    //         lineWidth: 2,
    //         color: '#00ccf3',
    //         marker: {
    //             symbol: 'circle',
    //             lineColor: '#333',
    //             lineWidth: 0
    //         },
    //         states: {
    //             hover: {
    //                 lineWidth: 2
    //             }
    //         }
    //     }]
    // });
});
$(function() {
    var $height = $('#height > .number');
    var $userAgents = $('.user-agents');

    function getSnapshot() {
        var url = 'https://bitnodes.earn.com/api/v1/snapshots/latest/?field=top';
        var previousTimestamp = snapshotTimestamp;
        setInterval(function() {
            if (snapshotTimestamp > previousTimestamp) {
                $.get(url, function(data) {
                    if (data.timestamp >= snapshotTimestamp) {
                        $height.html(data.latest_height);
                        var topAsns = data.top.top_asns;
                        var chartCategories = [];
                        var chartData = [];
                        for (var i = 0, len = topAsns.length; i < len; i++) {
                            chartCategories.push(topAsns[i][0]);
                            chartData.push(topAsns[i][1]);
                        }
                        chart.xAxis[0].setCategories(chartCategories);
                        chart.series[0].setData(chartData);
                        chart.redraw();
                        $userAgents.find('.user-agent').remove();
                        var topUserAgents = data.top.top_user_agents;
                        for (var i = 0, len = topUserAgents.length; i < len; i++) {
                            var html = ['<div class="user-agent">', '<span class="label">' + topUserAgents[i][0] + '</span>', '<span class="number">' + topUserAgents[i][1] + '%</span>', '<span class="label height' + (Math.abs(data.latest_height - topUserAgents[i][2]) > 2 ? ' stalled' : '') + '">' + topUserAgents[i][2] + '</span>', '</div>'].join('');
                            $userAgents.append(html);
                        }
                        previousTimestamp = snapshotTimestamp;
                    }
                }, 'json');
            }
        }, 30000);
    }
    getSnapshot();
});
$(function() {
    var wsUrl = 'wss://bitnodes.earn.com/ws-nodes/nodes';
    var ws;
    var timer;
    var attempts = 1;
    var paused = false;
    var $lastNode = $('#last-node');
    var $reachableNodes = $('#reachable-nodes');
    var $completed = $('#completed');

    function connect(url) {
        console.log('Connecting to ' + url);
        ws = new WebSocket(url);
        ws.onopen = onopen;
        ws.onclose = onclose;
        ws.onmessage = onmessage;
        ws.onerror = onerror;
        timer = null;
    }

    function onopen() {
        console.log('Connected to ' + ws.url);
        attempts = 1;
    }

    function onclose(event) {
        console.log('Disconnected from ' + ws.url);
        if (!timer && !paused) {
            var interval = generateInterval(attempts);
            console.log('Reconnecting in ' + Math.floor(interval) + ' ms');
            timer = setTimeout(function() {
                attempts++;
                connect(ws.url);
            }, interval);
        }
    }

    function onerror(event) {}

    function onmessage(event) {
        var data = JSON.parse(event.data);
        if (data.length === 1) {
            snapshotTimestamp = data[0].last_timestamp;
            reachableNodes = data[0].reachable_nodes;
            var html = ['<span class="label">Reachable nodes as of ' + new Date(data[0].last_timestamp * 1000) + '</span>', '<span class="number">' + reachableNodes + '</span>'].join('');
            $reachableNodes.html(html);
            if (userNodeTimestamp > 0) {
                if (snapshotTimestamp - userNodeTimestamp > 900) {
                    userNode = null;
                    map.series[2].setData([], true, false, false);
                }
            }
            return;
        }
        for (var i = 0, len = data.length; i < len; i++) {
            var address = data[i][1];
            var port = data[i][2];
            var country = data[i][3];
            var city = data[i][4];
            var latitude = data[i][5];
            var longitude = data[i][6];
            var nodePos = latitude + ',' + longitude;
            nodes.push(nodePos);
            if (i === 0) {
                snapshotLen = data[i][0];
                percentage = Math.min(snapshotLen / reachableNodes, 0.9999) * 100;
                $completed.css('width', percentage + '%');
            }
            if (nodes.length > 100) {
                nodes.shift();
                shiftNodes = true;
            }
            var node = address;
            if (address.indexOf(':') >= 0) {
                node = '[' + node + ']'
            }
            node += ':' + port;
            if (address === userAddress) {
                if (snapshotTimestamp > 0) {
                    userNodeTimestamp = snapshotTimestamp;
                }
                if (userNode === null) {
                    userNode = {
                        name: node,
                        country: country,
                        city: city,
                        lat: latitude,
                        lon: longitude
                    };
                    map.series[2].addPoint(userNode, true, false, false);
                }
            }
            
            map.series[1].addPoint({
                name: node,
                country: country,
                city: city,
                lat: latitude,
                lon: longitude
            }, false, shiftNodes, false);
            mapRedrawCounter++;
            var html = ['<span class="label">', ((address.indexOf(':') > -1) ? '[' + address + ']' : address), ':', port, '</span>', '<span class="number">' + snapshotLen + ' (' + percentage.toFixed(2) + '%)</span>'].join('');
            $lastNode.html(html);
        }
        if (mapRedrawCounter >= 15) {
            map.redraw();
            mapRedrawCounter = 0;
        }
    }

    function generateInterval(k) {
        var maxInterval = (Math.pow(2, k) - 1) * 1000;
        if (maxInterval > 30 * 1000)
            maxInterval = 30 * 1000;
        return Math.random() * maxInterval;
    }
    connect(wsUrl);
});