# H&Maybe

A full-stack fashion e-commerce web application built with PHP. Browse clothing, add to cart, checkout with Stripe, and manage orders — with a full admin panel for store operators.

## Features

### Customer
- Browse products by category (Women, Men) with search
- Product detail pages with size and color variations
- Shopping cart with quantity management
- Stripe Checkout payment (card, Malaysian Ringgit)
- Order history with status tracking and cancel option
- Email receipts on purchase
- Profile management with photo upload
- Email verification and password reset

### Admin
- Product CRUD with variations (size, color, stock, photos)
- Category management
- Order management with status updates
- Member list with detail view

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Plain PHP (no framework) |
| Database | MySQL/MariaDB via PDO |
| Payments | Stripe (`stripe-php`) |
| Email | PHPMailer (SMTP) |
| Frontend | jQuery, custom CSS |
| Images | `.avif` product photos, `SimpleImage` thumbnail library |

## Database

The schema (`h_and_maybe_db.sql`) includes 10 tables covering users, products, variations, cart, orders, addresses, and auth tokens. Seed data for 9 products with 100+ variations is included.

## Setup

1. Import `h_and_maybe_db.sql` into MySQL/MariaDB
2. Run `composer install` in the `app/` directory
3. Configure database credentials in `app/_base.php`
4. Set your Stripe secret key and Gmail SMTP credentials in the relevant files
5. Serve the `app/` directory with Apache/Nginx

**Note:** The current Stripe key and email credentials in the codebase are test/hardcoded values and should be replaced with environment variables before production use.
