<?php

class Database
{

    private $host;
    private $username;
    private $password;
    private $dbName;
    private $conn;
    private $port;

 public function __construct(
    $host = 'sql210.infinityfree.com',
    $username = 'if0_41267709',
    $password = 'acakoj56J',
    $dbName = 'if0_41267709_car2iu',
    $port = 3306
) {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->dbName = $dbName;
    $this->port = $port;
}

public function dbConnect()
{
    $this->conn = new mysqli(
        $this->host,
        $this->username,
        $this->password,
        $this->dbName,
        $this->port
    );

    if ($this->conn->connect_error) {
        die("Error de conexión: " . $this->conn->connect_error); // temporal para debug
        return false;
    }
    $this->conn->set_charset('utf8mb4');
    return $this->conn;
}

    public function registrarUsuario()
    {
        $conn = $this->dbConnect();

        if ($conn === false) {
            header('index.php');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = $_POST['nombre'];
                //Hay que ajustar aqui el insert
                $email = $_POST['email'];
                $password = $_POST['password'];
                $tlf = $_POST['telefono'];

                //Hay que verificar si el usuario ya esta registrado en la web

                $sql = "SELECT * FROM usuarios WHERE email = ? OR nombre = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $email, $nombre);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $stmt->close();
                    header('Location: /registro?error=duplicado');
                    exit();
                } else {
                    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO usuarios (nombre, email, contraseña, telefono) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ssss', $nombre, $email, $password_hashed, $tlf);
                    $stmt->execute();
                    $stmt->close();
                    header('Location: /login');
                    exit();
                }
            }
        }
    }


    public function iniciarSesion()
    {
        $conn = $this->dbConnect();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "SELECT id_usuario, avatar_ruta, nombre, email, contraseña FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();

                if (password_verify($password, $usuario['contraseña'])) {
                    if (session_status() === PHP_SESSION_NONE) {
                        ini_set('session.cookie_lifetime', 0);
                        session_start();
                    }
                    $_SESSION['id'] = $usuario['id_usuario'];
                    $_SESSION['usuario'] = $usuario['nombre'];
                    $_SESSION['email'] = $usuario['email'];
                    $_SESSION['avatar'] = $usuario['avatar_ruta'];

                    header('Location: /');
                    exit;
                } else {
                    header('Location: /login?error=1');
                    exit();
                }
            } else {
                header('Location: /login?error=no_user');
                exit;
            }
        }
    }
    public function cambiarPassword($passActual, $passNuevaHash)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            header('Location: /login');
            exit();
        }

        $conn = $this->dbConnect();
        $email = $_SESSION['email'];

        $sql = "SELECT contraseña FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();

        if ($usuario && password_verify($passActual, $usuario['contraseña'])) {
            $sql = "UPDATE usuarios SET contraseña = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $passNuevaHash, $email);

            if ($stmt->execute()) {
                $stmt->close();
                header('Location: /userPanel?pass=1');
                exit();
            }
        } else {
            header('Location: /userPanel?pass=1');
            exit();
        }
    }

    public function cambiarEmail($email, $nuevoEmail)
    {
        if ($email === $_SESSION['email']) {
            $conn = $this->dbConnect();
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nuevoEmail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();
                header("Location: /userPanel?email=1");
                exit();
            } else {
                $sql = "UPDATE usuarios SET email = ? WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $nuevoEmail, $email);
                $stmt->execute();
                header("Location: /userPanel");

            }
        } else {
            header("Location: /userPanel?email=2");
        }

    }
    public function cambiarNombre($nombre, $nuevoNombre)
    {
        $conn = $this->dbConnect();
        $sql = "SELECT nombre FROM usuarios WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            $stmt->close();
        }

        if ($nombre === $usuario['nombre']) {

            $sql = "SELECT * FROM usuarios WHERE nombre = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nuevoNombre);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                header("Location: /userPanel?nombre=1");
                //1 es que el nombre ya está en uso, lo paso por get para poder colocar el error
                exit();
            } else {
                $sql = "UPDATE usuarios SET nombre = ? WHERE nombre = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $nuevoNombre, $nombre);
                $stmt->execute();
                $stmt->close();
                header("Location: /userPanel?email=1");
            }
        } else {
            header("Location: /userPanel?nombre=2");
        }
    }


    public function guardarAvatar($ruta, $nombre)
    {
        $conn = $this->dbConnect();

        $sql = "UPDATE usuarios SET avatar_ruta = ? WHERE nombre = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ss', $ruta, $nombre);
            $stmt->execute();
            $stmt->close();
        }
    }


   public function listarAnuncios()
{
    $conn = $this->dbConnect();
    
    $sql = "SELECT anuncios.*, usuarios.nombre 
            FROM anuncios
            LEFT JOIN usuarios ON anuncios.id_usuario = usuarios.id_usuario";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $anuncios = $result->fetch_all(MYSQLI_ASSOC);
        return $anuncios;
    } else {
        return false;
    }
}

public function listarAnunciosPaginados(int $offset = 0, int $limit = 9): array
{
    $conn = $this->dbConnect();
    $sql  = "SELECT anuncios.*, usuarios.nombre
             FROM anuncios
             LEFT JOIN usuarios ON anuncios.id_usuario = usuarios.id_usuario
             ORDER BY anuncios.id_anuncio DESC
             LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function contarAnuncios(): int
{
    $conn = $this->dbConnect();
    $result = $conn->query("SELECT COUNT(*) AS total FROM anuncios");
    $row = $result->fetch_assoc();
    return (int)($row['total'] ?? 0);
}
   
    public function listarAnunciosUsuario()
    {
        $conn = $this->dbConnect();
        $sql = "SELECT anuncios.*, usuarios.nombre 
FROM anuncios
INNER JOIN usuarios ON anuncios.id_usuario = usuarios.id_usuario
WHERE anuncios.id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $anuncios = $result->fetch_all(MYSQLI_ASSOC);
            return $anuncios;
        } else {
            return false;
        }
    }
    
    
    
    public function nuevoAnuncio($titulo, $marca, $anio, $kilometraje, $precio, $descripcion, $ruta, $ubicacion)
    {
        $conn = $this->dbConnect();
        $sql = "INSERT INTO anuncios (id_usuario, titulo, marca, anio, kilometraje, descripcion, precio, ruta, ubicacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Orden según columnas SQL: id_usuario, titulo, marca, anio, kilometraje, descripcion, precio, ruta, ubicacion
        $stmt->bind_param('issiisdss', $_SESSION['id'], $titulo, $marca, $anio, $kilometraje, $descripcion, $precio, $ruta, $ubicacion);
        $stmt->execute();
        $stmt->close();
    }
    public function listarAnuncio($id)
{
    $conn = $this->dbConnect();

    $sql = "SELECT anuncios.*, usuarios.nombre 
            FROM anuncios
            INNER JOIN usuarios ON anuncios.id_usuario = usuarios.id_usuario
            WHERE anuncios.id_anuncio = ?"; 

    $stmt = $conn->prepare($sql);
    
   
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        
        return $result->fetch_assoc(); 
    } else {
        return false;
    }
}

public function datosUsuario($id) {
    $conn = $this->dbConnect();
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        
        return $result->fetch_assoc();
    }
    
    return null;
}


public function eliminarAnuncio($id){
    $conn = $this->dbConnect();
    $sql = "DELETE FROM anuncios WHERE id_anuncio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

public function venta($id){
    $conn = $this->dbConnect();
    if (!$conn) return false;

    // Verificar que el anuncio existe
    $check = $conn->prepare("SELECT id_anuncio FROM anuncios WHERE id_anuncio = ?");
    if (!$check) return false;
    $check->bind_param('i', $id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        $check->close();
        return false; // El anuncio no existe
    }
    $check->close();

    // Hacer el UPDATE (aunque affected_rows sea 0 porque ya estaba vendido, es correcto)
    $stmt = $conn->prepare("UPDATE anuncios SET vendido = 1 WHERE id_anuncio = ?");
    if (!$stmt) return false;
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result; // true si el UPDATE se ejecutó sin error
}

public function contadorVentas($id){
   $conn = $this->dbConnect();

   $sql = "SELECT * FROM anuncios WHERE id_usuario = ? AND vendido = 1";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param('i', $id);
   $stmt->execute();

   $result = $stmt->get_result();

   if($result->num_rows > 0){
       return $result->fetch_all(MYSQLI_ASSOC);
   }else{
       return [];
   }
}

public function verificarAdmin($id) {
    $conn = $this->dbConnect();
    $sql = "SELECT es_admin FROM usuarios WHERE id_usuario = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
       //en caso de que en la base de datos sea true, devolvemos true, en caso contrario devolvemos false todo el rato.
        return (bool)$row['es_admin'];
    }

    return false;
}

public function reportes(){
    $conn = $this->dbConnect();
    $sql = "SELECT 
                r.id_reporte,
                r.motivo,
                r.descripcion,
                r.fecha_reporte,
                u_reportador.nombre AS nombre_reportador,
                u_reportado.nombre AS nombre_reportado,
                u_reportado.id_usuario AS id_usuario,
                u_reportado.email AS email_reportado,
                a.titulo AS anuncio_titulo,
                r.estado
            FROM reportes r
            JOIN usuarios u_reportador ON r.id_usuario = u_reportador.id_usuario
            JOIN anuncios a ON r.id_anuncio = a.id_anuncio
            JOIN usuarios u_reportado ON a.id_usuario = u_reportado.id_usuario";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return false;
    }
}

public function nuevoReporte($id_anuncio, $id_usuario, $motivoReporte){
    $conn = $this->dbConnect();
    $stmt = $conn->prepare("INSERT INTO reportes (id_anuncio, id_usuario, motivo, descripcion) VALUES (?, ?, 'Reporte de usuario', ?)");
    $stmt->bind_param("iis", $id_anuncio, $id_usuario, $motivoReporte);
    $stmt->execute();
    $stmt->close();
}

public function borrarCuenta($id_usuario){
    $conn = $this->dbConnect();
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

public function marcarLeido($id_reporte){
    $conn = $this->dbConnect();
    $stmt = $conn->prepare("UPDATE reportes SET estado = 'leido' WHERE id_reporte = ?");
    $stmt->bind_param("i", $id_reporte);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

    // ================================================================
    // CHAT
    // ================================================================

    /**
     * Obtiene o crea un chat entre dos usuarios, opcionalmente ligado a un anuncio.
     * Garantiza que id_usuario_1 < id_usuario_2 para no duplicar.
     */
    public function obtenerOCrearChat(int $uid1, int $uid2, ?int $idAnuncio = null): ?int {
        $conn = $this->dbConnect();
        if (!$conn) return null;

        // normalizar orden
        [$a, $b] = $uid1 < $uid2 ? [$uid1, $uid2] : [$uid2, $uid1];

        // buscar existente
        if ($idAnuncio) {
            $sql = "SELECT id_chat FROM chats WHERE id_usuario_1=? AND id_usuario_2=? AND id_anuncio=? LIMIT 1";
            $st  = $conn->prepare($sql);
            $st->bind_param('iii', $a, $b, $idAnuncio);
        } else {
            $sql = "SELECT id_chat FROM chats WHERE id_usuario_1=? AND id_usuario_2=? AND id_anuncio IS NULL LIMIT 1";
            $st  = $conn->prepare($sql);
            $st->bind_param('ii', $a, $b);
        }
        $st->execute();
        $res = $st->get_result();
        if ($row = $res->fetch_assoc()) return (int)$row['id_chat'];

        // crear nuevo
        if ($idAnuncio) {
            $ins = $conn->prepare("INSERT INTO chats (id_usuario_1, id_usuario_2, id_anuncio) VALUES (?,?,?)");
            $ins->bind_param('iii', $a, $b, $idAnuncio);
        } else {
            $ins = $conn->prepare("INSERT INTO chats (id_usuario_1, id_usuario_2) VALUES (?,?)");
            $ins->bind_param('ii', $a, $b);
        }
        $ins->execute();
        return (int)$conn->insert_id;
    }

    /** Devuelve todos los chats de un usuario con datos del interlocutor y último mensaje */
    public function listarChatsUsuario(int $uid): array {
        $conn = $this->dbConnect();
        if (!$conn) return [];
        $sql = "
            SELECT c.id_chat, c.id_anuncio,
                   CASE WHEN c.id_usuario_1 = ? THEN c.id_usuario_2 ELSE c.id_usuario_1 END AS id_otro,
                   u.nombre  AS nombre_otro,
                   u.avatar_ruta AS avatar_otro,
                   a.titulo  AS titulo_anuncio,
                   (SELECT contenido  FROM mensajes WHERE id_chat=c.id_chat ORDER BY enviado_en DESC LIMIT 1) AS ultimo_msg,
                   (SELECT enviado_en FROM mensajes WHERE id_chat=c.id_chat ORDER BY enviado_en DESC LIMIT 1) AS ultimo_ts,
                   (SELECT COUNT(*)   FROM mensajes WHERE id_chat=c.id_chat AND id_emisor<>? AND leido=0) AS no_leidos
            FROM chats c
            JOIN usuarios u ON u.id_usuario = CASE WHEN c.id_usuario_1=? THEN c.id_usuario_2 ELSE c.id_usuario_1 END
            LEFT JOIN anuncios a ON a.id_anuncio = c.id_anuncio
            WHERE c.id_usuario_1=? OR c.id_usuario_2=?
            ORDER BY ultimo_ts DESC
        ";
        $st = $conn->prepare($sql);
        $st->bind_param('iiiii', $uid, $uid, $uid, $uid, $uid);
        $st->execute();
        return $st->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Devuelve los mensajes de un chat (máx 100 últimos) */
    public function mensajesChat(int $idChat, int $uid): array {
        $conn = $this->dbConnect();
        if (!$conn) return [];
        // marcar como leídos los del interlocutor
        $upd = $conn->prepare("UPDATE mensajes SET leido=1 WHERE id_chat=? AND id_emisor<>?");
        $upd->bind_param('ii', $idChat, $uid);
        $upd->execute();

        $sql = "SELECT m.id_mensaje, m.id_emisor, m.contenido, m.enviado_en, m.leido,
                       u.nombre AS nombre_emisor, u.avatar_ruta
                FROM mensajes m
                JOIN usuarios u ON u.id_usuario = m.id_emisor
                WHERE m.id_chat = ?
                ORDER BY m.enviado_en ASC
                LIMIT 100";
        $st = $conn->prepare($sql);
        $st->bind_param('i', $idChat);
        $st->execute();
        return $st->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Envía un mensaje */
    public function enviarMensaje(int $idChat, int $idEmisor, string $contenido): bool {
        $conn = $this->dbConnect();
        if (!$conn) return false;
        // Verificar que el emisor pertenece al chat
        $check = $conn->prepare("SELECT id_chat FROM chats WHERE id_chat=? AND (id_usuario_1=? OR id_usuario_2=?)");
        $check->bind_param('iii', $idChat, $idEmisor, $idEmisor);
        $check->execute();
        if ($check->get_result()->num_rows === 0) return false;

        $st = $conn->prepare("INSERT INTO mensajes (id_chat, id_emisor, contenido) VALUES (?,?,?)");
        $st->bind_param('iis', $idChat, $idEmisor, $contenido);
        return $st->execute();
    }

    /** Info básica de un chat (para verificar acceso) */
    public function infoChat(int $idChat, int $uid): ?array {
        $conn = $this->dbConnect();
        if (!$conn) return null;
        $st = $conn->prepare("
            SELECT c.*, a.titulo AS titulo_anuncio,
                   CASE WHEN c.id_usuario_1=? THEN c.id_usuario_2 ELSE c.id_usuario_1 END AS id_otro,
                   u.nombre AS nombre_otro, u.avatar_ruta AS avatar_otro
            FROM chats c
            LEFT JOIN anuncios a ON a.id_anuncio = c.id_anuncio
            JOIN usuarios u ON u.id_usuario = CASE WHEN c.id_usuario_1=? THEN c.id_usuario_2 ELSE c.id_usuario_1 END
            WHERE c.id_chat=? AND (c.id_usuario_1=? OR c.id_usuario_2=?)
        ");
        $st->bind_param('iiiii', $uid, $uid, $idChat, $uid, $uid);
        $st->execute();
        $row = $st->get_result()->fetch_assoc();
        return $row ?: null;
    }

}
