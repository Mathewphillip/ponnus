# PONNUS — Static HTML/CSS/JS Prototype (Study Reference)

This directory provides standalone HTML, CSS, and JavaScript views that mirror the full **PONNUS Restaurant Menu Management System**.

You can double-click any `.html` file to open and preview it directly in your browser without running a PHP/MySQL server.

---

## 📁 Directory Structure

```
html/
├── css/
│   └── style.css            # Unified stylesheet (theme colors, sidebar, cards, tables, badges)
├── js/
│   └── app.js               # Common JS utilities (password toggles, category filtering, navigation)
├── index.html               # Public Landing / Welcome page
├── login.html               # Staff Login (with password view toggle & demo credentials)
├── register.html            # Staff Registration (with dual password toggles)
├── public-menu.html         # Customer-Facing Menu (category filter pills, UGX pricing)
├── dashboard.html           # Restaurant Staff / Admin Dashboard
├── menu-list.html           # Full Menu Items CRUD Table
├── add-menu.html            # Add New Menu Item Form
├── edit-menu.html           # Edit Existing Menu Item Form
├── show-menu.html           # Single Menu Item Detailed View
└── README.md                # This reference guide
```

---

## 🔗 Full Navigation Flow

1. **Public Side**:
   - `index.html` → Click **"View Our Menu"** → opens `public-menu.html`.
   - `index.html` → Click **"Staff Login"** → opens `login.html`.
   - `public-menu.html` → Filter dishes by clicking **All Dishes**, **Main Course**, **Fast Food**, **Pizza**, **Beverages**.
   - `public-menu.html` → Click **"Staff Login"** or **"Home"** to navigate back.

2. **Authentication**:
   - `login.html`:
     - Click any of the pre-filled demo account chips (`admin@ponnus.test`, `staff@ponnus.test`, `manager@ponnus.test`).
     - Password is pre-set to `password123`.
     - Click the **eye icon** to show/hide the password text.
     - Click **Sign In** → automatically redirects to `dashboard.html`.
     - Click **Create an account** → opens `register.html`.
   - `register.html`:
     - Eye icons toggle visibility on both **Password** and **Confirm Password**.
     - Submitting redirects back to `login.html`.

3. **Dashboard & Menu Management**:
   - `dashboard.html` → Access summary stats, quick cards, or use the sidebar:
     - **Menu Items** → opens `menu-list.html`.
     - **Add New Item** → opens `add-menu.html`.
     - **Customer Menu** → opens `public-menu.html` in the same tab.
     - **Log Out** → returns to `index.html`.
   - `menu-list.html` → Table with sample dishes in UGX:
     - Click **View** → opens `show-menu.html?id=X`.
     - Click **Edit** → opens `edit-menu.html?id=X`.
     - Click **Delete** → confirms and removes the row dynamically from the table.
   - `show-menu.html` → Full view of a single dish, with direct buttons to **Edit Item** or **Delete Item**.
   - `add-menu.html` & `edit-menu.html` → Forms with complete field validation, UGX pricing, and availability radio options.
