document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formAjout');

    if (form) {
        form.addEventListener('submit', function (e) {
            let valide = true;

            const nom = document.getElementById('nom');
            const prenom = document.getElementById('prenom');
            const errorNom = document.getElementById('errorNom');
            const errorPrenom = document.getElementById('errorPrenom');

            // Reset erreurs
            errorNom.textContent = '';
            errorPrenom.textContent = '';

            if (nom.value.trim() === '') {
                errorNom.textContent = 'Le nom est obligatoire.';
                valide = false;
            }

            if (prenom.value.trim() === '') {
                errorPrenom.textContent = 'Le prénom est obligatoire.';
                valide = false;
            }

            if (!valide) {
                e.preventDefault();
            }
        });
    }
});