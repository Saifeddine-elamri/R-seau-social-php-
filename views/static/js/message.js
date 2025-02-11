// Lorsque l'utilisateur sélectionne un fichier
document.getElementById('image').addEventListener('change', function() {
    var fileName = this.files[0].name; // Récupère le nom du fichier
    var fileNameDisplay = document.getElementById('file-name-display'); // L'élément où afficher le nom du fichier
    fileNameDisplay.textContent = fileName; // Affiche le nom du fichier
});

// Fonction pour afficher/masquer la liste des emojis sous l'emoji cliqué
function toggleEmojis(button) {
    var emojiContainer = document.getElementById('emoji-container');
    
    // Positionner les emojis juste sous le bouton cliqué
    var buttonRect = button.getBoundingClientRect();
    emojiContainer.style.left = buttonRect.left + 'px';  // Positionner horizontalement
    emojiContainer.style.top = (buttonRect.top + buttonRect.height + 5) + 'px';  // Positionner verticalement (juste sous)

    if (emojiContainer.style.display === 'none') {
        emojiContainer.style.display = 'flex'; // Afficher les emojis avec flex pour une disposition horizontale
    } else {
        emojiContainer.style.display = 'none'; // Cacher les emojis
    }
}

// Fonction pour ajouter un emoji dans le champ de message
function addEmoji(emoji) {
    var textarea = document.querySelector('textarea[name="message"]');
    textarea.value += emoji; // Ajouter l'emoji à la fin du message
    textarea.focus(); // Revenir au champ de texte
}

