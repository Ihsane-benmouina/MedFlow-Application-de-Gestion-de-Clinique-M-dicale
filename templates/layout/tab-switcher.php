<!-- Shared Tab Switcher Engine -->
<script>
    /**
     * Generic tab switcher for sidebar navigation.
     *
     * @param {string} tabId        - The ID of the tab content div to show.
     * @param {string} contentClass - CSS class shared by all tab content divs (e.g. 'doc-tab-content').
     * @param {string} btnClass     - CSS class shared by all nav buttons (e.g. 'doc-nav-btn').
     * @param {string[]} activeClasses - Classes to add to the active button.
     * @param {string[]} inactiveClasses - Classes to add to inactive buttons.
     */
    function switchTab(tabId, contentClass, btnClass, activeClasses, inactiveClasses) {
        // Hide all tab content
        document.querySelectorAll('.' + contentClass).forEach(function(content) {
            content.classList.add('hidden');
        });

        // Show the selected tab
        document.getElementById(tabId).classList.remove('hidden');

        // Reset all nav buttons to inactive style
        document.querySelectorAll('.' + btnClass).forEach(function(btn) {
            activeClasses.forEach(function(cls) { btn.classList.remove(cls); });
            inactiveClasses.forEach(function(cls) { btn.classList.add(cls); });
        });

        // Activate the clicked button
        var activeBtn = document.getElementById('btn-' + tabId);
        if (activeBtn) {
            inactiveClasses.forEach(function(cls) { activeBtn.classList.remove(cls); });
            activeClasses.forEach(function(cls) { activeBtn.classList.add(cls); });
        }
    }
</script>
