<?php include __DIR__ . '/../layout/header.php'; ?>

    <!-- Container principal avec Sidebar et Zone de Contenu Médecin -->
    <div class="flex flex-col lg:flex-row gap-8 min-h-[calc(100vh-12rem)]">

        <!-- 1. SIDEBAR FIXE (Navigation Espace Praticien) -->
        <aside class="w-full lg:w-64 shrink-0">
            <div class="bg-slate-900 text-slate-400 rounded-2xl p-4 sticky top-24 shadow-xl border border-slate-800 space-y-6">
                <div class="px-3 py-2 border-b border-slate-800/60">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-400">Espace Professionnel</p>
                    <h4 class="text-white font-extrabold text-sm tracking-tight flex items-center gap-2 mt-0.5">
                        🩺 Dr. Ahmed Alami
                    </h4>
                </div>

                <!-- Liens de navigation du Cabinet -->
                <nav class="space-y-1">
                    <button onclick="switchDoctorTab('doc-stats')" id="btn-doc-stats" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-bold transition-all text-white bg-gradient-to-r from-emerald-500/10 to-emerald-500/20 border border-emerald-500/20 shadow-xs cursor-pointer doc-nav-btn">
                        📋 Tableau de bord & Actu
                    </button>

                    <button onclick="switchDoctorTab('doc-agenda')" id="btn-doc-agenda" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-semibold transition-all hover:bg-slate-800/50 hover:text-white cursor-pointer doc-nav-btn">
                        📅 Gestion de l'Agenda (RDV)
                    </button>

                    <button onclick="switchDoctorTab('doc-consultation')" id="btn-doc-consultation" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-semibold transition-all hover:bg-slate-800/50 hover:text-white cursor-pointer doc-nav-btn">
                        📝 Consultation & Prescriptions
                    </button>
                </nav>
            </div>
        </aside>

        <!-- 2. MAIN CONTENT (Zone d'affichage dynamique gérée par la Sidebar) -->
        <div class="flex-1 space-y-6">

            <!-- ========================================== -->
            <!-- TAB 1: TABLEAU DE BORD & ACTU              -->
            <!-- ========================================== -->
            <div id="doc-stats" class="space-y-6 doc-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Bonjour, Dr. Ahmed Alami</h2>
                    <p class="text-xs text-slate-400">Voici l'état d'activité de votre cabinet pour aujourd'hui.</p>
                </div>

                <!-- Petite grille d'indicateurs du jour -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">RDV Confirmés</p>
                        <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">12</h3>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">En Attente</p>
                        <h3 class="text-2xl font-extrabold text-amber-500 mt-1">3</h3>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Annulés</p>
                        <h3 class="text-2xl font-extrabold text-slate-400 mt-1">1</h3>
                    </div>
                </div>

                <!-- Box Note Interne du Cabinet -->
                <div class="bg-gradient-to-r from-emerald-900 to-slate-900 text-white p-6 rounded-2xl shadow-sm">
                    <h4 class="font-bold text-sm">💡 Rappel Système</h4>
                    <p class="text-xs text-slate-300 mt-1 leading-relaxed">Toute consultation terminée génère automatiquement une ordonnance archivée sécurisée consultable par le patient depuis son espace privé.</p>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 2: GESTION DE L'AGENDA (US 2.1 / 2.2)  -->
            <!-- ========================================== -->
            <div id="doc-agenda" class="hidden space-y-6 doc-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Gestion des Demandes de Rendez-vous</h2>
                    <p class="text-xs text-slate-400">Acceptez ou refusez les créneaux demandés par vos patients.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="bg-slate-50 text-[11px] font-bold uppercase text-slate-400 tracking-wider border-b border-slate-100">
                                <th class="p-4">Date & Heure</th>
                                <th class="p-4">Patient</th>
                                <th class="p-4">Statut</th>
                                <th class="p-4 text-right">Actions de l'Agenda</th>
                            </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-100">
                            <!-- Ligne 1 -->
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="p-4 font-bold text-slate-700">Lundi - 09:00</td>
                                <td class="p-4 font-semibold text-slate-900">Khadija Makkaoui</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">En attente</span>
                                </td>
                                <td class="p-4 text-right space-x-1">
                                    <button onclick="alert('Rendez-vous validé ! Statut mis à : CONFIRME');" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">Confirmer</button>
                                    <button onclick="alert('Rendez-vous décliné. Le créneau est à nouveau libre pour les autres patients.');" class="px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">Annuler le RDV</button>
                                </td>
                            </tr>
                            <!-- Ligne 2 -->
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="p-4 font-bold text-slate-700">Mardi - 11:30</td>
                                <td class="p-4 font-semibold text-slate-900">Youssef Nassiri</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Confirmé</span>
                                </td>
                                <td class="p-4 text-right">
                                    <button onclick="switchDoctorTab('doc-consultation');" class="px-3 py-1.5 bg-sky-50 text-sky-700 hover:bg-sky-500 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">🩺 Lancer la consultation</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 3: CONSULTATION & PRESCRIPTIONS (US 2.3)-->
            <!-- ========================================== -->
            <div id="doc-consultation" class="hidden space-y-6 doc-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Consultation en cours</h2>
                    <p class="text-xs text-slate-400">Rédigez l'ordonnance textuelle pour clore le dossier médical du patient.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs max-w-xl space-y-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Patient Sélectionné</p>
                        <h3 class="text-sm font-bold text-slate-900 mt-0.5">Youssef Nassiri (RDV de 11:30)</h3>
                    </div>

                    <form class="space-y-4" onsubmit="event.preventDefault(); alert('Consultation clôturée ! Statut::TERMINÉ enregistré et Ordonnance envoyée au dossier du Patient.'); switchDoctorTab('doc-stats');">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Prescription Médicale (Texte)</label>
                            <textarea rows="5" placeholder="1. Paracétamol 1g - 3 fois par jour pendant 5 jours&#10;2. Repos strict de 48 heures..." class="w-full p-4 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:border-emerald-500 bg-slate-50/40" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3.5 rounded-xl shadow-md shadow-emerald-500/10 cursor-pointer transition-all">
                            💾 Sauvegarder l'ordonnance & Terminer la consultation
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- MOTEUR INTERACTIVE SIDEBAR JS POUR LE MEDECIN -->
    <script>
        function switchDoctorTab(tabId) {
            // 1. Cacher tous les contenus d'onglets
            document.querySelectorAll('.doc-tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // 2. Afficher l'onglet actif
            document.getElementById(tabId).classList.remove('hidden');

            // 3. Réinitialiser les styles de tous les boutons de la Sidebar du médecin
            document.querySelectorAll('.doc-nav-btn').forEach(btn => {
                btn.classList.remove('text-white', 'bg-gradient-to-r', 'from-emerald-500/10', 'to-emerald-500/20', 'border-emerald-500/20', 'shadow-xs', 'font-bold');
                btn.classList.add('text-slate-400', 'font-semibold');
            });

            // 4. Activer le style sur le bouton cliqué
            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('text-slate-400', 'font-semibold');
            activeBtn.classList.add('text-white', 'bg-gradient-to-r', 'from-emerald-500/10', 'to-emerald-500/20', 'border-emerald-500/20', 'shadow-xs', 'font-bold');
        }
    </script>

<?php include __DIR__ . '/../layout/footer.php'; ?>