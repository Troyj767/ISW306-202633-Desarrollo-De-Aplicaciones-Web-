<div align="center">

# 🛍️ NovaShop

### Proyecto del Grupo 4 — Desarrollo de Aplicaciones Web (ISW306-202633)

![Status](https://img.shields.io/badge/estado-en%20construcci%C3%B3n-yellow)
![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)
![Fase](https://img.shields.io/badge/fase%20actual-3%20%2F%204-457B9D)

Tienda en línea desarrollada como proyecto académico a lo largo del trimestre.

</div>

---

## 📋 Descripción

**NovaShop** es un proyecto colaborativo del Grupo 4 para el curso **ISW306-202633 — Desarrollo de Aplicaciones Web**. Empezó como un esqueleto visual estático (Fase 1), ganó interactividad con JavaScript (Fase 2) y ahora tiene backend real con PHP, sesiones y base de datos MySQL (Fase 3), hasta terminar desplegada con un framework completo al final del trimestre (Fase 4).

## 🗺️ Fases del proyecto

| Fase | Contenido | Estado |
|---|---|---|
| **Fase 1 — Maquetación** | HTML5 semántico, CSS (externo/interno/en línea), identidad visual | ✅ Aprobada |
| **Fase 2 — Interactividad** | JavaScript (filtro de productos, validación del formulario) | ✅ Aprobada |
| **Fase 3 — Backend y datos** | Servidor local, login con sesiones, base de datos MySQL, CRUD | 🟡 En progreso |
| **Fase 4 — Framework y despliegue** | Migración a framework moderno + hosting | ⚪ Pendiente |

## 🚀 Tecnologías

- **HTML5 / CSS3** — estructura semántica y estilos (externo/interno/en línea)
- **JavaScript** — filtro de productos, validación de formularios en el cliente
- **PHP 8** — lógica de servidor, sesiones, conexión a base de datos (PDO)
- **MySQL / MariaDB** — persistencia de datos (productos, usuarios, mensajes de contacto)

*(El desglose exacto por lenguaje se puede ver en la barra de "Languages" de GitHub, arriba de este README.)*

## 📁 Estructura del proyecto

```
NovaShop/
├── index.php                  # Página de inicio (productos desde la BD)
├── nosotros.html               # Sobre nosotros
├── contacto.html                # Formulario de contacto (guarda de verdad en la BD)
├── css/
│   ├── styles.css               # Estilos del sitio público
│   └── admin.css                # Estilos del panel de administración
├── js/
│   ├── productos.js             # Filtro/búsqueda de productos
│   └── validacion.js            # Valida y envía el formulario de contacto
├── img/                          # Imágenes del sitio
├── config/
│   └── db.php                    # Conexión PDO a MySQL
├── includes/
│   ├── auth.php                   # Sesiones + requerirLogin()
│   ├── admin_header.php           # Encabezado compartido del panel
│   └── admin_footer.php           # Pie compartido del panel
├── auth/
│   ├── login.php                  # Formulario e inicio de sesión
│   └── logout.php                 # Cierre de sesión
├── admin/                          # Páginas privadas (requieren login)
│   ├── index.php                    # Panel con estadísticas
│   ├── mensajes.php                 # CRUD: listar mensajes de contacto
│   ├── mensaje_form.php              # CRUD: crear/editar mensaje
│   └── mensaje_eliminar.php          # CRUD: eliminar (con confirmación)
├── api/
│   └── contacto_guardar.php        # Endpoint público: guarda el formulario de contacto
├── db/
│   └── novashop.sql                # Script de creación de la base de datos
└── informe.pdf                     # Informe de la fase actual
```

## 🖥️ Cómo correrlo en local (servidor: XAMPP / WampServer / AppServ / EasyPHP)

1. **Servidor local:** instala XAMPP (u otro de los mencionados) y arranca **Apache** y **MySQL** desde su panel de control.
2. **Código:** clona (o copia) esta carpeta dentro de `htdocs` (XAMPP) o `www` (WampServer), por ejemplo `htdocs/novashop`.
3. **Base de datos:** abre `http://localhost/phpmyadmin`, pestaña **SQL**, pega el contenido completo de [`db/novashop.sql`](db/novashop.sql) y ejecútalo. Esto crea la base `novashop_db`, sus 3 tablas y datos de ejemplo.
4. **Configuración:** `config/db.php` usa por defecto el usuario `root` sin contraseña (el estándar de un XAMPP recién instalado), así que no hay que tocar nada. Si tu MySQL usa otro usuario/contraseña, **no edites `config/db.php`**: copia `config/db.local.example.php` como `config/db.local.php` y pon ahí tus datos. Ese archivo está en `.gitignore` y nunca se sube a GitHub.
5. **Abrir el sitio:** entra a `http://localhost/novashop/index.php`.
6. **Login del panel de administración:** `http://localhost/novashop/auth/login.php`
   - correo: `admin@novashop.com`
   - contraseña: `NovaShop2026`

> ⚠️ Estas son credenciales de **prueba académica**, no reales. Aun así, `config/db.php` y este README nunca deben llevar contraseñas de un servidor de producción real — solo las de desarrollo local.

## 🌿 Flujo de trabajo en Git

- La rama `main` contiene solo el trabajo aprobado de cada fase.
- Cada fase se trabaja en su propia rama (`fase-1-maquetacion`, `fase-2-javascript`, `fase-3-backend`, etc.) y se integra a `main` mediante Pull Request.
- Cada integrante commitea sus propios cambios desde su cuenta de GitHub.

```bash
git checkout main
git pull origin main
git checkout -b fase-3-backend
# ... hacer los cambios ...
git add .
git commit -m "feat: descripción clara del cambio"
git push origin fase-3-backend
# luego abrir un Pull Request hacia main
```

## 👥 Equipo — Grupo 4

| Integrante | Rol |
|---|---|
| Fernanda García Veloz | Líder |
| Winston Stevens Jiménez Reyes | Integrante |
| Luisanna Jiménez Reyes | Integrante |
| Yolwim Jhongelis Merán Pérez | Integrante |
| Erasmo José Minaya Taveras | Integrante |
| Daniel Esmill Pérez | Integrante |
| Carmen Nidia Soriano Martínez | Integrante |
| Robert Ulises Ureña Báez | Integrante |

## 📝 Notas

- Proyecto en desarrollo activo — puede haber cambios frecuentes.
- Coordinen en el tablero de ClickUp del equipo antes de hacer cambios significativos.
- Nunca subir contraseñas ni credenciales reales al repositorio.

---

<div align="center">

*Última actualización: 9 de septiembre de 2026*

</div>
