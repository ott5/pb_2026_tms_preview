# pb_2026_tms_preview

💻**English:** ⬆️ [Readme](#english) | ⚖️ [License](#license-english)  
💻**Polski:** ⬆️ [Opis](#polski) | ⚖️ [Licencja](#licencja-polska)

---

## English

### 📌 1. About the project
Welcome. This is a demo version of the **TMS** (Transport Management System) project. 
This repository shows a small part of a larger system. It focuses entirely on the universal **Address Module** (`code_preview`) to demonstrate the architecture, code cleanliness, and address data handling. A longer description of individual files can be found in the sections below.

### 2. 🛠️ Tech Stack

* 🚀 **Current version (`code_preview`):**
    * ⚙️ **Core technology:** `PHP 8+`, `Laravel 13+`
    * 🎨 **Admin panel:** `Filament 5+`, `guava/filament-knowledge-base`
    * 🛡️ **Permissions and authorization:** `bezhansalleh/filament-shield`, `spatie/laravel-permission`
    * 📖 **Documentation and API:** `Scribe` (API documentation generator)
    * 🐳 **Environment and tools:** `Docker` / `Laravel Sail`, `Debugbar`
    * 🗄️ **Database:** `MySQL` (managed via `HeidiSQL`)

* 📦 **Legacy / Previous version (`old`):**
    * ⚙️ **Core technology:** `PHP 8+`, `Laravel 13+`
    * 🎨 **Admin panel:** `Filament 5+` (generating simple CRUDs)
    * 💻 **Local environment:** `Laravel Herd` / `Laragon`
    * 🗄️ **Database:** `MySQL` (managed via `HeidiSQL`)

### 📂 3. Main repository structure

* **[`code_preview/`](./code_preview/)** - The current source code of the standalone address module.
* **[`old/`](./old/)** - An older version containing a smaller part of the entire TMS system. The folder also includes the final ERD diagram for the whole project.
* **[`adress_module_erd.pdf`](./address_module_erd.pdf)** - A detailed ERD relationship diagram for the current address module.
* **[`img/`](./img/)** - Screenshots showing how the address module works.
* **[`LICENSE`](./LICENSE)** - MIT License

### 4. 🌍 Address Module

The main address module is designed in a clean and modular way. Inside the [`code_preview/`](./code_preview) folder, you will find the following areas:

* **Folder [`app/`](./code_preview/app/)** – contains the business logic of the application:
    * **[`Enums/`](./code_preview/app/Enums/):** `AddressType`, `DivisionType`.
    * **[`Clusters/`](./code_preview/app/Filament/Clusters) (Filament):** Admin panel logic divided into independent areas:
        * **[`Employee/`](./code_preview/app/Filament/Clusters/Employee):** An area dedicated to employees, containing a pivot table and an employee-related resource (`EmployeeAddressResource`). It allows adding an address directly from the employee form (without going to the registry), which speeds up data entry. This serves as a pattern to copy in other sections of the system (e.g., clients, suppliers).
        * **[`Registry/`](./code_preview/app/Filament/Clusters/Registry):** A universal place for dictionary data (used many times across the system due to address universality). Contains resources (tables and forms): `AddressResource`, `AdministrativeDivisionResource`, `CityResource`, `CountryResource`, `CountryRegionResource`, `PostalCodeResource`.
    * **[`Schema/`](./code_preview/app/Filament/Schemas) (Filament):** Contains a single file [`AddressSchema.php`](./code_preview/app/Filament/Schemas/AddressSchema.php), which holds reusable methods for form business logic, field cascading (e.g., linking a country to a region, a city to a postal code), and advanced table filters in the panel.
    * **[`Models/`](./code_preview/app/Models):** Eloquent models (Laravel) connected to all the resources mentioned above.
    * **[`Polices/`](./code_preview/app/Polices):** Authorization policy files generated to manage permissions for individual CRUDs and subpages directly from the admin panel.

* **Folder [`database/`](./code_preview/database)** – manages the data layer:
    * **[`migrations/`](./code_preview/database/migrations):** Organized table migrations.
    * **[`seeders/`](./code_preview/database/seeders):** Main system seeders (including `CountrySeeder` and `CountryRegionSeeder`) that initialize basic dictionary data.
    * **[`factories/`](./code_preview/database/factories):** Three selected factories (`AddressFactory`, `CityFactory`, `PostalCodeFactory`) kept from the early stage of the project when data was generated automatically (now unnecessary and unused).

### 📦 5. Legacy version (`old`)

In the **[`old/`](./old/)** folder and the root directory, you can find an older version of the project and supporting documentation showing an earlier stage of work on the TMS system:

* **[`app_resources/`](./old/app_resources/)** – contains a small set of resources directly related to the migrations and models listed below:
    * **[`Addresses/`](./old/app_resources/Addresses):** Earlier implementation of address components (including the [`AddressFields.php`](./old/code_preview/app_resources/AddressFields.php) file, which is the previous version of `AddressSchema` from the current section).
    * **[`EmployeeDocuments/`](./old/app_resources/EmployeeDocuments):** Resources related to employee documents.
    * **[`Vehicles/`](./old/app_resources/Vehicles):** Resources related to vehicles in the transport system.
* **[`migrations/`](./old/migrations/)** – historical database migrations creating tables: `addresses`, `employees`, `employee_documents`, `vehicles`, and `vehicle_cargo_tank_details`.
* **[`models/`](./old/models/)** – related Eloquent models for the entities above: `Address`, `Employee`, `EmployeeDocument`, `Vehicle`, and `VehicleCargoTankDetail`.
* **[`database_schema`](./database_schema)** – the target diagram of the entire project, generated from the complete database using reverse engineering.
* **[`presentation`](./presentation)** – a PDF presentation explaining the shared sections of the system.

---

## Polski

### 📌1.O projekcie
Witaj. Jest to wersja demonstracyjna projektu **TMS** (Transport Management System)
To repozytorium prezentuje wycinek większego systemu, skupia się wyłącznie na przedstawieniu uniwersalnego **Modułu Adresów**(`code_preview`), aby pokazać architekturę, czystość kodu oraz obsluge danych adresowych. Dłuży opis poszczególnych plików znajduję się w poniższej sekcji.

### 2.🛠️Tech Stack

* 🚀 **Aktualna wersja (`code_preview`):**
    * ⚙️ **Technologia bazowa:** `PHP 8+`, `Laravel 13+`
    * 🎨 **Panel administracyjny:** `Filament 5+`, `guava/filament-knowledge-base`
    * 🛡️ **Uprawnienia i autoryzacja:** `bezhansalleh/filament-shield`, `spatie/laravel-permission`
    * 📖 **Dokumentacja i API:** `Scribe` (generator dokumentacji API)
    * 🐳 **Środowisko i narzędzia:** `Docker` / `Laravel Sail`, `Debugbar`
    * 🗄️ **Baza danych:** `MySQL` (zarządzanie przez `HeidiSQL`)

* 📦 **Legacy / Wersja poprzednia (`old`):**
    * ⚙️ **Technologia bazowa:** `PHP 8+`, `Laravel 13+`
    * 🎨 **Panel administracyjny:** `Filament 5+` (generowanie prostych crudów)
    * 💻 **Środowisko lokalne:** `Laravel Herd` / `Laragon`
    * 🗄️ **Baza danych:** `MySQL` (zarządzanie przez `HeidiSQL`)

### 📂3.Struktura głównego katalogu repozytorium

* **[`code_preview/`](./code_preview/)** - Aktualny kod źródłowy samodzielnego modułu adreesów.
* **[`old/`](./old/)** - Starsza wersja, która zawiera mniejszy wycinek, lecz całego systemu tms. W katalogu również się znajduje docelowy diagram erd całego projektu. 
* **[`adress_module_erd.pdf`](./address_module_erd.pdf)** - Szczegółowy diagram ERD relacji encji dla aktualnego modułu adresów.
* **[`img/`](./img/)** - Zrzuty ekranu prezentujące działanie modułu adresów.
* **[`LICENSE`](./LICENSE)** - Licencja MIT

### 4.🌍Moduł adresów

Główny moduł adresowy został zaprojektowany w sposób czysty i modularny. W folderze [`code_preview/`](./code_preview) znajdziesz następujące obszary:

* **Folder [`app/`](./code_preview/app/)** – zawiera logikę biznesową aplikacji:
    * **[`Enums/`](./code_preview/app/Enums/):** `AddressType`, `DivisionType`.
    * **[`Clusters/`](./code_preview/app/Filament/Clusters) (Filament):** Podział logiki panelu administracyjnego na niezależne obszary:
        * **[`Employee/`](./code_preview/app/Filament/Clusters/Employee):** Obszar dedykowany pracownikom, zawiera tabelę łącznikową i zasób powiązany z pracownikiem (`EmployeeAddressResource`). Umożliwia dodawanie adresu bezpośrednio z poziomu formularza pracownika (bez wchodzenia do rejestru), co automatyzuje wprowadzanie danych. Stanowi on wzorzec implementacyjny do powielenia w innych sekcjach systemu (np. klienci, dostawcy).
        * **[`Registry/`](./code_preview/app/Filament/Clusters/Registry):** Uniwersalne miejsce przechowujące dane słownikowe (wykorzystywane wielokrotnie w różnych miejscach systemu z racji uniwersalności adresu). Zawiera zasoby (tabele i formularze): `AddressResource`, `AdministrativeDivisionResource`, `CityResource`, `CountryResource`, `CountryRegionResource`, `PostalCodeResource`.
    * **[`Schema/`](./code_preview/app/Filament/Schemas) (Filament):** Zawiera pojedynczy plik [`AddressSchema.php`](./code_preview/app/Filament/Schemas/AddressSchema.php), w którym wydzielono metody wielokrotnego użytku odpowiadające za logikę biznesową formularzy i kaskadowość pól (np. powiązanie kraju z regionem, miasta z kodem pocztowym) oraz zaawansowane filtry tabel w panelu.
    * **[`Models/`](./code_preview/app/Models):** Modele Eloquent (Laravel) powiązane ze wszystkimi wyżej wymienionymi zasobami.
    * **[`Polices/`](./code_preview/app/Polices):** Pliki polityk autoryzacji wygenerowane w celu zarządzania uprawnieniami do poszczególnych CRUD-ów i podstron bezpośrednio z panelu administratora.

* **Folder [`database/`](./code_preview/database)** – zarządza warstwą danych:
    * **[`migrations/`](./code_preview/database/migrations):** Uporządkowane migracje tabel.
    * **[`seeders/`](./code_preview/database/seeders):** Główne seedery systemowe (w tym `CountrySeeder` i `CountryRegionSeeder`), które inicjalizują bazowe dane słownikowe.
    * **[`factories/`](./code_preview/database/factories):** Wybrane trzy fabryki (`AddressFactory`, `CityFactory`, `PostalCodeFactory`) zachowane z wczesnego etapu projektu, gdzie dane były uzupełniane automatycznie (obecnie na tym etapie są już zbędne i nieużywane).

### 📦 5. Starsza wersja systemu (Legacy / `old`)

W katalogu **[`old/`](./old/)** oraz w głównym katalogu znajduje się starsza wersja projektu i dokumentacja pomocnicza przedstawiająca wcześniejszy etap prac nad systemem TMS:

* **[`app_resources/`](./old/app_resources/)** – zawiera niewielki zestaw zasobów powiązanych bezpośrednio z poniższymi migracjami i modelami:
    * **[`Addresses/`](./old/app_resources/Addresses):** Wcześniejsza implementacja komponentów adresowych (w tym plik [`AddressFields.php`](./old/code_preview/app_resources/AddressFields.php), który stanowi poprzednią wersję pliku `AddressSchema` znanego z aktualnej sekcji).
    * **[`EmployeeDocuments/`](./old/app_resources/EmployeeDocuments):** Zasoby powiązane z dokumentami pracowników.
    * **[`Vehicles/`](./old/app_resources/Vehicles):** Zasoby powiązane z pojazdami w systemie transportowym.
* **[`migrations/`](./old/migrations/)** – historyczne migracje bazodanowe tworzące tabele: `addresses`, `employees`, `employee_documents`, `vehicles` oraz `vehicle_cargo_tank_details`.
* **[`models/`](./old/models/)** – powiązane modele Eloquent dla powyższych encji: `Address`, `Employee`, `EmployeeDocument`, `Vehicle` oraz `VehicleCargoTankDetail`.
* **[`database_schema`](./database_schema)** – docelowy diagram całego projektu, wygenerowany na podstawie kompletnej bazy danych metodą inżynierii wstecznej (*reverse engineering*).
* **[`presentation`](./presentation)** – plik prezentacji PDF przedstawiający omówienie udostępnionych sekcji systemu.