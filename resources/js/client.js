document.addEventListener('DOMContentLoaded', function () {
    let currentlyOpenModal = null;

    const openModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        currentlyOpenModal = modal;
        const modalPanel = modal.querySelector('.modal-panel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            modalPanel.classList.remove('opacity-0');
        });
    };

    const closeModal = () => {
        if (!currentlyOpenModal) return;

        const modalPanel = currentlyOpenModal.querySelector('.modal-panel');
        modalPanel.classList.add('opacity-0');

        setTimeout(() => {
            if (currentlyOpenModal) {
                currentlyOpenModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                currentlyOpenModal = null;
            }
        }, 300);
    };

    document.querySelectorAll('[data-modal-target]').forEach(trigger => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            const modalId = trigger.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (!modal) return;

            if (trigger.dataset.actionUrl) {
                const form = modal.querySelector('form');
                if (form) {
                    form.setAttribute('action', trigger.dataset.actionUrl);
                }
            }

            openModal(modalId);
        });
    });

    document.querySelectorAll('.modal-close-button').forEach(button => {
        button.addEventListener('click', closeModal);
    });

    document.querySelectorAll('[role="dialog"]').forEach(overlay => {
        overlay.addEventListener('click', (event) => {
            if (event.target === overlay) {
                closeModal();
            }
        });
    });

    document.querySelectorAll('[data-modal-switch]').forEach(switchBtn => {
        switchBtn.addEventListener('click', (event) => {
            event.preventDefault();
            const targetModalId = switchBtn.getAttribute('data-modal-switch');

            if (currentlyOpenModal) {
                closeModal();
                setTimeout(() => openModal(targetModalId), 300);
            } else {
                openModal(targetModalId);
            }
        });
    });

    const guestAccountButton = document.getElementById('guest-account-button');
    const guestDropdown = document.getElementById('guest-dropdown');
    if (guestAccountButton && guestDropdown) {
        guestAccountButton.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            guestDropdown.classList.toggle('hidden');
        });
    }

    const accountButton = document.getElementById('account-button');
    const accountDropdown = document.getElementById('account-dropdown');
    if (accountButton && accountDropdown) {
        accountButton.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            accountDropdown.classList.toggle('hidden');
        });
    }

    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            if (!isExpanded) {
                mobileMenu.classList.remove('hidden', 'max-h-0');
                mobileMenu.style.maxHeight = mobileMenu.scrollHeight + "px";
            } else {
                mobileMenu.style.maxHeight = '0';
                mobileMenu.addEventListener('transitionend', () => {
                    mobileMenu.classList.add('hidden');
                }, { once: true });
            }
        });
    }

    document.addEventListener('click', (event) => {
        if (guestDropdown && !guestDropdown.classList.contains('hidden') && guestAccountButton && !guestAccountButton.contains(event.target)) {
            guestDropdown.classList.add('hidden');
        }

        if (accountDropdown && !accountDropdown.classList.contains('hidden') && accountButton && !accountButton.contains(event.target)) {
            accountDropdown.classList.add('hidden');
        }
    });

    const megaMenuContainer = document.getElementById('mega-menu-container');
    if (megaMenuContainer) {
        const parentItems = megaMenuContainer.querySelectorAll('.mega-menu-parent-item');
        const childrenPanels = megaMenuContainer.querySelectorAll('.mega-menu-children-panel');
        const placeholder = document.getElementById('mega-menu-placeholder');

        const showPanel = (panelId) => {
            childrenPanels.forEach(p => p.classList.add('hidden'));
            if (placeholder) placeholder.classList.add('hidden');

            const targetPanel = document.getElementById(panelId);
            if (targetPanel) {
                targetPanel.classList.remove('hidden');
                targetPanel.classList.add('grid');
            } else if (placeholder) {
                placeholder.classList.remove('hidden');
            }
        };

        parentItems.forEach((item, index) => {
            item.addEventListener('mouseenter', () => {
                parentItems.forEach(i => i.classList.remove('bg-[var(--color-primary-light)]', 'text-[var(--color-primary-dark)]'));
                item.classList.add('bg-[var(--color-primary-light)]', 'text-[var(--color-primary-dark)]');

                const targetId = item.getAttribute('data-category-target');
                showPanel(targetId);
            });

            if (index === 0) {
                item.classList.add('bg-[var(--color-primary-light)]', 'text-[var(--color-primary-dark)]');
                const firstTargetId = item.getAttribute('data-category-target');
                showPanel(firstTargetId);
            }
        });

        const parentMenu = megaMenuContainer.closest('.group');
        if (parentMenu) {
            parentMenu.addEventListener('mouseleave', () => {
                parentItems.forEach((item, index) => {
                    item.classList.remove('bg-[var(--color-primary-light)]', 'text-[var(--color-primary-dark)]');
                    if (index === 0) {
                        item.classList.add('bg-[var(--color-primary-light)]', 'text-[var(--color-primary-dark)]');
                        const firstTargetId = item.getAttribute('data-category-target');
                        showPanel(firstTargetId);
                    }
                });
            });
        }
    }
});
