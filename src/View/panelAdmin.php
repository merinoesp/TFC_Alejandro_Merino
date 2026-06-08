<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrados</title>
</head>
<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
    $db = new Database('localhost', 'root', '', 'car2iu', 3306);
    $reportes = $db->reportes();
    ?>
    <main class="admin-panel">
        <section class="reportes">
            <h1 class="title">Reportes de Usuario</h1>
            <div class="reps-container">
                <?php if($reportes): ?>
                    <?php foreach($reportes as $reporte): ?>
                        <div class="rep">
                            <p>Usuario Reportado: <?= htmlspecialchars($reporte['nombre_reportado']) ?></p>
                            <p>Reportado por: <?= htmlspecialchars($reporte['nombre_reportador']) ?></p>
                            <p>Anuncio: <?= htmlspecialchars($reporte['anuncio_titulo']) ?></p>
                            <p>Motivo: <?= htmlspecialchars($reporte['motivo']) ?></p>
                            <p>Descripción: <?= htmlspecialchars($reporte['descripcion']) ?></p>
                            <p>Fecha: <?= htmlspecialchars($reporte['fecha_reporte']) ?></p>
                            <p>Estado: <strong><?= htmlspecialchars($reporte['estado'] ?? 'pendiente') ?></strong></p>

                            <div class="rep-acciones">
    <div class="dropdown">
        <button class="btn-accion btn-dropdown">
            ⚙ Acciones ▾
        </button>
        <div class="dropdown-menu">
            <button onclick="borrarCuenta(<?= $reporte['id_usuario'] ?>)">🗑 Borrar Cuenta</button>
            <button onclick="marcarLeido(<?= $reporte['id_reporte'] ?>)">✅ Marcar como Leído</button>
            <button onclick="contactar('<?= htmlspecialchars($reporte['email_reportado']) ?>')">✉ Contactar</button>
        </div>
    </div>
</div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-reportes">No hay reportes disponibles.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
    <script src="/public/assets/js/reportes.js"></script>
</body>
</html>