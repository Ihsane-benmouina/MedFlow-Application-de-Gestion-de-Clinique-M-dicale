<?php include __DIR__ . '/../layout/header.php'; ?>

    <div class="max-w-md mx-auto my-12 bg-white p-8 rounded-3xl border border-slate-100 shadow-xl space-y-6">
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Connexion Espace Privé</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Sélectionnez le type de compte simulé pour la démo d'UI :</p>
        </div>

        <!-- Formulaire qui simule la redirection RBAC à des fins d'évaluation d'UI -->
        <form class="space-y-4" id="loginForm">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Adresse Email</label>
                <input type="email" placeholder="mail@medflow.ma" class="w-full p-3.5 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 text-sm font-medium" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Simuler le Rôle (RBAC)</label>
                <select id="roleSelector" class="w-full p-3.5 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 text-sm font-semibold bg-white text-slate-700">
                    <option value="patient-dashboard">Patient (Mme. Khadija)</option>
                    <option value="doctor-dashboard">Médecin (Dr. Alami)</option>
                    <option value="admin-dashboard">Administrateur (Clinique Manager)</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-bold text-sm py-3.5 rounded-xl shadow-lg shadow-sky-500/10 cursor-pointer transition-all">
                Se connecter
            </button>
        </form>

        <div class="text-center pt-4 border-t border-slate-100">
            <p class="text-xs text-slate-500">Nouveau sur MedFlow ?</p>
            <a href="?action=register" class="text-xs font-bold text-sky-500 hover:underline mt-1 inline-block">Créer un compte Patient d'abord</a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const targetDashboard = document.getElementById('roleSelector').value;
            window.location.href = '?action=' + targetDashboard;
        });
    </script>

<?php include __DIR__ . '/../layout/footer.php'; ?>