<?php
$user = User::getUser();
/* @var string $body */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Camagru - Photos comme jamais.</title>
    <link rel="shortcut icon" href="../images/fav_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css"/>
    <style type="text/css">
        html,

        body {
            font-family: 'Open Sans', serif;
            background-color: rgb(252, 252, 252);
        }

        .my-container {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            border-radius: 3px;
            padding: 10px;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
        }

        *:focus {
            outline: none;
        }

        img {
            padding: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <div class="hero-head">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <h1 style="padding-top: 10px" class="title is-3">Camagru</h1>

                    <span class="navbar-burger burger" data-target="navbarMenu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </div>
                <div id="navbarMenu" class="navbar-menu">
                    <div class="navbar-end">
                        <div class="tabs is-right">
                            <ul>
                                <li><a href="/">Accueil</a></li>
                                <li><a href="/">Gallerie</a></li>

                                <?php if ($user == NULL) { ?>
                                <a href="/<?php echo Routes::$USER_REGISTER ?>" style="margin-left: 10px"
                                   class="button">S'inscrire</a>
                                <a href="/<?php echo Routes::$USER_LOGIN ?>" style="margin-left: 5px"
                                   class="button is-primary">Se connecter</a>
                            </ul>
                            <?php } else { ?>
                                <li><a href="/">Paramètres</a></li>
                                <li><a href="/">Ma page</a></li>
                                <li><a href="/<?php echo Routes::$PICTURE_ADD_PHOTO ?>">Ajouter une photo</a></li>
                                <li><a href="/<?php echo Routes::$USER_LOGOUT ?>">Se deconnecter</a></li>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="hero-body">
        <?php echo $body ?>
    </div>

    <div class="hero-foot">
        <div class="container">
            <div class="tabs is-centered">
                <ul>
                </ul>
            </div>
        </div>
    </div>
</section>
<script>
    (function () {
        let burger = document.querySelector('.burger');
        let menu = document.querySelector('#' + burger.dataset.target);
        burger.addEventListener('click', function () {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    })();
</script>
</body>

</html>