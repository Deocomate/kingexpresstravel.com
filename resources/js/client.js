(function() {
    let currentlyOpenModal = null;

    window.openModal = (modalId, actionUrl = null) => {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        if (actionUrl) {
            const form = modal.querySelector('form');
            if (form) {
                form.setAttribute('action', actionUrl);
            }
        }

        currentlyOpenModal = modal;
        const modalPanel = modal.querySelector('.modal-panel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            modalPanel.classList.remove('opacity-0');
        });
    };

    window.closeModal = () => {
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

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-modal-target]').forEach(trigger => {
            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                const modalId = trigger.getAttribute('data-modal-target');
                const actionUrl = trigger.dataset.actionUrl || null;
                window.openModal(modalId, actionUrl);
            });
        });

        document.querySelectorAll('.modal-close-button').forEach(button => {
            button.addEventListener('click', window.closeModal);
        });

        document.querySelectorAll('[role="dialog"]').forEach(overlay => {
            overlay.addEventListener('click', (event) => {
                if (event.target === overlay) {
                    window.closeModal();
                }
            });
        });

        document.querySelectorAll('[data-modal-switch]').forEach(switchBtn => {
            switchBtn.addEventListener('click', (event) => {
                event.preventDefault();
                const targetModalId = switchBtn.getAttribute('data-modal-switch');

                if (currentlyOpenModal) {
                    window.closeModal();
                    setTimeout(() => window.openModal(targetModalId), 300);
                } else {
                    window.openModal(targetModalId);
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

        const searchForm = document.getElementById('autocomplete-search-form');
        const searchInput = document.getElementById('autocomplete-search-input');
        const resultsContainer = document.getElementById('autocomplete-results');
        let debounceTimer;

        if (searchInput && resultsContainer && searchForm) {
            const suggestionsUrl = searchForm.dataset.suggestionsUrl;

            const debounce = (func, delay) => {
                return function(...args) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(this, args), delay);
                };
            };

            const fetchSuggestions = async (query) => {
                if (query.length < 2) {
                    resultsContainer.innerHTML = '';
                    resultsContainer.classList.add('hidden');
                    return;
                }

                resultsContainer.classList.remove('hidden');
                resultsContainer.innerHTML = `<div class="p-3 text-sm text-gray-500 text-center">Đang tìm kiếm...</div>`;

                try {
                    const response = await axios.get(suggestionsUrl, { params: { q: query } });
                    displaySuggestions(response.data);
                } catch (error) {
                    console.error('Error fetching search suggestions:', error);
                    resultsContainer.innerHTML = `<div class="p-3 text-sm text-red-500 text-center">Có lỗi xảy ra.</div>`;
                }
            };

            const displaySuggestions = (suggestions) => {
                if (!suggestions || suggestions.length === 0) {
                    resultsContainer.innerHTML = `<div class="p-3 text-sm text-gray-500">Không tìm thấy kết quả nào.</div>`;
                    return;
                }

                const suggestionsHtml = suggestions.map(item => {
                    let imageOrIconHtml = '';
                    if (item.type === 'Tour' && item.thumbnail) {
                        imageOrIconHtml = `<img src="${item.thumbnail}" alt="${item.name || ''}" class="w-12 h-10 object-cover rounded-md flex-shrink-0">`;
                    } else {
                        const iconClass = item.type === 'Tour' ? 'fa-route text-blue-500' : 'fa-map-marker-alt text-green-500';
                        imageOrIconHtml = `<div class="w-12 h-10 flex items-center justify-center flex-shrink-0"><i class="fa-solid ${iconClass} text-xl"></i></div>`;
                    }

                    return `
                    <a href="${item.url || '#'}" class="flex items-center gap-x-3 p-2 hover:bg-gray-100 transition-colors border-b last:border-b-0">
                        ${imageOrIconHtml}
                        <div class="flex-grow">
                            <p class="font-semibold text-gray-800 text-sm leading-tight">${item.name || ''}</p>
                            <p class="text-xs text-gray-500">${item.type || ''}</p>
                        </div>
                    </a>
                `;
                }).join('');

                resultsContainer.innerHTML = `<div class="max-h-80 overflow-y-auto">${suggestionsHtml}</div>`;
            };

            searchInput.addEventListener('input', debounce((e) => {
                fetchSuggestions(e.target.value);
            }, 300));

            document.addEventListener('click', (e) => {
                if (!searchForm.contains(e.target)) {
                    resultsContainer.classList.add('hidden');
                }
            });

            searchInput.addEventListener('focus', () => {
                if (searchInput.value.length >= 2 && resultsContainer.innerHTML.trim() !== '') {
                    resultsContainer.classList.remove('hidden');
                }
            });
        }
    });
})();
