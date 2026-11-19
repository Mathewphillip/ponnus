# PONNUS — HTML Teaching & Study Blueprint

This `html/` directory is an **exact 1:1 static replica** of the real Laravel views and master layouts in `resources/views/`.

## 🎓 Why This Is Built for Teaching
When instructing or demonstrating Laravel Blade, students or instructors can **directly copy and paste the HTML markup** from these files into their Blade views without altering any CSS classes, Bootstrap grid columns, or layout elements:
- All Bootstrap 5 class names, grid breakpoints (`col-md-3 col-lg-2`, `col-md-9 col-lg-10`, `card-stat`, `btn-brand`), card headers, badges, and modals are **100% identical** to the application's Blade files.
- The CSS in [`css/style.css`](css/style.css) contains the exact design tokens and CSS rules from [`resources/views/dashboard/layouts/master.blade.php`](../resources/views/dashboard/layouts/master.blade.php).
- The chef logo is stored locally as [`chef.jpg`](chef.jpg) so all views render self-contained without needing PHP `asset()` helpers.

---

## 🗺️ 1:1 Page-to-Blade Mapping Table

| HTML File | Corresponding Laravel Blade View | Purpose in the Teaching Curriculum |
|---|---|---|
| [`index.html`](index.html) | `resources/views/welcome.blade.php` | Clean homepage with chef branding, hero CTAs, and seeded demo accounts reference |
| [`login.html`](login.html) | `resources/views/auth/login.blade.php` | Staff login form with working password visibility eye-toggle & 1-click credential badges |
| [`register.html`](register.html) | `resources/views/auth/register.blade.php` | Staff registration form with separate eye-toggles on both Password and Confirm Password |
| [`public-menu.html`](public-menu.html) | `resources/views/public/menu.blade.php` | Customer-facing menu with interactive category filter pills (*All Dishes, Fast Food, Main Course, Pizza, Beverages*) & **UGX** pricing |
| [`dashboard.html`](dashboard.html) | `resources/views/dashboard/layouts/master.blade.php` + `navbar.blade.php` + `sidebar.blade.php` + `index.blade.php` | Main administrative dashboard: metric counter cards, quick action cards, active session details |
| [`menu-list.html`](menu-list.html) | `resources/views/dashboard/menu.blade.php` | Clean, balanced CRUD table with `#ID`, Dish, Category, Price in **UGX**, Status badges, View, Edit, and Delete modal trigger |
| [`add-menu.html`](add-menu.html) | `resources/views/dashboard/add-menu.blade.php` | Form to create a new dish with category dropdown, UGX price input, availability radios, and kitchen guidelines card |
| [`edit-menu.html`](edit-menu.html) | `resources/views/dashboard/edit-menu.blade.php` | Form to update an existing dish with ID tag, prepopulated inputs, and kitchen status metadata card |
| [`show-menu.html`](show-menu.html) | `resources/views/dashboard/show-menu.blade.php` | Single item detailed showcase: title, UGX price, description, 4-column specifications grid, timestamps, and quick action panel |
| [`chef.jpg`](chef.jpg) | `public/chef.jpg` | Local chef logo asset used across navigation, profile badges, and headers |
| [`css/style.css`](css/style.css) | Embedded CSS in `master.blade.php` | Shared stylesheet matching the light theme palette (`--primary-color: #ea580c; --body-bg: #f8fafc;`) |

---

## 🚀 How to Use During Instruction
1. Open any `.html` file directly in a web browser to demonstrate the finished user interface.
2. When demonstrating Laravel Blade templates, copy the inner container or card markup into `@section('content')` in the appropriate Blade file.
3. Replace static values (such as `$item->name`, `$item->price`, `route('menu.show', $item->id)`) with their Blade syntax.
