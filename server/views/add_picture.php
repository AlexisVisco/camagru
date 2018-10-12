<?php
    $_SIZE_CAM = 320 * 2;
?>

<style>

    .btn-d {
        position: absolute;
        display: flex;
        flex-direction: column-reverse;
        width: <?php echo $_SIZE_CAM ?>px;
        height: <?php echo $_SIZE_CAM ?>px;
        align-items: center;
        text-align: center;
        top: -100px;
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

    .vid {
        justify-content: center;
        align-items: center;
        width: <?php echo $_SIZE_CAM ?>px;
        height: <?php echo $_SIZE_CAM ?>px;
    }

</style>

<div class="container my-container">
    <div class="level">
        <div class="level-left" id="picture">
            <div class="btn-d"><button class="button-take" id="shoot"></button></div>
            <div class="vid"><video class="vid" id="video"></video></div>
            <canvas id="canvas"></canvas>
        </div>
    </div>
</div>

<script>
    (function () {
        let videoHtml = `<div class="vid"><video class="vid" id="video"></video></div>`;
        let btnHtml = `<div class="btn-d"><button class="button-take" id="shoot"></button></div>`;
        let canvasHtml = `<canvas id="canvas"></canvas>`;


        let streaming = false;
        let video = document.querySelector('#video');
        let canvas = document.querySelector('#canvas');
        let photo = document.querySelector('#photo');
        let shootButton = document.querySelector('#shoot');

        let width = <?php echo $_SIZE_CAM ?>;
        let height = <?php echo $_SIZE_CAM ?>;

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

        video.addEventListener('canplay', function (ev) {
            if (!streaming) {
                console.log("Hello !")
                height = video.videoHeight / (video.videoWidth / width);
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        function insertInCanvas() {
            canvas.width = width;
            canvas.height = height;
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);
            let data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }

        shootButton.addEventListener('click', function (ev) {
            insertInCanvas();
            ev.preventDefault();
        }, false);

    })();
</script>