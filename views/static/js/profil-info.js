
function toggleUploadForm() {
    var form = document.getElementById("uploadForm");
    form.style.display = (form.style.display === "none") ? "block" : "none";
}

function updateFileName() {
    var input = document.getElementById('fileInput');
    var fileName = document.getElementById('fileName');

    if (input.files.length > 0) {
        fileName.textContent = input.files[0].name;
        fileName.style.color = "#28a745"; // Changer la couleur en vert
    } else {
        fileName.textContent = "No file selected";
        fileName.style.color = "#555"; // Retour à la couleur d'origine
    }
}

function toggleUploadForm() {
    var form = document.getElementById('uploadForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function toggleEditForm() {
    var form = document.getElementById('editForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function updateFileName() {
    var input = document.getElementById('fileInput');
    var fileName = document.getElementById('fileName');
    fileName.textContent = input.files.length > 0 ? input.files[0].name : 'Aucun fichier sélectionné';
}