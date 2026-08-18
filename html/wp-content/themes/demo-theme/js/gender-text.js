/**
 * Obsługa dynamicznej odmiany tekstu według płci
 *
 * @package Demo_Theme
 */

document.addEventListener('DOMContentLoaded', () => {
    const rawTemplateEl = document.getElementById('gender-raw-template');
    const outputContainer = document.getElementById('gender-rendered-output');
    const genderButtons = document.querySelectorAll('.gender-btn');
    const badgeEl = document.getElementById('current-gender-badge');

    if (!rawTemplateEl || !outputContainer) {
        return;
    }

    const STORAGE_KEY = 'demo_theme_preferred_gender';
    const GENDER_LABELS = {
        m: 'Tryb: Mężczyzna',
        f: 'Tryb: Kobieta'
    };

    function renderInitialHTML(rawText) {
        const paragraphs = rawText.split(/\n\s*\n/);

        const html = paragraphs.map(pText => {
            if (!pText.trim()) return '';

            const parsedParagraph = pText.replace(/\{([^{}|]+)(?:\|([^{}|]+))?\}/g, (match, m, f) => {
                const male = (m || '').trim();
                const female = (f || male).trim();

                return `<span class="gender-dynamic-word" data-m="${escapeHtml(male)}" data-f="${escapeHtml(female)}">${escapeHtml(male)}</span>`;
            });

            const formatted = parsedParagraph.replace(/\n/g, '<br>');
            return `<p>${formatted}</p>`;
        }).join('');

        outputContainer.innerHTML = html;
    }

    function applyGender(gender, animate = true) {
        const validGender = ['m', 'f'].includes(gender) ? gender : 'm';

        genderButtons.forEach(btn => {
            const btnGender = btn.getAttribute('data-gender');
            if (btnGender === validGender) {
                btn.classList.add('active');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                btn.classList.remove('active');
                btn.setAttribute('aria-pressed', 'false');
            }
        });

        if (badgeEl && GENDER_LABELS[validGender]) {
            badgeEl.textContent = GENDER_LABELS[validGender];
            badgeEl.setAttribute('data-current-gender', validGender);
        }
        outputContainer.setAttribute('data-active-gender', validGender);

        const dynamicWords = outputContainer.querySelectorAll('.gender-dynamic-word');
        dynamicWords.forEach(span => {
            const targetWord = span.getAttribute(`data-${validGender}`) || span.getAttribute('data-m');

            if (span.textContent !== targetWord) {
                span.textContent = targetWord;

                if (animate) {
                    span.classList.remove('word-changed');
                    void span.offsetWidth;
                    span.classList.add('word-changed');
                }
            }
        });

        try {
            localStorage.setItem(STORAGE_KEY, validGender);
        } catch (e) {}
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    renderInitialHTML(rawTemplateEl.textContent || '');

    let initialGender = 'm';
    try {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved && ['m', 'f'].includes(saved)) {
            initialGender = saved;
        }
    } catch (e) {}

    applyGender(initialGender, false);

    genderButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const selectedGender = btn.getAttribute('data-gender');
            applyGender(selectedGender, true);
        });
    });
});
