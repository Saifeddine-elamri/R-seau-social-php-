<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="views/static/css/messages-style.css">
    <link rel="stylesheet" href="views/static/css/messages/messages-section.css">

</head>
<body>

<div class="container">
<?php
// Inclusion des fichiers nécessaires
include __DIR__ . '/../templates/header.php'; 
include 'contacts-section.php'; // Inclusion de la section contacts
include 'messages-section.php'; // Inclusion de la section des messages
include 'message-form.php'; // Inclusion du formulaire d'envoi
include __DIR__ . '/../templates/footer.php'; 
?>
</div>
<script src="views/static/js/message.js"></script>
<script src="views/static/js/messages/message-section.js"></script>

</body>
</html>