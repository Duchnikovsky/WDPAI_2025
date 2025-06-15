# 📚 Bookly – Uniwersytecki System Wypożyczalni Książek 

Bookly to system do zarządzania wypożyczalnią książek dla uczelni wyższych. Aplikacja umożliwia studentom przeglądanie katalogu książek dostępnych w bibliotekach różnych uczelni, ich rezerwację oraz zarządzanie kontem użytkownika. Administratorzy mogą zarządzać zasobami oraz generować kody rejestracyjne.

![logo_white](https://github.com/user-attachments/assets/236ba36f-f979-4de5-8a29-ab069ba6dc50)


---

## 🧩 Technologie

- 🔧 PHP 8.2.11 (czysty, MVC)
- 🐘 PostgreSQL (relacyjna baza danych)
- 🎨 HTML5, CSS3, JavaScript (Vanilla)
- 🖼️ Font Awesome (ikony)
- ⚙️ Routing z poziomu `index.php`
- 🔐 System sesji i autoryzacji

---

## 🗂️ Funkcjonalności

### 🧑‍💼 Rejestracja i logowanie
- Rejestracja z użyciem **kodów dostępu** (generowanych przez administratorów)
- Hashowanie haseł (`password_hash`)
- Logowanie i sesje użytkownika

![LoginDesktop](https://github.com/user-attachments/assets/dd672642-9b0e-47b6-b58e-0045dbec2bad)
![LoginMobile](https://github.com/user-attachments/assets/a3e406d5-24f7-472c-99f4-bd53ab2b17a3)



### 📖 Przeglądanie książek
- Lista wszystkich książek z podziałem na strony (paginacja)
- Wyszukiwanie po tytule i autorze
- Filtracja po kategorii

![DashboardDesktop](https://github.com/user-attachments/assets/e33b08d2-ec85-461b-bebf-b4f87b5a85e6)
![DashboardMobile](https://github.com/user-attachments/assets/c0cdc645-4edd-4995-a1ab-d69d4d28fd97)


### 🏷️ Kategorie
- Przegląd dostępnych kategorii
- Ikony kategorii
- Kliknięcie kategorii filtruje książki

![Categories](https://github.com/user-attachments/assets/7343ba8d-cc16-4c69-8e8f-0961938b50df)



### 🏆 Bestsellery
- Lista 10 najczęściej wypożyczanych książek z ostatnich 30 dni

![Bestsellers](https://github.com/user-attachments/assets/a66a449b-451b-4c2e-9633-d750cfbcd29c)


### 🏫 Biblioteki i dostępność
- Książki przypisane do konkretnych bibliotek uczelnianych
- Rezerwacja książki z wybranej biblioteki
- Generowanie 8-znakowego kodu rezerwacji

![Book](https://github.com/user-attachments/assets/33ea902e-ebe6-46ff-b670-eb08a1374f50)


### 🧾 Profil użytkownika
- Lista wszystkich rezerwacji użytkownika
- Informacje o koncie

![Profile](https://github.com/user-attachments/assets/6b58be3c-b0dd-4c0b-be75-17461756990b)


### 🛠️ Panel administratora
- Dodawanie nowych książek i egzemplarzy do bibliotek
- Generowanie kodów rejestracyjnych
- Zarządzanie danymi

![AdminPanel](https://github.com/user-attachments/assets/61d98bbe-d726-4f4b-b04a-f5f95cbce693)


---

## Diagram ERD
![WDPAI diagram](https://github.com/user-attachments/assets/e85ebdfe-4b4f-426c-97db-90e1e0c89533)


---

## 🛠️ Struktura projektu

📦 Bookly/
├── public/ # Statyczne pliki frontendowe

├── src/

│ ├── controllers/ # Logika kontrolerów (MVC)

│ ├── models/ # Klasy modeli danych

│ ├── repository/ # Warstwa dostępu do danych (Repozytoria)

│ ├── views/ # Widoki HTML + PHP

│ └── Routing.php # Routing aplikacji

├── database/

│ └── Bookly.sql # Dump struktury i danych PostgreSQL

├── index.php # Punkt wejściowy aplikacji

└── README.md

---

## 🧪 Jak uruchomić lokalnie

1. **Sklonuj repozytorium:**

```bash
git clone https://github.com/twoj-login/bookly.git
cd bookly
```

2. **Uruchom kontener docker:**
```bash
docker compose up
```

3. **Skonfiguruj bazę danych:**

Utwórz bazę danych PostgreSQL (np. db)
Zaimportuj Bookly.sql:
```bash
psql -U postgres -d db -f database/Bookly.sql
```

4. **Skonfiguruj połączenie DB w config.php:**
```bash
const DB_USERNAME = 'docker';
const DB_PASSWORD = 'docker';
const DB_HOST = 'db';
const DB_NAME = 'db';
```

5. **Otwórz przeglądarkę:**
```bash
http://localhost:8080
```

---

🙌 Autor
Projekt stworzony przez Filip Duchnik, jako projekt zaliczeniony z przedmiotu Wstęp do programowania aplikacji internetowych.


