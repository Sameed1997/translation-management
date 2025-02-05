# **Translation Management API**

This is a Laravel-based Translation Management API that allows users to manage translations across multiple locales with features like tagging, searching, and exporting translations.

---

## **Installation Steps**

Follow the steps below to set up the project locally:

### **1. Clone the Repository**
```bash
git clone <repository-url>
```

### **2. Create a Database**
- Set up a database in your preferred SQL environment (e.g., MySQL).
- Note the database name, username, and password.

### **3. Set Up the Environment File**
Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```

### **4. Generate the Application Key**
Run the following command to generate the application key:
```bash
php artisan key:generate
```

### **5. Configure the `.env` File**
Edit the `.env` file and update the following database configuration:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### **6. Run Migrations and Seed the Database**
Run the migrations to create database tables and seed sample data:
```bash
php artisan migrate
php artisan db:seed --class=TranslationSeeder
```

### **7. Register and Login**
- Use the **Register API** to create an account.
- Use the **Login API** to authenticate and get your token.

### **8. Start the Development Server**
Run the following command to start the Laravel development server:
```bash
php artisan serve
```

The API will be available at:
```
http://127.0.0.1:8000
```

### **9. View API Documentation**
Visit the Swagger API documentation at:
```
http://127.0.0.1:8000/swagger/api/documentation
```

---

## **Features**
- Create, update, view, and search translations.
- Tag translations for better context management.
- Export translations as JSON for frontend applications.
- Token-based authentication for API access.
- Fully documented API using Swagger (OpenAPI).

---

## **Testing**
To run automated tests:
```bash
php artisan test
```

---

## **License**
This project is open-source and available under the [MIT license](LICENSE).

