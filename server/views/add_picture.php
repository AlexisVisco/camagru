<?php
$_SIZE_CAM = 320 * 2;
?>

<style>

    .btn-d {
        position: absolute;
        display: flex;
        flex-direction: column-reverse;
        width: <?php echo $_SIZE_CAM ?>px;
        align-items: center;
        text-align: center;
        justify-content: space-around;
        bottom: 45px;
    }

    .button-take {
        background: white;
        height: 40px;
        width: 40px;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        border: 6px solid rgba(128, 128, 128, 0.22);
        cursor: pointer;
        z-index: 1000000;
    }

    .button-take:hover {
        background: #ff2a00;
        border: 6px solid rgb(255, 255, 255);
    }

    .vid-up {
        display: flex;
        align-items: center;
        flex-direction: row;
        width: 100%;
    }

    .vid {
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

</style>

<div class="container my-container">
    <div id="picture" class="vid-up">
    </div>
    <br>
</div>

<script>

    Element.prototype.remove = function () {
        this.parentElement.removeChild(this);
    };

    NodeList.prototype.remove = HTMLCollection.prototype.remove = function () {
        for (var i = this.length - 1; i >= 0; i--) {
            if (this[i] && this[i].parentElement) {
                this[i].parentElement.removeChild(this[i]);
            }
        }
    };

    (function () {

        let streaming = false;

        let video = undefined;
        let shootButton = undefined;

        let width = <?php echo $_SIZE_CAM ?>;
        let height = <?php echo $_SIZE_CAM ?>;

        videoInsert();

        navigator.getMedia = (navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia);

        navigator.getMedia(
            {
                video: true,
                audio: false
            },
            function (stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    const vendorURL = window.URL || window.webkitURL;
                    video.src = vendorURL.createObjectURL(stream);
                }
                video.play();
            },
            function (err) {
                console.log("An error occured! " + err);
            }
        );

        function addVideoStreaming() {
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth / width);
                video.setAttribute('width', width);
                video.setAttribute('height', height);

                console.log(video.videoWidth);
                streaming = true;
            }
        }

        function createCanvasElement() {
            let canvas = document.createElement("canvas");
            canvas.height = video.videoHeight;
            canvas.width = video.videoWidth;
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);

            return canvas;
        }

        function clearPicture() {
            document.getElementById("picture").innerHTML = "";
            video = null;
            shootButton = null;
            streaming = false;
        }

        function videoInsert() {

            document.getElementById("picture").insertAdjacentHTML(
                "beforeend",
                "<div class=\"btn-d\"><button class=\"button-take\" id=\"shoot\"></button></div>");


            document.getElementById("picture").insertAdjacentHTML(
                "beforeend",
                "<div class=\"vid\"><video class=\"vid\" id=\"video\"></video></div>");

            video = document.querySelector('#video');

            shootButton = document.querySelector('#shoot');
            video.addEventListener('canplay', addVideoStreaming, false);

            shootButton.addEventListener('click', function (ev) {
                let canvas = createCanvasElement();
                video.remove();
                clearPicture();
                canvasInsert(canvas);
                ev.preventDefault();
            }, false);

        }

        function canvasInsert(c) {
            c.id = "photo";
            document.getElementById("picture").insertAdjacentElement("beforeend", c);
        }


    })();
</script>