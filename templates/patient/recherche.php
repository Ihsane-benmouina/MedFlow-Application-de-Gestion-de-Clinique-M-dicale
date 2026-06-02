<?php include __DIR__ . '/../layout/header.php'; ?>

    <script>
        let isUserLoggedIn = false;
        let selectedSlotInfo = null;
        let currentSpeciality = 'all';
        // Offset dial l-yamat li affichés f l-planning (0 = 5 jours loulines, 1 = 5 jours tanyine)
        let currentWeekOffset = 0;
    </script>

    <div class="max-w-6xl mx-auto space-y-8 py-6 px-4">

        <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-sky-500/15 via-transparent to-transparent"></div>
            <div class="max-w-xl relative z-10 space-y-4">
                <span class="text-sky-400 text-xs font-bold uppercase tracking-widest bg-sky-500/10 px-3 py-1 rounded-full border border-sky-500/20">Prendre rendez-vous 24h/24</span>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">Votre santé, <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-400">uniquement sur RDV.</span></h1>
                <p class="text-xs text-slate-300 max-w-sm">Recherchez un médecin par son nom pour consulter ses créneaux disponibles.</p>
            </div>

            <div class="mt-8 bg-white p-2 rounded-2xl shadow-2xl flex gap-2 relative z-10 border border-slate-200/50 max-w-2xl">
                <div class="flex-1 relative flex items-center">
                    <span class="absolute left-4 text-slate-400 text-base">🔍</span>
                    <input type="text" id="nameSearch" oninput="applyFilters()" placeholder="Nom du médecin (ex: Alami, Benjelloun...)" class="w-full pl-11 pr-4 py-3.5 text-slate-800 rounded-xl focus:outline-none text-sm font-medium placeholder-slate-400">
                </div>
                <button onclick="applyFilters()" class="bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs px-6 rounded-xl transition-all cursor-pointer">Trouver</button>
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Parcourir par spécialité</h3>
            <div class="flex items-center gap-3 overflow-x-auto pb-3 scrollbar-none snap-x [-ms-overflow-style:none] [scrollbar-width:none]">
                <button onclick="filterSpeciality('all')" id="btn-all" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-bold bg-sky-500 text-white shadow-lg shadow-sky-500/20 cursor-pointer transition-all spec-btn">✨ <span>Tous les médecins</span></button>
                <button onclick="filterSpeciality('cardio')" id="btn-cardio" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-700 border border-slate-100 cursor-pointer transition-all spec-btn">❤️ <span>Cardiologie</span></button>
                <button onclick="filterSpeciality('general')" id="btn-general" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-700 border border-slate-100 cursor-pointer transition-all spec-btn">🩺 <span>Médecine Générale</span></button>
                <button onclick="filterSpeciality('pediatre')" id="btn-pediatre" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold bg-white text-slate-700 border border-slate-100 cursor-pointer transition-all spec-btn">👶 <span>Pédiatrie</span></button>
            </div>
        </div>

        <div class="space-y-6">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="text-base font-extrabold text-slate-900 tracking-tight">Praticiens correspondants</h3>

                <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-xl">
                    <button onclick="navigateAllAgendas('prev')" id="global-prev" class="px-2.5 py-1 text-xs font-bold bg-white rounded-lg shadow-2xs text-slate-700 disabled:opacity-40 cursor-pointer" disabled>◀</button>
                    <span id="global-week-title" class="text-[11px] font-bold text-slate-500 px-1">Semaine 1</span>
                    <button onclick="navigateAllAgendas('next')" id="global-next" class="px-2.5 py-1 text-xs font-bold bg-white rounded-lg shadow-2xs text-slate-700 cursor-pointer">▶</button>
                </div>
            </div>

            <div class="space-y-6" id="doctors-list-container">

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col lg:flex-row gap-6 items-start doc-card" data-spec="cardio" data-name="ahmed alami">
                    <div class="w-full lg:w-2/5 space-y-3">
                        <div class="flex gap-4 items-center">
                            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-extrabold text-base">Dr</div>
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-sm">Dr. Ahmed Alami</h4>
                                <p class="text-[11px] font-bold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md mt-0.5 inline-block">Cardiologue</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">📍 81 Avenue Hassan II, Casablanca<br>💳 Conventionné Secteur 1</p>
                    </div>
                    <div class="w-full lg:w-3/5 border-t lg:border-t-0 lg:border-l border-slate-100 pt-4 lg:pt-0 lg:pl-6">
                        <div class="grid grid-cols-5 gap-2 text-center agenda-grid" data-doc-id="alami"></div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col lg:flex-row gap-6 items-start doc-card" data-spec="general" data-name="rachid benjelloun">
                    <div class="w-full lg:w-2/5 space-y-3">
                        <div class="flex gap-4 items-center">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-extrabold text-base">Dr</div>
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-sm">Dr. Rachid Benjelloun</h4>
                                <p class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md mt-0.5 inline-block">Généraliste</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">📍 14 Rue Allal Ben Abdellah, Rabat<br>💳 Tarif National de Référence</p>
                    </div>
                    <div class="w-full lg:w-3/5 border-t lg:border-t-0 lg:border-l border-slate-100 pt-4 lg:pt-0 lg:pl-6">
                        <div class="grid grid-cols-5 gap-2 text-center agenda-grid" data-doc-id="benjelloun"></div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col lg:flex-row gap-6 items-start doc-card" data-spec="pediatre" data-name="sanaa el fassi">
                    <div class="w-full lg:w-2/5 space-y-3">
                        <div class="flex gap-4 items-center">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-extrabold text-base">Dr</div>
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-sm">Dr. Sanaa El Fassi</h4>
                                <p class="text-[11px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md mt-0.5 inline-block">Pédiatre</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">📍 40 Boulevard Anfa, Casablanca<br>💳 Secteur Privé Externe</p>
                    </div>
                    <div class="w-full lg:w-3/5 border-t lg:border-t-0 lg:border-l border-slate-100 pt-4 lg:pt-0 lg:pl-6">
                        <div class="grid grid-cols-5 gap-2 text-center agenda-grid" data-doc-id="elfassi"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="auth-modal-overlay" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-100 relative max-h-[90vh] overflow-y-auto">

            <div class="bg-sky-50 border border-sky-100 rounded-2xl p-4 text-center mb-6">
                <p class="text-[10px] font-bold text-sky-600 uppercase tracking-widest">Créneau Sélectionné</p>
                <h4 class="text-sm font-extrabold text-slate-900 mt-0.5" id="summary-slot-txt">Mardi 9 Juin à 08:30</h4>
                <p class="text-xs text-slate-400 font-medium">Validation requise pour bloquer le rendez-vous</p>
            </div>

            <div id="modal-login-box" class="space-y-5">
                <div class="text-center"><h3 class="text-lg font-extrabold text-slate-900">Connexion</h3></div>
                <form class="space-y-3.5" onsubmit="event.preventDefault(); triggerSuccessAuth();">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                        <input type="email" placeholder="patient@test.com" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Mot de passe</label>
                        <input type="password" placeholder="••••••••" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium" required>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs py-3.5 rounded-xl cursor-pointer transition-all">🔓 S'identifier & Valider</button>
                </form>
                <p class="text-center text-xs text-slate-400 font-medium">Nouveau patient ? <button onclick="switchModalMode('reg')" class="text-sky-500 font-bold hover:underline">Créer un compte</button></p>
            </div>

            <div id="modal-reg-box" class="hidden space-y-5">
                <div class="text-center"><h3 class="text-lg font-extrabold text-slate-900">Créer mon dossier Patient</h3></div>
                <form class="space-y-3" onsubmit="event.preventDefault(); triggerSuccessAuth();">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-0.5">Prénom</label>
                            <input type="text" placeholder="Youssef" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-0.5">Nom</label>
                            <input type="text" placeholder="Nassiri" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-0.5">Email</label>
                        <input type="email" placeholder="youssef@mail.com" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-0.5">Téléphone (ERD Row)</label>
                        <input type="tel" placeholder="0600000000" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-0.5">Mot de passe</label>
                        <input type="password" placeholder="••••••••" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
                    </div>
                    <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs py-3.5 rounded-xl cursor-pointer transition-all mt-2">✨ S'inscrire & Réserver</button>
                </form>
                <p class="text-center text-xs text-slate-400 font-medium">Déjà inscrit ? <button onclick="switchModalMode('login')" class="text-sky-500 font-bold hover:underline">Se connecter</button></p>
            </div>

            <button onclick="closeAuthModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-sm cursor-pointer">✕</button>
        </div>
    </div>


    <script>
        const daysList = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
        const monthsList = ['janv.', 'févr.', 'mars', 'avril', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];

        // 1. RENDER DES AGENDAS DOCTOLIB POUR TOUTES LES CARDS
        function renderAllAgendas() {
            document.querySelectorAll('.agenda-grid').forEach(grid => {
                grid.innerHTML = '';
                let docId = grid.getAttribute('data-doc-id');
                let startOffset = currentWeekOffset * 5;

                for (let i = startOffset; i < startOffset + 5; i++) {
                    let d = new Date();
                    d.setDate(d.getDate() + i);

                    let dayName = daysList[d.getDay()];
                    let dayNum = d.getDate();
                    let monthName = monthsList[d.getMonth()];

                    let colHtml = `
                <div class="space-y-1.5 flex flex-col items-center">
                    <div class="pb-1.5 border-b border-slate-100 w-full text-center mb-1">
                        <p class="text-[11px] font-bold text-slate-900 capitalize">${dayName}</p>
                        <p class="text-[10px] font-bold text-slate-400">${dayNum} ${monthName}</p>
                    </div>
            `;

                    // Faux dispatching des heures selon le médecin pour faire réaliste
                    let slots = [];
                    if (docId === 'alami' && i % 2 === 0) slots = ["09:00", "11:30"];
                    if (docId === 'benjelloun' && i % 3 === 0) slots = ["14:00", "16:30"];
                    if (docId === 'elfassi' && i % 2 !== 0) slots = ["08:30", "10:00", "15:10"];

                    if (slots.length > 0) {
                        slots.forEach(time => {
                            colHtml += `
                        <button onclick="handleSlotSelection('${grid.closest('.doc-card').querySelector('h4').innerText}', '${dayName} ${dayNum} ${monthName}', '${time}')" class="w-full py-2 bg-sky-50/70 hover:bg-sky-500 hover:text-white text-sky-600 text-[11px] font-bold rounded-xl transition-all border border-sky-100/40 cursor-pointer">
                            ${time}
                        </button>
                    `;
                        });
                    } else {
                        colHtml += `<span class="text-slate-300 text-xs py-2 block">—</span>`;
                    }

                    colHtml += `</div>`;
                    grid.innerHTML += colHtml;
                }
            });
        }

        // 2. NAVIGUER DANS LE TEMPS (MAX 2 SEMAINES)
        function navigateAllAgendas(direction) {
            if (direction === 'next' && currentWeekOffset === 0) {
                currentWeekOffset = 1;
                document.getElementById('global-prev').removeAttribute('disabled');
                document.getElementById('global-next').setAttribute('disabled', 'true');
                document.getElementById('global-week-title').innerText = "Semaine 2";
            } else if (direction === 'prev' && currentWeekOffset === 1) {
                currentWeekOffset = 0;
                document.getElementById('global-next').removeAttribute('disabled');
                document.getElementById('global-prev').setAttribute('disabled', 'true');
                document.getElementById('global-week-title').innerText = "Semaine 1";
            }
            renderAllAgendas();
        }

        // 3. ACTION AU CLIC SUR UNE HEURE
        function handleSlotSelection(docName, dateStr, timeStr) {
            selectedSlotInfo = `${dateStr} à ${timeStr} avec ${docName}`;

            if (isUserLoggedIn) {
                alert(`Félicitations! Votre rendez-vous est bloqué pour le : ${selectedSlotInfo}.`);
                window.location.href = "?action=patient_dashboard";
            } else {
                document.getElementById('summary-slot-txt').innerText = `${dateStr} à ${timeStr} (${docName})`;
                document.getElementById('auth-modal-overlay').classList.remove('hidden');
            }
        }

        // 4. MOTEUR DE FILTRAGE COMBINÉ (RECHERCHE + SPÉCIALITÉ)
        function filterSpeciality(spec) {
            currentSpeciality = spec;
            document.querySelectorAll('.spec-btn').forEach(btn => {
                btn.classList.remove('bg-sky-500', 'text-white', 'shadow-lg', 'shadow-sky-500/20', 'font-bold');
                btn.classList.add('bg-white', 'text-slate-700', 'border-slate-100', 'font-semibold');
            });
            document.getElementById('btn-' + spec).classList.remove('bg-white', 'text-slate-700', 'border-slate-100', 'font-semibold');
            document.getElementById('btn-' + spec).classList.add('bg-sky-500', 'text-white', 'shadow-lg', 'shadow-sky-500/20', 'font-bold');
            applyFilters();
        }

        function applyFilters() {
            const searchVal = document.getElementById('nameSearch').value.toLowerCase().trim();

            document.querySelectorAll('.doc-card').forEach(card => {
                const matchesSpec = (currentSpeciality === 'all' || card.getAttribute('data-spec') === currentSpeciality);
                const matchesName = card.getAttribute('data-name').includes(searchVal);

                if (matchesSpec && matchesName) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        // Modal Helpers
        function switchModalMode(mode) {
            if (mode === 'reg') {
                document.getElementById('modal-login-box').classList.add('hidden');
                document.getElementById('modal-reg-box').classList.remove('hidden');
            } else {
                document.getElementById('modal-reg-box').classList.add('hidden');
                document.getElementById('modal-login-box').classList.remove('hidden');
            }
        }
        function closeAuthModal() { document.getElementById('auth-modal-overlay').classList.add('hidden'); }

        function triggerSuccessAuth() {
            closeAuthModal();
            alert(`Identification réussie ! Le rendez-vous [${selectedSlotInfo}] a été inséré avec succès dans votre espace Patient.`);
            isUserLoggedIn = true;
            window.location.href = "?action=patient_appointments";
        }

        // Lancement au chargement global
        renderAllAgendas();
    </script>

<?php include __DIR__ . '/../layout/footer.php'; ?>