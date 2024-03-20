# Installation <br/>

Git Clone

```bash
git clone https://github.com/mohasin-dev/analyzenbd-assesment.git
```

Composer Install

```bash
composer install
```

Copy .env.example to .env

```bash
cp .env.example .env
```

Key Generate

```bash
php artisan key:generate
```

Update Database Setup From .env File & Also Update 'DB_COLLATION' (If Needed)

```bash
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Migration and Seeder

```bash
php artisan migrate --seed
```

NPM Install & Run

```bash
npm install
npm run dev
```

Run Server

```bash
php artisan serve
```

Access URL</br>

```bash
http://127.0.0.1:8000
```

Unit Test</br>

```bash
php artisan test tests/Unit/Services/UserServiceTest.php
```