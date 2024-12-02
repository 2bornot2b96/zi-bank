<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="asset/img/zi-logo-banke.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/style/style.css">
    <title><?= $title ?></title>
</head>
<body class="container">
    <!--en-tête-->
<header class="mt-4">
    <div class="header">
        <img src="asset/img/zi-logo-banke.jpg" alt="logo de la superbe bank" class="logo-principal">
        <div>
            <h1 class="header-heading">ZI BANKE</h1>
        </div>
        <?php if(isset($_SESSION['user_logged'])): ?>
            <a href="index.php?action=disconnect"><button class="button">se deconnecter</button></a>
        <?php else : ?>
            <div>
                <a href="index.php?action=create_account"><button class="button">crée un compte</button></a>
                <a href="index.php"><button class="button">se connecter</button></a>
            </div>
        <?php endif; ?>  
    </div>
</header>
<main>
 
    <?= $content ?>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>  
<script src="asset/script/script.js"></script>
</body>
</html>