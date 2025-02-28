let mediaRecorder;
let audioChunks = [];
let stream = null;

const recordBtn = document.getElementById('recordBtn');
const stopBtn = document.getElementById('stopBtn');
const audioInput = document.getElementById('audioInput');
const fileNameDisplay = document.getElementById('file-name-display');

// Vérifier et démarrer l'enregistrement
async function startRecording() {
    try {
        // Vérifier l'état de la permission
        const permissionStatus = await navigator.permissions.query({ name: 'microphone' });

        if (permissionStatus.state === 'granted') {
            // Si déjà autorisé, démarrer directement
            stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            setupRecorder(stream);
        } else if (permissionStatus.state === 'prompt') {
            // Si pas encore demandé, demander la permission
            stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            setupRecorder(stream);
        } else {
            fileNameDisplay.textContent = 'Microphone bloqué. Vérifiez les permissions.';
            return;
        }
    } catch (err) {
        fileNameDisplay.textContent = 'Erreur: Impossible d\'accéder au microphone';
        console.error(err);
    }
}

// Configurer le MediaRecorder
function setupRecorder(stream) {
    mediaRecorder = new MediaRecorder(stream);

    mediaRecorder.ondataavailable = (event) => {
        audioChunks.push(event.data);
    };

    mediaRecorder.onstop = () => {
        const audioBlob = new Blob(audioChunks, { type: 'audio/mp3' });
        const audioFile = new File([audioBlob], `${Date.now()}.mp3`, { type: 'audio/mp3' });
        audioChunks = [];

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(audioFile);
        audioInput.files = dataTransfer.files;

        fileNameDisplay.textContent = `Audio: ${audioFile.name}`;
        stream.getTracks().forEach(track => track.stop());
        stream = null;

        recordBtn.style.display = 'inline-block';
        stopBtn.style.display = 'none';
    };

    audioChunks = [];
    mediaRecorder.start();
    recordBtn.style.display = 'none';
    stopBtn.style.display = 'inline-block';
    fileNameDisplay.textContent = 'Enregistrement en cours...';
}

recordBtn.onclick = () => {
    startRecording();
};

stopBtn.onclick = () => {
    if (mediaRecorder) {
        mediaRecorder.stop();
    }
};

// Fonctions existantes pour les émojis
function toggleEmojis(button) {
    const container = document.getElementById('emoji-container');
    container.style.display = container.style.display === 'none' ? 'block' : 'none';
}

function addEmoji(emoji) {
    const textarea = document.querySelector('textarea[name="message"]');
    textarea.value += emoji;
}
