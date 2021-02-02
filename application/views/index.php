<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>变频恒压供水系统-远程控制中心</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/bootstrap-theme.min.css">
    <link rel="stylesheet" href="./assets/bootstrap-slider.min.css">
	<link rel="stylesheet" href="./assets/waterSupply.css">

    <script src="./assets/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/bootstrap-slider.min.js" type="text/javascript"></script>
	<script src="./assets/jquery-websocket.js" type="text/javascript"></script>
	<script src="./assets/Highcharts.js" type="text/javascript"></script>
	<script src="./assets/waterSupply.js" type="text/javascript"></script>
    <!--link rel="stylesheet" href="main.css"-->

</head>
<body style="height: 100%;width: 100%;">
<canvas id="canvas" style="position:absolute;top:0;left:0;z-index:-1;display:block;"></canvas>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar">123123</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">变频恒压供水系统</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Designed by @sususweet @Vera W</a></li>
                <!--li><a href="https://lulupanel.qaqapp.com/logout">登出</a></li-->
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="row center-block">
        <div class="col-md-10 col-md-offset-2">
			<div class="col-md-10">
				<div class="white_box"></div>

				<div class="row center-block">
					<div id="warning" class="alert alert-warning" style="display: none;">
						与变频供水系统的通信失败，请刷新页面或联系管理员！
					</div>
					<div class="col-lg-3 col-md-3 col-sm-8 col-xs-8">
						<h4>系统运行状态</h4>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<button id="Mottor" type="button" class="btn btn-info center-block">开始</button>
					</div>
				</div>
				<div style="border-bottom: 1px solid #EEEEEE;margin-top: 20px;margin-bottom: 20px;"></div>

				<div class="row center-block">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input id="standbyPressure" data-slider-tooltip="hide" style="padding-left:20px;" data-slider-id='ex1Slider' type="number" data-slider-min="8.0" data-slider-max="15.0" data-slider-step="0.1" data-slider-value="12"/>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label for="standbyPressure">待机压力</label>
							<label id="standbyPressureValue" style="font-family:Comic Sans MS;font-size:15px;padding-left: 20px"></label>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input id="workingPressure" data-slider-tooltip="hide" data-slider-id='ex1Slider' type="number" data-slider-min="8.0" data-slider-max="15.0" data-slider-step="0.1" data-slider-value="10"/>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label for="workingPressure">供水压力</label>
							<label id="workPressureValue" style="font-family:Comic Sans MS;font-size:15px;padding-left: 20px"></label>
						</div>
					</div>
				</div>
				<div class="row center-block">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" align="center">
						<h4>当前水压</h4>
						<label id="presentPressure" style="font-family:Comic Sans MS;font-size:25px;padding-left=100px;">*.*</label>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" align="center">
						<h4>当前流量</h4>
						<label id="presentFlow" style="font-family:Comic Sans MS;font-size:25px;center-right">*.*</label>
					</div>
				</div>
				<div>
					<h4>系统供水压力实时监测</h4>
				</div>
				<div style="border-bottom: 1px solid #EEEEEE;margin-top: 20px;margin-bottom: 20px;"></div>
				<div id="PressureChart"></div>
			</div>

        </div>
    </div>
    </div>
</div>

<script type="text/javascript">
	function getScrollHeight() {
		return Math.max(document.body.scrollHeight,document.documentElement.scrollHeight);
	}
	function getScrollWidth() {
		return Math.max(document.body.scrollWidth,document.documentElement.scrollWidth);
	}
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    // 获取窗口宽度
    if (window.innerWidth)
        winWidth = window.innerWidth;
    else if ((document.body) && (document.body.clientWidth))
        winWidth = document.body.clientWidth;
    // 获取窗口高度
    if (window.innerHeight)
        winHeight = window.innerHeight;
    else if ((document.body) && (document.body.clientHeight))
        winHeight = document.body.clientHeight;

    canvas.width =  winWidth;
    canvas.height = getScrollHeight();


	ctx.fillRect(0,0,winWidth,getScrollHeight());


	//如果浏览器支持requestAnimFrame则使用requestAnimFrame否则使用setTimeout
    window.requestAnimFrame = (function(){
        return  window.requestAnimationFrame       ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame    ||
            function( callback ){
                window.setTimeout(callback, 1000 / 60);
            };
    })();
    //初始角度为0
    var step = 0;
    //定义三条不同波浪的颜色
    var lines = ["rgba(0,222,255, 0.2)",
        "rgba(157,192,249, 0.2)",
        "rgba(0,168,255, 0.2)"];
    function loop(){
        ctx.clearRect(0,0,canvas.width,canvas.height);
        step++;
        //画3个不同颜色的矩形
        for(var j = lines.length - 1; j >= 0; j--) {
            ctx.fillStyle = lines[j];
            //每个矩形的角度都不同，每个之间相差45度
            var angle = (step+j*45)*Math.PI/180;
            var deltaHeight   = Math.sin(angle) * 50;
            var deltaHeightRight  = Math.cos(angle) * 50;
            ctx.beginPath();
            ctx.moveTo(0, canvas.height/2+deltaHeight);
            ctx.bezierCurveTo(canvas.width /2, canvas.height/2+deltaHeight-50, canvas.width / 2, canvas.height/2+deltaHeightRight-50, canvas.width, canvas.height/2+deltaHeightRight);
            ctx.lineTo(canvas.width, canvas.height);
            ctx.lineTo(0, canvas.height);
            ctx.lineTo(0, canvas.height/2+deltaHeight);
            ctx.closePath();
            ctx.fill();
        }
        requestAnimFrame(loop);
    }
    loop();
</script>


</body>
<footer>

</footer>
</html>
