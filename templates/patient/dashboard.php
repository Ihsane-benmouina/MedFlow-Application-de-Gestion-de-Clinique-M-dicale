<?php include __DIR__ . '/../layout/header.php'; ?>

    <!-- Container principal avec Sidebar et Zone de Contenu Patient -->
    <div class="flex flex-col lg:flex-row gap-8 min-h-[calc(100vh-12rem)]">

        <!-- 1. SIDEBAR FIXE (Navigation Espace Patient) -->
        <aside class="w-full lg:w-64 shrink-0">
            <div class="bg-slate-900 text-slate-400 rounded-2xl p-4 sticky top-24 shadow-xl border border-slate-800 space-y-6">
                <div class="px-3 py-2 border-b border-slate-800/60">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-sky-400">Espace Personnel</p>
                    <h4 class="text-white font-extrabold text-sm tracking-tight flex items-center gap-2 mt-0.5">
                        👤 Youssef Nassiri
                    </h4>
                </div>

                <!-- Liens de navigation du Patient -->
                <nav class="space-y-1">
                    <button onclick="switchPatientTab('pat-book')" id="btn-pat-book" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-bold transition-all text-white bg-gradient-to-r from-sky-500/10 to-sky-500/20 border border-sky-500/20 shadow-xs cursor-pointer pat-nav-btn">
                        🔍 Prendre un Rendez-vous
                    </button>

                    <button onclick="switchPatientTab('pat-appointments')" id="btn-pat-appointments" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-semibold transition-all hover:bg-slate-800/50 hover:text-white cursor-pointer pat-nav-btn">
                        📅 Mes Rendez-vous
                    </button>

                    <button onclick="switchPatientTab('pat-records')" id="btn-pat-records" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-xs font-semibold transition-all hover:bg-slate-800/50 hover:text-white cursor-pointer pat-nav-btn">
                        📁 Mon Dossier (Ordonnances)
                    </button>
                </nav>
            </div>
        </aside>

        <!-- 2. MAIN CONTENT (Zone d'affichage dynamique gérée par la Sidebar) -->
        <div class="flex-1 space-y-6">

            <!-- ========================================== -->
            <!-- TAB 1: RECHERCHE & RESERVATION             -->
            <!-- ========================================== -->
            <div id="pat-book" class="space-y-6 pat-tab-content">
                <!-- Hero Box avec Search Bar unique -->
                <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-sky-500/15 via-transparent to-transparent"></div>
                    <div class="max-w-xl relative z-10 space-y-4">
                        <span class="text-sky-400 text-xs font-bold uppercase tracking-widest bg-sky-500/10 px-3 py-1 rounded-full border border-sky-500/20">Prendre rendez-vous 24h/24</span>
                        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">Votre santé, <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-400">uniquement sur RDV.</span></h1>
                    </div>

                    <!-- Search Bar -->
                    <div class="mt-8 bg-white p-2 rounded-2xl shadow-2xl flex gap-2 relative z-10 border border-slate-200/50 max-w-2xl">
                        <div class="flex-1 relative flex items-center">
                            <span class="absolute left-4 text-slate-400 text-base">🔍</span>
                            <input type="text" id="nameSearch" oninput="filterByName()" placeholder="Nom du médecin (ex: Alami...)" class="w-full pl-11 pr-4 py-3.5 text-slate-800 rounded-xl focus:outline-none text-sm font-medium placeholder-slate-400">
                        </div>
                    </div>
                </div>

                <!-- Barre Horizontale Scrollable des Catégories -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Parcourir par spécialité</h3>
                        <span class="text-[11px] text-slate-400 font-medium sm:hidden">Défiler ↔️</span>
                    </div>
                    <div class="flex items-center gap-3 overflow-x-auto pb-3 scrollbar-none snap-x [-ms-overflow-style:none] [scrollbar-width:none]">
                        <button onclick="filterSpeciality('all')" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-bold bg-sky-500 text-white shadow-lg shadow-sky-500/20 cursor-pointer transition-all spec-btn" id="btn-all"> ✨ <span>Tous</span></button>
                        <button onclick="filterSpeciality('cardio')" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-700 border border-slate-100 cursor-pointer transition-all spec-btn" id="btn-cardio"> ❤️ <span>Cardiologie</span></button>
                        <button onclick="filterSpeciality('general')" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-700 border border-slate-100 cursor-pointer transition-all spec-btn" id="btn-general"> 🩺 <span>Médecine Générale</span></button>
                    </div>
                </div>

                <!-- Grille de réservation des Médecins -->
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight border-b border-slate-100 pb-2">Praticiens disponibles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="doctors-grid">
                        <!-- Dr Alami -->
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 flex flex-col justify-between gap-6 doc-card" data-spec="cardio" data-name="ahmed alami">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-extrabold text-lg">Dr</div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Dr. Ahmed Alami</h4>
                                    <p class="text-xs font-semibold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md mt-1 inline-block">Cardiologue</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Choisir un créneau :</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button onclick="alert('Demande de RDV envoyée pour Lundi à 09:00 ! En attente de validation du médecin.'); switchPatientTab('pat-appointments');" class="py-2.5 text-xs font-bold text-center text-sky-600 bg-sky-50/80 border border-sky-100 hover:bg-sky-500 hover:text-white rounded-xl transition-all cursor-pointer">Lundi 09:00</button>
                                    <button onclick="alert('Demande de RDV envoyée pour Mardi à 11:30 ! En attente de validation du médecin.'); switchPatientTab('pat-appointments');" class="py-2.5 text-xs font-bold text-center text-sky-600 bg-sky-50/80 border border-sky-100 hover:bg-sky-500 hover:text-white rounded-xl transition-all cursor-pointer">Mardi 11:30</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 2: MES RENDEZ-VOUS                     -->
            <!-- ========================================== -->
            <div id="pat-appointments" class="hidden space-y-6 pat-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Mes Consultations & Demandes</h2>
                    <p class="text-xs text-slate-400">Suivez l'historique et le statut de vos rendez-vous.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="bg-slate-50 text-[11px] font-bold uppercase text-slate-400 tracking-wider border-b border-slate-100">
                            <th class="p-4">Médecin</th>
                            <th class="p-4">Date & Heure</th>
                            <th class="p-4">Statut</th>
                        </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100">
                        <tr>
                            <td class="p-4 font-bold text-slate-900">Dr. Ahmed Alami</td>
                            <td class="p-4 text-slate-600 font-medium">Mardi 2 Juin - 11:30</td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Confirmé</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 3: DOSSIER MÉDICAL / ORDONNANCES       -->
            <!-- ========================================== -->
            <div id="pat-records" class="hidden space-y-6 pat-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Mon Dossier Médical Numérique</h2>
                    <p class="text-xs text-slate-400">Consultez en toute sécurité les ordonnances délivrées par vos praticiens.</p>
                </div>

                <!-- Carte Ordonnance -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs max-w-xl space-y-4">
                    <div class="flex justify-between items-start border-b border-slate-100 pb-3">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Ordonnance Émise</h4>
                            <p class="text-xs text-slate-400">Par: <span class="font-semibold text-slate-700">Dr. Ahmed Alami</span></p>
                        </div>
                        <span class="text-xs bg-slate-100 px-2.5 py-1 rounded-md text-slate-600 font-medium">Reçue aujourd'hui</span>
                    </div>

                    <!-- Zone de texte de l'ordonnance rédigée par le doc -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100/70 font-mono text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                        1. Paracétamol 1g - 3 fois par jour pendant 5 jours.
                        2. Repos strict de 48 heures.
                    </div>

                    <div class="flex justify-end">
                        <button onclick="window.print();" class="text-xs font-bold text-sky-600 hover:text-sky-700 flex items-center gap-1 cursor-pointer">
                            🖨️ Imprimer ou Télécharger PDF
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- MOTEUR INTERACTIVE SIDEBAR JS POUR LE PATIENT -->
    <script>
        function switchPatientTab(tabId) {
            document.querySelectorAll('.pat-tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(tabId).classList.remove('hidden');

            document.querySelectorAll('.pat-nav-btn').forEach(btn => {
                btn.classList.remove('text-white', 'bg-gradient-to-r', 'from-sky-500/10', 'to-sky-500/20', 'border-sky-500/20', 'shadow-xs', 'font-bold');
                btn.classList.add('text-slate-400', 'font-semibold');
            });

            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('text-slate-400', 'font-semibold');
            activeBtn.classList.add('text-white', 'bg-gradient-to-r', 'from-sky-500/10', 'to-sky-500/20', 'border-sky-500/20', 'shadow-xs', 'font-bold');
        }

        // Moteur de recherche et filtrage des catégories (Copie conforme)
        let currentSpeciality = 'all';

        function filterSpeciality(spec) {
            currentSpeciality = spec;
            document.querySelectorAll('.spec-btn').forEach(btn => {
                btn.classList.remove('bg-sky-500', 'text-white', 'shadow-lg', 'shadow-sky-500/20', 'font-bold');
                btn.classList.add('bg-white', 'text-slate-700', 'border-slate-100', 'font-semibold');
            });
            const activeBtn = document.getElementById('btn-' + spec);
            activeBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-100', 'font-semibold');
            activeBtn.classList.add('bg-sky-500', 'text-white', 'shadow-lg', 'shadow-sky-500/20', 'font-bold');
            applyFilters();
        }

        function filterByName() { applyFilters(); }

        function applyFilters() {
            const searchVal = document.getElementById('nameSearch').value.toLowerCase().trim();
            document.querySelectorAll('.doc-card').forEach(card => {
                const matchesSpec = (currentSpeciality === 'all' || card.getAttribute('data-spec') === currentSpeciality);
                const matchesName = card.getAttribute('data-name').includes(searchVal);
                if (matchesSpec && matchesName) { card.classList.remove('hidden'); } else { card.classList.add('hidden'); }
            });
        }
    </script>

<?php include __DIR__ . '/../layout/footer.php'; ?>