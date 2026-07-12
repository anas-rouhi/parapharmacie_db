{{--
    Boîte de confirmation réutilisable (remplace les vieux `confirm()` natifs du navigateur).

    Utilisation — il suffit d'ajouter `data-confirm` sur un <form> :
        <form ... data-confirm="Voulez-vous vraiment supprimer ce produit ?">

    Attributs optionnels :
        data-confirm-title  → titre du popup      (défaut : "Êtes-vous sûr ?")
        data-confirm-btn    → texte du bouton     (défaut : "Oui, supprimer")
        data-confirm-icon   → warning|question|error|info  (défaut : "warning")
--}}
@once
    @if(!isset($skipSwalCdn))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif

    <script>
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-confirm')) return;
            if (form.dataset.confirmed === 'true') return; // déjà validé → on laisse passer

            e.preventDefault();
            e.stopPropagation();

            Swal.fire({
                title: form.dataset.confirmTitle || 'Êtes-vous sûr ?',
                text: form.dataset.confirm,
                icon: form.dataset.confirmIcon || 'warning',
                showCancelButton: true,
                confirmButtonText: form.dataset.confirmBtn || 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                focusCancel: true,
                buttonsStyling: true,
                customClass: {
                    popup: 'rounded-2xl',
                    title: 'text-lg font-black',
                    confirmButton: 'font-bold',
                    cancelButton: 'font-bold',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = 'true';
                    form.submit(); // ne redéclenche pas l'événement 'submit'
                }
            });
        }, true);
    </script>
@endonce
