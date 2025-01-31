# Shopping Cart Application

## Introduction
The Shopping Cart Application is a lightweight web-based system designed to provide users with a seamless and interactive shopping experience. Customers can browse categories and products, add items to their cart, modify quantities, and proceed to checkout. The application is built with a **PHP backend** and a **SQLite database**, with a simple and responsive frontend powered by **HTML5** and **Bootstrap 5** for styling.

The application runs in a **Dockerized environment**, utilizing **PHP-FPM** and **Nginx** for efficient and scalable deployment.

---

## Features
- **Product Listing**: Browse and search products dynamically.
- **Category Management**: View products by category and sort them.
- **Shopping Cart**:
   - Add, update, and remove items dynamically.
   - Cart totals are calculated in real-time.
- **RESTful APIs**: Manage product and cart data efficiently.
- **Dockerized Deployment**: Ensures portability and easy setup.

---

## Technology Stack
### **Frontend**
- **HTML5**: For structure and content.
- **Bootstrap 5**: For styling and responsive design.
- **Axios**: For making API requests (served via CDN).

### **Backend**
- **PHP**: Handles routing, API requests, and database interactions.
- **SQLite**: Lightweight database for persistent storage.
- **Custom Minimalistic Framework**: Captures requests, parses URIs, and returns JSON responses or serves templates.

### **Environment**
- **Docker**:
   - **PHP-FPM**: For efficient PHP execution.
   - **Nginx**: Serves as the web server.

---

## API Endpoints
### Products
- **Get Featured Products**: ```GET /api/v1/products/featured```
- **Get All Products**: ```GET /api/v1/products```
- **Search Products**: ```GET /api/v1/products/search?query=book&category=3&max_price=20```

### Categories
- **Get All Categories**: ```GET /api/v1/categories```
- **Get Products in Category**: ```GET /api/v1/category/3?sort=a-to-z```
### Basket
- **Add to Basket**: ```POST /api/v1/basket/add```
  - **Payload**:
  ```json
  {
  "product_id": "8"
  }
  ```
  
  - **Update Basket**: ```PATCH /api/v1/basket/update/1```
  ```json
  {
  "quantity": 3
  }
  ```
  - **Remove from Basket**: ```DELETE /api/v1/basket/delete/1```
  
