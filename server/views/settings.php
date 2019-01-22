<?php $user = json_decode($_SESSION["user"]); ?>
<div class="container has-text-centered">
    <div class="column is-5 is-offset-4">
        <h3 class="title has-text-grey">Modifier votre profil</h3>
        <p class="subtitle has-text-grey">Une information ne vous plait pas ? Changez là !</p>
        <div class="box">
            <?php FlashMessage::html() ?>
            <form method="post" action="/<?php echo Routes::$USER_SETTINGS ?>">
                <div class="field">
                    <p class="control">
                        <input name="email" class="input" type="email" placeholder="Email" value="<?php echo $user->email ?>">
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <input name="username" class="input" type="text" placeholder="Username" value="<?php echo $user->username ?>">
                    </p>
                </div>
                <div class="field">
                    <div class="control">
                        <input name="password" class="input" type="password" placeholder="Ancien mot de passe">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input name="passwordNew" class="input" type="password" placeholder="Nouveau mot de passe">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <label class="checkbox">
                            <input type="checkbox" name="notify" value="<?php echo $user->notified ? 'checked' : '' ?>">
                            Recevoir les notifications par email
                        </label>
                    </div>
                </div>
                <button type="submit" class="button is-block is-info is-fullwidth">Modifier vos informations</button>
            </form>
        </div>
    </div>
</div>