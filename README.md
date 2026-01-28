# Task Manager

A professional web application for managing tasks and organizing your work life. Features include priorities, filters, user authentication, categories, file uploads, a sidebar with open/close functionality, and more.

---

## :star: Features

- User registration and authentication
- Create, update, and delete tasks
- Assign priorities (**High, Normal, Low**) to tasks
- Mark favorite tasks ⭐
- Categorize tasks into **Categories**
- Trash bin (with restore and permanent delete)
- Advanced filtering (by priority, completion, favorite)
- File/image upload for tasks, with previews
- Responsive sidebar with open/close toggle
- Fast stats (total, completed, pending tasks)
- User roles (Admin/User) support
- Protected API endpoints (Sanctum)

---

## 🚀 Getting Started

1. **Clone the repository:**
   ```bash
   git clone https://github.com/YOUR_USERNAME/NEW_CRUD_APP.git
   cd NEW_CRUD_APP
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Create environment file and generate app key:**
   ```bash
   cp .env.example .env         # On Linux/Mac
   # OR for Windows:
   copy .env.example .env

   php artisan key:generate
   ```

4. **Run migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```

5. **Serve the backend:**
   ```bash
   php artisan serve
   ```

6. **(Optional) Run frontend build:**
   ```bash
   npm run dev
   ```

7. **Browse to:**  
   [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🧑‍💻 Demo Users

- **Admin:**  
  Email: `admin@example.com`  
  Password: `password`

- **User:**  
  Email: `user@example.com`  
  Password: `password`

> Or register a new account from the sign-up page.

---

## 🧪 Running Tests

```bash
php artisan test
```

---

## 🤝 Contributing

Contributions are welcome!  
- Feel free to open a Pull Request.
- Or open an Issue for bug reports and feature ideas.

---

## 📄 License

This project is open-source and free to use.

---

## 📬 For any question, feedback, or suggestion just open an issue!
