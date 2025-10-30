(function (global) {
    const httpClient = global.axios;
    if (httpClient && httpClient.defaults && httpClient.defaults.headers && httpClient.defaults.headers.common) {
        httpClient.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    } else if (!httpClient) {
        console.warn('Axios CDN is not loaded; falling back to fetch for AJAX requests.');
    }

    const SwalGlobal = global.Swal;
    const showFallbackNotification = (type, message) => {
        const prefix = type === 'error' ? 'Lỗi' : 'Thông báo';
        console[type === 'error' ? 'error' : 'log'](`${prefix}: ${message}`);
    };

    if (SwalGlobal && typeof SwalGlobal.mixin === 'function') {
        const Toast = SwalGlobal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            customClass: {
                popup: 'custom-toast'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', SwalGlobal.stopTimer);
                toast.addEventListener('mouseleave', SwalGlobal.resumeTimer);
            }
        });

        global.showSuccessToast = function (message) {
            Toast.fire({
                icon: 'success',
                title: message
            });
        };

        global.showErrorToast = function (message) {
            Toast.fire({
                icon: 'error',
                title: message
            });
        };
    } else {
        global.showSuccessToast = (message) => showFallbackNotification('success', message);
        global.showErrorToast = (message) => showFallbackNotification('error', message);
    }

    (function () {
        let currentlyOpenModal = null;

        global.openModal = (modalId, actionUrl = null) => {
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

        global.closeModal = () => {
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
                    global.openModal(modalId, actionUrl);
                });
            });

            document.querySelectorAll('.modal-close-button').forEach(button => {
                button.addEventListener('click', global.closeModal);
            });

            document.querySelectorAll('[role="dialog"]').forEach(overlay => {
                overlay.addEventListener('click', (event) => {
                    if (event.target === overlay) {
                        global.closeModal();
                    }
                });
            });

            document.querySelectorAll('[data-modal-switch]').forEach(switchBtn => {
                switchBtn.addEventListener('click', (event) => {
                    event.preventDefault();
                    const targetModalId = switchBtn.getAttribute('data-modal-switch');

                    if (currentlyOpenModal) {
                        global.closeModal();
                        setTimeout(() => global.openModal(targetModalId), 300);
                    } else {
                        global.openModal(targetModalId);
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
                    mobileMenuButton.setAttribute('aria-expanded', (!isExpanded).toString());
                    if (!isExpanded) {
                        mobileMenu.classList.remove('hidden', 'max-h-0');
                        mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
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
                    return function (...args) {
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
                    resultsContainer.innerHTML = '<div class="p-3 text-sm text-gray-500 text-center">Đang tìm kiếm...</div>';

                    try {
                        let data;
                        if (httpClient && typeof httpClient.get === 'function') {
                            const response = await httpClient.get(suggestionsUrl, { params: { q: query } });
                            data = response.data;
                        } else {
                            const url = new URL(suggestionsUrl, global.location.origin);
                            url.searchParams.set('q', query);
                            const response = await fetch(url.toString(), {
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            });
                            if (!response.ok) throw new Error('Network response was not ok');
                            data = await response.json();
                        }
                        displaySuggestions(data);
                    } catch (error) {
                        console.error('Error fetching search suggestions:', error);
                        resultsContainer.innerHTML = '<div class="p-3 text-sm text-red-500 text-center">Có lỗi xảy ra.</div>';
                    }
                };

                const displaySuggestions = (suggestions) => {
                    if (!suggestions || suggestions.length === 0) {
                        resultsContainer.innerHTML = '<div class="p-3 text-sm text-gray-500">Không tìm thấy kết quả nào.</div>';
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

            const tourSearchForm = document.getElementById('tour-search-form');
            if (tourSearchForm) {
                const destinationInput = document.getElementById('destination-input');
                const suggestionsContainer = document.getElementById('destination-suggestions');
                const budgetSelect = document.getElementById('budget-select');
                const suggestionsUrl = tourSearchForm.dataset.suggestionsUrl;
                let searchDebounceTimer;
                let activeSuggestionIndex = -1;

                const fetchDestinationSuggestions = async (query) => {
                    if (query.length < 1) {
                        suggestionsContainer.innerHTML = '';
                        suggestionsContainer.classList.add('hidden');
                        return;
                    }
                    try {
                        let data;
                        if (httpClient && typeof httpClient.get === 'function') {
                            const response = await httpClient.get(suggestionsUrl, { params: { q: query } });
                            data = response.data;
                        } else {
                            const url = new URL(suggestionsUrl, global.location.origin);
                            url.searchParams.set('q', query);
                            const response = await fetch(url.toString(), {
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            });
                            if (!response.ok) throw new Error('Network response was not ok');
                            data = await response.json();
                        }
                        displayDestinationSuggestions(data);
                    } catch (error) {
                        console.error('Error fetching destination suggestions:', error);
                    }
                };

                const displayDestinationSuggestions = (suggestions) => {
                    activeSuggestionIndex = -1;
                    if (!suggestions || suggestions.length === 0) {
                        suggestionsContainer.innerHTML = '';
                        suggestionsContainer.classList.add('hidden');
                        return;
                    }
                    const suggestionsHtml = suggestions.map(item =>
                        `<div class="suggestion-item p-3 hover:bg-gray-100 cursor-pointer text-sm text-gray-700">${item.name}</div>`
                    ).join('');
                    suggestionsContainer.innerHTML = suggestionsHtml;
                    suggestionsContainer.classList.remove('hidden');
                };

                const updateActiveSuggestion = () => {
                    const items = suggestionsContainer.querySelectorAll('.suggestion-item');
                    items.forEach((item, index) => {
                        item.classList.toggle('bg-gray-100', index === activeSuggestionIndex);
                    });
                };

                destinationInput.addEventListener('input', (e) => {
                    clearTimeout(searchDebounceTimer);
                    searchDebounceTimer = setTimeout(() => {
                        fetchDestinationSuggestions(e.target.value);
                    }, 300);
                });

                destinationInput.addEventListener('keydown', (e) => {
                    const items = suggestionsContainer.querySelectorAll('.suggestion-item');
                    const suggestionsVisible = !suggestionsContainer.classList.contains('hidden');

                    if (suggestionsVisible && items.length > 0) {
                        if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            activeSuggestionIndex = (activeSuggestionIndex + 1) % items.length;
                            updateActiveSuggestion();
                        } else if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            activeSuggestionIndex = (activeSuggestionIndex - 1 + items.length) % items.length;
                            updateActiveSuggestion();
                        } else if (e.key === 'Enter') {
                            if (activeSuggestionIndex > -1) {
                                e.preventDefault();
                                destinationInput.value = items[activeSuggestionIndex].textContent;
                                suggestionsContainer.classList.add('hidden');
                                activeSuggestionIndex = -1;
                            }
                        }
                    }
                });

                suggestionsContainer.addEventListener('click', (e) => {
                    if (e.target.classList.contains('suggestion-item')) {
                        destinationInput.value = e.target.textContent;
                        suggestionsContainer.innerHTML = '';
                        suggestionsContainer.classList.add('hidden');
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!tourSearchForm.contains(e.target)) {
                        suggestionsContainer.classList.add('hidden');
                    }
                });

                budgetSelect.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        tourSearchForm.requestSubmit();
                    }
                });

                tourSearchForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const budgetValue = budgetSelect.value;
                    const destinationValue = destinationInput.value;

                    const params = new URLSearchParams();

                    if (destinationValue) {
                        params.append('destination', destinationValue);
                    }

                    if (budgetValue) {
                        const [from, to] = budgetValue.split('-');
                        params.append('price_from', from);
                        params.append('price_to', to);
                    }

                    global.location.href = `${this.action}?${params.toString()}`;
                });
            }

            const executeScriptsInContainer = (containerElement) => {
                containerElement.querySelectorAll('script').forEach(script => {
                    const newScript = document.createElement('script');
                    for (const attr of script.attributes) {
                        newScript.setAttribute(attr.name, attr.value);
                    }
                    newScript.textContent = script.textContent;
                    script.parentNode.replaceChild(newScript, script);
                });
            };

            const handleProfileNav = async (url, pushState = true) => {
                const contentArea = document.getElementById('profile-content-area');
                if (!contentArea) return;

                contentArea.innerHTML = `
                <div class="flex items-center justify-center min-h-[400px]">
                    <i class="fa-solid fa-spinner fa-spin text-4xl text-[var(--color-primary)]"></i>
                </div>
            `;

                try {
                    const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    if (!response.ok) throw new Error('Network response was not ok.');
                    const html = await response.text();

                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newContent = doc.getElementById('profile-content-area');
                    const titleElement = doc.querySelector('title');
                    const newTitle = titleElement ? titleElement.innerText : document.title;

                    if (pushState) {
                        history.pushState({ path: url }, newTitle, url);
                    }
                    document.title = newTitle;

                    contentArea.innerHTML = newContent ? newContent.innerHTML : '<p class="text-center">Lỗi khi tải nội dung.</p>';
                    executeScriptsInContainer(contentArea);

                    const sidebar = document.getElementById('profile-sidebar-nav');
                    if (sidebar) {
                        sidebar.querySelectorAll('a.profile-nav-link').forEach(a => {
                            a.classList.remove('bg-[var(--color-primary-light)]', 'text-[var(--color-primary-dark)]');
                            a.classList.add('text-gray-600', 'hover:bg-gray-100', 'hover:text-gray-800');
                        });
                        const activeLink = sidebar.querySelector(`a[href="${url}"]`);
                        if (activeLink) {
                            activeLink.classList.add('bg-[var(--color-primary-light)]', 'text-[var(--color-primary-dark)]');
                            activeLink.classList.remove('text-gray-600', 'hover:bg-gray-100', 'hover:text-gray-800');
                        }
                    }

                } catch (error) {
                    console.error('Lỗi tải trang:', error);
                    global.location.href = url;
                }
            };

            document.body.addEventListener('click', e => {
                const link = e.target.closest('a.profile-nav-link');
                if (link) {
                    e.preventDefault();
                    handleProfileNav(link.href);
                }
            });

            global.addEventListener('popstate', e => {
                if (e.state && e.state.path) {
                    handleProfileNav(e.state.path, false);
                }
            });

            if (global.location.pathname.startsWith('/tai-khoan')) {
                history.replaceState({ path: global.location.href }, document.title, global.location.href);
            }
        });
    })();
})(window);
