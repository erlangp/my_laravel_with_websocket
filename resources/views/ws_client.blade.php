<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Web Socket Client Sample</title>

<!-- Styles -->
<style>
html, body {
	background-color: #fff;
	color: #636b6f;
	font-family: 'Raleway', sans-serif;
	font-weight: 100;
	height: 100vh;
	margin: 0;
}

.full-height {
	height: 100vh;
}

.flex-center {
	align-items: center;
	display: flex;
	justify-content: center;
}

.position-ref {
	position: relative;
}

.top-right {
	position: absolute;
	right: 10px;
	top: 18px;
}

.content {
	text-align: center;
}

.title {
	font-size: 84px;
}

.links>a {
	color: #636b6f;
	padding: 0 25px;
	font-size: 12px;
	font-weight: 600;
	letter-spacing: .1rem;
	text-decoration: none;
	text-transform: uppercase;
}

.m-b-md {
	margin-bottom: 30px;
}
</style>
</head>
<body>
	<div class="full-height">
		<div id="div_content" class="content"></div>
	</div>

	<script>
            // Erlang Parasu <erlangparasu@gmail.com> 2018-05-05
            'use strict';
            var el = document.getElementById('div_content');
            el.innerHTML = el.innerHTML + "\n" + "WebSocket is not supported.";
            if ("WebSocket" in window) { // Check browser support websocket
                var ws = new WebSocket('ws://127.0.0.1:8092');
                ws.onopen = function () {
                    el.innerHTML = "<br><br>" + "onopen: ";
                };
                ws.onmessage = function (ev) {
                    el.innerHTML = el.innerHTML + "<br><br>" + "onmessage: data=" + ev.data;
                };
                ws.onerror = function (ev) {
                    el.innerHTML = el.innerHTML + "<br><br>" + "onerror: error=" + ev;
                };
                ws.onclose = function () {
                    el.innerHTML = el.innerHTML + "<br><br>" + "onclose: ";
                };
            }
        </script>
</body>
</html>
