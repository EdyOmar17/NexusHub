document.addEventListener('DOMContentLoaded', () => {
    // Utility for safely adding listeners
    const safeAddListener = (id, event, callback) => {
        const el = document.getElementById(id);
        if (el) el.addEventListener(event, callback);
        return el;
    };

    // --- MOBILE SIDEBAR TOGGLE ---
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const btnMenuToggle = document.getElementById('btn-menu-toggle');

    const openSidebar = () => {
        if (sidebar) sidebar.classList.add('open');
        if (sidebarOverlay) sidebarOverlay.classList.add('active');
    };

    const closeSidebar = () => {
        if (sidebar) sidebar.classList.remove('open');
        if (sidebarOverlay) sidebarOverlay.classList.remove('active');
    };

    if (btnMenuToggle) btnMenuToggle.addEventListener('click', openSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

    // Close sidebar when clicking a nav link on mobile
    document.querySelectorAll('.sidebar .nav-link, .sidebar .logout-btn').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });

    // Initialize Elements
    const websiteContainer = document.getElementById('website-container');
    const siteSearch = document.getElementById('site-search');
    const navLinks = document.querySelectorAll('.nav-link');
    const serverCards = document.querySelectorAll('.server-card');
    
    const modal = document.getElementById('website-modal');
    const modalTitle = document.getElementById('modal-title');
    const websiteForm = document.getElementById('website-form');
    const formMethod = document.getElementById('form-method');
    const btnNewSite = document.getElementById('btn-new-site');
    const btnCloseModals = document.querySelectorAll('.btn-close-modal');
    
    // Form Fields (Only used inside openModal which checks for modal)
    const fFields = {
        domain: document.getElementById('modal-domain'),
        server: document.getElementById('modal-server'),
        username: document.getElementById('modal-username'),
        password: document.getElementById('modal-password'),
        priority: document.getElementById('modal-priority'),
        status: document.getElementById('modal-status'),
        backup: document.getElementById('modal-backup'),
        hacked: document.getElementById('modal-hacked'),
        hackedDesc: document.getElementById('modal-hacked-desc'),
        maintenance: document.getElementById('modal-maintenance')
    };
    
    const hackedDescContainer = document.getElementById('hacked-desc-container');

    if (fFields.hacked) {
        fFields.hacked.addEventListener('change', (e) => {
            if (e.target.checked) {
                hackedDescContainer.classList.remove('d-none');
            } else {
                hackedDescContainer.classList.add('d-none');
                fFields.hackedDesc.value = '';
            }
        });
    }

    // Notifications
    const btnNotifications = document.getElementById('btn-notifications');

    // Theme Elements
    const themeBtn = document.querySelector('.theme-toggle');
    const settingsToggles = document.querySelectorAll('.toggle-pill');

    // Initialize Lucide icons
    if (window.lucide) {
        window.lucide.createIcons();
    }

    const btnDeleteTrigger = document.getElementById('btn-delete-trigger');
    const deleteForm = document.getElementById('delete-form');

    // Auto-hide success alert
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            successAlert.style.opacity = '0';
            successAlert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 3000);
    }

    // --- THEME LOGIC ---
    function updateThemeIcon(isLight) {
        if (!themeBtn) return;
        const icon = themeBtn.querySelector('i');
        if (!icon) return;
        
        icon.setAttribute('data-lucide', isLight ? 'sun' : 'moon');
        if (window.lucide) window.lucide.createIcons();
    }

    function updateSettingsToggles(isLight) {
        if (!settingsToggles.length) return;
        settingsToggles.forEach(pill => {
            const label = pill.previousElementSibling?.querySelector('strong')?.textContent || '';
            if (label.includes('Modo Oscuro')) {
                if (isLight) pill.classList.remove('active');
                else pill.classList.add('active');
            }
        });
    }

    const currentTheme = localStorage.getItem('nexus-theme');
    if (currentTheme === 'light') {
        document.body.classList.add('light-theme');
        updateThemeIcon(true);
    }

    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            const isLight = document.body.classList.toggle('light-theme');
            localStorage.setItem('nexus-theme', isLight ? 'light' : 'dark');
            updateThemeIcon(isLight);
            updateSettingsToggles(isLight);
        });
    }

    if (settingsToggles.length) {
        settingsToggles.forEach(pill => {
            pill.addEventListener('click', () => {
                const label = pill.previousElementSibling?.querySelector('strong')?.textContent || '';
                if (label.includes('Modo Oscuro')) {
                    const nowLight = document.body.classList.toggle('light-theme');
                    localStorage.setItem('nexus-theme', nowLight ? 'light' : 'dark');
                    updateThemeIcon(nowLight);
                    updateSettingsToggles(nowLight);
                } else {
                    pill.classList.toggle('active');
                }
            });
        });
        updateSettingsToggles(currentTheme === 'light');
    }

    // --- MODAL LOGIC ---
    const openModal = (mode, data = null) => {
        if (!modal || !websiteForm) return;
        modal.classList.remove('d-none');
        
        if (mode === 'new') {
            if (modalTitle) modalTitle.textContent = 'Nuevo Sitio Web';
            websiteForm.action = '/websites';
            if (formMethod) formMethod.innerHTML = '';
            websiteForm.reset();
            if (btnDeleteTrigger) btnDeleteTrigger.classList.add('d-none');
            if (hackedDescContainer) hackedDescContainer.classList.add('d-none');
        } else {
            if (modalTitle) modalTitle.textContent = 'Editar Sitio Web';
            websiteForm.action = `/websites/${data.id}`;
            if (formMethod) formMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            
            if (btnDeleteTrigger) {
                btnDeleteTrigger.classList.remove('d-none');
                if (deleteForm) deleteForm.action = `/websites/${data.id}`;
            }
            
            if (fFields.domain) fFields.domain.value = data.domain;
            if (fFields.server) fFields.server.value = data.server;
            if (fFields.username) fFields.username.value = data.username;
            if (fFields.password) fFields.password.value = data.password;
            if (fFields.priority) fFields.priority.value = data.priority;
            if (fFields.status) fFields.status.value = data.status;
            if (fFields.backup) fFields.backup.checked = data.backup === '1';
            if (fFields.hacked) fFields.hacked.checked = data.hacked === '1';
            if (fFields.maintenance) fFields.maintenance.checked = data.maintenance === '1';
            
            if (fFields.hackedDesc) fFields.hackedDesc.value = data.hackedDesc || '';
            if (hackedDescContainer) {
                if (data.hacked === '1') {
                    hackedDescContainer.classList.remove('d-none');
                } else {
                    hackedDescContainer.classList.add('d-none');
                }
            }
        }
    };

    const closeModal = () => {
        if (modal) modal.classList.add('d-none');
    };

    if (btnNewSite) btnNewSite.addEventListener('click', () => openModal('new'));
    if (btnCloseModals.length) {
        btnCloseModals.forEach(btn => btn.addEventListener('click', closeModal));
    }
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
    }

    // --- DELETE MODAL LOGIC ---
    const deleteConfirmModal = document.getElementById('delete-confirm-modal');
    const btnCancelDelete = document.getElementById('btn-cancel-delete');
    const btnConfirmDeleteAction = document.getElementById('btn-confirm-delete-action');

    if (btnDeleteTrigger && deleteForm && deleteConfirmModal) {
        btnDeleteTrigger.addEventListener('click', () => {
            deleteConfirmModal.classList.remove('d-none');
        });

        btnCancelDelete.addEventListener('click', () => {
            deleteConfirmModal.classList.add('d-none');
        });

        btnConfirmDeleteAction.addEventListener('click', () => {
            deleteForm.submit();
        });

        // Close on overlay click
        deleteConfirmModal.addEventListener('click', (e) => {
            if (e.target === deleteConfirmModal) {
                deleteConfirmModal.classList.add('d-none');
            }
        });
    }

    // --- NOTIFICATIONS LOGIC ---
    const notifModal = document.getElementById('notif-modal');
    const notifList = document.getElementById('notif-list');
    const notifEmpty = document.getElementById('notif-empty');
    const btnMarkRead = document.querySelector('.btn-mark-read');
    const notifBadge = document.querySelector('.notif-badge');
    const notifCount = document.querySelector('.notif-count');
    const btnNotifCloseModal = document.getElementById('btn-close-notif');

    const updateNotifUI = () => {
        if (!notifList) return;
        const items = notifList.querySelectorAll('.notif-item');
        const unreadItems = notifList.querySelectorAll('.notif-item.unread');
        
        if (notifCount) {
            notifCount.textContent = unreadItems.length > 0 
                ? `${unreadItems.length} nuevas` 
                : 'Sin nuevas';
        }

        if (notifBadge) {
            notifBadge.style.display = unreadItems.length > 0 ? 'block' : 'none';
        }

        if (items.length === 0) {
            notifList.classList.add('d-none');
            if (notifEmpty) notifEmpty.classList.remove('d-none');
            if (btnMarkRead) btnMarkRead.style.display = 'none';
        } else {
            notifList.classList.remove('d-none');
            if (notifEmpty) notifEmpty.classList.add('d-none');
            if (btnMarkRead) btnMarkRead.style.display = 'flex';
        }
    };

    if (btnNotifications && notifModal) {
        btnNotifications.addEventListener('click', () => {
            notifModal.classList.remove('d-none');
        });
    }

    if (btnNotifCloseModal && notifModal) {
        btnNotifCloseModal.addEventListener('click', () => {
            notifModal.classList.add('d-none');
        });
    }

    if (notifModal) {
        notifModal.addEventListener('click', (e) => {
            if (e.target === notifModal) notifModal.classList.add('d-none');
        });
    }

    if (btnMarkRead) {
        btnMarkRead.addEventListener('click', () => {
            const unread = notifList.querySelectorAll('.notif-item.unread');
            unread.forEach(item => item.classList.remove('unread'));
            updateNotifUI();
        });
    }

    if (notifList) {
        notifList.addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.btn-remove-notif');
            if (removeBtn) {
                e.stopPropagation();
                const item = removeBtn.closest('.notif-item');
                item.style.opacity = '0';
                item.style.transform = 'translateX(30px)';
                setTimeout(() => {
                    item.remove();
                    updateNotifUI();
                }, 300);
                return;
            }

            const item = e.target.closest('.notif-item');
            if (item && item.classList.contains('unread')) {
                item.classList.remove('unread');
                updateNotifUI();
            }
        });
    }

    // --- FILTERING & DASHBOARD INTERACTION ---
    if (websiteContainer) {
        websiteContainer.addEventListener('click', (e) => {
            const item = e.target.closest('.website-item');
            if (item && !e.target.closest('.btn-show-pass') && !e.target.closest('.btn-icon')) {
                const data = {
                    id: item.getAttribute('data-id'),
                    domain: item.getAttribute('data-domain'),
                    server: item.getAttribute('data-server'),
                    username: item.getAttribute('data-username'),
                    password: item.getAttribute('data-password'),
                    status: item.getAttribute('data-status'),
                    priority: item.getAttribute('data-priority'),
                    backup: item.getAttribute('data-backup'),
                    hacked: item.getAttribute('data-hacked'),
                    hackedDesc: item.getAttribute('data-hacked-desc'),
                    maintenance: item.getAttribute('data-maintenance')
                };
                openModal('edit', data);
            }
            
            // Password Toggle
            const toggleBtn = e.target.closest('.btn-show-pass');
            if (toggleBtn) {
                e.stopPropagation();
                const parent = toggleBtn.closest('.cred-item');
                const hidden = parent?.querySelector('.pass-hidden');
                const reveal = parent?.querySelector('.pass-reveal');
                if (hidden && reveal) {
                    const isHidden = reveal.classList.contains('d-none');
                    reveal.classList.toggle('d-none');
                    hidden.classList.toggle('d-none');
                    toggleBtn.innerHTML = `<i data-lucide="${isHidden ? 'eye-off' : 'eye'}"></i>`;
                    if (window.lucide) window.lucide.createIcons();
                }
            }
        });

        // Search filtering
        let currentServerFilter = 'all';
        let currentSearchTerm = '';
        let currentStatusFilter = 'all';

        const filterSites = () => {
            const items = websiteContainer.querySelectorAll('.website-item');
            items.forEach(item => {
                const server = item.getAttribute('data-server');
                const status = item.getAttribute('data-status');
                const domain = item.querySelector('.site-name')?.textContent.toLowerCase() || '';
                const matchesServer = currentServerFilter === 'all' || server === currentServerFilter;
                const matchesSearch = domain.includes(currentSearchTerm.toLowerCase());
                const matchesStatus = currentStatusFilter === 'all' || status === currentStatusFilter;
                item.style.display = (matchesServer && matchesSearch && matchesStatus) ? 'flex' : 'none';
            });
        };

        if (siteSearch) {
            siteSearch.addEventListener('input', (e) => {
                currentSearchTerm = e.target.value;
                filterSites();
            });
        }

        const statusFilter = document.getElementById('status-filter');
        if (statusFilter) {
            statusFilter.addEventListener('change', (e) => {
                currentStatusFilter = e.target.value;
                filterSites();
            });
        }

        const updateActiveUI = (filterVal) => {
            currentServerFilter = filterVal;
            navLinks.forEach(l => l.classList.toggle('active', l.getAttribute('data-filter') === filterVal));
            serverCards.forEach(c => c.classList.toggle('active', c.getAttribute('data-server') === filterVal));
            filterSites();
        };

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const filter = link.getAttribute('data-filter');
                if (filter) {
                    e.preventDefault();
                    updateActiveUI(filter);
                }
            });
        });

        serverCards.forEach(card => {
            card.addEventListener('click', () => updateActiveUI(card.getAttribute('data-server')));
        });
    }

    // --- REAL TIME ECHO MONITORING ---
    if (window.Echo && window.userId) {
        window.Echo.private('App.Models.User.' + window.userId)
            .notification((notification) => {
                const isSuspendida = notification.status === 'suspendida';
                
                // Update the UI card
                const item = document.querySelector(`.website-item[data-id="${notification.website_id}"]`);
                if (item) {
                    item.setAttribute('data-status', notification.status);
                    const badge = item.querySelector('.status-badge');
                    if (badge) {
                        badge.className = `status-badge badge-${notification.status}`;
                        badge.textContent = notification.status === 'operativa' ? 'Operativa' : 'Suspendida';
                    }
                }

                // Append to modal
                const notifList = document.getElementById('notif-list');
                const notifEmpty = document.getElementById('notif-empty');
                if (notifList) {
                    notifList.classList.remove('d-none');
                    if (notifEmpty) notifEmpty.classList.add('d-none');
                    
                    const newNotif = document.createElement('div');
                    newNotif.className = `notif-item unread ${isSuspendida ? 'danger' : 'success'}`;
                    newNotif.setAttribute('data-id', notification.id || Date.now());
                    newNotif.innerHTML = `
                        <div class="notif-icon"><i data-lucide="${isSuspendida ? 'shield-alert' : 'check-circle'}"></i></div>
                        <div class="notif-content">
                            <div class="notif-title-row">
                                <strong>${isSuspendida ? 'Sitio Caído' : 'Sitio Recuperado'}</strong>
                                <span class="notif-time">Ahora</span>
                            </div>
                            <span>${notification.domain} está ${notification.status}.</span>
                        </div>
                        <button class="btn-remove-notif">&times;</button>
                    `;
                    notifList.prepend(newNotif);
                    
                    if (window.lucide) window.lucide.createIcons();
                    
                    const notifCount = document.querySelector('.notif-count');
                    const badgeNotif = document.querySelector('.notif-badge');
                    if (notifCount) {
                        const count = notifList.querySelectorAll('.notif-item.unread').length;
                        notifCount.textContent = `${count} nueva${count !== 1 ? 's' : ''}`;
                        if(badgeNotif) badgeNotif.style.display = 'block';
                    }
                }
            });
    }
});
