<?php $title = 'Zi Banke - connexion'; ?>

<?php ob_start(); ?>

<section class="login">
    <form class="login-block" action="index.php?action=connexion" method="POST" >
        <h2>vous connectez:</h2>
        <div>
            <div class="login-id">
                <label for="identity">identifiant:</label><br>
                <input type="mail" id="identity" name="mail">
            </div>
            <div class="login-password">
                <label for="passe">mot de passe:</label><br>
                <input type="password" id="passe" name="pass">
            </div>
            <input type="submit" value="se connecter" class="button login-button">
        </div>
        <?php if(isset($_SESSION['notice'])): ?>
        <p><?= $_SESSION['notice'] ?></p>
        <?php unset($_SESSION['notice']); ?>
    <?php endif; ?>
    </form>
    
</section>

<?php $content = ob_get_clean(); ?>
<?php require('php/template/template.php'); ?>