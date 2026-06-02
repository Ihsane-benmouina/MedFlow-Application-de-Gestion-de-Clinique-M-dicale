<?php include __DIR__ . '/../layout/header.php'; ?>

    <div class="max-w-md mx-auto my-12 bg-white p-8 rounded-3xl border border-slate-100 shadow-xl space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Inscription Patient</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Créez votre dossier médical numérique MedFlow</p>
        </div>

        <form class="space-y-4" onsubmit="event.preventDefault(); alert('Compte Patient créé avec succès ! Connectez-vous maintenant.'); window.location.href='?action=login';">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nom Complet</label>
                <input type="text" placeholder="Khadija Makkaoui" class="w-full p-3 border border-slate-200 rounded-xl text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Adresse Email</label>
                <input type="email" placeholder="khadija@mail.com" class="w-full p-3 border border-slate-200 rounded-xl text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Mot de passe</label>
                <input type="password" placeholder="••••••••" class="w-full p-3 border border-slate-200 rounded-xl text-sm" required>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-bold text-xs py-3.5 rounded-xl cursor-pointer hover:bg-slate-800 transition-all">
                Créer mon compte patient
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="?action=login" class="text-xs font-bold text-slate-400 hover:text-slate-600">Déjà inscrit ? Se connecter</a>
        </div>
    </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>