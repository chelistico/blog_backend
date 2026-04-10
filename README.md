# TechDaily Backend - API Laravel 12

API REST para el blog de tecnología TechDaily.

## Entorno Docker

Este proyecto está diseñado para funcionar en un entorno Docker.

### Contenedores

| Contenedor | Servicio | Propósito |
|------------|----------|-----------|
| `docker_php84` | Apache + PHP 8.4 | Servidor web API |
| `docker_mysql` | MySQL 8.x | Base de datos |

### Configuración MySQL

| Parámetro | Valor |
|-----------|-------|
| Host | `docker_mysql` |
| Puerto | `3306` |
| Usuario | `root` |
| Contraseña | `toor` |
| Base de datos | `techdaily` |

## Instalación en Docker

### 1. Verificar conexión a la base de datos

```bash
docker exec -w /var/www/html/blog/backend docker_php84 php artisan db:show
```

### 2. Crear base de datos si no existe

```bash
docker exec docker_mysql mysql -uroot -ptoor -e "CREATE DATABASE IF NOT EXISTS techdaily CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. Ejecutar migraciones

```bash
docker exec -w /var/www/html/blog/backend docker_php84 php artisan migrate
```

### 4. Ejecutar seeders (primera vez)

```bash
docker exec -w /var/www/html/blog/backend docker_php84 php artisan db:seed
```

### 5. Verificar funcionamiento

```bash
curl http://blog-api.local/
curl http://blog-api.local/api/home
```

## URLs

### Desarrollo
- **API Base URL**: http://blog-api.local/api
- **Virtual Host**: Apuntando a `/var/www/html/blog/backend/public`

### Producción
- **API Base URL**: https://api.chelistico.ar/api

## Comandos Laravel (dentro del contenedor)

```bash
# Ubicación del proyecto
cd /var/www/html/blog/backend

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Migraciones
php artisan migrate
php artisan migrate:fresh
php artisan migrate:status

# Seeders
php artisan db:seed

# Ver rutas
php artisan route:list

# Información del sistema
php artisan about
```

## Endpoints API

### Artículos
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/articles | Listar artículos |
| GET | /api/articles/{id} | Ver artículo |
| GET | /api/articles/search?q= | Buscar |
| GET | /api/articles/by-tag/{tag} | Por tag |
| GET | /api/articles/latest | Últimos |
| GET | /api/articles/popular | Populares |

### Recursos
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/tags | Listar tags |
| GET | /api/authors | Listar autores |
| GET | /api/settings | Configuraciones |
| GET | /api/advertisements | Anuncios |
| GET | /api/footer | Footer |

### SEO
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/seo/article/{id} | JSON-LD artículo |
| GET | /api/seo/website | JSON-LD website |

### Homepage
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | /api/home | Datos completos homepage |

### Autenticación
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| POST | /api/auth/register | Registro |
| POST | /api/auth/login | Login |
| POST | /api/auth/logout | Logout |
| GET | /api/auth/me | Usuario actual |

### Admin (requiere autenticación)
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| CRUD | /api/admin/articles | Gestión artículos |
| CRUD | /api/admin/tags | Gestión tags |
| CRUD | /api/admin/authors | Gestión autores |
| CRUD | /api/admin/advertisements | Gestión anuncios |
| CRUD | /api/admin/footer | Gestión footer |
| GET/PUT | /api/admin/settings | Configuraciones |

## Comandos Artisan

```bash
# Servidor de desarrollo
php artisan serve --host=0.0.0.0 --port=80

# Migraciones
php artisan migrate
php artisan migrate:fresh
php artisan migrate:fresh --seed

# Limpiar cachés
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear

# Publicar assets
php artisan vendor:publish --all
```

## Testing

```bash
# Ejecutar tests
php artisan test

# Con coverage
php artisan test --coverage
```

## Estructura del Proyecto

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/           # Controladores API públicos
│   │   │   └── Admin/         # Controladores admin
│   │   ├── Resources/          # API Resources (transformers)
│   │   └── Requests/          # Form Requests
│   ├── Models/                 # Modelos Eloquent
│   └── Services/              # Lógica de negocio
├── config/                     # Configuraciones Laravel
├── database/
│   ├── factories/              # Factories para testing
│   ├── migrations/             # Migraciones BD
│   └── seeders/               # Seeders de datos
├── routes/
│   └── api.php                # Rutas API
├── storage/
│   └── app/public/            # Archivos públicos (imágenes)
└── tests/                     # Tests
```

## Configuración de Dominio

### Desarrollo (blog-api.local)

El backend está configurado para funcionar en `blog-api.local` apuntando a `backend/public`.

Agregar en `/etc/hosts`:
```
127.0.0.1  blog-api.local
```

### Producción (api.chelistico.ar)

Configurar el virtual host para que apunte a `backend/public` y habilitar SSL.

## Documentación

- [Plan general del proyecto](../README.md)
- [Workitems](../.opencode/workitems/00-plan-overview.md)
