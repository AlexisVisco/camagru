<div class="container">
    <div id="flow">
        <span class="flow-1"></span>
    </div>
    <div class="section">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="card large round">
                    <div class="card-image ">
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
                                <i style="padding-right: 50px; cursor: pointer; <?php printSafety($picture->hasLike ? "color: #ff3351;" : "") ?>"
                                   class="heart <?php printSafety($picture->hasLike ? "fa" : "far") ?> fa-heart"
                                   onclick="heart('<?php printSafety($picture->id) ?>')"
                                ></i>
                                <p style="font-weight: bolder; display: inline; padding-right: 2px"><?php printSafety($picture->comments) ?></p>
                                <i style="" class="far fa-comment"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <?php FlashMessage::html() ?>
                <?php if (isset($_SESSION["user"])) { ?>
                    <article style="display: block" class="media">
                        <form action="/comment/<?php printSafety($picture->id) ?>/" method="post">
                            <div class="media-content">
                                <div class="field">
                                    <p class="control">
                                    <textarea class="textarea" name="body"
                                              placeholder="Écris ton commentaire"></textarea>
                                    </p>
                                </div>
                                <div class="field">
                                    <p class="control">
                                        <button class="button" type="submit">Post comment</button>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </article>
                <?php } ?>
                <?php foreach ($comments as $comment) { ?>
                    <article class="media">
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <strong><?php printSafety($comment->user->username) ?></strong>
                                <p style="margin: 10px 0px"><?php printSafety($comment->body) ?></p>
                                <small><i style="margin-right: 10px"
                                          class="fa fa-calendar"></i> <?php printSafety($comment->date) ?></small>
                                </p>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<script>
    function heart(id) {
        window.location.href = `/like/${id}/?redirect=/photo/${id}/`;
    }
</script>