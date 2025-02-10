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


document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".like-btn").forEach(button => {
        button.addEventListener("click", function() {
            this.nextElementSibling.classList.toggle("visible");
        });
    });

    document.querySelectorAll(".emoji-option").forEach(emoji => {
        emoji.addEventListener("click", function() {
            let form = this.closest("form");
            form.querySelector(".selected-emoji").value = this.dataset.emoji;
        });
    });
});


// Lorsque l'utilisateur sélectionne un fichier
document.getElementById('post_image').addEventListener('change', function() {
    var fileName = this.files[0].name; // Récupère le nom du fichier
    var fileNameDisplay = document.getElementById('file-name-display'); // L'élément où afficher le nom du fichier
    fileNameDisplay.textContent = fileName; // Affiche le nom du fichier
});
