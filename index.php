<?php
session_start();
require_once __DIR__ . '/src/Model/Database.php';
$_db_index = null;
if (isset($_SESSION['id'])) {
    $_db_index = new Database('sql210.infinityfree.com','if0_41267709','acakoj56J','if0_41267709_car2iu',3306);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio — Car2iu</title>
</head>

<body>
    <?php require_once 'src/View/partials/nav.php'; ?>

    <main class="main" style="padding:0; justify-content: flex-start; align-items: stretch;">

        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero__glow hero__glow--left" aria-hidden="true"></div>
            <div class="hero__glow hero__glow--right" aria-hidden="true"></div>

            <div class="hero__content">
                <?php if (!isset($_SESSION['usuario'])): ?>
                    <div class="hero__badge animate-fade-up" style="animation-delay: 0.1s">
                        <span class="badge-dot" aria-hidden="true"></span>
                        Marketplace de vehículos en España
                    </div>
                    <h1 class="hero__title animate-fade-up" style="animation-delay: 0.2s">
                        Encuentra el coche<br>
                        <span class="hero__title--accent">de tus sueños</span>
                    </h1>
                    <p class="hero__subtitle animate-fade-up" style="animation-delay: 0.35s">
                        Un punto de encuentro entre apasionados del motor. Compra, vende
                        y descubre miles de vehículos con total confianza.
                    </p>
                    <div class="hero__actions animate-fade-up" style="animation-delay: 0.5s">
                        <a href="/registro" class="button button-primary button-lg">
                            Regístrate gratis
                        </a>
                        <a href="/anuncios" class="button button-outline button-lg">
                            Ver anuncios
                        </a>
                    </div>
                <?php else: ?>
                    <div class="hero__badge animate-fade-up" style="animation-delay: 0.1s">
                        <span class="badge-dot" aria-hidden="true"></span>
                        Bienvenido de nuevo
                    </div>
                    <h1 class="hero__title animate-fade-up" style="animation-delay: 0.2s">
                        Hola, <span class="hero__title--accent"><?= htmlspecialchars($_SESSION['usuario']) ?></span> 👋
                    </h1>
                    <p class="hero__subtitle animate-fade-up" style="animation-delay: 0.35s">
                        ¿A qué esperas para hacer tus próximas compras? Explora los mejores
                        vehículos disponibles ahora mismo.
                    </p>
                    <div class="hero__actions animate-fade-up" style="animation-delay: 0.5s">
                        <a href="/anuncios" class="button button-primary button-lg">
                            Ver anuncios
                        </a>
                        <?php if (!$_db_index || !$_db_index->verificarAdmin($_SESSION['id'])): ?>
                        <a href="/crearAnuncio" class="button button-outline button-lg">
                            Subir vehículo
                        </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Decorative car silhouette / abstract shape -->
            <div class="hero__visual animate-fade-left" style="animation-delay: 0.4s" aria-hidden="true">
                <div class="hero__visual-card">
                    <div class="hero__visual-orb"></div>
                    <svg class="hero__car-icon" viewBox="0 0 200 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="20" y="45" width="160" height="40" rx="8" fill="var(--primary-700)" opacity="0.6"/>
                        <path d="M45 45 L65 20 H135 L155 45 Z" fill="var(--primary-600)" opacity="0.8"/>
                        <rect x="68" y="24" width="64" height="20" rx="3" fill="var(--primary-300)" opacity="0.25"/>
                        <circle cx="55" cy="85" r="14" fill="var(--bg-800)" stroke="var(--primary-400)" stroke-width="3"/>
                        <circle cx="55" cy="85" r="7" fill="var(--primary-500)" opacity="0.5"/>
                        <circle cx="145" cy="85" r="14" fill="var(--bg-800)" stroke="var(--primary-400)" stroke-width="3"/>
                        <circle cx="145" cy="85" r="7" fill="var(--primary-500)" opacity="0.5"/>
                    </svg>
                    <div class="hero__visual-stats">
                        <div class="visual-stat">
                            <span class="visual-stat__num">12k+</span>
                            <span class="visual-stat__label">Anuncios</span>
                        </div>
                        <div class="visual-stat-divider" aria-hidden="true"></div>
                        <div class="visual-stat">
                            <span class="visual-stat__num">4.8★</span>
                            <span class="visual-stat__label">Valoración</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATS STRIP -->
        <section class="stats-strip" aria-label="Estadísticas">
            <div class="stats-strip__inner">
                <div class="stat-item animate-fade-up" style="animation-delay: 0.6s">
                    <span class="stat-item__num">12.000+</span>
                    <span class="stat-item__label">Vehículos publicados</span>
                </div>
                <div class="stat-divider" aria-hidden="true"></div>
                <div class="stat-item animate-fade-up" style="animation-delay: 0.7s">
                    <span class="stat-item__num">8.500+</span>
                    <span class="stat-item__label">Usuarios registrados</span>
                </div>
                <div class="stat-divider" aria-hidden="true"></div>
                <div class="stat-item animate-fade-up" style="animation-delay: 0.8s">
                    <span class="stat-item__num">3.200+</span>
                    <span class="stat-item__label">Ventas completadas</span>
                </div>
                <div class="stat-divider" aria-hidden="true"></div>
                <div class="stat-item animate-fade-up" style="animation-delay: 0.9s">
                    <span class="stat-item__num">99%</span>
                    <span class="stat-item__label">Clientes satisfechos</span>
                </div>
            </div>
        </section>

        <!-- FEATURES SECTION -->
        <section class="features" aria-labelledby="features-heading">
            <div class="features__header animate-fade-up">
                <span class="section-label">¿Por qué Car2iu?</span>
                <h2 id="features-heading">Todo lo que necesitas<br>en un solo lugar</h2>
            </div>
            <div class="features__grid">
                <article class="feature-card animate-fade-up" style="animation-delay: 0.1s">
                    <div class="feature-card__icon" aria-hidden="true">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </div>
                    <h3>Búsqueda inteligente</h3>
                    <p>Filtra por marca, modelo, precio y kilómetros para encontrar exactamente lo que buscas en segundos.</p>
                </article>
                <article class="feature-card animate-fade-up" style="animation-delay: 0.2s">
                    <div class="feature-card__icon" aria-hidden="true">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3>Transacciones seguras</h3>
                    <p>Sistema de verificación de usuarios y reportes para que compres y vendas con total tranquilidad.</p>
                </article>
                <article class="feature-card animate-fade-up" style="animation-delay: 0.3s">
                    <div class="feature-card__icon" aria-hidden="true">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <h3>Contacto directo</h3>
                    <p>Habla directamente con el vendedor. Sin intermediarios, sin comisiones ocultas.</p>
                </article>
                <article class="feature-card animate-fade-up" style="animation-delay: 0.4s">
                    <div class="feature-card__icon feature-card__icon--accent" aria-hidden="true">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z"/><path d="M12 8v4l3 3"/></svg>
                    </div>
                    <h3>IA Integrada</h3>
                    <p>Asistente inteligente que te ayuda a valorar tu vehículo y redactar el anuncio perfecto.</p>
                </article>
            </div>
        </section>

        <!-- CTA SECTION (solo si no está logueado) -->
        <?php if (!isset($_SESSION['usuario'])): ?>
        <section class="cta-section animate-fade-up">
            <div class="cta-section__inner">
                <div class="cta-section__glow" aria-hidden="true"></div>
                <h2>¿Listo para empezar?</h2>
                <p>Únete a miles de compradores y vendedores. El registro es gratuito y solo tarda un minuto.</p>
                <a href="/registro" class="button button-accent button-lg">
                    Crear cuenta gratis
                </a>
            </div>
        </section>
        <?php endif; ?>

    </main>

    <?php require_once 'src/View/partials/footer.php'; ?>
</body>

</html>
