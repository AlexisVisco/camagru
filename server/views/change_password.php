<div class="container has-text-centered">
    <div class="column is-5 is-offset-4">
        <h3 class="title has-text-grey">Et un nouveau mot de passe !</h3>
        <p class="subtitle has-text-grey">Hop! Magie un nuveau mot de passe?</p>
        <div class="box">
            <form method="post">
                <?php FlashMessage::html() ?>
                <div class="field">
                    <div class="control">
                        <input  name="password" class="input" type="password" placeholder="Mot de passe">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input name="passwordConfirm" class="input" type="password" placeholder="Confirmation mot de passe">
                    </div>
                </div>
                <button type="submit" class="button is-block is-info is-fullwidth">Change le mot de passe !</button>
            </form>
        </div>
        <p class="has-text-grey">
            <a href="/<?php echo Routes::$USER_REGISTER?>">S'inscrire</a> &nbsp;·&nbsp;
            <a href="/<?php echo Routes::$USER_LOGIN?>">Se connecter</a>
        </p>
    </div>
</div>