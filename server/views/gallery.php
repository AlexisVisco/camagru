<div class="container">
    <div id="flow">
        <span class="flow-1"></span>
    </div>
    <div class="section">
        <div class="row columns is-multiline">
            <?php
            foreach ($pictures as $picture) { ?>
                <div class="column is-one-third">
                    <div class="card large round">
                        <div onclick="picture('<?php printSafety($picture->id) ?>')" class="card-image ">
                            <figure style="cursor: pointer" class="image">
                                <img src="<?php printSafety($picture->data) ?>">
                            </figure>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="media-content">
                            <div style="display: flex">
                                <p style="display: inline; align-self: flex-start"><span class="title is-6"><a
                                                style="cursor: text">@<?php printSafety($picture->user->username) ?></a></span>
                                </p>
                                <div style="margin-left: auto">
                                    <p style="font-weight: bolder; display: inline; padding-right: 2px"><?php printSafety($picture->likes) ?></p>
                                    <i style="padding-right: 50px; cursor: pointer; <?php printSafety($picture->hasLike ? "color: #ff3351;" : "") ?>" class="heart <?php printSafety($picture->hasLike ? "fa" : "far") ?> fa-heart"
                                    onclick="heart('<?php printSafety($picture->id) ?>')"
                                    ></i>
                                    <p style="font-weight: bolder; display: inline; padding-right: 2px"><?php printSafety($picture->comments) ?></p>
                                    <i style="" class="far fa-comment"></i>
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
            <a href="/<?php echo Routes::$PICTURE_GALLERY ?>?page=<?php printSafety($page - 1)?>" class="pagination-next">Page précédente</a>
            <?php }

            if ($page + 1 > $maxPage) { ?>
            <a class="pagination-next" disabled>Page suivante</a>
            <?php } else  {?>
            <a href="/<?php echo Routes::$PICTURE_GALLERY ?>?page=<?php printSafety($page + 1)?>" class="pagination-next">Page suivante</a>
            <?php } ?>
        </div>
    </div>
</div>

<style>
    .heart:hover {
        color: #ff3351;
    }
</style>

<script>
    function heart(id) {
        window.location.href = `/like/${id}/`;
    }

    function picture(id) {
        window.location.href = `/photo/${id}/`;
    }
</script>