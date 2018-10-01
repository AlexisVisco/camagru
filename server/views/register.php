<div class="container has-text-centered">
    <div class="column is-5 is-offset-4">
        <h3 class="title has-text-grey">S'inscrire</h3>
        <p class="subtitle has-text-grey">Vous voulez vous inscrire ? C'est ici !</p>
        <div class="box">
            <?php FlashMessage::html() ?>
            <form method="post" action="/<?php echo Routes::$USER_REGISTER ?>">
                <div class="field">
                    <p class="control">
                        <input name="email" class="input" type="email" placeholder="Email">
                    </p>
                </div>

                <div class="field">
                    <div class="control">
                        <input name="username" class="input" type="text" placeholder="Nom d'utilisateur" autofocus="">
                    </div>
                </div>

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
                <button type="submit" class="button is-block is-info is-fullwidth">S'inscrire</button>
            </form>
        </div>
        <p class="has-text-grey">
            <a href="/<?php echo Routes::$USER_LOGIN?>">Se connecter</a> &nbsp;·&nbsp;
            <a href="/<?php echo Routes::$USER_FORGOT_PWD?>">Mot de passe oublié</a>
        </p>
    </div>
</div>