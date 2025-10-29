# F1 Championship 2025 - Laravel Application

🏁 **Formula 1 Championship management system** built with Laravel and HTML5 UP Eventually template.

## Features

### 🎨 **Frontend**
- **HTML5 UP Eventually Template** integration as homepage
- **Responsive F1-themed design** with red color scheme (#ff6b6b)
- **Interactive navigation** with login dropdown
- **Tab-based data display** for F1 History section

### 🏎️ **F1 Data Management**
- **Pilots Database** - 801+ driver records
- **Race Results** - 2000+ race results with DNF tracking
- **Grand Prix Calendar** - 750+ race events
- **MySQL Models** with proper relationships

### 📱 **Pages**
- **Homepage** - Eventually template with F1 branding
- **F1 History** - Interactive tabs showing Drivers, Results, Grand Prix
- **Contact** - Form with validation and F1 styling
- **Authentication** - Login/Register system

## Technology Stack

- **Laravel** - PHP framework
- **MySQL** - Database
- **HTML5 UP Eventually** - Template
- **Bootstrap 5** - CSS framework
- **Blade Templates** - Laravel templating
- **Inertia.js** - Modern monolith architecture

## Database Structure

### Models
- `Pilot` - Driver information (ID, name, gender, birth date, nationality)
- `Result` - Race results (date, pilot, position, issues, team, car, engine)
- `GrandPrix` - Race events (date, name, location)

### Data Import
- Supports TXT file import with tab-separated values
- Custom Artisan command: `php artisan f1:import`
- Progressive data loading with error handling

## Installation

1. **Clone repository**
```bash
git clone https://github.com/GH5MZN/WebProg2_EA_beadando.git
cd WebProg2_EA_beadando
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**
```bash
# Configure MySQL in .env file
php artisan migrate
php artisan f1:import  # Import F1 data from TXT files
```

5. **Development server**
```bash
php artisan serve
npm run dev
```

## Project Structure

```
📁 F1 Championship App
├── 🏠 Homepage (Eventually template)
├── 🏁 F1 History (Drivers/Results/GP)
├── 📧 Contact (Form with validation)
├── 🔐 Authentication (Login/Register)
└── 🗄️ Database (MySQL with F1 data)
```

## Screenshots

### Homepage
- F1-themed Eventually template with navigation
- Hero section with championship branding
- Responsive design with red accent colors

### F1 History
- Interactive tabs for different data types
- Sortable tables with pagination
- Real F1 data from text file imports

### Contact
- Professional contact form
- F1 styling consistency
- Form validation and success feedback

## Development

This project was developed as a **Web Programming 2** assignment, demonstrating:
- **Laravel MVC architecture**
- **Database design and relationships**
- **Frontend template integration**
- **Data import and management**
- **Responsive web design**

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---
