# BlockPC Plantilla para Laravel

Este repositorio contiene plantillas para frontend y backend para una aplicación de Laravel.

## Contenido:
- Laravel 12
- Tailwind CSS
- Livewire 3
- Alpine.js
- Pest (Testing)

## Paquetes instalados para Laravel:
- [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) (solo para desarrollo)
- [christophrumpel/missing-livewire-assertions](https://github.com/christophrumpel/missing-livewire-assertions)
- [spatie/laravel-permission](https://spatie.be/index.php/docs/laravel-permission)
- [intervention/image](http://image.intervention.io/)

## Iconos [blade-ui-kit/blade-icons](https://github.com/blade-ui-kit/blade-icons)
- [Boxicons](https://github.com/mallardduck/blade-boxicons)
- [Heroicons](https://github.com/blade-ui-kit/blade-heroicons)

## Laravel [Reverb](https://reverb.laravel.com/)

> **Nota:** No olvides limpiar la caché de iconos si no se ven correctamente

**Helpers:** archivo `Blockpc\helpers.php`

## Paquetes NPM:
- [tailwind-scrollbar](https://github.com/adoxography/tailwind-scrollbar)

Este repositorio incluye un modelo `Profile` (one-to-one para user) y un modelo `Image` (modelo polimórfico).

## Instalación

Primero clona el repositorio:

```bash
git clone https://github.com/blockpc/blockpc-11 _your-name-project_
```

A continuación:

```bash
cd _your-name-project_
cp .env.example .env  # Configura tu app name, app url, database, email, etc
composer install
```

### Si NO usas Laravel SAIL:

```bash
php artisan key:generate
php artisan storage:link
php artisan icons:cache
php artisan migrate --seed
npm install
npm run dev
```

### Si usas Laravel SAIL:

Recomendamos crear un alias en el bash:
```bash
nano ~/.bashrc

alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

source ~/.bashrc
```

```bash
sail up -d
sail php artisan key:generate
sail php artisan storage:link
sail php artisan icons:cache
sail php artisan migrate --seed
sail npm install
sail npm run dev
```

### Tests en paralelo
```bash
sail pest -p
```

## Cambiar remoto (importante)

Deberías cambiar el remoto que hace referencia a la URL de tu proyecto en GitHub:

```bash
git remote set-url origin <url-de-tu-proyecto-git>
git remote -v
```

## Instalar PhpMyAdmin en Sail (opcional)

Ejecuta:
```bash
php artisan sail:install
```

Si quieres instalar `phpmyadmin` para MySQL/MariaDB, agrega esto a tu archivo `docker-compose.yml`:

```yaml
phpmyadmin:
    container_name: phpmyadmin
    image: phpmyadmin/phpmyadmin:latest
    restart: always
    links:
        - mariadb:mariadb
    ports:
        - 8080:80
    environment:
        MYSQL_USERNAME: "${DB_USERNAME}"
        MYSQL_ROOT_PASSWORD: "${DB_PASSWORD}"
        PMA_HOST: mariadb
    networks:
        - sail
    depends_on:
        - mariadb
```

## Crear Paquete (Módulo)

Con el comando `php artisan blockpc:package` puedes crear tu propio módulo con su ServiceProvider personal.

Por ejemplo, si ejecutas `php artisan blockpc:package` y le asignas el nombre `course`, se creará la siguiente estructura dentro de la carpeta `Packages`:

```
Packages/
└── Course/
    ├── App/
    │   ├── Livewire/
    │   │   └── Course.php
    │   ├── Models/
    │   │   └── Course.php (si eliges agregar modelo)
    │   └── Providers/
    │       └── CourseServiceProvider.php
    ├── config/
    │   └── config.php
    ├── database/
    │   ├── factories/
    │   │   └── CourseFactory.php (si eliges agregar modelo)
    │   └── migrations/
    │       └── 2024_XX_XX_XXXXXX_create_courses_table.php (si eliges agregar modelo)
    ├── lang/
    │   └── en/
    │       └── course.php
    ├── resources/
    │   └── views/
    │       └── livewire/
    │           └── course.blade.php
    └── routes/
        └── web.php

# También se crea un test:
tests/Feature/Packages/Course/CourseRouteTest.php
```

Este comando ejecuta automáticamente `php artisan optimize --quiet`.

## Eliminar un Paquete

Con el comando `php artisan blockpc:delete-package` puedes eliminar un paquete instalado.

## Laravel Reverb

Se usa Laravel Reverb para enviar mensajes entre usuarios en tiempo real.

Los mensajes son enviados por medio de un `job`. Debes ejecutar:
- **Local:** `php artisan queue:listen`
- **Producción:** `php artisan queue:work`

El job emitirá un evento que envía la notificación vía Reverb.

### Configuración:
1. Ajusta la variable de entorno `VITE_ENABLE_REVERB=true`
2. Ejecuta `php artisan reverb:start`

> **Por defecto:** `VITE_ENABLE_REVERB=false`. Los mensajes se envían igual (siempre que el worker esté activo), solo que el usuario deberá actualizar la página.

## Permisos y Roles

Se usa el paquete `spatie/laravel-permission` para manejar los permisos y roles del sistema.
Existen 3 comandos y dos archivos asociados a permisos y roles que podrian ser de ayuda.

- `blockpc:permissions-sync`: Sincroniza, valida y limpia los permisos definidos en el sistema
    - Hace referencia a la clase `PermissionList`, que es una clase que lista permisos del sistema
- `blockpc:roles-sync`: Sincroniza, valida y limpia los roles definidos en el sistema
    - Hace referencia a la clase `RoleList`, que es una clase que lista roles del sistema
- `blockpc:sync-all`: Sincroniza roles y permisos definidos en código
    - hace las dos tareas y es muy util en produccion con su opcion `ci`

----

¡Disfruta desarrollando! 🚀
