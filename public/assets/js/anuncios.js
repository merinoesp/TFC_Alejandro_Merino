document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btn-cargar-mas');
    if (!btn) return;

    btn.addEventListener('click', function () {
        const offset = parseInt(this.dataset.offset, 10);
        const total = parseInt(this.dataset.total, 10);
        const per = parseInt(this.dataset.per, 10);
        const counter = document.getElementById('pag-contador');

        btn.disabled = true;
        btn.textContent = 'Cargando…';

        fetch(`/src/Controller/apiAnuncios.php?offset=${offset}&limit=${per}`)
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('card-container');
                data.anuncios.forEach(a => {
                    container.insertAdjacentHTML('beforeend', buildCard(a));
                });

                const newOffset = offset + data.anuncios.length;
                btn.dataset.offset = newOffset;

                if (newOffset >= total) {
                    document.getElementById('paginacion-wrap').style.display = 'none';
                } else {
                    btn.disabled = false;
                    btn.innerHTML = `Cargar más <span id="pag-contador">(${newOffset} de ${total})</span>`;
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.textContent = 'Error — reintentar';
            });
    });

    function buildCard(a) {
        const precio = Number(a.precio).toLocaleString('es-ES', { maximumFractionDigits: 0 });
        const km = Number(a.kilometraje).toLocaleString('es-ES', { maximumFractionDigits: 0 });
        const ruta = '/' + a.ruta.replace(/^[./]+/, '');
        const vendidoBadge = a.vendido == 1 ? '<span class="wlp-card__badge wlp-card__badge--vendido">Vendido</span>' : '';
        const vendidoClass = a.vendido == 1 ? ' wlp-card--vendido' : '';
        return `
            <article class="wlp-card${vendidoClass}">
                <a href="/anuncio?id=${a.id_anuncio}" class="wlp-card__link" tabindex="-1" aria-hidden="true">
                    <div class="wlp-card__img-wrap">
                        <img src="${ruta}" alt="${escHtml(a.titulo)}" loading="lazy">
                        ${vendidoBadge}
                    </div>
                </a>
                <div class="wlp-card__body">
                    <p class="wlp-card__precio">${precio} €</p>
                    <h2 class="wlp-card__titulo"><a href="/anuncio?id=${a.id_anuncio}">${escHtml(a.titulo)}</a></h2>
                    <div class="wlp-card__meta">
                        <span>${escHtml(a.marca)}</span>
                        <span>${escHtml(a.anio)}</span>
                        <span>${km} km</span>
                    </div>
                    <div class="wlp-card__footer">
                        <span class="wlp-card__ubicacion">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            ${escHtml(a.ubicacion)}
                        </span>
                        <span class="wlp-card__vendedor">${escHtml(a.nombre)}</span>
                    </div>
                </div>
            </article>`;
    }

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
});