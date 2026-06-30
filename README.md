<h1 align="center">👗 H&Maybe</h1>
<h3 align="center"><em>A full-stack fashion store — shop, pay, and track, with a complete admin back office.</em></h3>

<p align="center">
  <img src="https://img.shields.io/badge/language-PHP-777BB4?style=for-the-badge&logo=php" alt="PHP"/>
  <img src="https://img.shields.io/badge/database-MySQL-4479A1?style=for-the-badge&logo=mysql" alt="MySQL"/>
  <img src="https://img.shields.io/badge/payments-Stripe-635BFF?style=for-the-badge&logo=stripe" alt="Stripe"/>
  <img src="https://img.shields.io/badge/email-PHPMailer-0078D4?style=for-the-badge&logo=maildotru" alt="PHPMailer"/>
  <img src="https://img.shields.io/badge/frontend-jQuery-0769AD?style=for-the-badge&logo=jquery" alt="jQuery"/>
</p>

---

## 📖 About The Project

**H&Maybe** is an online fashion store built end to end. Shoppers can browse the catalogue, pick sizes and colours, fill a cart, and pay securely by card. Behind the storefront, a complete **admin panel** lets the shop run the whole operation — managing products, stock, and orders without ever touching the database directly.

The app is written in **plain PHP** (no framework) over a **MySQL** database accessed via **PDO**. Payments go through **Stripe Checkout** in Malaysian Ringgit, and transactional emails (receipts, verification, password resets) are sent with **PHPMailer**. It's a from-scratch, full-stack build that covers the entire e-commerce lifecycle.

---

## ✨ Features

### 🛍️ Customer Storefront

|  | Feature | Description |
|--|---------|-------------|
| 🔐 | **Accounts** | Register, log in, and stay signed in with "remember me" tokens. |
| 📧 | **Email Verification** | Confirm your email before shopping, with secure tokens. |
| 🔑 | **Password Reset** | Forgot your password? Reset it via an emailed link. |
| 📋 | **Browse & Search** | Browse by category (Women, Men) and search the catalogue. |
| 👕 | **Product Variations** | Each product offers size and colour options with their own stock. |
| 🛒 | **Shopping Cart** | Add items, adjust quantities, and see live subtotals. |
| 💳 | **Stripe Checkout** | Pay securely by card in Malaysian Ringgit (MYR). |
| 🧾 | **Email Receipts** | Get an itemised receipt by email after every purchase. |
| 📦 | **Order History** | Track order status and cancel orders when allowed. |
| 📍 | **Address Book** | Save and manage delivery addresses. |
| 👤 | **Profile** | Update your details and upload a profile photo. |

### 🛠️ Admin Panel

|  | Feature | Description |
|--|---------|-------------|
| 🍰 | **Product Management** | Full CRUD on products and their variations (size, colour, stock, photos). |
| 🗂️ | **Category Management** | Create and organise product categories. |
| 📦 | **Order Management** | View orders and update their status through the fulfilment workflow. |
| 👥 | **Member Management** | Browse the member list with detailed customer views. |

---

## 🧭 Shopping Flow

```
  BROWSE / SEARCH
        │
        ▼
  PRODUCT DETAIL ──(pick size + colour)──► ADD TO CART
        │                                       │
        │                                       ▼
        │                                 SHOPPING CART
        │                                       │
        ▼                                       ▼
   ◄─────────────────── CHECKOUT (Stripe) ◄─────┘
                            │
                            ▼
                   PAYMENT CONFIRMED
                            │
              ┌─────────────┼─────────────┐
              ▼             ▼             ▼
       EMAIL RECEIPT   ORDER RECORD   ORDER HISTORY
```

---

## 🛠️ Technology Stack

| Category | Technology | Purpose |
|:---------|:-----------|:--------|
| **Backend** | Plain PHP (no framework) | Server-side logic and routing |
| **Database** | MySQL / MariaDB via PDO | Relational data store |
| **Payments** | Stripe (`stripe-php`) | Card checkout in MYR |
| **Email** | PHPMailer (SMTP) | Receipts, verification, password resets |
| **Images** | `SimpleImage` | Product/profile photo processing (`.avif`) |
| **Pagination** | `SimplePager` | Paged product and member lists |
| **Frontend** | jQuery + custom CSS | Interactivity and styling |
| **Dependencies** | Composer | PHP package management |

---

## 📂 Project Structure

```
HAndMaybe/
├── h_and_maybe_db.sql              # Full schema + seed data
└── app/
    ├── _base.php                   # DB connection, helpers, session
    ├── _head.php / _foot.php       # Shared layout partials
    ├── index.php                   # Storefront entry
    ├── css/                        # Per-page stylesheets
    ├── js/handmaybe.js             # Client-side scripts
    ├── lib/
    │   ├── PHPMailer.php / SMTP.php # Email sending
    │   ├── SimpleImage.php          # Image processing
    │   └── SimplePager.php          # Pagination
    ├── images/                     # Catalogue photos (.avif)
    ├── photos/                     # Uploaded user/product photos
    └── vendor/                     # Composer dependencies (Stripe, etc.)
```

---

## 🗄️ Database Design

The schema (`h_and_maybe_db.sql`) defines **12 tables** covering the full store. Seed data for 9 products with 100+ variations is included.

| Table | Holds |
|:------|:------|
| **user** | Accounts, profiles, roles |
| **address** | Saved delivery addresses |
| **category** | Product categories |
| **product** | Catalogue items |
| **product_variation** | Size/colour/stock per product |
| **cart** | A user's active cart |
| **cart_items** | Line items within a cart |
| **order** | Placed orders |
| **order_items** | Line items within an order |
| **email_verification_tokens** | Email confirmation tokens |
| **password_reset_tokens** | Password reset tokens |
| **remember_tokens** | "Remember me" session tokens |

---

## 🚀 Getting Started

### Prerequisites

- **PHP** 8+ with PDO
- **MySQL** / **MariaDB**
- **Composer**
- A web server (Apache / Nginx)

### Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/ExoticPengy/HAndMaybe.git
   ```

2. **Import the database**

   ```bash
   mysql -u root -p < h_and_maybe_db.sql
   ```

3. **Install dependencies**

   ```bash
   cd app && composer install
   ```

4. **Configure** — set your database credentials in `app/_base.php`, plus your Stripe secret key and Gmail SMTP credentials.

5. **Serve** the `app/` directory with Apache or Nginx.

> ⚠️ The Stripe key and email credentials currently in the codebase are test/hardcoded values. Move them to environment variables before any production use.

---

## 📝 License

Educational project — all rights reserved.
