import Sortable from 'sortablejs';

const FA_ICONS = [
    "fas fa-code", "fab fa-java", "fab fa-python", "fab fa-node", "fab fa-php", "fab fa-js", "fab fa-react", "fab fa-vuejs", "fab fa-angular", "fab fa-laravel", "fab fa-html5", "fab fa-css3-alt", "fab fa-sass", "fab fa-git-alt", "fab fa-github", "fab fa-bitbucket", "fab fa-docker",
    "fas fa-server", "fas fa-cloud", "fab fa-aws", "fab fa-microsoft", "fab fa-google", "fas fa-database", "fas fa-cubes", "fas fa-microchip", "fas fa-network-wired", "fas fa-terminal", "fas fa-hdd", "fas fa-laptop-code",
    "fas fa-cogs", "fas fa-cog", "fas fa-tools", "fas fa-tasks", "fas fa-chart-line", "fas fa-chart-pie", "fas fa-chart-bar", "fas fa-clipboard-list", "fas fa-vial", "fas fa-check-circle", "fas fa-bug", "fas fa-rocket", "fas fa-shield-alt", "fas fa-lock", "fas fa-key",
    "fas fa-envelope", "fas fa-phone-alt", "fab fa-whatsapp", "fab fa-linkedin", "fab fa-twitter", "fab fa-telegram", "fas fa-globe", "fas fa-map-marker-alt", "fas fa-paper-plane", "fas fa-user", "fas fa-briefcase", "fas fa-building", "fas fa-graduation-cap", "fas fa-award", "fas fa-certificate", "fas fa-university", "fas fa-heart", "fas fa-star"
];

document.addEventListener('DOMContentLoaded', () => {
    // 1. Control del Sidebar Móvil y Desktop
    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    const backdrop = document.getElementById('sidebarBackdrop');

    if (window.innerWidth > 768) {
        const savedState = localStorage.getItem('adminSidebarState');
        if (savedState === 'collapsed') {
            document.body.classList.add('sidebar-collapsed');
        }
    }

    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('mobile-open');
            backdrop.classList.toggle('active');
        } else {
            document.body.classList.toggle('sidebar-collapsed');
            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
            localStorage.setItem('adminSidebarState', isCollapsed ? 'collapsed' : 'expanded');
        }
    }

    function closeMobileSidebar() {
        sidebar.classList.remove('mobile-open');
        backdrop.classList.remove('active');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebar();
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeMobileSidebar);
    }

    document.querySelectorAll('.sidebar-menu a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                closeMobileSidebar();
            }
        });
    });

    // 2. SortableJS Drag-and-Drop
    const sortables = document.querySelectorAll('.sortable-list');
    sortables.forEach(list => {
        const model = list.dataset.model;
        if (!model) return;

        Sortable.create(list, {
            animation: 150,
            handle: '.handle',
            ghostClass: 'sortable-ghost',
            onEnd: function () {
                const items = [];
                list.querySelectorAll(':scope > .sortable-item').forEach((el, index) => {
                    items.push({
                        id: el.dataset.id,
                        sort_order: index + 1
                    });
                });

                fetch(`/admin/reorder/${model}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ items })
                })
                .then(res => res.json())
                .catch(err => console.error('Error al ordenar:', err));
            }
        });
    });

    // 3. Icon Picker con Búsqueda en tiempo real
    document.querySelectorAll('.icon-picker-wrapper').forEach(wrapper => {
        const input = wrapper.querySelector('.icon-value-input');
        const preview = wrapper.querySelector('.icon-preview-box i');
        const dropdown = wrapper.querySelector('.icon-dropdown');
        const searchInput = wrapper.querySelector('.icon-search-input');
        const resultsContainer = wrapper.querySelector('.icon-grid-results');

        function renderIcons(filter = '') {
            resultsContainer.innerHTML = '';
            const filtered = FA_ICONS.filter(icon => icon.toLowerCase().includes(filter.toLowerCase()));
            filtered.forEach(iconClass => {
                const div = document.createElement('div');
                div.className = 'icon-option';
                div.title = iconClass;
                div.innerHTML = `<i class="${iconClass}"></i>`;
                div.addEventListener('click', () => {
                    input.value = iconClass;
                    preview.className = iconClass;
                    dropdown.classList.remove('active');
                });
                resultsContainer.appendChild(div);
            });
        }

        renderIcons();

        input.addEventListener('focus', () => {
            document.querySelectorAll('.icon-dropdown').forEach(d => d.classList.remove('active'));
            dropdown.classList.add('active');
            searchInput.focus();
        });

        searchInput.addEventListener('input', (e) => {
            renderIcons(e.target.value);
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    });

    // 4. Sincronización del Color Picker
    document.querySelectorAll('.color-picker-group').forEach(group => {
        const colorInput = group.querySelector('input[type="color"]');
        const textInput = group.querySelector('.color-text-input');

        colorInput.addEventListener('input', (e) => {
            textInput.value = e.target.value;
        });
        textInput.addEventListener('input', (e) => {
            if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
                colorInput.value = e.target.value;
            }
        });
    });

    // 5. Modales
    window.openModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('active');
    };

    window.closeModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('active');
    };

    // 6. Portapapeles Media
    window.copyMediaUrl = function (url) {
        navigator.clipboard.writeText(url).then(() => {
            alert('URL copiada al portapapeles: ' + url);
        });
    };
});