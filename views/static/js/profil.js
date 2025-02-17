document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner tous les boutons "Comment"
    document.querySelectorAll(".comment-toggle").forEach(button => {
        button.addEventListener("click", function() {
            let postId = this.getAttribute("data-post-id");
            let commentForm = document.getElementById("comment-form-" + postId);
            
            if (commentForm.style.display === "flex") {
                commentForm.style.display = "none";
            } else {
                commentForm.style.display = "flex";
            }
        });
    });
});





// Fonction pour afficher les noms des fichiers sans écraser
function handleFileSelect(inputElement, displayElement, type) {
    var files = inputElement.files; // Récupère tous les fichiers sélectionnés
    var fileNames = [];

    // Parcours chaque fichier sélectionné
    for (var i = 0; i < files.length; i++) {
        var file = files[i]; // Récupère le fichier courant
        var fileName = file.name; // Récupère le nom du fichier
        var fileType = file.type; // Récupère le type MIME du fichier

        // Vérifie si le fichier correspond au type attendu (image ou vidéo)
        if ((type === 'image' && fileType.startsWith('image/')) || 
            (type === 'video' && fileType.startsWith('video/'))) {
            fileNames.push(fileName); // Ajoute le nom du fichier à la liste
        }
    }

    // Si des fichiers sont sélectionnés pour ce type (image ou vidéo), affiche les noms
    if (fileNames.length > 0) {
  

        // Affiche les noms de chaque fichier sélectionné
        fileNames.forEach(function(name) {
            var para = document.createElement('p');
            para.textContent = name; // Affiche le nom du fichier
            displayElement.appendChild(para);
        });
    }
}

// Lorsque l'utilisateur sélectionne un fichier d'image
document.getElementById('post_image').addEventListener('change', function() {
    var fileNameDisplay = document.getElementById('file-name-display');
    handleFileSelect(this, fileNameDisplay, 'image');
});

// Lorsque l'utilisateur sélectionne un fichier vidéo
document.getElementById('post_video').addEventListener('change', function() {
    var fileNameDisplay = document.getElementById('file-name-display');
    handleFileSelect(this, fileNameDisplay, 'video');
});

document.querySelectorAll('.emoji').forEach(emoji => {
    emoji.addEventListener('click', function() {

        const form = this.closest('form');

        // Mettre à jour l'input caché avec l'emoji sélectionné dans ce formulaire
        form.querySelector('.selected-emoji').value = this.dataset.emoji;

        // Mettre à jour le texte du bouton dans ce formulaire
        form.querySelector('.like-btn').innerHTML = `${this.dataset.emoji} ${this.dataset.text}`;
            // Récupérer l'emoji et le texte à partir des attributs de l'élément cliqué

        form.submit();


        // Soumettre automatiquement le formulaire
    });
});

document.querySelectorAll('.comment-toggle').forEach(function(button) {
    button.addEventListener('click', function() {
        const postId = this.getAttribute('data-post-id');
        const commentsSection = document.getElementById('comments-' + postId);
        
        // Bascule la classe 'hidden'
        commentsSection.classList.toggle('hidden');
    });
});