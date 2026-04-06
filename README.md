<p align="center">
  <h1 align="center">🚀 Laravel Bisbond</h1>
  <p align="center">
    A powerful, dashboard-first regional business toolkit for Laravel applications.
  </p>
  <p align="center">
    <a href="https://packagist.org/packages/ahsan-ul-alam/laravel-bisbond"><img src="https://img.shields.io/packagist/v/ahsan-ul-alam/laravel-bisbond?style=flat-square" alt="Packagist Version"></a>
    <a href="https://packagist.org/packages/ahsan-ul-alam/laravel-bisbond"><img src="https://img.shields.io/packagist/dt/ahsan-ul-alam/laravel-bisbond?style=flat-square" alt="Downloads"></a>
    <a href="https://github.com/ahsan-ul-alam/laravel-bisbond/blob/main/LICENSE"><img src="https://img.shields.io/github/license/ahsan-ul-alam/laravel-bisbond?style=flat-square" alt="License"></a>
    <img src="https://img.shields.io/badge/Laravel-10%2B-red?style=flat-square&logo=laravel" alt="Laravel">
    <img src="https://img.shields.io/badge/PHP-8.1%2B-blue?style=flat-square&logo=php" alt="PHP">
  </p>
</p>

##Documentation: <a href="https://tinyurl.com/bisbond">https://tinyurl.com/bisbond</a>

---

> 🎯 **Install once → Open `/bisbond` → Configure everything from the dashboard.**

Laravel Bisbond provides a centralized admin panel to manage **business settings, Bangla formatting, invoice system, SMS configuration, modules, system health, routes, commands, and future payment integrations** — all from one place.

---

## 📋 Table of Contents

- [Why Laravel Bisbond?](#-why-laravel-bisbond)
- [Features](#-features)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Helper Functions](#-helper-functions)
- [Architecture](#-architecture)
- [Roadmap](#-roadmap)
- [Contributing](#-contributing)
- [Author](#-author)
- [License](#-license)

---

## 💡 Why Laravel Bisbond?

In most Laravel projects, developers juggle multiple packages to handle business settings, invoices, SMS, payments, and regional formatting — each with their own setup steps.

**Laravel Bisbond solves this** by giving you a single, unified dashboard:

| Without Bisbond     | With Bisbond               |
| ------------------- | -------------------------- |
| Multiple packages   | One install                |
| Manual config files | Dashboard UI               |
| No regional support | Built-in Bangla formatting |
| Scattered settings  | Centralized control        |
| No health checks    | Smart status detection     |

---

## ✨ Features

### 🧠 Dashboard Control Center

- Central dashboard accessible at `/bisbond`
- Real-time system health overview
- Quick-action shortcuts for all configurations
- Clean, modern UI built with Blade + Tailwind CSS

### ⚙️ Smart Settings System

- Database-driven configuration with dot-notation access
- Automatic caching for performance
- Fallback to config file when DB value is absent

```php
bisbond_setting('general.business_name');
bisbond_setting('invoice.prefix');
```

### 📊 Configuration Health Check

Automatically detects and reports setup issues:

| Status   | Example                  |
| -------- | ------------------------ |
| ✅ OK    | Business Name Configured |
| ✅ OK    | Invoice Module Ready     |
| ❌ Error | Missing Payment Config   |

Each issue includes a `status`, `message`, `suggestion`, and a **direct action link**.

### 🧩 Module System

Dynamically enable or disable features without touching code:

```php
bisbond_module('invoice'); // true / false
bisbond_module('sms');
```

Available modules: `formatter` · `invoice` · `sms` · `payments` _(future)_

### 🇧🇩 Bangla Formatter

Built-in helpers for Bangladeshi applications:

```php
bn_digits(1234);    // ১২৩৪
bn_money(1500);     // ৳১,৫০০.০০
bn_date(now());     // ৭ এপ্রিল ২০২৬
```

### 🧾 Invoice System

- Live invoice preview in the dashboard
- Uses settings (prefix, footer, business info) automatically
- Bangla-formatted monetary values
- Ready for PDF export extension

### 📩 SMS Configuration

Configure SMS providers and templates from the dashboard:

- **Providers:** API key, Sender ID, Provider name
- **Templates:** OTP, Order Confirmation, Payment Success
- **Placeholders:** `{name}` · `{otp}` · `{amount}` · `{invoice_no}`

### 💳 Payment System _(Architecture Ready)_

Provider/adapter pattern designed for:

`bKash` · `Nagad` · `SSLCommerz` · `Rocket` · `Manual Payment`

### 🔍 Route & Command Explorer

- Browse all package routes (URI, Method, Name, Controller)
- List all available Artisan commands at a glance

---

## 📦 Installation

**1. Require the package**

```bash
composer require ahsan-ul-alam/laravel-bisbond
```

**2. Run the installer**

```bash
php artisan bisbond:install
```

**3. Open the dashboard**

```
http://your-app.test/bisbond
```

That's it. No complex setup steps.

---

## ⚙️ Configuration

All settings are managed through the dashboard UI at `/bisbond`. The available settings are:

| Group       | Settings                                |
| ----------- | --------------------------------------- |
| **General** | Business Name, Phone, Currency, Locale  |
| **Invoice** | Invoice Prefix, Footer Note             |
| **SMS**     | Provider, API Key, Sender ID, Templates |
| **Modules** | Enable / Disable individual features    |

To re-publish the config file:

```bash
php artisan vendor:publish --tag=bisbond-config --force
```

To update the package:

```bash
composer update ahsan-ul-alam/laravel-bisbond
php artisan optimize:clear
php artisan migrate
```

---

## 📌 Helper Functions

```php
// Settings
bisbond_setting('general.business_name');
bisbond_setting('invoice.prefix');

// Modules
bisbond_module('invoice');   // bool
bisbond_module('sms');       // bool

// Bangla Formatting
bn_digits(1234);             // ১২৩৪
bn_money(1500);              // ৳১,৫০০.০০
bn_date(now());              // ৭ এপ্রিল ২০২৬
```

---

## 🧱 Architecture

```
src/
├── Console/           # Artisan commands (bisbond:install)
├── Facades/           # BisbondManager facade
├── Helpers/           # Global helper functions
├── Http/
│   └── Controllers/   # Dashboard & module controllers
├── Models/            # BisbondSetting model
├── Services/
│   ├── SettingService.php        # Settings read/write/cache
│   ├── BisbondHealthService.php  # System health checks
│   └── BisbondManager.php        # Core access layer
└── Support/           # Module resolution & utilities
```

**Settings flow:** DB (`bisbond_settings`) → Laravel Cache → Config file fallback

**Health check output:**

```php
[
    'status'     => 'error',        // ok | warning | error
    'message'    => 'Missing SMS config',
    'suggestion' => 'Add your SMS provider API key',
]
```

---

## 🗺️ Roadmap

- [x] Dashboard Control Center
- [x] Settings System with health checks
- [x] Module on/off system
- [x] Bangla formatter helpers
- [x] Invoice preview
- [x] SMS configuration UI
- [x] Route & Command explorer
- [ ] Invoice PDF export
- [ ] Live SMS sending integration
- [ ] Payment gateway adapters (bKash, Nagad, SSLCommerz)
- [ ] Provider registry system
- [ ] Plugin architecture
- [ ] Developer help UI

---

## 🤝 Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you'd like to change.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 👨‍💻 Author

**Md. Ahsan Ul Alam**  
Full Stack Developer — Laravel · React.js · Next.js

---

## ⭐ Support

If Laravel Bisbond helps your project:

- ⭐ **Star** this repository
- 💬 **Share** your feedback via Issues
- 🚀 **Use it** and let others know

---

## 📜 License

Licensed under the [MIT License](LICENSE).
