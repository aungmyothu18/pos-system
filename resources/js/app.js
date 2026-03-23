import './bootstrap';

// Global dark mode handling
(function () {
    const THEME_KEY = 'theme';

    function applyTheme(isDark) {
        const root = document.documentElement;

        if (isDark) {
            root.classList.add('dark');
            localStorage.setItem(THEME_KEY, 'dark');
        } else {
            root.classList.remove('dark');
            localStorage.setItem(THEME_KEY, 'light');
        }

        document.querySelectorAll('.dark-mode-icon-dark').forEach(el => {
            el.classList.toggle('hidden', !isDark);
        });

        document.querySelectorAll('.dark-mode-icon-light').forEach(el => {
            el.classList.toggle('hidden', isDark);
        });
    }

    // Expose for inline `onclick="toggleDarkMode()"`
    window.toggleDarkMode = function () {
        const isDark = document.documentElement.classList.contains('dark');
        applyTheme(!isDark);
    };

    function initDarkMode() {
        try {
            const stored = localStorage.getItem(THEME_KEY);
            const prefersDark = window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches;

            const shouldUseDark = stored
                ? stored === 'dark'
                : prefersDark;

            applyTheme(shouldUseDark);
        } catch {
            // Fallback without localStorage/media query
            applyTheme(false);
        }

        const themeToggleButton = document.getElementById('theme-toggle');
        if (themeToggleButton) {
            themeToggleButton.addEventListener('click', event => {
                event.preventDefault();
                window.toggleDarkMode();
            });
        }
    }

    function initSidebar() {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('sidebar-open');
        const closeBtn = document.getElementById('sidebar-close');

        if (!sidebar || !openBtn) {
            return;
        }

        const openSidebar = event => {
            if (event) event.preventDefault();
            sidebar.classList.remove('-translate-x-full');
        };

        const closeSidebar = event => {
            if (event) event.preventDefault();
            sidebar.classList.add('-translate-x-full');
        };

        openBtn.addEventListener('click', openSidebar);

        if (closeBtn) {
            closeBtn.addEventListener('click', closeSidebar);
        }
    }

    // Jewelry receive page logic (front-end only)
    const jewelryItems = [];

    window.saveJewelry = function () {
        const customerNameInput = document.getElementById('customerName');
        const jewelryTypeSelect = document.getElementById('jewelryType');
        const kyatInput = document.getElementById('kyat');
        const pelInput = document.getElementById('pel');
        const ywayInput = document.getElementById('yway');
        const pointInput = document.getElementById('point');
        const colorSelect = document.getElementById('color');
        const statusSelect = document.getElementById('status');

        if (!customerNameInput || !jewelryTypeSelect) {
            return;
        }

        const customerName = customerNameInput.value.trim();
        const type = jewelryTypeSelect.value;

        if (!customerName) {
            alert('Please enter customer name.');
            return;
        }

        const kyat = kyatInput && kyatInput.value ? Number(kyatInput.value) : 0;
        const pel = pelInput && pelInput.value ? Number(pelInput.value) : 0;
        const yway = ywayInput && ywayInput.value ? Number(ywayInput.value) : 0;
        const point = pointInput && pointInput.value ? Number(pointInput.value) : 0;

        const weightParts = [];
        if (kyat) weightParts.push(`${kyat} ကျပ်`);
        if (pel) weightParts.push(`${pel} ပဲ`);
        if (yway) weightParts.push(`${yway} ရွေး`);
        if (point) weightParts.push(`${point} ပွိုင့်`);

        const weight = weightParts.length ? weightParts.join(' ') : '-';

        const color = colorSelect ? colorSelect.value : '';
        const status = statusSelect ? statusSelect.value : '';

        jewelryItems.push({
            customerName,
            type,
            weight,
            color,
            status,
        });

    };

    window.printReceiveSlip = function () {
        window.print();
    };

    document.addEventListener('DOMContentLoaded', () => {
        initDarkMode();
        initSidebar();
    });
})();

