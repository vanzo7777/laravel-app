document.addEventListener("DOMContentLoaded", function () {
    const block = document.querySelector('.search-live');
    if (!block) return;

    const input = block.querySelector('.search__input');
    const popup = block.querySelector('.search-popup');
    const url = block.dataset.searchUrl;

    if (!input || !popup || !url) return;

    const isAdminSearch = url.includes('/admin/');

    const escapeHtml = (str = '') => {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    };

    const renderFrontResults = (items) => {
        if (!items.length) {
            popup.innerHTML = `<div class="search-popup__empty">Nichts gefunden</div>`;
            popup.hidden = false;
            return;
        }

        popup.innerHTML = items.map(item => `
            <a href="${item.url}" class="search-popup__item">
                <img src="${item.image_url}" alt="${escapeHtml(item.title)}" class="search-popup__image">
                <div class="search-popup__content">
                    <div class="search-popup__title">${escapeHtml(item.title)}</div>
                    <div class="search-popup__meta">
                        ${escapeHtml(item.author)} · ${escapeHtml(item.publish_date)}
                    </div>
                    <div class="search-popup__excerpt">${escapeHtml(item.excerpt ?? '')}</div>
                </div>
            </a>
        `).join('');

        popup.hidden = false;
    };

    const renderAdminResults = (items) => {
        if (!items.length) {
            popup.innerHTML = `<div class="search-popup__empty">Nichts gefunden</div>`;
            popup.hidden = false;
            return;
        }

        popup.innerHTML = items.map(item => `
            <a href="${item.edit_url}" class="search-popup__item">
                <div class="search-popup__content">
                    <div class="search-popup__title">${escapeHtml(item.title)}</div>
                    <div class="search-popup__meta">
                        ${escapeHtml(item.author)} · ${escapeHtml(item.publish_date)}
                    </div>
                </div>
            </a>
        `).join('');

        popup.hidden = false;
    };

    input.addEventListener('input', async () => {
        const value = input.value.trim();

        if (value.length < 2) {
            popup.hidden = true;
            popup.innerHTML = '';
            return;
        }

        try {
            const response = await fetch(`${url}?search=${encodeURIComponent(value)}`);

            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }

            const items = await response.json();

            if (isAdminSearch) {
                renderAdminResults(items);
            } else {
                renderFrontResults(items);
            }
        } catch (error) {
            console.error(error);
            popup.hidden = true;
            popup.innerHTML = '';
        }
    });
});