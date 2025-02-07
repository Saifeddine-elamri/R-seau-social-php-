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