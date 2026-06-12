# Car2iu — TFC Alejandro Merino Cubero

Plataforma web de compraventa de vehículos de segunda mano con módulo de inteligencia artificial integrado.

---

## Descripción

Car2iu es una aplicación web desarrollada como Trabajo de Fin de Ciclo por **Alejandro Merino Cubero**. Se trata de un marketplace de vehículos de segunda mano orientado al mercado español, que permite a los usuarios publicar, buscar y contactar vendedores de forma directa, sin intermediarios.

### Funcionalidades principales

- **Sistema de anuncios** — publicación de vehículos con imagen, precio, kilometraje, marca, año y ubicación
- **Módulo de IA integrado** — asistente especializado en automoción (GPT-4o mini) que asesora sobre fiabilidad, averías, precios de mercado y elección de motorización
- **Sistema de usuarios** — registro, login, perfil, cambio de avatar, contraseña y email
- **Panel de administración** — gestión de usuarios, anuncios y reportes
- **Sistema de reportes** — los usuarios pueden reportar anuncios inapropiados
- **Contacto directo** — el email del vendedor se muestra al interesado con un clic
- **Diseño responsive** — adaptado a móvil, tablet y escritorio

---

## Tecnologías utilizadas

- **Backend:** PHP 8 (arquitectura MVC sin framework)
- **Frontend:** HTML5, CSS3 (modular por componentes), JavaScript vanilla
- **Base de datos:** MySQL
- **IA:** OpenAI API (GPT-4o mini)
- **Servidor:** Apache con mod_rewrite (.htaccess)
- **Hosting:** InfinityFree

---

## Instalación

### ⚠️ Nota sobre el repositorio

El proyecto se distribuye principalmente como archivo **ZIP** debido a que los archivos de configuración contienen una API key de OpenAI, lo que activa la protección de secretos de GitHub e impide el push normal al repositorio.

Para desplegar el proyecto:

1. **Descarga el ZIP** del proyecto
2. **Extrae** los archivos en la raíz de tu servidor web
3. **Configura la base de datos** — crea el archivo `src/Model/db_config.php` con tus credenciales:

```php
<?php
return [
    'host'     => 'tu_host',
    'username' => 'tu_usuario',
    'password' => 'tu_password',
    'dbName'   => 'tu_base_de_datos',
    'port'     => 3306,
];
```

4. **Configura la IA** — crea el archivo `src/Model/ia_config.php` con tu API key de OpenAI:

```php
<?php
return [
    'provider' => 'openai',
    'openai' => [
        'api_key' => 'sk-tu-api-key',
        'model'   => 'gpt-4o-mini',
        'url'     => 'https://api.openai.com/v1/chat/completions',
    ],
];
```

5. **Importa la base de datos** — ejecuta el script `sql/createDatabase.sql` en tu servidor MySQL
6. **Comprueba el `.htaccess`** — si la app no está en la raíz del dominio, ajusta el `RewriteBase` del `.htaccess` principal

---

## Estructura del proyecto

```
car2iu/
├── .htaccess                  # Rutas limpias (mod_rewrite)
├── index.php                  # Página principal
├── composer.json
├── public/
│   └── assets/
│       ├── css/               # Estilos modulares por componente
│       └── js/                # Scripts por funcionalidad
├── src/
│   ├── Controller/            # Controladores (lógica de negocio)
│   ├── Model/                 # Modelos y configuración
│   └── View/                  # Vistas PHP + partials
├── lib/                       # PHPMailer
├── uploads/                   # Imágenes subidas por usuarios
├── storage/logs/              # Logs de la aplicación
└── sql/                       # Script de creación de la BD
```

---

## Autor

**Alejandro Merino Cubero**  
Trabajo de Fin de Ciclo — Desarrollo de Aplicaciones Web
