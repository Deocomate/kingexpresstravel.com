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
});
