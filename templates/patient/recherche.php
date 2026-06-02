<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="space-y-10">
    <!-- Hero Box & Barre de Recherche Pure (Section 1) -->
    <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-sky-500/15 via-transparent to-transparent"></div>

        <div class="max-w-xl relative z-10 space-y-4">
            <span class="text-sky-400 text-xs font-bold uppercase tracking-widest bg-sky-500/10 px-3 py-1 rounded-full border border-sky-500/20">Prendre rendez-vous 24h/24</span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">Votre santé, <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-400">uniquement sur RDV.</span></h1>
            <p class="text-slate-400 text-sm sm:text-base font-medium">Recherchez un médecin par son nom pour consulter ses créneaux disponibles.</p>
        </div>

        <!-- Search Bar unique bohdiha -->
        <div class="mt-8 bg-white p-2 rounded-2xl shadow-2xl flex gap-2 relative z-10 border border-slate-200/50 max-w-2xl">
            <div class="flex-1 relative flex items-center">
                <span class="absolute left-4 text-slate-400 text-base">🔍</span>
                <input type="text" id="nameSearch" oninput="filterByName()" placeholder="Nom du médecin (ex: Alami, Benjelloun...)" class="w-full pl-11 pr-4 py-3.5 text-slate-800 rounded-xl focus:outline-none text-sm font-medium placeholder-slate-400">
            </div>
            <button class="bg-sky-500 hover:bg-sky-600 text-white font-bold text-sm px-6 py-3.5 rounded-xl transition-all shadow-lg shadow-sky-500/20 cursor-pointer">
                Trouver
            </button>
        </div>
    </div>

    <!-- Barre Horizontale Scrollable dial les Catégories (Section 2) -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Parcourir par spécialité</h3>
            <span class="text-[11px] text-slate-400 font-medium sm:hidden">Défiler ↔️</span>
        </div>

        <!-- Had l-div hiya l-barre li kat-scrolla Horizontale -->
        <div class="flex items-center gap-3 overflow-x-auto pb-3 scrollbar-none snap-x [-ms-overflow-style:none] [scrollbar-width:none]">

            <!-- Tous -->
            <button onclick="filterSpeciality('all')" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-bold bg-sky-500 text-white shadow-lg shadow-sky-500/20 cursor-pointer transition-all spec-btn" id="btn-all">
                ✨ <span>Tous les médecins</span>
            </button>

            <!-- Cardiologie -->
            <button onclick="filterSpeciality('cardio')" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-700 hover:bg-slate-50 border border-slate-100 hover:border-slate-200 cursor-pointer transition-all spec-btn" id="btn-cardio">
                ❤️ <span>Cardiologie</span>
            </button>

            <!-- Médecine Générale -->
            <button onclick="filterSpeciality('general')" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-700 hover:bg-slate-50 border border-slate-100 hover:border-slate-200 cursor-pointer transition-all spec-btn" id="btn-general">
                🩺 <span>Médecine Générale</span>
            </button>

            <!-- Pédiatrie -->
            <button onclick="filterSpeciality('pedia')" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-700 hover:bg-slate-50 border border-slate-100 hover:border-slate-200 cursor-pointer transition-all spec-btn" id="btn-pedia">
                👶 <span>Pédiatrie</span>
            </button>

            <!-- Ophtalmologie (Optionnelle pour le scroll) -->
            <button onclick="alert('Aucun médecin disponible dans cette spécialité pour le moment.');" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-400 border border-slate-100/70 opacity-60 cursor-pointer transition-all">
                👁️ <span>Ophtalmologie</span>
            </button>

            <!-- Dentiste -->
            <button onclick="alert('Aucun médecin disponible dans cette spécialité pour le moment.');" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-400 border border-slate-100/70 opacity-60 cursor-pointer transition-all">
                🦷 <span>Dentiste</span>
            </button>
        </div>
    </div>

    <!-- Grille des Médecins (Section 3) -->
    <div class="space-y-4">
        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
            <h3 class="text-lg font-bold text-slate-900 tracking-tight">Praticiens correspondants</h3>
            <span class="text-xs font-semibold text-sky-600 bg-sky-50 px-2.5 py-1 rounded-md" id="med-count">3 médecins disponibles</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="doctors-grid">

            <!-- Médecin 1: Cardiologue -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs hover:shadow-md transition-all p-6 flex flex-col justify-between gap-6 doc-card" data-spec="cardio" data-name="ahmed alami">
                <div class="flex justify-between items-start">
                    <div class="flex gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-sky-50 to-sky-100 border border-sky-200/60 text-sky-600 flex items-center justify-center font-extrabold text-xl shadow-inner">Dr</div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base doc-fullname">Dr. Ahmed Alami</h4>
                            <p class="text-xs font-semibold text-sky-600 bg-sky-50 px-2.5 py-0.5 rounded-md mt-1 inline-block">Cardiologue</p>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Créneaux disponibles :</p>
                    <div class="grid grid-cols-3 gap-2">
                        <a href="?action=login" class="py-2.5 text-xs font-bold text-center text-sky-600 bg-sky-50/80 border border-sky-100 hover:bg-sky-500 hover:text-white rounded-xl transition-all shadow-xs">09:00</a>
                        <a href="?action=login" class="py-2.5 text-xs font-bold text-center text-sky-600 bg-sky-50/80 border border-sky-100 hover:bg-sky-500 hover:text-white rounded-xl transition-all shadow-xs">11:30</a>
                    </div>
                </div>
            </div>

            <!-- Médecin 2: Généraliste -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs hover:shadow-md transition-all p-6 flex flex-col justify-between gap-6 doc-card" data-spec="general" data-name="rachid benjelloun">
                <div class="flex justify-between items-start">
                    <div class="flex gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-50 to-indigo-100 border border-indigo-200/60 text-indigo-600 flex items-center justify-center font-extrabold text-xl shadow-inner">Dr</div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base doc-fullname">Dr. Rachid Benjelloun</h4>
                            <p class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-md mt-1 inline-block">Généraliste</p>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Créneaux disponibles :</p>
                    <div class="grid grid-cols-3 gap-2">
                        <a href="?action=login" class="py-2.5 text-xs font-bold text-center text-indigo-600 bg-indigo-50/80 border border-indigo-100 hover:bg-indigo-600 hover:text-white rounded-xl transition-all shadow-xs">14:00</a>
                        <a href="?action=login" class="py-2.5 text-xs font-bold text-center text-indigo-600 bg-indigo-50/80 border border-indigo-100 hover:bg-indigo-600 hover:text-white rounded-xl transition-all shadow-xs">16:30</a>
                    </div>
                </div>
            </div>

            <!-- Médecin 3: Pédiatre -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-xs hover:shadow-md transition-all p-6 flex flex-col justify-between gap-6 doc-card" data-spec="pedia" data-name="sanaa el fassi">
                <div class="flex justify-between items-start">
                    <div class="flex gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-rose-50 to-rose-100 border border-rose-200/60 text-rose-600 flex items-center justify-center font-extrabold text-xl shadow-inner">Dr</div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base doc-fullname">Dr. Sanaa El Fassi</h4>
                            <p class="text-xs font-semibold text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-md mt-1 inline-block">Pédiatre</p>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Créneaux disponibles :</p>
                    <div class="grid grid-cols-3 gap-2">
                        <a href="?action=login" class="py-2.5 text-xs font-bold text-center text-rose-600 bg-rose-50/80 border border-rose-100 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-xs">10:00</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Logique de filtrage combinée (Spécialité + Nom) -->
<script>
    let currentSpeciality = 'all';

    function filterSpeciality(spec) {
        currentSpeciality = spec;

        // Switch active state classes on buttons
        document.querySelectorAll('.spec-btn').forEach(btn => {
            btn.classList.remove('bg-sky-500', 'text-white', 'shadow-lg', 'shadow-sky-500/20', 'font-bold');
            btn.classList.add('bg-white', 'text-slate-700', 'border-slate-100', 'font-semibold');
        });

        const activeBtn = document.getElementById('btn-' + spec);
        activeBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-100', 'font-semibold');
        activeBtn.classList.add('bg-sky-500', 'text-white', 'shadow-lg', 'shadow-sky-500/20', 'font-bold');

        applyFilters();
    }

    function filterByName() {
        applyFilters();
    }

    function applyFilters() {
        const searchVal = document.getElementById('nameSearch').value.toLowerCase().trim();
        let count = 0;

        document.querySelectorAll('.doc-card').forEach(card => {
            const matchesSpec = (currentSpeciality === 'all' || card.getAttribute('data-spec') === currentSpeciality);
            const matchesName = card.getAttribute('data-name').includes(searchVal);

            if (matchesSpec && matchesName) {
                card.classList.remove('hidden');
                count++;
            } else {
                card.classList.add('hidden');
            }
        });

        document.getElementById('med-count').innerText = `${count} médecin(s) disponible(s)`;
    }
</script>