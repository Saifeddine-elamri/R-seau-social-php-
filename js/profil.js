function showSection(sectionId) {
            // Masquer toutes les sections
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.remove('active');
            });

            // Afficher la section sélectionnée
            document.getElementById(sectionId).classList.add('active');
        }

        // Afficher la première section par défaut
showSection('profile-info');
