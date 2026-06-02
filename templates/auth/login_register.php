<?php include __DIR__ . '/../layout/header.php'; ?>

    <div class="min-h-[calc(100vh-14rem)] flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-3xl border border-slate-100 shadow-xl relative overflow-hidden">

            <!-- Decoration background blur minimal -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-sky-500/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>

            <!-- ========================================== -->
            <!-- FORMULAIRE 1: CONNEXION (LOGIN)            -->
            <!-- ========================================== -->
            <div id="login-form-box" class="space-y-6">
                <div class="text-center">
                    <span class="text-sky-500 text-2xl">🔐</span>
                    <h2 class="mt-2 text-2xl font-extrabold text-slate-900 tracking-tight">Connexion à votre espace</h2>
                    <p class="mt-1.5 text-xs text-slate-400 font-medium">Saisissez vos identifiants pour accéder à votre tableau de bord.</p>
                </div>

                <!-- Simulation backend redirection pour tester les 3 rôles -->
                <form class="mt-8 space-y-4" onsubmit="event.preventDefault(); handleSimulationLogin();">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Adresse Email</label>
                        <input type="email" id="login-email" placeholder="nom@exemple.com" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-xs font-semibold text-slate-600">Mot de passe</label>
                            <a href="#" class="text-[11px] font-bold text-sky-500 hover:underline">Oublié ?</a>
                        </div>
                        <input type="password" id="login-password" placeholder="••••••••" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                    </div>



                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs py-3.5 rounded-xl cursor-pointer transition-all shadow-xs mt-2">
                        🔓 Se connecter
                    </button>
                </form>

                <div class="text-center pt-2 border-t border-slate-100">
                    <p class="text-xs text-slate-400 font-medium">
                        Nouveau sur notre plateforme ?
                        <button onclick="toggleAuthMode('register')" class="text-sky-500 font-bold hover:underline cursor-pointer ml-1">Créer un compte patient</button>
                    </p>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- FORMULAIRE 2: INSCRIPTION PATIENT (REG)     -->
            <!-- ========================================== -->
            <div id="register-form-box" class="hidden space-y-6">
                <div class="text-center">
                    <span class="text-sky-500 text-2xl">🚀</span>
                    <h2 class="mt-2 text-2xl font-extrabold text-slate-900 tracking-tight">Inscription Patient</h2>
                    <p class="mt-1.5 text-xs text-slate-400 font-medium">Créez votre compte en quelques secondes pour réserver un créneau.</p>
                </div>

                <!-- Champs calqués 3la l-ERD users table -->
                <form class="mt-6 space-y-3.5" onsubmit="event.preventDefault(); alert('Compte Patient enregistré avec succès ! Connectez-vous maintenant.'); toggleAuthMode('login');">

                    <!-- Groupement Nom & Prénom (Firstname / Lastname) -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Prénom</label>
                            <input type="text" placeholder="Youssef" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Nom</label>
                            <input type="text" placeholder="Nassiri" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Adresse Email</label>
                        <input type="email" placeholder="youssef.nassiri@mail.com" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                    </div>

                    <!-- Phone (champs men l-ERD) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Numéro de Téléphone</label>
                        <input type="tel" placeholder="+212 600-000000" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Mot de passe sécurisé</label>
                        <input type="password" placeholder="••••••••" class="w-full p-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 font-medium bg-slate-50/40" required>
                    </div>

                    <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs py-3.5 rounded-xl cursor-pointer transition-all shadow-md shadow-sky-500/10 mt-2">
                        ✨ Finaliser mon inscription
                    </button>
                </form>

                <div class="text-center pt-2 border-t border-slate-100">
                    <p class="text-xs text-slate-400 font-medium">
                        Vous avez déjà un compte ?
                        <button onclick="toggleAuthMode('login')" class="text-sky-500 font-bold hover:underline cursor-pointer ml-1">S'identifier ici</button>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- GESTION DE L'INTERACTION UI & ROUTING PAR ROLE -->
    <script>
        // Switcher bin Login o Inscription smooth bl-JS
        function toggleAuthMode(mode) {
            if(mode === 'register') {
                document.getElementById('login-form-box').classList.add('hidden');
                document.getElementById('register-form-box').classList.remove('hidden');
            } else {
                document.getElementById('register-form-box').classList.add('hidden');
                document.getElementById('login-form-box').classList.remove('hidden');
            }
        }

        // Simulation dial l-backend Router 3la hssab role (Enum)
        function handleSimulationLogin() {
            const email = document.getElementById('login-email').value.toLowerCase().trim();

            if (email === 'admin@test.com') {
                alert('Accès accordé: Rôle [ADMIN] détecté dans la base users. Redirection...');
                window.location.href = '?action=admin_dashboard';
            } else if (email === 'doctor@test.com') {
                alert('Accès accordé: Rôle [DOCTOR] détecté avec spécialité. Redirection...');
                window.location.href = '?action=doctor_dashboard';
            } else {
                alert('Accès accordé: Rôle [PATIENT] détecté. Redirection vers l\'espace de réservation...');
                window.location.href = '?action=patient_dashboard';
            }
        }
    </script>

<?php include __DIR__ . '/../layout/footer.php'; ?>