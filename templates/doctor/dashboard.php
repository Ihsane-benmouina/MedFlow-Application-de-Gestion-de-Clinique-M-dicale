<?php
use App\Helpers\SessionHelper;
use App\Helpers\ViewHelper;

SessionHelper::ensureStarted();

if (!isset($appointments)) {
    $appointments = [];
}

$counts = ViewHelper::countByStatus($appointments);

include __DIR__ . '/../layout/header.php';
?>

    <!-- Container principal avec Sidebar et Zone de Contenu Médecin -->
    <div class="flex flex-col lg:flex-row gap-8 min-h-[calc(100vh-12rem)]">

        <!-- 1. SIDEBAR FIXE (Navigation Espace Praticien) -->
        <aside class="w-full lg:w-64 shrink-0">
            <div class="bg-slate-900 text-slate-400 rounded-2xl p-4 sticky top-24 shadow-xl border border-slate-800 space-y-6">
                <div class="px-3 py-2 border-b border-slate-800/60">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-400">Espace Professionnel</p>
                    <h4 class="text-white font-extrabold text-sm tracking-tight flex items-center gap-2 mt-0.5">
                        🩺 Dr. <?= ViewHelper::escape($_SESSION['user']['nom'] ?? 'Ahmed Alami') ?>
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
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Bonjour, Dr. <?= ViewHelper::escape($_SESSION['user']['nom'] ?? 'Ahmed Alami') ?></h2>
                    <p class="text-xs text-slate-400">Voici l'état d'activité de votre cabinet pour aujourd'hui.</p>
                </div>

                <!-- Petite grille d'indicateurs du jour DYNAMIC -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">RDV Confirmés</p>
                        <h3 class="text-2xl font-extrabold text-emerald-600 mt-1"><?= $counts['confirmed'] ?></h3>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">En Attente</p>
                        <h3 class="text-2xl font-extrabold text-amber-500 mt-1"><?= $counts['pending'] ?></h3>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Annulés</p>
                        <h3 class="text-2xl font-extrabold text-slate-400 mt-1"><?= $counts['cancelled'] ?></h3>
                    </div>
                </div>

                <!-- Box Note Interne du Cabinet -->
                <div class="bg-gradient-to-r from-emerald-900 to-slate-900 text-white p-6 rounded-2xl shadow-sm">
                    <h4 class="font-bold text-sm">💡 Rappel Système</h4>
                    <p class="text-xs text-slate-300 mt-1 leading-relaxed">Toute consultation terminée génère automatiquement une ordonnance archivée sécurisée consultable par le patient depuis son espace privé.</p>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 2: GESTION DE L'AGENDA (DYNAMIC)       -->
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

                            <?php if (empty($appointments)): ?>
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-slate-400 italic">Aucun rendez-vous trouvé dans votre historique.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($appointments as $rdv): ?>
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="p-4 font-bold text-slate-700"><?= date('d/m à H:i', strtotime($rdv['heure_debut'])) ?></td>
                                        <td class="p-4 font-semibold text-slate-900"><?= ViewHelper::escape($rdv['patient_nom'] . ' ' . $rdv['patient_prenom']) ?></td>
                                        <td class="p-4">
                                            <?= ViewHelper::renderStatusBadge($rdv['statut']) ?>
                                        </td>
                                        <td class="p-4 text-right space-x-1">
                                            <?php if ($rdv['statut'] === 'En attente'): ?>
                                                <!-- Action Confirmer -->
                                                <form action="index.php?action=doctor_update_statut" method="POST" class="inline">
                                                    <input type="hidden" name="id_rdv" value="<?= $rdv['id_rdv'] ?>">
                                                    <input type="hidden" name="statut_action" value="Confirmé">
                                                    <button type="submit" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">Confirmer</button>
                                                </form>
                                                <!-- Action Annuler -->
                                                <form action="index.php?action=doctor_update_statut" method="POST" class="inline">
                                                    <input type="hidden" name="id_rdv" value="<?= $rdv['id_rdv'] ?>">
                                                    <input type="hidden" name="statut_action" value="Annulé">
                                                    <button type="submit" onclick="return confirm('Annuler ce rendez-vous ?')" class="px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">Annuler le RDV</button>
                                                </form>
                                            <?php elseif ($rdv['statut'] === 'Confirmé'): ?>
                                                <!-- Lancer la Consultation via l-JS m9ad -->
                                                <button onclick="prepareConsultation(<?= $rdv['id_rdv'] ?>, '<?= ViewHelper::escape($rdv['patient_nom'] . ' ' . $rdv['patient_prenom'] . ' (RDV de ' . date('H:i', strtotime($rdv['heure_debut'])) . ')') ?>')" class="px-3 py-1.5 bg-sky-50 text-sky-700 hover:bg-sky-500 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">🩺 Lancer la consultation</button>
                                            <?php else: ?>
                                                <span class="text-xs text-slate-400 italic">Aucune action</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- TAB 3: CONSULTATION & PRESCRIPTIONS        -->
            <!-- ========================================== -->
            <div id="doc-consultation" class="hidden space-y-6 doc-tab-content">
                <div class="border-b border-slate-200/60 pb-3">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Consultation en cours</h2>
                    <p class="text-xs text-slate-400">Rédigez l'ordonnance textuelle pour clore le dossier médical du patient.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs max-w-xl space-y-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Patient Sélectionné</p>
                        <!-- Nom du patient injecté dynamiquement par JS -->
                        <h3 id="active-patient-display" class="text-sm font-bold text-slate-900 mt-0.5 italic text-slate-400">Aucun patient sélectionné (Sélectionnez un RDV "Confirmé" dans l'agenda)</h3>
                    </div>

                    <form action="index.php?action=finaliser_consultation" method="POST" class="space-y-4">
                        <!-- ID du rdv sélectionné envoyé en POST sécurisé -->
                        <input type="hidden" name="id_rdv" id="input-rdv-id">

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">Diagnostic / Notes Médicales</label>
                            <input type="text" name="diagnostic" required placeholder="Ex: Grippe saisonnière, Fatigue intense" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 bg-slate-50/40 mb-4">

                            <label class="block text-xs font-semibold text-slate-600 mb-2">Prescription Médicale / Ordonnance (Texte)</label>
                            <textarea name="ordonnance" rows="5" placeholder="1. Paracétamol 1g - 3 fois par jour pendant 5 jours&#10;2. Repos strict de 48 heures..." class="w-full p-4 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:border-emerald-500 bg-slate-50/40" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3.5 rounded-xl shadow-md shadow-emerald-500/10 cursor-pointer transition-all">
                            💾 Sauvegarder l'ordonnance & Terminer la consultation
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <?php include __DIR__ . '/../layout/tab-switcher.php'; ?>

    <script>
        function switchDoctorTab(tabId) {
            switchTab(tabId, 'doc-tab-content', 'doc-nav-btn',
                ['text-white', 'bg-gradient-to-r', 'from-emerald-500/10', 'to-emerald-500/20', 'border-emerald-500/20', 'shadow-xs', 'font-bold'],
                ['text-slate-400', 'font-semibold']
            );
        }

        function prepareConsultation(rdvId, patientDetails) {
            document.getElementById('input-rdv-id').value = rdvId;
            document.getElementById('active-patient-display').innerText = "👤 " + patientDetails;
            document.getElementById('active-patient-display').classList.remove('italic', 'text-slate-400');
            switchDoctorTab('doc-consultation');
        }
    </script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
