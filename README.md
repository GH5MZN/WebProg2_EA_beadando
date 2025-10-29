# F1 Bajnokság 2025 - Laravel Alkalmazás

🏁 **Formula 1 bajnokság kezelő rendszer** Laravel és HTML5 UP Eventually sablon alapján.

## Funkciók

### 🎨 **Frontend**
- **HTML5 UP Eventually sablon** integrálva főoldalként
- **Reszponzív F1-es témájú design** piros színsémával (#ff6b6b)
- **Interaktív navigáció** bejelentkezés dropdown-pal
- **Tab-alapú adatmegjelenítés** az F1 történelem szekcióban

### 🏎️ **F1 Adatkezelés**
- **Pilóta adatbázis** - 801+ pilóta rekord
- **Versenyeredmények** - 2000+ versenyeredmény DNF követéssel
- **Grand Prix naptár** - 750+ versenyesemény
- **MySQL modellek** megfelelő kapcsolatokkal

### 📱 **Oldalak**
- **Főoldal** - Eventually sablon F1 branding-gel
- **F1 Történelem** - Interaktív tabok pilótákkal, eredményekkel, Grand Prix-kkel
- **Kapcsolat** - Űrlap validációval és F1 stílussal
- **Hitelesítés** - Bejelentkezés/Regisztrációs rendszer

## Technológiai Stack

- **Laravel** - PHP keretrendszer
- **MySQL** - Adatbázis
- **HTML5 UP Eventually** - Sablon
- **Bootstrap 5** - CSS keretrendszer
- **Blade sablonok** - Laravel templating
- **Inertia.js** - Modern monolit architektúra

## Adatbázis Struktúra

### Modellek
- `Pilot` - Pilóta információk (ID, név, nem, születési dátum, nemzetiség)
- `Result` - Versenyeredmények (dátum, pilóta, pozíció, problémák, csapat, autó, motor)
- `GrandPrix` - Versenyesemények (dátum, név, helyszín)

### Adatimport
- TXT fájl import támogatás tab-separated értékekkel
- Egyedi Artisan parancs: `php artisan f1:import`
- Progresszív adatbetöltés hibakezeléssel

## Telepítés

1. **Repository klónozása**
```bash
git clone https://github.com/GH5MZN/WebProg2_EA_beadando.git
cd WebProg2_EA_beadando
```

2. **Függőségek telepítése**
```bash
composer install
npm install
```

3. **Környezet beállítása**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Adatbázis beállítása**
```bash
# MySQL konfigurálása a .env fájlban
php artisan migrate
php artisan f1:import  # F1 adatok importálása TXT fájlokból
```

5. **Fejlesztői szerver**
```bash
php artisan serve
npm run dev
```

## Éles Környezetbe Telepítés

### 🌐 **Tárhelyszolgáltatók**

#### **1. Osztott tárhely (pl. ATHOS, Tárhely.eu)**
```bash
# Csak az app fájlok feltöltése (vendor mappa nincs a git-ben)
# 1. FTP/FileManager-rel töltsd fel a fájlokat
# 2. SSH-ban vagy hosting vezérlőpult-ban:
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### **2. VPS/Szerver (pl. DigitalOcean, Vultr)**
```bash
# Domain beállítás
git clone https://github.com/GH5MZN/WebProg2_EA_beadando.git /var/www/html
cd /var/www/html
composer install --no-dev --optimize-autoloader
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### **3. Ingyenes tárhely (pl. Heroku, Railway)**
- **Procfile** szükséges: `web: vendor/bin/heroku-php-apache2 public/`
- Környezeti változók beállítása
- MySQL adatbázis addon hozzáadása

### ⚙️ **Éles környezet ellenőrzőlista**
- [ ] `.env` fájl létrehozása és konfigurálása
- [ ] `APP_DEBUG=false` beállítása
- [ ] MySQL adatbázis létrehozása
- [ ] `php artisan migrate` futtatása
- [ ] `php artisan f1:import` adatok betöltéséhez
- [ ] Webszerver konfiguráció (Apache/Nginx)
- [ ] Domain DNS beállítása

## Projekt Struktúra

```
📁 F1 Bajnokság App
├── 🏠 Főoldal (Eventually sablon)
├── 🏁 F1 Történelem (Pilóták/Eredmények/GP)
├── 📧 Kapcsolat (Űrlap validációval)
├── 🔐 Hitelesítés (Bejelentkezés/Regisztráció)
└── 🗄️ Adatbázis (MySQL F1 adatokkal)
```

## Képernyőfotók

### Főoldal
- F1-es témájú Eventually sablon navigációval
- Hero szekció bajnokság branding-gel
- Reszponzív design piros kiemelő színekkel

### F1 Történelem
- Interaktív tabok különböző adattípusokhoz
- Rendezhető táblák lapozással
- Valós F1 adatok szövegfájl importból

### Kapcsolat
- Professzionális kapcsolat űrlap
- F1 stílus konzisztencia
- Űrlap validáció és sikeres visszajelzés

## Fejlesztés

Ez a projekt **Webprogramozás 2** beadandóként készült, bemutatva:
- **Laravel MVC architektúra**
- **Adatbázis tervezés és kapcsolatok**
- **Frontend sablon integráció**
- **Adatimport és -kezelés**
- **Reszponzív webdesign**

## Licensz

Ez a projekt nyílt forráskódú szoftver a [MIT licensz](LICENSE) alatt.

---
