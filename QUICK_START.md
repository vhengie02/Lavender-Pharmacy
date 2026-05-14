# QUICK REFERENCE - Lavender Pharmacy

## 🚀 Quick Start

1. **Import Database**
   ```sql
   mysql -u root -p < database/database.sql
   mysql -u root -p < database/sample_data.sql
   ```

2. **Configure Database**
   - Edit: `config/db_config.php`
   - Update credentials

3. **Access Application**
   - Home: http://localhost/lavender-pharmacy/
   - Login: http://localhost/lavender-pharmacy/login.php

---

## 👥 Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@lavenderpharmacy.com | Admin123456 |
| Editor | editor@lavenderpharmacy.com | Editor123456 |
| Customer | customer@lavenderpharmacy.com | Customer123456 |

---

## 📁 Important Files

- **Configuration**: `config/db_config.php`
- **Database Schema**: `database/database.sql`
- **Sample Data**: `database/sample_data.sql`
- **Documentation**: `README.md`
- **Setup Guide**: `SETUP.md`
- **Main Classes**: `classes/*.php`
- **Authentication**: `login.php`, `register.php`

---

## 🎯 Key Features

✅ User Authentication
✅ Product Shopping
✅ Shopping Cart
✅ Secure Checkout
✅ Receipt Generation
✅ Order Management
✅ Admin Dashboard
✅ Responsive Design

---

## 📊 Database Tables

1. users
2. products
3. categories
4. carts
5. orders
6. order_items
7. receipts
8. payments
9. inventory_logs
10. audit_logs

---

## 🔐 Default Credentials (After Sample Data Import)

**Admin Dashboard**: http://localhost/lavender-pharmacy/admin/dashboard.php
- Use admin@lavenderpharmacy.com / Admin123456

**Customer Shop**: http://localhost/lavender-pharmacy/customer/shop.php
- Use customer@lavenderpharmacy.com / Customer123456

---

## 💻 Technology Stack

- **Backend**: PHP 7.4+, MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 5
- **Libraries**: jQuery, AJAX, Font Awesome, SweetAlert2

---

## 📋 Main Pages

**Public:**
- index.php (Homepage)
- login.php (Login)
- register.php (Registration)

**Customer:**
- customer/shop.php (Products)
- customer/cart.php (Cart)
- customer/checkout.php (Checkout)
- customer/orders.php (Order History)

**Admin:**
- admin/dashboard.php (Dashboard)

---

## 🔧 Troubleshooting

**Database Connection Error**
- Check MySQL is running
- Verify credentials in config/db_config.php
- Ensure database exists

**File Upload Issues**
- Set uploads/ permissions to 755

**404 Errors**
- Check web server is running
- Verify file paths in includes

---

## 📞 Support

Email: admin@lavenderpharmacy.com
Phone: 09188887673

---

**Version**: 1.0.0
**Status**: ✅ Ready to Use
**Last Updated**: May 14, 2026
