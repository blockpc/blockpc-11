# BlockPC Plantilla para Laravel

Este repositorio contiene pantillas para frontend y backend para una plaicación de laravel

Contains:
- Laravel 12
- Tailwind
- Livewire
- Alpine JS
- Pest

Paquetes instalados para laravel:
- [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) (for only dev)
- [christophrumpel/missing-livewire-assertions](https://github.com/christophrumpel/missing-livewire-assertions)
- [spatie/laravel-permission](https://spatie.be/index.php/docs/laravel-permission)
- [intervention/image](http://image.intervention.io/)

Iconos [blade-ui-kit/blade-icons](https://github.com/blade-ui-kit/blade-icons)
- [Boxicons](https://github.com/mallardduck/blade-boxicons)
- [Heroicons](https://github.com/blade-ui-kit/blade-heroicons)

Laravel [Reverb](https://reverb.laravel.com/)

_No olvidar limpiar la cache de iconos si no se ven correctamente_

Helpers: archivo `Blockpc\helpers.php`

Paquetes NPM:

- [tailwind-scrollbar](https://github.com/adoxography/tailwind-scrollbar)

Este repositorio incluye un modelo `Profile` (one-to-one for user) y un modelo `Image` (polimorphic model)

### Instalación

Primero clonar el repositorio

>    git clone https://github.com/blockpc/blockpc-11 _your-name-proyect_

Siguiente

>    cd _your-name-proyect_
>    cp .env.example .env (Configure your app name, app url, database, email, etc)
>    composer install
>    php artisan key:generate
>    php artisan storage:link
>    php artisan icons:cache

Si no se usa laravel SAIL

>	php artisan migrate --seed
>	npm install
>	npm run dev

sino, con SAIL

>	check if not docker-compose.yml exists
>		php artisan sail:install (select your prefers apps, comma separator)
>		you must change DB_HOST in your .env
>
>	check VITE_PORT in docker-compose.yml `${VITE_PORT:-5173}:${VITE_PORT:-5173}`
>	./vendor/bin/sail up -d
>	./vendor/bin/sail php artisan migrate --seed
>	check in phpunit.xml or add `<env name="DB_CONNECTION" value="sqlite"/>`
>	./vendor/bin/sail npm install
>	./vendor/bin/sail npm run dev

Abrir una consola

>    run tests using `pest -p`

### Cambiar remoto (importante)

Deberias cambiar el remoto que hace referencia a la url de github

- git remote set-url origin `url-at-your-proyect-git`
- git remote -v

### Install PhpMyAdmin on Sail (optional)

`php artisan sail:install`

Si quieres instalar `phpmyadmin` para mysql/mariadb agrega a tu archivo `docker-compose.yml`
y reemplaza mysql/mariadb

```
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

### Crear Paquete (Modulo)

Con el comando `php artisan blockpc:package` tu puedes crear tu propio modulo con su ServiceProvider personal.
El comando crea una estructura como esta:

Pro ejemplo, si ejecutas `php artisan blockpc:package` y le asignas un nombre `course`
Se creara la siguiente estructura dentro de la carpeta Packages

```
Packages/
    - Package/
        - App/
            - Livewire/
                    - Course.php
            - Models/
                - Course.php
            - Providers/
                - CourseServiceProvider.php
        - config/
            - config.php
        - database/
            - factories/
                - CourseFactory.php
            - migrations/
                - 2022_06_02_140645_create_courses_table.php
        - lang/
            - en/
                - course.php
        - resources/
            - views/
                - index.blade.php
        - routes/
            - web.php

add a test 'tests/Feature/Packages/Course/CourseRouteTest.php'

```
Este comando ejecuta `php artisan optimize --quiet`

### Eliminar un Paquete

Con el comando `php artisan blockpc:package-delete` tu puedes eliminar un paquete instalado

### Laravel Reverb

Se usa laravel reverb para poder enviar mensaje entre usuarios.
Los mensajes son enviados por medio de un `job` (`php artisan queue:listen` en local, `php artisan queue:work` en produccion)
El job emitira un evento que envia la notificacion via _reverb_

Pasos:
- Se debe ajustar una variable de entorno `VITE_ENABLE_REVERB` a true
- se debe ejecutar `php artisan reverb:start`

Por defecto, `VITE_ENABLE_REVERB` esta en false, y no se usa reverb.
Los mensajes se envian igual (siempre que este el worker este activo) solo que el usuario debera actualizar la pagina

Enjoy!
