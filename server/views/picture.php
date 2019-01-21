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
                                <i style="padding-right: 50px; cursor: pointer; <?php echo $picture->hasLike ? "color: #ff3351;" : "" ?>"
                                   class="heart <?php echo $picture->hasLike ? "fa" : "far" ?> fa-heart"
                                   onclick="heart('<?php echo $picture->id ?>')"
                                ></i>
                                <p style="font-weight: bolder; display: inline; padding-right: 2px"><?php echo $picture->comments ?></p>
                                <i style="" class="far fa-comment"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <?php FlashMessage::html() ?>
                <?php if (isset($_SESSION["user"])) { ?>
                    <article style="display: block" class="media">
                        <form action="/comment/<?php echo $picture->id ?>/" method="post">
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
                                    <strong><?php echo $comment->user->username ?></strong>
                                <p style="margin: 10px 0px"><?php echo $comment->body ?></p>
                                <small><i style="margin-right: 10px"
                                          class="fa fa-calendar"></i> <?php echo $comment->date ?></small>
                                </p>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
