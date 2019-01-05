var desc = {
    "/public/img/thug_glasses.png": {
        w: 200, h: 200,
        dw: 0, dh: -50,
    },
    "/public/img/glasses.png": {
        w: 150, h: 150,
        dw: 0, dh: 0,
    },
    "/public/img/horror.png": {
        w: 150, h: 150,
        dw: 0, dh: 50,
    },
    "/public/img/dog.png": {
        w: 200, h: 200,
        dw: 0, dh: -50,
    },
};

var preview_img = '/public/img/thug_glasses.png';
var width = 500, height = 0;
var canvas_preview = document.querySelector('#canvas_preview');

function setPreview() {
    var img = new Image();
    img.height = desc[preview_img].h;
    img.width = desc[preview_img].w;
    img.onload = function () {
        canvas_preview.setAttribute('width', width);
        canvas_preview.setAttribute('height', height);
        canvas_preview.getContext('2d').clearRect(0, 0, canvas_preview.width, canvas_preview.height);
        console.log(width, height, width / 2 + (desc[preview_img].w / 2));
        canvas_preview.getContext('2d').drawImage(
            img,
            width / 2 - (desc[preview_img].w / 2) + (desc[preview_img].dw),
            height / 2 - (desc[preview_img].h / 2) + (desc[preview_img].dh),

            desc[preview_img].h,
            desc[preview_img].w);
    };
    img.src = preview_img;
}

function preview(event, img) {
    event.preventDefault();
    event.stopPropagation();
    preview_img = img;
    setPreview();
}

(function () {
    var streaming = false,
        video = document.querySelector('#video'),
        canvas = document.querySelector('#canvas'),
        photo = document.querySelector('#photo'),
        startbutton = document.querySelector('#startbutton'),
        photo_input = document.querySelector('#photo_input'),
        photo_input_2 = document.querySelector('#photo_input_2');


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
                var vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
            }
            video.play();
        },
        function (err) {
            console.log("An error occured! " + err);
        }
    );

    video.addEventListener('canplay', function () {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);

            setPreview();


            streaming = true;
        }
    }, false);

    function take() {
        canvas.width = width;
        canvas.height = height;

        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');

        document.getElementById("show").style.display = 'block';
        document.getElementById("save").style.display = 'block';
        document.getElementById("montage").style.display = 'block';

        console.log(data);
        photo.style.display = "visible";
        photo.setAttribute('src', data);
        photo_input.setAttribute('value', data);
        photo_input_2.setAttribute('value', data);
    }

    startbutton.addEventListener('click', function (ev) {
        take();
        ev.preventDefault();
    }, false);

})();

