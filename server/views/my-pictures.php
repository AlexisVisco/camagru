<div class="container">
    <div id="flow">
        <span class="flow-1"></span>
    </div>
    <div class="section">
        <div>
            <?php FlashMessage::html() ?>
            <br>
        </div>
        <div class="row columns is-multiline">
            <?php
            foreach ($pictures as $picture) { ?>
                <div class="column is-one-third">
                    <div class="card large round">
                        <div onclick="picture('<?php echo $picture->id ?>')" class="card-image ">
                            <figure style="cursor: pointer" class="image">
                                <img src="<?php echo $picture->data ?>">
                            </figure>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="media-content">
                            <div style="display: flex">
                                <p style="display: inline; align-self: flex-start"><span class="title is-6"><a
                                            style="cursor: text">@<?php echo $picture->user->username ?></a></span>
                                </p>
                                <div style="margin-left: auto">
                                    <p style="font-weight: bolder; display: inline; padding-right: 2px"><?php echo $picture->likes ?></p>
                                    <i style="padding-right: 30px; cursor: pointer;" class="far fa-heart"></i>
                                    <p style="font-weight: bolder; display: inline; padding-right: 2px"><?php echo $picture->comments ?></p>
                                    <i style="padding-right: 30px;" class="far fa-comment"></i>
                                    <i style="cursor: pointer; color: red" class="far fa-trash-alt" onclick="deletePicture('<?php echo $picture->id ?>')"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="columns is-center">

            <?php if ($page - 1 < 0) { ?>
                <a class="pagination-next" disabled>Page précédente</a>
            <?php } else  {?>
                <a href="/<?php echo Routes::$PICTURE_MY_PICTURES ?>?page=<?php echo $page - 1?>" class="pagination-next">Page précédente</a>
            <?php }

            if ($page + 1 > $maxPage) { ?>
                <a class="pagination-next" disabled>Page suivante</a>
            <?php } else  {?>
                <a href="/<?php echo Routes::$PICTURE_MY_PICTURES ?>?page=<?php echo $page + 1?>" class="pagination-next">Page suivante</a>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function deletePicture(id) {
        window.location.href = `/supprimer-photo/${id}/`;
    }
    function picture(id) {
        window.location.href = `/photo/${id}/`;
    }
</script>