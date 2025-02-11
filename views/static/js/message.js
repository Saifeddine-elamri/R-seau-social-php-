// Lorsque l'utilisateur sélectionne un fichier
document.getElementById('image').addEventListener('change', function() {
    var fileName = this.files[0].name; // Récupère le nom du fichier
    var fileNameDisplay = document.getElementById('file-name-display'); // L'élément où afficher le nom du fichier
    fileNameDisplay.textContent = fileName; // Affiche le nom du fichier
});
