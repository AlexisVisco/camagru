<div class="container has-text-centered">
    <div class="column is-5 is-offset-4">
        <h3 class="title has-text-grey">Mot de passe oublié</h3>
        <p class="subtitle has-text-grey">Oups, vous avez un trou de mémoire?</p>
        <div class="box">
            <form method="post" action="/<?php echo Routes::$USER_FORGOT_PWD ?>">
                <?php FlashMessage::html() ?>
                <div class="field">
                    <p class="control">
                        <input name="email" class="input" type="email" placeholder="Email de votre compte">
                    </p>
                </div>
                <button type="submit" class="button is-block is-info is-fullwidth">Récupérer</button>
            </form>
        </div>
        <p class="has-text-grey">
            <a href="/<?php echo Routes::$USER_REGISTER?>">S'inscrire</a> &nbsp;·&nbsp;
            <a href="/<?php echo Routes::$USER_LOGIN?>">Se connecter</a>
        </p>
    </div>
</div>