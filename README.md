# System Zarządzania Szpitalem

## O Projekcie

System zarządzania szpitalem to nowoczesna aplikacja webowa zbudowana przy użyciu frameworka Laravel, zaprojektowana do efektywnego zarządzania procesami szpitalnymi. Projekt wykorzystuje najnowsze technologie i najlepsze praktyki programistyczne.

## Wymagania Systemowe

- PHP >= 8.2
- Composer
- Node.js i npm
- MySQL/PostgreSQL
- Serwer WWW (np. Apache, Nginx)

## Technologie

- **Backend:**
  - Laravel 12.0
  - PHP 8.2
  - Laravel Tinker
  - PHPUnit dla testów

- **Frontend:**
  - TailwindCSS
  - Vite
  - Axios

## Instalacja

1. Sklonuj repozytorium:
```bash
git clone [adres-repozytorium]
cd szpital-system
```

2. Zainstaluj zależności PHP:
```bash
composer install
```

3. Zainstaluj zależności JavaScript:
```bash
npm install
```

4. Skonfiguruj środowisko:
```bash
cp .env.example .env
php artisan key:generate
```

5. Skonfiguruj bazę danych w pliku `.env`

6. Wykonaj migracje:
```bash
php artisan migrate
```

## Uruchomienie Aplikacji

Projekt można uruchomić na dwa sposoby:

### 1. Tryb Deweloperski (z hot-reloadingiem)

```bash
composer run dev
```

To polecenie uruchomi:
- Serwer Laravel na `http://localhost:8000`
- Kolejkę zadań
- Logi aplikacji
- Vite z hot-reloadingiem

### 2. Tryb Produkcyjny

```bash
npm run build
php artisan serve
```

## Testowanie

Aby uruchomić testy:

```bash
composer run test
```

## Struktura Projektu

- `app/` - Główny kod aplikacji
- `config/` - Pliki konfiguracyjne
- `database/` - Migracje i seedy bazy danych
- `public/` - Pliki publiczne
- `resources/` - Widoki, assety i pliki frontendowe
- `routes/` - Definicje tras
- `tests/` - Testy aplikacji

