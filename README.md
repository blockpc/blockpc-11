# BlockPC Layout for Laravel

This repo contains a frontend and bakend layouts for a laravel

Contains:
- Laravel 12
- Tailwind
- Livewire
- Alpine JS
- Pest

Packages for laravel:
- [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) (for only dev)
- [christophrumpel/missing-livewire-assertions](https://github.com/christophrumpel/missing-livewire-assertions)
- [spatie/laravel-permission](https://spatie.be/index.php/docs/laravel-permission)
- [intervention/image](http://image.intervention.io/)

Icons [blade-ui-kit/blade-icons](https://github.com/blade-ui-kit/blade-icons) with
- [Boxicons](https://github.com/mallardduck/blade-boxicons)
- [Heroicons](https://github.com/blade-ui-kit/blade-heroicons)

Laravel [Reverb](https://reverb.laravel.com/)

_Dont forget clear cache icons if don't see them correctly_

Helpers: file autoload helper on `Blockpc\helpers.php`

Packages NPM:

- [tailwind-scrollbar](https://github.com/adoxography/tailwind-scrollbar)

This packages includes a model `Profile` (one-to-one for user) and model `Image` (polimorphic model)

### Install Clone

first clone

>    git clone https://github.com/blockpc/blockpc-11 _your-name-proyect_

next

>    cd _your-name-proyect_
>    cp .env.example .env (Configure your app name, app url, database, email, etc)
>    composer install
>    php artisan key:generate
>    php artisan storage:link
>    php artisan icons:cache

if not use SAIL

>	php artisan migrate --seed
>	npm install
>	npm run dev

else, with SAIL

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

open new console

>    run tests using `pest -p`

### Change remote (important)

You must before start your proyect remove or change the git remote url

- git remote set-url origin `url-at-your-proyect-git`
- git remote -v

### Install PhpMyAdmin on Sail (optional)

`php artisan sail:install`

if you wants install `phpmyadmin` for mysql/mariadb add at your `docker-compose.yml`
and replace mariadb or mysql

```
phpmyadmin:
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

### Create Package

with command `php artisan blockpc:package` you can create your own packages folder with own service provider.
This command create a folder structure like this:

if the name for your package is course
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
This command run `php artisan optimize --quiet`

### Delete command

with command `php artisan blockpc:package-delete` you can delete your own packages folder

### Laravel Reverb

Se usa laravel reverb para poder enviar mensaje entre usuarios.
Los mensajes son enviados por medio de un `job` (`php artisan queue:listen` en local, `php artisan queue:work` en produccion)
Pasos:
- Se debe ajustar una variable de entorno `VITE_ENABLE_REVERB` a true
- se debe ejecutar `php artisan reverb:start`

Por defecto, `VITE_ENABLE_REVERB` esta en false, y no se usa reverb.
Los mensajes se envian igual (siempre que este el worker este activo) solo que el usuario debera actualizar la pagina

### Others

_i try to stand this repository always to update_

Enjoy!
