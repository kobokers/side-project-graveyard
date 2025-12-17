# Side Project Graveyard 🪦

A Laravel 11 marketplace where entrepreneurs can list their abandoned side projects and connect with buyers who want to give them a second life.

## Features

- 🔐 **Full Authentication** (Laravel Breeze)
- 📝 **Project Listings** with images, pricing, and detailed information
- 🔍 **Advanced Search & Filters** by category, price, traffic, and revenue
- 💳 **Stripe Payment Integration** ($10 listing fee, $25 featured upgrade)
- ⭐ **Featured Listings** for 30 days with premium visibility
- 📊 **User Dashboard** to manage all your projects
- 🎨 **Responsive UI** with Tailwind CSS
- 📧 **Email Notifications** (ready to configure)

## Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

### Installation

```bash
# Clone or navigate to the project
cd side-project-graveyard

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env

# Edit .env and add your Stripe keys:
# STRIPE_SECRET=sk_test_your_secret_key
# STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Create storage symlink
php artisan storage:link

# Start the development server
php artisan serve

# In another terminal, compile assets
npm run dev
```

Visit **http://localhost:8000** to see your marketplace!

## Stripe Setup

1. Create a free account at [https://dashboard.stripe.com/register](https://dashboard.stripe.com/register)
2. Get your test API keys from **Developers → API keys**
3. Add them to your `.env` file
4. For webhook testing, install the [Stripe CLI](https://stripe.com/docs/stripe-cli):
   ```bash
   stripe listen --forward-to localhost:8000/webhook/stripe
   ```

## Usage

### For Sellers
1. **Register** an account
2. **List your project** with details, images, and pricing
3. **Pay $10** listing fee via Stripe
4. Your project goes **live immediately**
5. **Optional**: Upgrade to featured for $25/month

### For Buyers
1. **Browse projects** for free
2. **Filter** by category, price, traffic, revenue
3. **View details** and contact sellers via email
4. **Negotiate** and close the deal directly

## Tech Stack

- **Framework**: Laravel 11
- **Authentication**: Laravel Breeze (Blade)
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Payments**: Laravel Cashier (Stripe)
- **Frontend**: Tailwind CSS
- **File Storage**: Local (configurable to S3)

## Project Structure

- `app/Http/Controllers/` - HomeController, ProjectController, PaymentController, DashboardController
- `app/Models/` - Project, Transaction, User
- `app/Policies/` - ProjectPolicy for authorization
- `resources/views/` - All Blade templates
- `routes/web.php` - All application routes

## Pricing

- **Listing Fee**: FREE! 🎉
- **Commission**: 5% on successful deals only
- **Featured Upgrade**: $25 per 30 days (optional)

## Testing

Use Stripe test cards for payment testing:
- **Success**: `4242 4242 4242 4242`
- **Decline**: `4000 0000 0000 0002`

Any future expiry date and any 3-digit CVC.

## Deployment

For production deployment:
1. Set `APP_ENV=production` and `APP_DEBUG=false`
2. Switch to MySQL/PostgreSQL
3. Configure S3 for file storage
4. Set up queue worker for emails
5. Register webhook URL in Stripe dashboard
6. Ensure HTTPS for webhook security

## License

Open source. Feel free to use and modify.

## Support

For issues or questions, create an issue in the repository.

---

Built with ❤️ using Laravel 11
