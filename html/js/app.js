/* ============================================================
   PONNUS Restaurant — Shared JavaScript
   ============================================================ */

/* ── Auto-mark sidebar active link based on current filename ── */
(function markActiveNav() {
    const page = location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        const href = link.getAttribute('href') || '';
        if (href === page) {
            link.classList.add('active');
        }
    });
})();

/* ── Password visibility toggle ──
   Usage: <button onclick="togglePwd('inputId','iconId')"> */
function togglePwd(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        if (icon) { icon.classList.replace('bi-eye', 'bi-eye-slash'); }
    } else {
        input.type = 'password';
        if (icon) { icon.classList.replace('bi-eye-slash', 'bi-eye'); }
    }
}

/* ── Public menu category filter ── */
function filterCategory(cat) {
    document.querySelectorAll('.filter-pill').forEach(p => {
        p.classList.toggle('active', p.dataset.cat === cat);
    });
    document.querySelectorAll('.menu-item-card').forEach(card => {
        const show = cat === 'All' || card.dataset.category === cat;
        card.closest('.col').style.display = show ? '' : 'none';
    });
    // update count
    const visible = document.querySelectorAll('.menu-item-card:not([style*="display: none"])').length;
    const countEl = document.getElementById('dishCount');
    if (countEl) countEl.textContent = visible;
    const catLabel = document.getElementById('catLabel');
    if (catLabel) catLabel.textContent = cat === 'All' ? '' : `in ${cat}`;
}

/* ── Mobile sidebar toggle ── */
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) sidebar.classList.toggle('open');
}

/* ── Confirm delete ── */
function confirmDelete(name) {
    return confirm(`Delete "${name}"? This cannot be undone.`);
}

/* ── Flash alert auto-dismiss after 4 s ── */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.auto-dismiss').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }, 4000);
    });
});
