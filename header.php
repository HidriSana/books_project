<html>

<head>
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <p><?php echo 'Bienvenue' . ' ' . $donkey . '!'; ?></p>
        <a href="login.php" title="Me connecter">
            <p>Se connecter</p>
        </a>
        <a href="index.php" title="Accueil">
            <p>Accueil</p>
        </a>
        <a href="cart.php" title="Voir mon panier">
            <p><?php echo 'Il y a' . ' ' . $cart . ' ' . 'livre(s) dans mon panier.'; ?></p>
        </a>
        <form action="index.php" method="get">
            <input type="text" name="query" placeholder="Rechercher...">
            <input type="submit" value="Rechercher">
        </form>


    </header>
    <main>