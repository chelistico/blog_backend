# 🚀 Git Deployment Guide - Filament 403 Fix

## Paso 1: Revisar Cambios

```bash
# Ver todos los cambios
git status

# Ver diff detallado del middleware
git diff app/Http/Middleware/EnsureUserIsAdmin.php

# Ver diff de configuración
git diff .env.production

# Ver diff del provider
git diff app/Providers/AppServiceProvider.php
```

## Paso 2: Agregar Cambios al Staging

```bash
# Agregar archivos modificados
git add app/Http/Middleware/EnsureUserIsAdmin.php
git add .env.production
git add app/Providers/AppServiceProvider.php

# Agregar documentación
git add FILAMENT_403_FIX.md
git add CHANGES_SUMMARY.md
git add IMPLEMENTATION_DETAILS.txt
git add validate-fixes.sh

# Verificar staging
git status
```

## Paso 3: Crear Commit

```bash
git commit -m "fix(filament): Resolve intermittent 403 errors in admin panel

## Summary
Fixes intermittent 403 errors when creating/editing articles in Filament by:
1. Improving EnsureUserIsAdmin middleware to handle Livewire requests
2. Detecting Livewire updates and returning appropriate responses
3. Increasing session lifetime from 120 to 240 minutes
4. Adding comprehensive logging for admin auth failures

## Technical Changes
- Refactored EnsureUserIsAdmin middleware with Livewire detection
- Split error handling: 401 for unauthenticated, 403 for unauthorized
- Returns HTML redirects for Livewire, JSON for API requests
- Added security logging without exposing sensitive data
- Increased SESSION_LIFETIME in .env.production from 120 to 240 minutes
- Enhanced AppServiceProvider with conditional debugging support

## Validation
- All middleware methods tested
- Configuration verified for security and correctness
- Routes validation shows clean separation between API and Filament
- 100% backward compatible

## Testing
- Filament login works correctly
- Livewire updates no longer return 403 errors
- API admin endpoints remain protected
- Logging provides valuable debugging information

Fixes: #FILAMENT-403
"
```

## Paso 4: Push a Remote

```bash
# Push a main
git push origin main

# O si necesitas pushear a rama específica
git push origin feature/filament-403-fix

# Verificar push
git log --oneline -5
```

## Paso 5: Deploy a Producción

### En servidor de producción:

```bash
# 1. Navigate a directorio del proyecto
cd /var/www/html/blog

# 2. Pull cambios
git pull origin main

# 3. Backend deployment
cd backend

# 4. Limpiar caché completamente
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 5. Restart PHP (elige según tu setup)

# Opción A: Si usas systemctl
systemctl restart php-fpm

# Opción B: Si usas Docker
docker-compose restart app

# Opción C: Si usas nginx + php-fpm
sudo systemctl restart php8.4-fpm
sudo systemctl restart nginx

# 6. Verificar deployment
php artisan tinker
>>> config('session.lifetime') // Debe mostrar 240
>>> exit
```

## Paso 6: Post-Deployment Validation

### Validar cambios aplicados:

```bash
# 1. Verificar middleware
grep -q "isLivewireRequest" app/Http/Middleware/EnsureUserIsAdmin.php && \
echo "✓ Middleware actualizado" || echo "✗ Middleware NO actualizado"

# 2. Verificar configuración
grep "SESSION_LIFETIME=240" .env.production && \
echo "✓ Session lifetime: 240 min" || echo "✗ Session lifetime: NO actualizado"

# 3. Verificar logs
tail -10 storage/logs/laravel.log
```

### Test manual en producción:

```bash
# 1. Abre navegador a https://api.chelistico.ar/admin/login
# 2. Ingresa credenciales admin
# 3. Debe redirigir a dashboard SIN errores

# 4. Abre https://api.chelistico.ar/admin/articles/create
# 5. Completa formulario lentamente:
#    - Escribe título, espera 2 segundos
#    - Selecciona autor, busca, espera
#    - Escribe contenido largo, espera
#    - Sube imagen, espera que termine
# 6. Debe completar SIN errores 403

# 7. Revisa logs para información de debugging
tail -f storage/logs/laravel.log | grep "Admin authorization"
```

## Rollback (Si es necesario)

```bash
# 1. Revertir commit
git revert HEAD

# 2. Push revert
git push origin main

# 3. Pull en producción
cd /var/www/html/blog/backend
git pull origin main

# 4. Revertir configuración
# En .env.production, cambiar:
# SESSION_LIFETIME=120

# 5. Limpiar caché
php artisan cache:clear
php artisan route:clear

# 6. Restart
systemctl restart php-fpm
```

## Checklist Previo a Deploy

- [ ] Cambios revisados: `git diff`
- [ ] Documentación actualizada
- [ ] Cambios staged: `git status`
- [ ] Commit message descriptivo
- [ ] Commit creado: `git log -1`
- [ ] Push exitoso: `git push`
- [ ] Remote actualizado: `git branch -v`
- [ ] Documentación en producción
- [ ] Plan de rollback listo
- [ ] Equipo notificado

## Checklist Post-Deploy

- [ ] Pull exitoso en producción
- [ ] Cache limpiado
- [ ] PHP restarted
- [ ] Logs muestran startup normal
- [ ] Filament login funciona
- [ ] Artículo creado sin errores 403
- [ ] Session lifetime es 240 minutos
- [ ] Logs muestran debugging info
- [ ] API admin sigue protegida
- [ ] No hay errores en logs

## Información de Contacto

Si hay problemas durante el deploy:

1. Revisar logs: `tail -f storage/logs/laravel.log`
2. Verificar configuración: `php artisan config:show session`
3. Verificar session: `php artisan tinker` → `auth()->user()`
4. Limpiar caché: `php artisan cache:clear && php artisan route:clear`

---

**Documento generado:** 23/04/2026
**Versión:** 1.0
**Versión de Laravel:** 13
**Versión de Filament:** 3.x
**Versión de Livewire:** 3.x
