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

var dic = {
    "/public/img/thug_glasses.png": "thug_glasses",
    "/public/img/glasses.png": "glasses",
    "/public/img/horror.png": "horror",
    "/public/img/dog.png": "dog"
}

var streaming = false,
    video = document.querySelector('#video'),
    photo = document.querySelector('#photo'),
    startbutton = document.querySelector('#startbutton'),
    photo_input = document.querySelector('#photo_input'),
    raw_image = document.querySelector('#raw_image'),
    lhistory = document.querySelector('#list_history'),
    camPreview = document.querySelector('#cameraPreview'),
    preview_img = '/public/img/thug_glasses.png',
    width = 500, height = 0,
    canvasPreview = document.querySelector('#canvas_preview');

document.querySelector('#' + dic[preview_img]).style["border"] = "2px solid green"

function setPreview() {
    var img = new Image();
    img.height = desc[preview_img].h;
    img.width = desc[preview_img].w;
    img.onload = function () {
        canvasPreview.setAttribute('width', width);
        canvasPreview.setAttribute('height', height);
        canvasPreview.getContext('2d').clearRect(0, 0, canvasPreview.width, canvasPreview.height);
        canvasPreview.getContext('2d').drawImage(
            img,
            width / 2 - (desc[preview_img].w / 2) + (desc[preview_img].dw),
            height / 2 - (desc[preview_img].h / 2) + (desc[preview_img].dh),

            desc[preview_img].h,
            desc[preview_img].w);
    };
    img.src = preview_img;
}

function preview(event, img) {
    let o = document.querySelector('#' + dic[preview_img]);
    let n = document.querySelector('#' + dic[img]);
    o.style["border"] = "none";
    n.style["border"] = "2px solid green";
    event.preventDefault();
    event.stopPropagation();
    preview_img = img;
    setPreview();
}

function toCanvas() {
    photo.style.display = "visible";
    photo.setAttribute('src', photo.src);
    photo_input.setAttribute('value', photo.src);
    raw_image.setAttribute('value', photo.src);
}

function validFormWithoutComposition(event) {
    if (validFormWithComposition(event)) {
        document.querySelector('#composition').value = "false"
    }
}

function validFormWithComposition(event) {
    if (!raw_image.value.startsWith("data:image")) {
        event.preventDefault();
        alert("Une photo doit être prise ou uploadé")
        return false
    }
    document.querySelector("#composition_img").value = JSON.stringify({
        location: preview_img,
        desc: desc[preview_img]
    });
    return true
}

toCanvas();

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
            video.srcObject = stream;
        }
        video.play();
    },
    function (err) {
        startbutton.style.display = 'none';
        video.style.display = 'none';
        canvasPreview.style.display = 'none';
        camPreview.style.display = 'none';
    }
);

video.addEventListener('canplay', function () {
    if (!streaming) {
        height = video.videoHeight / (video.videoWidth / width);
        canvasPreview.height = height;
        canvasPreview.width = width;
        video.setAttribute('width', width);
        video.setAttribute('height', height);

        setPreview();


        streaming = true;
    }
}, false);

function take() {
    var pc = document.createElement('canvas');
    pc.width = width;
    pc.height = height;

    pc.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = pc.toDataURL('image/png');

    document.getElementById("show").style.display = 'block';
    document.getElementById("save").style.display = 'block';
    document.getElementById("montage").style.display = 'block';

    photo.style.display = "visible";
    photo.setAttribute('src', data);
    lhistory.insertAdjacentHTML("afterbegin",
        `<div class="column is-one-fifth">
            <div class="card large round">
                <div class="card-image ">
                    <figure class="image">
                        <img width="100px" src="${data}">
                    </figure>
                </div>
            </div>
        </div>`);
    photo_input.setAttribute('value', data);
    raw_image.setAttribute('value', data);
}

startbutton.addEventListener('click', function (ev) {
    take();
    ev.preventDefault();
}, false);



