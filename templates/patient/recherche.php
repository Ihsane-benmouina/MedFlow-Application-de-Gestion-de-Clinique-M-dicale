<?php include __DIR__ . '/../layout/header.php';
// require_once __DIR__ .'';
// Sécurité pour éviter les warnings si la page est appelée directement sans le Controller
if (!isset($specialites)) {
    $specialites = [];
}
if (!isset($medecinsList)) {
    $medecinsList = [];
}

$searchQuery = $_GET['search'] ?? '';
$selectedSpecialite = $_GET['specialite'] ?? 'all';
$front = htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? '/index.php');

?>

    <script>
        // Khllina la session dynamic bach JavaScript i-chouf wach l-patient m-connecter déjà
        let isUserLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;
        let selectedSlotInfo = null;
        let currentSpeciality = '<?= isset($_GET['specialite']) ? htmlspecialchars($_GET['specialite']) : 'all' ?>';
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

        <form method="GET" action="<?= $front ?>" class="mt-8 bg-white p-2 rounded-2xl shadow-2xl flex gap-2 relative z-10 border border-slate-200/50 max-w-2xl">
            <input type="hidden" name="action" value="home">
            <input type="hidden" name="specialite" value="all">
            <div class="flex-1 relative flex items-center">
                <span class="absolute left-4 text-slate-400 text-base">🔍</span>
                <input type="text" name="search" value="<?= htmlspecialchars($searchQuery ?? '') ?>" placeholder="Nom du médecin (ex: Alami, Benjelloun...)" class="w-full pl-11 pr-4 py-3.5 text-slate-800 rounded-xl focus:outline-none text-sm font-medium placeholder-slate-400">
            </div>
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs px-6 rounded-xl transition-all cursor-pointer">Trouver</button>
        </form>
    </div>

    <?php if (isset($_SESSION['error_msg'])): ?>
        <div class="bg-rose-50 text-rose-700 text-xs font-semibold px-4 py-2.5 rounded-xl border border-rose-100">
            ⚠️ <?= htmlspecialchars($_SESSION['error_msg']); unset($_SESSION['error_msg']); ?>
        </div>
    <?php endif; ?>

    <div class="space-y-3">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Parcourir par spécialité</h3>
        <div class="flex items-center gap-3 overflow-x-auto pb-3 scrollbar-none snap-x [-ms-overflow-style:none] [scrollbar-width:none]">

                <a href="<?= $front ?>?action=home&specialite=all&search=<?= urlencode($searchQuery ?? '') ?>" id="btn-all" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-bold <?= ($selectedSpecialite ?? 'all') === 'all' ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/20' : 'bg-white text-slate-700 border border-slate-100' ?> cursor-pointer transition-all spec-btn">
                <span>✨ Tous les médecins</span>
            </a>

            <?php foreach ($specialites as $spec): ?>
                <a href="<?= $front ?>?action=home&specialite=<?= urlencode($spec['id']) ?>&search=<?= urlencode($searchQuery ?? '') ?>" class="snap-start shrink-0 inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl text-sm font-semibold <?= (string)($selectedSpecialite ?? 'all') === (string)$spec['id'] ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/20' : 'bg-white text-slate-700 border border-slate-100' ?> cursor-pointer transition-all spec-btn">
                    <span>🩺 <?= htmlspecialchars($spec['name'] ?? $spec['nom'] ?? '') ?></span>
                </a>
            <?php endforeach; ?>
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
            <?php if (empty($medecinsList)): ?>
                <div class="bg-white p-8 rounded-3xl border border-dashed border-slate-200 text-center text-slate-400 text-sm">
                    Aucun médecin trouvé pour cette recherche.
                </div>
            <?php else: ?>
                <?php foreach ($medecinsList as $medecin): ?>
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col lg:flex-row gap-6 items-start doc-card"
                         data-spec="<?= htmlspecialchars($medecin['id_speciality'] ?? '') ?>"
                         data-name="<?= htmlspecialchars(mb_strtolower(($medecin['firstname'] ?? '') . ' ' . ($medecin['lastname'] ?? ''), 'UTF-8')) ?>">

                        <div class="w-full lg:w-2/5 space-y-3">
                            <div class="flex gap-4 items-center">
                                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-extrabold text-base">
                                    Dr
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-slate-900 text-sm">
                                        Dr. <?= htmlspecialchars($medecin['firstname'] ?? '') ?> <?= htmlspecialchars($medecin['lastname'] ?? '') ?>
                                    </h4>
                                    <p class="text-[11px] font-bold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md mt-0.5 inline-block">
                                        <?= htmlspecialchars($medecin['speciality_name'] ?? 'Généraliste') ?>
                                    </p>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 font-medium leading-relaxed">
                                📍 Clinique MedFlow, Maroc <br>
                                💳 Conventionné Secteur 1
                            </p>
                        </div>

                        <div class="w-full lg:w-3/5 border-t lg:border-t-0 lg:border-l border-slate-100 pt-4 lg:pt-0 lg:pl-6">
                            <div class="grid grid-cols-5 gap-2 text-center agenda-grid"
                                 data-doc-id="<?= htmlspecialchars($medecin['id_doctor'] ?? '') ?>"
                                 data-slots='<?= json_encode($medecin["creneaux"] ?? []) ?>'>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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

            <form id="final-booking-form" action="<?= $front ?>?action=reserver_rdv" method="POST" class="hidden">
                <input type="hidden" name="id_medecin" id="submit-doc-id">
                <input type="hidden" name="id_creneau" id="submit-creneau-id">
            </form>

            <div id="modal-login-box" class="space-y-5">
                <div class="text-center"><h3 class="text-lg font-extrabold text-slate-900">Connexion</h3></div>

                <form class="space-y-3.5" action="<?= $front ?>?action=login_submit" method="POST">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                        <input type="email" name="email" placeholder="patient@test.com" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Mot de passe</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium" required>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs py-3.5 rounded-xl cursor-pointer transition-all">🔓 S'identifier & Valider</button>
                </form>
                <p class="text-center text-xs text-slate-400 font-medium">Nouveau patient ? <button onclick="switchModalMode('reg')" class="text-sky-500 font-bold hover:underline">Créer un compte</button></p>
            </div>

            <div id="modal-reg-box" class="hidden space-y-5">
                <div class="text-center"><h3 class="text-lg font-extrabold text-slate-900">Créer mon dossier Patient</h3></div>
                <form class="space-y-3" action="<?= $front ?>?action=register_submit" method="POST">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-0.5">Prénom</label>
                            <input type="text" name="prenom" placeholder="Youssef" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-0.5">Nom</label>
                            <input type="text" name="nom" placeholder="Nassiri" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-0.5">Email</label>
                        <input type="email" name="email" placeholder="youssef@mail.com" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-0.5">Mot de passe</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full p-2.5 border border-slate-200 rounded-xl text-xs" required>
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

        // 1. RENDER DES AGENDAS DYNAMIC AVEC LES VRAIS CRÉNEAUX DE LA BASE DE DONNÉES
        function renderAllAgendas() {
            document.querySelectorAll('.agenda-grid').forEach(grid => {
                grid.innerHTML = '';
                let docId = grid.getAttribute('data-doc-id');

                // Parser les créneaux PHP injectés
                let dbSlots = JSON.parse(grid.getAttribute('data-slots') || '[]');
                let startOffset = currentWeekOffset * 5;

                for (let i = startOffset; i < startOffset + 5; i++) {
                    let d = new Date();
                    d.setDate(d.getDate() + i);

                    let dayName = daysList[d.getDay()];
                    let dayNum = d.getDate();
                    let monthName = monthsList[d.getMonth()];
                    let currentTargetDateStr = d.toISOString().split('T')[0]; // Format YYYY-MM-DD

                    let colHtml = `
                        <div class="space-y-1.5 flex flex-col items-center">
                            <div class="pb-1.5 border-b border-slate-100 w-full text-center mb-1">
                                <p class="text-[11px] font-bold text-slate-900 capitalize">${dayName}</p>
                                <p class="text-[10px] font-bold text-slate-400">${dayNum} ${monthName}</p>
                            </div>
                    `;

                    // Filtrer les créneaux s7a7 de la base de données correspondant à ce jour précis
                    let matchingSlots = dbSlots.filter(slot => slot.start_time.startsWith(currentTargetDateStr));

                    if (matchingSlots.length > 0) {
                        matchingSlots.forEach(slot => {
                            let time = slot.start_time.substring(11, 16); // Extraction de HH:MM
                            colHtml += `
                                <button onclick="handleSlotSelection('${grid.closest('.doc-card').querySelector('h4').innerText}', '${dayName} ${dayNum} ${monthName}', '${time}', '${docId}', '${slot.id}')"
                                        class="w-full py-2 bg-sky-50/70 hover:bg-sky-500 hover:text-white text-sky-600 text-[11px] font-bold rounded-xl transition-all border border-sky-100/40 cursor-pointer">
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

        // 3. SELECTION D'UN CRÉNEAU DYNAMIC
        function handleSlotSelection(docName, dateStr, timeStr, docId, creneauId) {
            selectedSlotInfo = `${dateStr} à ${timeStr} avec ${docName}`;

            // Remplir le formulaire caché de réservation
            document.getElementById('submit-doc-id').value = docId;
            document.getElementById('submit-creneau-id').value = creneauId;

            if (isUserLoggedIn) {
                // Soumettre directement si le patient est identifié
                document.getElementById('final-booking-form').submit();
            } else {
                // Ouvrir le modal d'identification dyalk sinon
                document.getElementById('summary-slot-txt').innerText = `${dateStr} à ${timeStr} (${docName})`;
                document.getElementById('auth-modal-overlay').classList.remove('hidden');
            }
        }

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

        // Démarrage global
        renderAllAgendas();
    </script>

<?php include __DIR__ . '/../layout/footer.php'; ?>