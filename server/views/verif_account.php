<div class="container has-text-centered">
    <div class="column is-5 is-offset-4">
        <h3 class="title has-text-grey">Valider mon compte !</h3>
        <div class="box">
            <?php FlashMessage::html() ?>
            <form method="post" action="/confirmation/<?php printSafety($id) ?>/<?php printSafety($token) ?>/">
                <button type="submit" class="button is-block is-info is-fullwidth">Verifier mon compte</button>
            </form>
        </div>
    </div>
</div>