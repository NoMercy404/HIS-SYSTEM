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


##🖼️ Screenshots
<img width="986" height="687" alt="1" src="https://github.com/user-attachments/assets/712b506a-db00-4a33-b8ab-aece46f0faf5" />

<img width="1498" height="866" alt="2" src="https://github.com/user-attachments/assets/7cb1b571-b0f7-4751-9511-0c8b211c0989" />

<img width="1872" height="898" alt="5" src="https://github.com/user-attachments/assets/b74f8980-1c50-42d4-b6eb-df65f24397e3" />

<img width="1872" height="892" alt="6" src="https://github.com/user-attachments/assets/d60bf17a-e7c3-484c-9bbc-0c9844b9d93b" />

<img width="1868" height="887" alt="7" src="https://github.com/user-attachments/assets/abb4fdf0-5e3b-4da2-b4e4-b8e8572585dc" />

<img width="1848" height="883" alt="8" src="https://github.com/user-attachments/assets/cd5abf60-ef87-4c8f-b8ca-fdbf7190e07b" />

<img width="948" height="712" alt="11" src="https://github.com/user-attachments/assets/af851c68-0e0d-48f9-801c-2ec56a0267b6" />


## 🧪 Konta testowe

Możesz skorzystać z poniższych kont do testowania aplikacji:

**Konto 1:**

- **Email:** `test@example.com`
- **Hasło:** `admin123`

**Konto 2:**

- **Email:** `anna@example.com`
- **Hasło:** `admin`

lub własnoręcznie się zarejestrować
