<html>

<head>
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <p><?php echo 'Bienvenue' . ' ' . $donkey . '!'; ?></p>
        <p>
            <a class="connect" href="login.php" title="Me connecter">Se connecter/S'inscrire</a>
        </p>
        <p>
            <a class="home" href="index.php" title="Accueil">Accueil</a>
        </p>
        <p>
            <a class="cart" href="cart.php" title="Voir mon panier">
                <?php echo 'Il y a' . ' ' . $cart . ' ' . 'livre(s) dans mon panier.'; ?></a>
        </p>
        <form action="index.php" method="get">
            <input type="text" name="query" placeholder="Rechercher...">
            <input type="submit" value="Rechercher">
        </form>


    </header>
    <main>
        <?php
        // Connection to db
        require_once('server.php');
        //Functions 
        require_once('functions.php');
