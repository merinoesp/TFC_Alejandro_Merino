<header>
    <?php if (session_status() === PHP_SESSION_NONE) session_start(); 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
    $db = new Database("sql210.infinityfree.com","if0_41267709", "acakoj56J", "if0_41267709_car2iu", 3306);
    
    ?>

    <nav class="nav">

        <div class="logo">
            <img src="https://placehold.co/70x70" alt="logo">
        </div>

        <input type="checkbox" id="menu-toggle" class="menu-toggle">

        <label for="menu-toggle" class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </label>

        <?php
        if (isset($_SESSION['usuario'])) {
            if($db->verificarAdmin($_SESSION['id'])){
                echo '<div class="list-elements">
            <a href="/index.php">Inicio</a>
            <a href="/cerrarSesion">Cerrar Sesión</a>
            <a href="/userPanel">Panel de Usuario</a>
            <a href="/anuncios">Anuncios</a>
            <a href="/src/Model/IA/index.php">IA</a>
            <a href="/panelAdmin">Panel de Administrador</a>
        </div>';
            }else{
                echo '<div class="list-elements">
            <a href="/index.php">Inicio</a>
            <a href="/cerrarSesion">Cerrar Sesión</a>
            <a href="/userPanel">Panel de Usuario</a>
            <a href="/anuncios">Anuncios</a>
            <a href="/src/Model/IA/index.php">IA</a>
            <a href="/crearAnuncio"><button class="button button-primary">Subir +</button></a>
        </div>';
            }
        } else {
            echo '<div class="list-elements">
            <a href="/index.php">Inicio</a>
            <a href="/login">Iniciar Sesión</a>
            <a href="#">Sobre Nosotros</a>
            <a href="/anuncios">Anuncios</a>
           
        </div>';
        }
        ?>

    </nav>
</header>
