# 📌 System Szpitalny

Aplikacja webowa do zarządzania użytkownikami, logowaniem oraz zadaniami — zbudowana w oparciu o **Laravel** i **Vite + npm**.

---

## 📖 Opis aplikacji

Szpital System to aplikacja umożliwiająca:

- Rejestrację i logowanie użytkowników  
- Zarządzanie dostępem do panelu administracyjnego  
- Obsługę zadań i użytkowników (np. lekarzy, pacjentów)  
- Wymuszanie zmiany hasła po 30 dniach  
- Bezpieczne sesje z autoryzacją i migracjami  

Projekt łączy backend (Laravel) z frontendem (npm/Vite), zapewniając dynamiczną i nowoczesną aplikację webową.

---

## ⚙️ Wymagania wstępne

Przed rozpoczęciem pracy upewnij się, że masz zainstalowane i **dodane do zmiennych środowiskowych**:

- **PHP** (zalecana wersja: 8.2+)
- **Node.js** (zalecana wersja LTS, np. `v18.x` lub `v20.x`)
- **npm** (np. `v9+`)
- **Composer**
- **SQLite** (do lokalnej bazy danych)

Sprawdź wersje poleceniami:

```bash
php -v
node -v
npm -v
composer -V
```
## 🛠️ Instalacja i uruchomienie

1. **Przejdź do katalogu projektu:**

```bash
cd szpital-system
```
2. **Zainstaluj zależności PHP i JS:**
```bash
composer install --ignore-platform-req=ext-fileinfo
npm install
```
3. **Wykonaj migracje i seedowanie:**
```bash
php artisan migrate:fresh --seed
```
4. **Uruchom backend (Laravel):**
```bash
php artisan serve
```
5. **Uruchom frontend (Vite)::**
```bash
npm run dev
```
6. **Otwórz aplikacje::**
```bash
http://localhost:8000
```
w przypadku nie działania tego linku kliknij link który pojawia się po wpisaniu komendy ```php artisan serve```.

## 🧪 Konta testowe

Możesz skorzystać z poniższych kont do testowania aplikacji:

**Konto 1:**

- **Email:** `test@example.com`
- **Hasło:** `admin123`

**Konto 2:**

- **Email:** `anna@example.com`
- **Hasło:** `admin`

lub własnoręcznie się zarejestrować
