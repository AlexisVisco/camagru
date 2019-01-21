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
                                    <i style="padding-right: 50px; cursor: pointer; <?php echo $picture->hasLike ? "color: #ff3351;" : "" ?>" class="heart <?php echo $picture->hasLike ? "fa" : "far" ?> fa-heart"
                                    onclick="heart('<?php echo $picture->id ?>')"
                                    ></i>
                                    <p style="font-weight: bolder; display: inline; padding-right: 2px"><?php echo $picture->comments ?></p>
                                    <i style="" class="far fa-comment"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="columns is-center">
            <a href="/<?php echo Routes::$PICTURE_GALLERY ?>?page=<?php echo $page - 1 >= 0 ? $page - 1 : 0?>" class="pagination-previous <?php echo $page - 1 < 0 ? 'disabled' : '' ?>">Previous</a>
            <a href="/<?php echo Routes::$PICTURE_GALLERY ?>?page=<?php echo $page + 1?>" class="pagination-next">Next page</a>
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