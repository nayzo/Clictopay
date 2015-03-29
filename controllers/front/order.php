<?php

/*
 * (c) Ala Eddine Khefifi <alakhefifi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

session_start();
?>

<html>
<head>
    <style>
        .centering {
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        img {
            vertical-align: middle;
            height: 330px;
            width: 330px
        }
    </style>
</head>
<body>
<div class="centering">
    <img src="/modules/clictopay/logos/loading.gif" alt="loading">

    <h2>Opération en cours d'éxécution, Veuillez patienter</h2>
</div>

<form name="clictopayform" action="<?php echo $_SESSION['URL']; ?>" method="post">
    <input name="Reference" type="hidden" value="<?php echo $_SESSION['Reference']; ?>">
    <input name="Montant" type="hidden" value="<?php echo $_SESSION['Montant']; ?>">
    <input name="Devise" type="hidden" value="<?php echo $_SESSION['Devise']; ?>">
    <input name="sid" type="hidden" value="<?php echo $_SESSION['sid']; ?>">
    <input name="affilie" type="hidden" value="<?php echo $_SESSION['affilie']; ?>">
</form>
<?php
session_unset();
session_destroy();
?>
<script>
    window.onload = function () {
        document.clictopayform.submit()
    };
</script>
</body>
</html>
