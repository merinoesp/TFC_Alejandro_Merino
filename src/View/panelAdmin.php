<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
</head>
<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
    $db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
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
                                    <button class="btn-accion btn-dropdown">⚙ Acciones ▾</button>
                                    <div class="dropdown-menu">
                                        <button onclick="borrarCuenta(<?= $reporte['id_usuario'] ?>)">🗑 Borrar Cuenta</button>
                                        <button onclick="borrarAnuncioAdmin(<?= $reporte['id_anuncio'] ?>)">🚫 Eliminar Anuncio</button>
                                        <button onclick="marcarLeido(<?= $reporte['id_reporte'] ?>)">✅ Marcar como Leído</button>
                                        <button onclick="contactar('<?= htmlspecialchars($reporte['email_reportado'], ENT_QUOTES) ?>')">✉ Contactar</button>
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

    <!-- Modal Contactar -->
    <div id="modalContactar" class="modal-contactar-overlay" style="display:none;">
        <div class="modal-contactar-box">
            <h3>📧 Email del usuario reportado</h3>
            <p id="emailContactar" class="email-display"></p>
            <div class="modal-contactar-btns">
                <button id="btnCopiar" class="btn-accion btn-dropdown" onclick="copiarEmail()">📋 Copiar</button>
                <button class="btn-accion" onclick="cerrarModalContactar()" style="background:#666;">Cerrar</button>
            </div>
        </div>
    </div>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
    <script src="/public/assets/js/reportes.js"></script>
</body>
</html>
