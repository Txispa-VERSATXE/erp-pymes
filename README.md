# ERP PYMES – Sistema de Gestión Empresarial

Aplicación web desarrollada con **Laravel 13 + MongoDB Atlas**, desplegada en **Railway**.

🌐 **URL de producción:** https://web-production-755fc.up.railway.app

---

## Credenciales de acceso

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | admin@erp.com | admin123 |
| Empleado | empleado@erp.com | emp123 |

---

## Requisitos previos (instalación local)

- PHP 8.3 o superior con extensiones: `mongodb`, `gd`, `zip`, `intl`, `bcmath`
- Composer 2.x
- Node.js 18+ y npm
- Cuenta en [MongoDB Atlas](https://cloud.mongodb.com) (o MongoDB local)
- Git

---

## Instalación local paso a paso

### 1. Clonar el repositorio

```bash
git clone https://github.com/Txispa-VERSATXE/erp-pymes.git
cd erp-pymes
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias frontend

```bash
npm install && npm run build
```

### 4. Configurar el archivo de entorno

Copia el archivo de ejemplo y edítalo:

```bash
cp .env.example .env
```

Abre `.env` y configura las siguientes variables — **este es el archivo de configuración global de la aplicación**:

```env
APP_NAME="ERP PYMEs"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# ── Base de datos MongoDB ──────────────────────────────
DB_CONNECTION=mongodb
DB_URI=mongodb+srv://USUARIO:PASSWORD@cluster0.XXXXX.mongodb.net/
DB_DATABASE=erp_pymes

# ── Sesiones y caché ───────────────────────────────────
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=array
QUEUE_CONNECTION=sync
```

> ⚠️ Sustituye `USUARIO`, `PASSWORD` y el host del cluster por los datos de tu MongoDB Atlas.  
> Si usas MongoDB local, cambia `DB_URI` por `mongodb://127.0.0.1:27017`.

### 5. Generar la clave de aplicación

```bash
php artisan key:generate
```

### 6. Arrancar el servidor local

```bash
php artisan serve
```

La aplicación estará disponible en **http://localhost:8000**.

---

## Archivo de configuración global

El archivo **`.env`** en la raíz del proyecto centraliza toda la configuración de la aplicación:

| Variable | Descripción |
|----------|-------------|
| `APP_NAME` | Nombre de la aplicación |
| `APP_ENV` | Entorno (`local` o `production`) |
| `APP_DEBUG` | Modo debug (`true` en local, `false` en producción) |
| `APP_URL` | URL base de la aplicación |
| `DB_CONNECTION` | Driver de base de datos (`mongodb`) |
| `DB_URI` | Cadena de conexión completa a MongoDB |
| `DB_DATABASE` | Nombre de la base de datos |
| `SESSION_DRIVER` | Driver de sesiones (`file` en producción) |
| `APP_KEY` | Clave de cifrado (generada con `artisan key:generate`) |

---

## Estructura del proyecto

```
erp-pymes/
├── app/
│   ├── Http/Controllers/     # Controladores de cada módulo
│   ├── Http/Middleware/      # Middleware de autenticación y roles
│   └── Models/               # Modelos Eloquent (MongoDB)
├── public/
│   └── images/               # Logo e imágenes estáticas
├── resources/
│   └── views/
│       ├── layouts/          # Layout principal (app.blade.php)
│       ├── auth/             # Pantalla de login
│       ├── clientes/         # Vistas del módulo Clientes
│       ├── productos/        # Vistas del módulo Productos
│       ├── ventas/           # Vistas del módulo Ventas
│       ├── compras/          # Vistas del módulo Compras
│       ├── proveedores/      # Vistas del módulo Proveedores
│       ├── inventario/       # Vistas del módulo Inventario
│       └── usuarios/         # Vistas de administración
├── routes/
│   └── web.php               # Definición de rutas
├── Dockerfile                # Imagen Docker para despliegue en Railway
├── .env.example              # Plantilla de configuración
└── README.md                 # Este archivo
```

---

## Módulos disponibles

| Módulo | Funcionalidades |
|--------|----------------|
| Dashboard | KPIs, alertas de stock, gráfica de ventas |
| Clientes | CRUD completo + exportación Excel/PDF |
| Productos | CRUD + control de stock + alertas |
| Ventas | CRUD + estados (pagado/pendiente) + exportación |
| Compras | CRUD + vinculación con proveedores |
| Proveedores | CRUD completo + exportación |
| Inventario | Niveles visuales + ajustes manuales |
| Administración | Gestión de usuarios y roles (solo admin) |
| Perfil | Edición de datos personales y contraseña |

---

## Despliegue en Railway (producción)

El proyecto incluye un **Dockerfile** listo para desplegar en Railway:

1. Conectar el repositorio GitHub en [railway.app](https://railway.app)
2. En **Settings → Build**, seleccionar builder **Dockerfile**
3. Configurar las variables de entorno en **Variables → Raw Editor** con los valores de producción (ver sección anterior, usando `APP_ENV=production` y `APP_DEBUG=false`)
4. Cualquier `git push` a `main` despliega automáticamente

---

## Stack tecnológico

| Tecnología | Versión | Rol |
|------------|---------|-----|
| Laravel | 13.8.0 | Framework backend (MVC) |
| PHP | 8.3.31 | Lenguaje servidor |
| MongoDB Atlas | M0 Free | Base de datos en la nube |
| laravel-mongodb | 5.7.1 | Driver ODM para Eloquent |
| maatwebsite/excel | 3.1.69 | Exportación Excel |
| barryvdh/laravel-dompdf | 3.1 | Generación de PDFs |
| Tailwind CSS / Bootstrap 5 | — | Frontend |
| Docker | php:8.3-cli | Contenedor de producción |
| Railway | Hobby Plan | Plataforma de despliegue |

---

## Licencia

Proyecto académico – CIFP Avilés · 2º DAW · Curso 2025-2026
