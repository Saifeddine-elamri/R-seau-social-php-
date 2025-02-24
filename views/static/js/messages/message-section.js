document.addEventListener("DOMContentLoaded", function() {
    // Lorsque l'utilisateur clique sur le bouton de réaction, afficher ou masquer les emojis
    document.querySelectorAll(".react-btn").forEach(button => {
        button.addEventListener("click", function() {
            const messageId = this.closest('.message').getAttribute("data-message-id");
            const reactionPicker = document.getElementById("reaction-picker-" + messageId);

            // Afficher ou cacher le sélecteur d'emojis
            reactionPicker.style.display = reactionPicker.style.display === "none" ? "flex" : "none";
        });
    });

    // Lorsque l'utilisateur clique sur un emoji, envoyer la réaction
    document.querySelectorAll(".reaction-picker .reaction").forEach(emoji => {
        emoji.addEventListener("click", function() {
            const emojiSelected = this.getAttribute("data-emoji");
            const messageId = this.getAttribute("data-message-id");
            
            // Mettre à jour le contenu de la réaction sous le message
            const reactionDisplay = document.getElementById("reaction-display-" + messageId);
            reactionDisplay.innerHTML = `<strong>Réaction:</strong> ${emojiSelected}`;

            // Soumettre la réaction via un formulaire
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "react-message";  // L'URL de traitement pour la réaction

            const inputMessageId = document.createElement("input");
            inputMessageId.type = "hidden";
            inputMessageId.name = "message_id";
            inputMessageId.value = messageId;
            form.appendChild(inputMessageId);

            const inputReaction = document.createElement("input");
            inputReaction.type = "hidden";
            inputReaction.name = "reaction";
            inputReaction.value = emojiSelected;
            form.appendChild(inputReaction);

            document.body.appendChild(form);  // Ajoute le formulaire au DOM
            form.submit();  // Envoie le formulaire
        });
    });
});
