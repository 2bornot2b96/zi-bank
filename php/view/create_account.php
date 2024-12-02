<?php $title = 'Zi Banke - création de compte'; ?>

<?php ob_start(); ?>

<section class="login">
    <form class="login-block" action="index.php?action=creating" method="POST" >
        <h2>crée un compte:</h2>
        <div>
            <div class="login-id">
                <label for="identity">votre mail:</label><br>
                <input type="mail" id="identity" name="mail">
            </div>
            <div class="login-password">
                <label for="passe">mot de passe:</label><br>
                <input type="password" id="passe" name="pass">
            </div>
            <div>
                <label for="nom">votre nom:</label><br>
                <input type="text" id="nom" name="nom">
            </div>
            <div>
                <label for="prenom">votre prénom:</label><br>
                <input type="text" id="prenom" name="prenom">
            </div>
            <div>
                <input type="submit" value="envoyer" class="button login-button">
                <input type="reset" value="recommencer" class="button login-button">
            </div>
        </div>
        <?php if(isset($_SESSION['notice'])): ?>
        <p><?= $_SESSION['notice'] ?></p>
        <?php unset($_SESSION['notice']); ?>
        <?php endif; ?>
    </form>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('php/template/template.php'); ?>