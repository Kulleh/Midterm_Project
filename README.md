# Point of Sale System

This CodeIgniter 4 project contains the work completed for laboratory steps 1 through 4 of the IT0049 midterm project. Steps 1 and 2 were present in the supplied project; this update adds customer management and staff account management.

## Updates Made

### Laboratory Step 3 Customer Management

- Added the `CustomerModel` for the `customers` table.
- Added the `Customers` controller with list, add, edit, update, and delete actions.
- Added routes for `/customers`, `/customers/create`, `/customers/edit/{id}`, and the related form submissions.
- Added customer views for listing, creating, and editing records.
- Added validation for required names, valid email addresses, and database field lengths.
- Added escaped output and clear success or error messages.

### Laboratory Step 4 Staff Account Management

- Added the `UserModel` for the `users` table.
- Added the `Users` controller with list, add, edit, update, and delete actions.
- Added routes for `/users`, `/users/create`, `/users/edit/{id}`, and the related form submissions.
- Added staff account views for listing, creating, and editing records.
- Added unique username checking.
- Added password hashing with PHP `password_hash()` before a password is stored.
- Added avatar upload handling restricted to JPG, PNG, and WebP images up to 2 MB.
- Added random stored filenames and display-ready avatar URLs.
- Added safe replacement and deletion of old avatar files.
- Added a shared navigation partial linking the products, customers, and staff pages.

## Existing Work Preserved

- The supplied product management pages and product model were retained.
- The supplied login page and routes were retained. Authentication protection is not part of this update and is recommended for laboratory step 5.
- The supplied database export already contains the `products`, `customers`, `users`, and `sales` tables required by the project.

## Setup

1. Import `midterm_products_db.sql` into MySQL or MariaDB.
2. Open `.env` and update `app.baseURL` and the `database.*` settings for the local machine.
3. From the project folder, install dependencies if needed:

   ```bash
   composer install
   ```

4. Start the development server:

   ```bash
   php spark serve
   ```

5. Open `http://localhost:8080/customers` or `http://localhost:8080/users`.

Avatar files are created automatically in `public/uploads/avatars` when the first avatar is uploaded. The web server must have permission to write to that directory.

## Recommendations for Laboratory Steps 5 to 7

### Step 5 Authentication and Access Protection

- Replace the current placeholder login behavior with a database lookup in the `users` table.
- Verify passwords with `password_verify()` and store the authenticated user ID and name in the session.
- Add a CodeIgniter filter that protects products, customers, staff, sales, and sales history routes.
- Add logout and redirect unauthenticated visitors to `/login`.
- Keep the login error message generic so it does not reveal whether a username exists.

### Step 6 Record Sale

- Add a form where a logged-in staff member selects a product, optionally selects a customer, and enters a positive quantity.
- Check stock on the server immediately before recording the sale.
- Use a database transaction to insert the sale and decrease `products.stock_quantity` together.
- Reject quantities greater than available stock with a clear message and leave both tables unchanged.
- Calculate `total_price` from the database product price rather than trusting a submitted price.

### Step 7 Sales History

- Add a `SalesModel` and a sales history controller with joins to products, customers, and users.
- Display product, customer when present, staff member, quantity, total price, and sale date.
- Order recent transactions first and add pagination if the list becomes large.
- Keep sales records read-only unless a separate reversal or refund workflow is designed.
- Test the complete flow: log in, record a valid sale, confirm stock decreased, reject an over-stock sale, and verify the transaction appears in history.

## Scope Note

This update intentionally stops after customer and staff account management. Authentication, sales recording, and sales history remain available for the team member assigned to steps 5 through 7.
