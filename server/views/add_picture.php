<?php
$_SIZE_CAM = 320 * 2;
?>

<div class="container has-text-centered">
    <div class="column" style="padding-bottom: 20px">
        <section class="column is-three-quarters">
            <?php FlashMessage::html() ?>
        </section>
    </div>
    <div class="columns">
        <section class="section hero has-text-centered is-bold is-full">
            <div class="container">
                <div class="box" id="webcam">
                    <div class="columns">
                        <div class="column">
                            <canvas id="canvas_preview" style="position: absolute; z-index: 1" height="500"></canvas>
                            <video  style="z-index: 0" id="video"></video>
                        </div>
                        <div class="column"
                             id="show" <?php if (!isset($fileb64)) { ?> style="display: None" <?php } ?>>

                            <canvas id="canvas" style="display: none"></canvas>
                            <img id="photo" src="<?php if (isset($fileb64)) { echo  $fileb64; } ?>" alt="Your"
                                 width="500"
                                 height="350">
                        </div>
                    </div>
                    <div class="field is-grouped is-grouped-centered">
                        <p class="control">
                            <button class="button is-warning" id="startbutton">TAKE PHOTO
                            </button>
                        </p>
                        <p class="control">
                        <div id="save">
                            <form action="/picture/save" method="post">
                                <input id="photo_input" type="hidden" name="data">
                            </form>
                        </div>
                        <div>
                            <form enctype="multipart/form-data" method="POST"
                                  action="/<? echo Routes::$PICTURE_ADD_PHOTO_UPLOAD ?>">
                                <input type="hidden" name="MAX_FILE_SIZE"
                                       value="3000000"/>
                                <div class="file">
                                    <label class="file-label">
                                        <input class="file-input" type="file"
                                               name="userfile"
                                               accept="image/x-png,image/gif,image/jpeg"
                                               onchange="document.forms[1].submit()">
                                        <span class="file-cta">
                            <span class="file-icon">
                            <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">Choose a file</span> </span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
<section class="section hero has-text-centered is-bold"
         style="padding: 1.5rem 1.5rem !important; padding-right: 0 !important;">
    <form action="/picture/mount" method="post">
        <div id="montage" class="container">
            <div class="columns is-multiline">
                <div class="column is-one-quarter">
                    <div class="box">
                        <input type="image" name="submit_thug_glasses"
                               value="thug_glasses" alt="thug_glasses"
                               src="/public/img/thug_glasses.png" height="150">
                    </div>
                    <button class="button is-primary" onclick="preview(event, '/public/img/thug_glasses.png')">Preview</button>
                </div>
                <div class="column is-one-quarter">
                    <div class="box">
                        <input type="image" name="submit_dog"
                               value="dog" alt="dog"
                               src="/public/img/dog.png"
                               height="150">
                    </div>
                    <button class="button is-primary" onclick="preview(event, '/public/img/dog.png')">Preview</button>
                </div>
                <div class="column is-one-quarter">
                    <div class="box">
                        <input type="image" name="submit_glasses" value="glasses"
                               alt="glasses"
                               src="/public/img/glasses.png"
                               height="150">
                    </div>
                    <button class="button is-primary" onclick="preview(event, '/public/img/glasses.png')">Preview</button>
                </div>
                <div class="column is-one-quarter">
                    <div class="box">
                        <input type="image" name="submit_horror" value="horror"
                               alt="horror"
                               src="/public/img/horror.png"
                               height="150">
                    </div>
                    <button class="button is-primary" onclick="preview(event, '/public/img/horror.png')">Preview</button>
                </div>
                <input id="photo_input_2" type="hidden" name="raw">
            </div>
        </div>
    </form>
</section>

<script src="/public/js/cam.js"></script>