<?php
session_start();
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>E-Signature</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <!-- Custom fonts for this template-->
    <link href="bootstrap/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="bootstrap/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="bootstrap/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="bootstrap_select/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="bootstrap/vendor/jquery/jquery.min.js"></script>
    <script src="bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="bootstrap/vendor/jquery-easing/jquery.easing.min.js"></script>



    <!-- Page level plugins -->
    <script src="bootstrap/vendor/chart.js/Chart.min.js"></script>
</head>
<style>
    body {
        padding-top: 20px;
        padding-bottom: 20px;
        overflow: hidden;
    }

    #sig-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 5px;
        cursor: crosshair;
    }

    #sig-dataUrl {
        width: 100%;
    }

    .hidden {
        display: none;
    }
</style>

<body>
    <div class="container" style="text-align: center;">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <h1>กรุณาเซ็นลายเซ็นของท่าน</h1>
                        </h6>
                        <div class="alert alert-danger" role="alert">
                            เซ็นลายเซ็นให้เต็มถึงขอบบนและล่าง เพื่อให้ลายเซ็นสมบูรณ์และมีขนาดที่ถูกต้องที่สุด
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="cnn_add_master_signature.php">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <canvas id="sig-canvas" name="signed" width="750px" height="200px">
                                        คุณไม่สามารถใช้งานการเซ็นออนไลน์ได้ กรุณาเปลี่ยนอุปกรณ์ใช้งานใหม่
                                    </canvas>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 ">
                                    <button class="btn btn-primary" id="sig-submitBtn">
                                        ยืนยันลายเซ็น
                                    </button>
                                    <a class="btn btn-default" id="sig-clearBtn">
                                        เคลียร์ลายเซ็น
                                    </a>
                                    <a href="javascript:history.back()" class="btn btn-danger" id="sig-clearBtn">
                                        ยกเลิกการสร้างลายเซ็น
                                    </a>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12 col-lg-12 hidden">
                                    <textarea id="sig-dataUrl" name="signed" class="form-control" rows="5">
				  Data URL for your signature will go here!
			                	</textarea>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12 col-lg-12 hidden">
                                    <img id="sig-image" src="" alt="Your signature will go here!" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h1 class="h3 mb-4 text-gray-800">ลายเซ็นเดิม</h1>
                        <?php
                        if ($_SESSION['admin_signature'] == "") {
                            # code...
                        } else {
                        ?>
                            <img src="../signature/<?php echo $_SESSION['admin_signature'] ?>" alt="" width="50%" height="50%">
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h1 class="h3 mb-4 text-gray-800">อัพโหลดลายเซ็นเป็นไฟล์ PNG file</h1>
                        <form action="cnn_upload_sign.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="upload" id="upload" class="form-control" required accept="image/png">
                            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <!--<script src="https://code.angularjs.org/snapshot/angular.min.js"></script>-->
    <script>
        (function() {

            // Get a regular interval for drawing to the screen
            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();

            // Set up the canvas
            var canvas = document.getElementById("sig-canvas");
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#0B15F5";
            ctx.lineWidth = 5;

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            var submitBtn = document.getElementById("sig-submitBtn");
            clearBtn.addEventListener("click", function(e) {
                clearCanvas();
                sigText.innerHTML = "Data URL for your signature will go here!";
                sigImage.setAttribute("src", "");
            }, false);
            submitBtn.addEventListener("click", function(e) {
                var dataUrl = canvas.toDataURL();
                sigText.innerHTML = dataUrl;
                sigImage.setAttribute("src", dataUrl);
            }, false);

            // Set up mouse events for drawing
            var drawing = false;
            var mousePos = {
                x: 0,
                y: 0
            };
            var lastPos = mousePos;
            canvas.addEventListener("mousedown", function(e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            }, false);
            canvas.addEventListener("mouseup", function(e) {
                drawing = false;
            }, false);
            canvas.addEventListener("mousemove", function(e) {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Set up touch events for mobile, etc
            canvas.addEventListener("touchstart", function(e) {
                mousePos = getTouchPos(canvas, e);
                var touch = e.touches[0];
                var mouseEvent = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchend", function(e) {
                var mouseEvent = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(mouseEvent);
            }, false);
            canvas.addEventListener("touchmove", function(e) {
                var touch = e.touches[0];
                var mouseEvent = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }, false);

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchend", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchmove", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);

            // Get the position of the mouse relative to the canvas
            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                };
            }

            // Get the position of a touch relative to the canvas
            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                };
            }

            // Draw to the canvas
            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Clear the canvas
            function clearCanvas() {
                canvas.width = canvas.width;
                ctx.strokeStyle = "#0B15F5";
                ctx.lineWidth = 5;
            }

            // Allow for animation
            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

        })();
    </script>
    <script type="text/javascript">
        var sig = $('#sig-canvas').signature({
            syncField: '#sig-dataUrl',
            syncFormat: 'PNG'
        });
    </script>
</body>

</html>