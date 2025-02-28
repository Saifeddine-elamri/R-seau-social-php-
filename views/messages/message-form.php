<!-- Formulaire d'envoi de message -->
<form method="POST" action="send" enctype="multipart/form-data" class="form-container">
    <input type="hidden" name="receiver_id" value="<?php echo $selected_contact; ?>">
    <textarea name="message" placeholder="Tapez un message..."></textarea>

    <button type="button" class="emoji-toggle-btn" onclick="toggleEmojis(this)">😊</button>

    <div class="emoji-container" id="emoji-container" style="display: none;">
        <button type="button" class="emoji-btn" onclick="addEmoji('😊')">😊</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('❤️')">❤️</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('👍')">👍</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('😂')">😂</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🎉')">🎉</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('😍')">😍</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('😎')">😎</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🥺')">🥺</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('💯')">💯</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('💪')">💪</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('😄')">😄</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🥳')">🥳</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🤩')">🤩</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🎶')">🎶</button>
    </div>

    <div class="file-upload-container">
        <label for="image" class="upload-label" title="Ajouter une image">
            📷
        </label>
        <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" class="file-input">

        <!-- Bouton pour l'audio -->
        <button type="button" id="recordBtn" class="upload-label" title="Enregistrer un audio">🎙️</button>
        <button type="button" id="stopBtn" class="upload-label" title="Arrêter l'enregistrement" style="display: none;">⏹️</button>
        <input type="hidden" id="audioInput" name="audio">
    </div>

    <button type="submit"><span class="send-icon">➤</span></button>
    <div id="file-name-display" class="file-name-display"></div>
</form>
