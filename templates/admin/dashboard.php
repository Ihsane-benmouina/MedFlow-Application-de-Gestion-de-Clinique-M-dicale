<?php include __DIR__ . '/../layout/header.php'; ?>

    <div class="flex flex-col lg:flex-row gap-8 min-h-[calc(100vh-12rem)]" id="admin-layout">

        <aside class="w-full lg:w-64 shrink-0">
            <div class="bg-slate-900 text-slate-400 rounded-2xl p-4 sticky top-24 shadow-xl border border-slate-800 space-y-6">
                <div class="px-3 py-2 border-b border-slate-800/60">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-sky-400">Rôle Actuel</p>
                    <h4 class="text-white font-extrabold text-sm tracking-tight flex items-center gap-2 mt-0.5">
                        🛡️ Central Admin
                    </h4>
                </div>

                <nav class="space-y-1">
                    <button onclick="switchAdminTab('tab-stats')" id="btn-tab-stats" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-bold transition-all text-white bg-gradient-to-r from-sky-500/10 to-sky-500/20 border border-sky-500/20 shadow-xs cursor-pointer admin-nav-btn">
                        📊 Vue d'ensemble & Stats
                    </button>

                    <button onclick="switchAdminTab('tab-add-doctor')" id="btn-tab-add-doctor" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-semibold transition-all hover:bg-slate-800/50 hover:text-white cursor-pointer admin-nav-btn">
                        ➕ Ajouter un Praticien
                    </button>

                    <button onclick="switchAdminTab('tab-list-doctors')" id="btn-tab-list-doctors" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-semibold transition-all hover:bg-slate-800/50 hover:text-white cursor-pointer admin-nav-btn">
                        👥 Registre & Comptes (Modifier/Désactiver)
                    </button>
                </nav>
            </div>
        </aside>

        <div class="flex-1 space-y-6">

            <div id="tab-stats" class="space-y-6 admin-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Vue d'ensemble de la Clinique</h2>
                    <p class="text-xs text-slate-400">Suivi des performances et de l'état général du système.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre total de RDV Clinique</p>
                            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">3,482</h3>
                        </div>
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center text-xl shadow-inner">📊</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Taux d'annulation global</p>
                            <h3 class="text-3xl font-extrabold text-rose-600 mt-1">3.4%</h3>
                        </div>
                        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-xl shadow-inner">⚠️</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs space-y-4">
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">Effectifs par Spécialités Médicales</h3>
                        <p class="text-xs text-slate-400">Total des médecins actuellement assignés à chaque catégorie.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-4 border border-slate-100 bg-slate-50/50 rounded-xl flex justify-between items-center">
                            <div class="flex items-center gap-3"><span>❤️</span> <h4 class="text-sm font-bold text-slate-700">Cardiologie</h4></div>
                            <span class="text-xs font-bold bg-white px-2.5 py-1 rounded-md border border-slate-200">4 actifs</span>
                        </div>
                        <div class="p-4 border border-slate-100 bg-slate-50/50 rounded-xl flex justify-between items-center">
                            <div class="flex items-center gap-3"><span>🩺</span> <h4 class="text-sm font-bold text-slate-700">Médecine Générale</h4></div>
                            <span class="text-xs font-bold bg-white px-2.5 py-1 rounded-md border border-slate-200">8 actifs</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-add-doctor" class="hidden space-y-6 admin-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Ajouter un Nouveau Praticien</h2>
                    <p class="text-xs text-slate-400">Créez un compte sécurisé pour un médecin afin de lui ouvrir l'accès à son planning hebdomadaire.</p>
                </div>

                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-xs max-w-xl">
                    <form class="space-y-4" onsubmit="event.preventDefault(); alert('Médecin inséré avec succès ! Retrouvez-le dans l\'onglet Registre.'); switchAdminTab('tab-list-doctors');">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Nom complet du praticien</label>
                            <input type="text" placeholder="Dr. Ahmed Alami" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Adresse Email professionnelle (Sert d'identifiant)</label>
                            <input type="email" placeholder="ahmed.alami@medflow.ma" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Spécialité Obligatoire (Filtre Patient)</label>
                            <select class="w-full p-3 border border-slate-200 rounded-xl text-sm bg-white text-slate-700 focus:outline-none focus:border-sky-500 font-medium" required>
                                <option value="">Sélectionner une spécialité officielle...</option>
                                <option value="cardio">Cardiologue</option>
                                <option value="general">Généraliste</option>
                            </select>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-6 py-3.5 rounded-xl cursor-pointer transition-all shadow-xs">
                                🚀 Créer et Valider le Compte
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="tab-list-doctors" class="hidden space-y-6 admin-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Registre des Comptes Médecins</h2>
                    <p class="text-xs text-slate-400">Visualisez la liste complète des praticiens enregistrés. Vous disposez des droits pour modifier ou suspendre leurs accès.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="bg-slate-50 text-[11px] font-bold uppercase text-slate-400 tracking-wider border-b border-slate-100">
                                <th class="p-4">Médecin & Contact</th>
                                <th class="p-4">Spécialité Spécifiée</th>
                                <th class="p-4">Statut Système</th>
                                <th class="p-4 text-right">Actions de Contrôle</th>
                            </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-100">

                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold text-slate-900">Dr. Ahmed Alami</div>
                                    <div class="text-xs text-slate-400">ahmed.alami@medflow.ma</div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">Cardiologue</span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Actif
                                    </span>
                                </td>
                                <td class="p-4 text-right space-x-1">
                                    <button onclick="openEditModal('Dr. Ahmed Alami', 'ahmed.alami@medflow.ma', 'cardio')" class="px-3 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-xl text-xs font-bold transition-all cursor-pointer">
                                        ✏️ Modifier
                                    </button>
                                    <button onclick="confirmDisable('Dr. Ahmed Alami')" class="px-3 py-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">
                                        🚫 Désactiver
                                    </button>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold text-slate-900">Dr. Rachid Benjelloun</div>
                                    <div class="text-xs text-slate-400">rachid.benj@medflow.ma</div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Généraliste</span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Actif
                                    </span>
                                </td>
                                <td class="p-4 text-right space-x-1">
                                    <button onclick="openEditModal('Dr. Rachid Benjelloun', 'rachid.benj@medflow.ma', 'general')" class="px-3 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-xl text-xs font-bold transition-all cursor-pointer">
                                        ✏️ Modifier
                                    </button>
                                    <button onclick="confirmDisable('Dr. Rachid Benjelloun')" class="px-3 py-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">
                                        🚫 Désactiver
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="edit-doctor-modal" class="hidden fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-100 space-y-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Modifier le Profil Praticien</h3>
                <p class="text-xs text-slate-400">Mise à jour des informations de compte médecin.</p>
            </div>
            <form class="space-y-3.5" onsubmit="event.preventDefault(); closeEditModal(); alert('Informations mises à jour avec succès dans la base de données !');">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nom complet</label>
                    <input type="text" id="modal-name" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Adresse Email</label>
                    <input type="email" id="modal-email" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Spécialité médicale</label>
                    <select id="modal-spec" class="w-full p-3 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-sky-500 font-medium text-slate-700">
                        <option value="cardio">Cardiologue</option>
                        <option value="general">Généraliste</option>
                    </select>
                </div>
                <div class="pt-2 flex justify-end gap-2 text-xs font-bold">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 text-slate-500 hover:bg-slate-100 rounded-xl transition-all cursor-pointer">Annuler</button>
                    <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl transition-all shadow-md shadow-sky-500/10 cursor-pointer">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchAdminTab(tabId) {
            // 1. Cacher tous les contenus d'onglets
            document.querySelectorAll('.admin-tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // 2. Afficher l'onglet actif
            document.getElementById(tabId).classList.remove('hidden');

            // 3. Réinitialiser les styles de tous les boutons de la Sidebar
            document.querySelectorAll('.admin-nav-btn').forEach(btn => {
                btn.classList.remove('text-white', 'bg-gradient-to-r', 'from-sky-500/10', 'to-sky-500/20', 'border-sky-500/20', 'shadow-xs', 'font-bold');
                btn.classList.add('text-slate-400', 'font-semibold');
            });

            // 4. Activer le style sur le bouton cliqué
            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('text-slate-400', 'font-semibold');
            activeBtn.classList.add('text-white', 'bg-gradient-to-r', 'from-sky-500/10', 'to-sky-500/20', 'border-sky-500/20', 'shadow-xs', 'font-bold');
        }

        // Fonctions utilitaires pour la démo UI (Modal & Alertes)
        function openEditModal(name, email, spec) {
            document.getElementById('modal-name').value = name;
            document.getElementById('modal-email').value = email;
            document.getElementById('modal-spec').value = spec;
            document.getElementById('edit-doctor-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-doctor-modal').classList.add('hidden');
        }

        function confirmDisable(doctorName) {
            if(confirm(`Êtes-vous sûr de vouloir désactiver immédiatement le compte de ${doctorName} ? L'accès au système lui sera refusé.`)) {
                alert('Compte suspendu avec succès.');
            }
        }
    </script>

<?php include __DIR__ . '/../layout/footer.php'; ?>