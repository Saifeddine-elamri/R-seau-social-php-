// Gestion des boutons Like
document.querySelectorAll('.like-btn, .like-btn-custom').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault(); // Empêche la soumission immédiate
        const emojiPicker = this.nextElementSibling;
        
        // Afficher le sélecteur d'emojis
        emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
    });
});

// Gestion des clics sur les emojis
document.querySelectorAll('.comment-emoji').forEach(emoji => {
    emoji.addEventListener('click', function() {
        const form = this.closest('.like-form');
        const emojiInput = form.querySelector('.comment-selected-emoji');
        const button = form.querySelector('button');

        // Mettre à jour la valeur de l'input caché
        const newEmoji = this.getAttribute('data-emoji');
        const newText = this.getAttribute('data-text');
        emojiInput.value = newEmoji;

        // Mettre à jour l'affichage du bouton
        button.innerHTML = `${newEmoji} ${newText}`;
        button.className = newEmoji !== '👍' ? 'like-btn-custom' : 'like-btn';

        // Cacher le sélecteur
        this.parentElement.style.display = 'none';

        // Soumettre le formulaire
        form.submit();
    });
});

// Cacher le sélecteur si clic hors de celui-ci
document.addEventListener('click', function(e) {
    if (!e.target.closest('.like-btn') && !e.target.closest('.like-btn-custom') && !e.target.closest('.comment-emoji-picker')) {
        document.querySelectorAll('.comment-emoji-picker').forEach(picker => {
            picker.style.display = 'none';
        });
    }
});


document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".reply-comment").forEach(button => {
        button.addEventListener("click", function() {
            let commentId = this.getAttribute("data-comment-id");
            let replyBox = document.getElementById("reply-box-" + commentId);
            
            // Bascule l'affichage du champ de réponse
            if (replyBox.style.display === "none" || replyBox.style.display === "") {
                replyBox.style.display = "block";
            } else {
                replyBox.style.display = "none";
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".toggle-replies").forEach(button => {
        button.addEventListener("click", function() {
            const commentId = this.getAttribute("data-comment-id");
            const replyContainer = document.getElementById("replies-" + commentId);

            if (replyContainer.style.display === "none") {
                replyContainer.style.display = "block";
                this.textContent = "Masquer les réponses";
            } else {
                replyContainer.style.display = "none";
                this.textContent = "Voir " + replyContainer.children.length + " réponse(s)";
            }
        });
    });
});
