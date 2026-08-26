# JobHub — Modern Job Portal

JobHub is a feature-rich, theme-able job portal built with PHP (vanilla MVC), MySQL, and Bootstrap 4.6. It connects job seekers with employers through an intuitive, modern interface with 4 atmospheric themes, real-time analytics, and AI-ready architecture.

> **Project**: Web Programming & Application — Ton Duc Thang University

---

## ✨ Features

### 👤 For Job Seekers (Students / Candidates)

| Feature                    | Description                                                                         |
| -------------------------- | ----------------------------------------------------------------------------------- |
| 🔐 **Authentication**      | Register & login with role-based access (job seeker / employer)                     |
| 🔍 **Job Search**          | Search jobs by keyword, filter by category, city, level, type, salary               |
| 📄 **Apply for Jobs**      | Apply with CV upload in one click                                                   |
| 📑 **CV Builder**          | Generate a professional CV preview and download as PDF                              |
| ⭐ **Bookmarks**           | Save interesting jobs to review later                                               |
| 📊 **Analytics Dashboard** | Visual stats (total applications, interviews, offers) + application pipeline funnel |
| 🎯 **Skill Match**         | See how your skills match job requirements (AI-ready)                               |
| ⚙️ **Settings**            | Manage profile, education, experience, certifications, theme, language              |
| 🌐 **Localization**        | English + Vietnamese language support                                               |

### 🏢 For Employers

| Feature                   | Description                                                                                  |
| ------------------------- | -------------------------------------------------------------------------------------------- |
| 🔐 **Authentication**     | Register as employer, manage company profile                                                 |
| 📝 **Post Jobs**          | Multi-step wizard to create detailed job postings                                            |
| ✏️ **Edit / Manage Jobs** | Update, close, or delete job listings                                                        |
| 📥 **View Applications**  | See all candidates who applied, with CV download                                             |
| 🔄 **Update Status**      | Change application status (Pending → Reviewed → Shortlisted → Interview → Accepted/Rejected) |
| 📊 **Manage Dashboard**   | Overview of all posted jobs and application counts                                           |

### 🎨 Design & UX

| Feature                     | Description                                                                         |
| --------------------------- | ----------------------------------------------------------------------------------- |
| 🌅 **4 Atmospheric Themes** | Dawn (sunrise warm), Noon (bright sky), Dusk (twilight purple), Night (starry dark) |
| 🌈 **Gradient Backgrounds** | Each theme has custom `--gradient-hero`, `--gradient-surface`, `--gradient-glow`    |
| 🍞 **Toast Notifications**  | Modern fixed-position toast system replacing old flash alerts                       |
| 📱 **Responsive**           | Mobile-first design, works on all screen sizes                                      |
| ♿ **Animations**           | Fade-in-up with IntersectionObserver, shimmer skeletons, smooth scroll              |
| 🔄 **Form Wizards**         | Multi-step job posting wizard with auto-save                                        |
| ⬆️ **Back to Top**          | Floating scroll-to-top button                                                       |

### 🤖 AI Readiness (Future)

| Feature                                 | Status                |
| --------------------------------------- | --------------------- |
| Skill match scoring (circular progress) | 🟡 Frontend ready     |
| Resume parsing & analysis               | 🟡 Architecture ready |
| Job recommendation engine               | 🟡 Interface defined  |
| Auto-apply suggestions                  | 🟡 Slots reserved     |

> The project includes `src/Services/AI/AIServiceInterface` — ready for ML integration via a custom implementation.

---

## 🚀 Getting Started

### 📦 Option 1: Docker (Recommended — Replaces XAMPP)

Docker runs Apache + PHP 8.2, MySQL 8.0, and phpMyAdmin in isolated containers.

#### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (Windows/Mac) or Docker Engine + Docker Compose (Linux)

#### Steps

```bash
# 1. Clone the repository
git clone https://github.com/nmphux/course-webprog-jobportal-2022-enhanced.git jobhub
cd jobhub

# 2. Start all services
docker-compose up -d

# 3. The database.sql is automatically imported on first run
#    (MySQL container executes it from /docker-entrypoint-initdb.d/)

# 4. Open the app
#    → App:        http://localhost:8080
#    → phpMyAdmin: http://localhost:8081
```

#### Docker Services

| Service          | Container Name | URL                   | Port   |
| ---------------- | -------------- | --------------------- | ------ |
| Apache + PHP 8.2 | `jobhub-app`   | http://localhost:8080 | `8080` |
| MySQL 8.0        | `jobhub-db`    | localhost:3307        | `3307` |
| phpMyAdmin 5.2   | `jobhub-pma`   | http://localhost:8081 | `8081` |

#### Docker Database Credentials

| User          | Password        | Database |
| ------------- | --------------- | -------- |
| `root`        | `root_secret`   | `jobhub` |
| `jobhub_user` | `jobhub_secret` | `jobhub` |

#### Useful Commands

```bash
# View live logs
docker-compose logs -f

# Run tests
docker exec jobhub-app php tests/TestRunner.php

# Stop services
docker-compose down

# Full reset (delete database volume + rebuild)
docker-compose down -v && docker-compose up -d --build
```

### 🪟 Option 2: XAMPP (Legacy)

#### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (includes Apache, MySQL, PHP, phpMyAdmin)

#### Steps

```bash
# 1. Clone the repository
git clone https://github.com/nmphux/course-webprog-jobportal-2022-enhanced.git jobhub

# 2. Copy to XAMPP htdocs
cp -r jobhub C:/xampp/htdocs/jobhub
```

3. **Enable `mod_rewrite`** in XAMPP:
   - Open `C:/xampp/apache/conf/httpd.conf`
   - Uncomment this line (remove `#`):
     ```
     LoadModule rewrite_module modules/mod_rewrite.so
     ```
   - Save and restart Apache via XAMPP Control Panel

4. **Start XAMPP services**:
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL**

5. **Create the database**:
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Create a new database named **`job_portal_db`**
   - Select `job_portal_db`, click **Import** tab
   - Choose the `database.sql` file from the project
   - Click **Go** to import

6. **Open the app**:
   ```
   http://localhost/jobhub
   ```

---

## 🔑 Test Accounts

All passwords are **`password`** (bcrypt hash in `database.sql`).

### Job Seekers

| Name              | Email               | Role       |
| ----------------- | ------------------- | ---------- |
| Vo Hoang Nhat Anh | `seeker1@gmail.com` | Job Seeker |
| Cao Thi Quynh Dao | `seeker2@gmail.com` | Job Seeker |

### Employers

| Name             | Email                  | Role     |
| ---------------- | ---------------------- | -------- |
| Nguyen Minh Quan | `employer1@gmail.com`  | Employer |
| Rajesh Sharma    | `employer2@gmail.com`  | Employer |
| John Smith       | `employer3@gmail.com`  | Employer |
| Hans Weber       | `employer4@gmail.com`  | Employer |
| Tran Thu Ha      | `employer5@gmail.com`  | Employer |
| Priya Patel      | `employer6@gmail.com`  | Employer |
| Emily Davis      | `employer7@gmail.com`  | Employer |
| Pierre Dubois    | `employer8@gmail.com`  | Employer |
| Le Hoang Nam     | `employer9@gmail.com`  | Employer |
| Amit Kumar       | `employer10@gmail.com` | Employer |
| Michael Johnson  | `employer11@gmail.com` | Employer |
| Charlotte Walker | `employer12@gmail.com` | Employer |

> All accounts listed in the `users` table of `database.sql` with password `123456`.

---

## 🎨 Theme Switcher

Click your avatar → **Settings** → **Theme** tab to switch between 4 atmospheric themes:

| Theme        | Preview               | Primary   | Accent    | Mood        |
| ------------ | --------------------- | --------- | --------- | ----------- |
| **Dawn** 🌅  | Warm sunrise gradient | `#EA580C` | `#F43F5E` | Energetic   |
| **Noon** ☀️  | Bright blue sky       | `#2563EB` | `#0EA5E9` | Corporate   |
| **Dusk** 🌆  | Twilight purple→amber | `#F59E0B` | `#C084FC` | Atmospheric |
| **Night** 🌙 | Starry midnight blue  | `#38BDF8` | `#A78BFA` | Dark mode   |

Each theme includes:

- `--gradient-hero`, `--gradient-surface`, `--gradient-accent`, `--gradient-glow`
- `--glow-primary`, `--glow-card`, `--glow-success`, `--glow-danger`, `--glow-warning`
- Harmonized status colors (success/warning/danger/info) matching the brand palette

---

## 🧪 Running Tests

```bash
# Docker
docker exec jobhub-app php tests/TestRunner.php

# XAMPP
php tests/TestRunner.php
```

**Test coverage**: 37 test methods, 75 assertions across 4 test files.

| Test File                         | Tests | Coverage                                       |
| --------------------------------- | ----- | ---------------------------------------------- |
| `tests/Unit/helpersTest.php`      | 11    | Escape HTML, CSRF, URLs, flash messages        |
| `tests/Feature/AuthTest.php`      | 8     | Login/register forms, validation, locales      |
| `tests/Feature/JobSearchTest.php` | 9     | Search form, filters, pagination, sort         |
| `tests/Feature/SettingsTest.php`  | 9     | Profile, password, education, themes, language |

---

## 🗂️ Project Structure

```
jobhub/
├── config/
│   ├── app.php                  # App configuration
│   ├── database.php             # PDO (auto-detects Docker vs XAMPP)
│   ├── routes.php               # All URL routes
│   └── lang/                    # Translations (en, vi)
├── docker/
│   ├── apache.conf              # Apache virtual host config
│   └── php.ini                  # PHP config for Docker
├── public/
│   ├── index.php                # Entry point
│   ├── router.php               # Built-in PHP dev server
│   ├── assets/
│   │   ├── css/                 # theme.css, app.css, components.css, etc.
│   │   ├── js/                  # app.js, theme.js, search.js, etc.
│   │   └── img/                 # Logos, icons, illustrations
│   └── uploads/                 # User uploads (avatars, CVs, logos)
├── src/
│   ├── Controllers/             # Auth, Job, Candidate, Employer, etc.
│   ├── Core/                    # MVC framework (App, Router, Controller, Model)
│   ├── Middleware/               # Auth, CSRF, Locale middlewares
│   ├── Models/                  # User, Job, Company, Application, etc.
│   ├── Services/                # Auth, FileUpload, AI (interface)
│   ├── Views/                   # Templates (layouts, pages, partials)
│   └── helpers.php              # Global helpers (e(), flash(), csrf_field(), etc.)
├── tests/                       # Unit + Feature tests
├── Dockerfile                   # Apache + PHP 8.2 image
├── docker-compose.yml           # Full stack (app + db + phpMyAdmin)
├── database.sql                 # Schema + 20 sample jobs + test data
└── .htaccess                    # Security rules
```

---

## ⚙️ Configuration

### Environment Detection (Docker vs XAMPP)

`config/database.php` auto-detects the environment:

- **Docker**: Uses `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` env vars
- **XAMPP**: Falls back to `localhost` / `root` / empty password (XAMPP defaults)

No manual changes needed between environments.

### App Config (`config/app.php`)

```php
'name' => 'JobHub',
'default_locale' => 'en',
'supported_locales' => ['en', 'vi'],
'items_per_page' => 12,
'password_min_length' => 6,
'upload_max_size' => 5 * 1024 * 1024, // 5MB
```

---

## 📝 License

Copyright 2026 JobHub

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

```
Apache License
Version 2.0, January 2004
http://www.apache.org/licenses/

TERMS AND CONDITIONS FOR USE, REPRODUCTION, AND DISTRIBUTION

1. Definitions.
   "License" shall mean the terms and conditions for use, reproduction,
   and distribution as defined by Sections 1 through 9 of this document.
   ...

2. Grant of Copyright License.
   Subject to the terms and conditions of this License, each Contributor
   hereby grants to You a perpetual, worldwide, non-exclusive, no-charge,
   royalty-free, irrevocable copyright license to reproduce, prepare
   Derivative Works of, publicly display, publicly perform, sublicense,
   and distribute the Work and such Derivative Works in Source or Object form.
   ...

   Full license text: https://www.apache.org/licenses/LICENSE-2.0
```
