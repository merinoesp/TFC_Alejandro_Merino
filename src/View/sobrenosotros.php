<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <title>Sobre Nosotros — Car2iu</title>
    <style>
        .about-hero {
            background: linear-gradient(135deg, var(--color-bg-secondary, #1a1a2e) 0%, var(--color-bg, #0f0f1a) 100%);
            padding: 5rem 2rem 4rem;
            text-align: center;
        }
        .about-hero h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        .about-hero p {
            font-size: 1.15rem;
            max-width: 620px;
            margin: 0 auto;
            opacity: 0.8;
            line-height: 1.7;
        }
        .about-section {
            max-width: 900px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }
        .about-section h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .about-section p {
            font-size: 1rem;
            line-height: 1.8;
            opacity: 0.85;
            margin-bottom: 1.2rem;
        }
        .about-values {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .value-card {
            background: var(--color-bg-secondary, #1a1a2e);
            border: 1px solid var(--color-border, rgba(255,255,255,0.08));
            border-radius: 12px;
            padding: 1.8rem 1.5rem;
            text-align: center;
        }
        .value-card .icon {
            font-size: 2.2rem;
            margin-bottom: 0.8rem;
        }
        .value-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .value-card p {
            font-size: 0.9rem;
            opacity: 0.75;
            line-height: 1.6;
            margin: 0;
        }
        .about-cta {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--color-bg-secondary, #1a1a2e);
        }
        .about-cta h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        .about-cta p {
            opacity: 0.8;
            margin-bottom: 1.8rem;
            font-size: 1.05rem;
        }
        .divider {
            height: 1px;
            background: var(--color-border, rgba(255,255,255,0.08));
            margin: 0 2rem;
        }
    </style>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php'; ?>

    <main>
        <!-- HERO -->
        <div class="about-hero">
            <h1>Sobre <span style="color: var(--color-accent, #7c6af7)">Car2iu</span></h1>
            <p>Somos el marketplace de referencia en España para la compra y venta de vehículos entre particulares. Conectamos a compradores y vendedores con total confianza y transparencia.</p>
        </div>

        <!-- MISIÓN -->
        <section class="about-section">
            <h2>¿Quiénes somos?</h2>
            <p>Car2iu nació con una idea simple: hacer que comprar o vender un vehículo en España sea una experiencia sencilla, segura y sin intermediarios innecesarios. Somos una plataforma digital donde cualquier particular puede publicar su vehículo o encontrar el coche que siempre ha querido, todo en un mismo lugar.</p>
            <p>Creemos que el proceso de compraventa de coches debería ser tan cómodo como comprar cualquier otra cosa por internet. Por eso hemos diseñado Car2iu para que publicar un anuncio lleve apenas un minuto, y encontrar el vehículo ideal sea rápido, intuitivo y sin sorpresas.</p>

            <div class="divider" style="margin: 2.5rem 0;"></div>

            <h2>Nuestros valores</h2>
            <div class="about-values">
                <div class="value-card">
                    <div class="icon">🔒</div>
                    <h3>Confianza</h3>
                    <p>Verificamos los anuncios y ofrecemos un sistema de reportes para mantener la plataforma libre de fraudes y publicaciones engañosas.</p>
                </div>
                <div class="value-card">
                    <div class="icon">⚡</div>
                    <h3>Rapidez</h3>
                    <p>Publica tu vehículo en minutos. Sin burocracia, sin papeleo. Todo desde tu móvil u ordenador, en cualquier momento.</p>
                </div>
                <div class="value-card">
                    <div class="icon">🤝</div>
                    <h3>Transparencia</h3>
                    <p>Precios reales, vendedores reales. Fomentamos la comunicación directa entre comprador y vendedor, sin comisiones ocultas.</p>
                </div>
                <div class="value-card">
                    <div class="icon">🇪🇸</div>
                    <h3>Comunidad</h3>
                    <p>Somos un proyecto 100% español, pensado para los apasionados del motor que buscan un espacio cercano y de confianza.</p>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <div class="about-cta">
            <h2>¿Listo para empezar?</h2>
            <p>Únete a nuestra comunidad y compra o vende tu vehículo hoy mismo. El registro es gratuito.</p>
            <a href="/registro" class="button button-primary button-lg">Crear cuenta gratis</a>
            &nbsp;&nbsp;
            <a href="/anuncios" class="button button-outline button-lg">Ver anuncios</a>
        </div>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
</body>
</html>
