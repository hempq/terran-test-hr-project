# Terran test project

You can check it live [on this website](http://159.89.25.68/), with the credentials:

Admin user

    E-mail: admin@example.com
    Password: admin

Normal user

    E-mail: normal@example.com
    Password: normal

### With Docker

Run:

    docker-compose up --build

After it starts, just on the first time, run on another terminal:

    docker exec terran-test bash -c "composer start && npm start"

The application will be available on http://localhost:8000 and the phpMyAdmin on http://localhost:8081

### Common way
Rename the .env.example file to .env, and fill it with your local info, then:

Install PHP and JavaScript dependencies:

    composer install
    npm install

Generate Laravel keys:

    php artisan key:generate

Generate i18n string for Vue, based on Laravel i18n files:

    php artisan vue-i18n:generate

Migrate and seed the database:

    php artisan migrate --seed

Cache route:

    php artisan route:cache

Compile all the front-end stuff:

    npm run prod
