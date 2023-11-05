<?php

// Connexion à la BDD
require_once('server.php');

// Inclure l'en-tête
$pageTitle = 'Modifier un livre';
$donkey = 'Donkey'; // A modifier   une fois que le login est géré ++++
$cart = 0;
include('header.php');

$sqlBooksEdit = 'UPDATE';
