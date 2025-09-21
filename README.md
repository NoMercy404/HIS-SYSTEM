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


## 🖼️ Screenshots
<img width="986" height="687" alt="1" src="https://github.com/user-attachments/assets/59439936-04b4-49ba-bd62-f11af628fa41" />
<img width="1872" height="898" alt="5" src="https://github.com/user-attachments/assets/3b9d72ea-5b6f-4449-8aa6-22e5e7f24476" />
<img width="1872" height="892" alt="6" src="https://github.com/user-attachments/assets/20269934-e05f-4840-85bf-ae8fcb3af488" />
<img width="1867" height="882" alt="9" src="https://github.com/user-attachments/assets/14d946ea-6f07-40d2-80eb-6532c7311196" />
<img width="1632" height="761" alt="10" src="https://github.com/user-attachments/assets/69b18c4e-efb5-4227-a580-73d97448f47f" />



## 🧪 Konta testowe

Możesz skorzystać z poniższych kont do testowania aplikacji:

**Konto 1:**

- **Email:** `test@example.com`
- **Hasło:** `admin123`

**Konto 2:**

- **Email:** `anna@example.com`
- **Hasło:** `admin`

lub własnoręcznie się zarejestrować
