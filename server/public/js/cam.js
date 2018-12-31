(function () {
    var streaming = false,
        video = document.querySelector('#video'),
        canvas = document.querySelector('#canvas'),
        photo = document.querySelector('#photo'),
        startbutton = document.querySelector('#startbutton'),
        photo_input = document.querySelector('#photo_input'),
        photo_input_2 = document.querySelector('#photo_input_2'),
        width = 500,
        height = 0;

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