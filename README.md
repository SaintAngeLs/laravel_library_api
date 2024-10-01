# Laravel Library API

The **Laravel Library API** provides a structured and efficient way to manage a library system, handling the management of books and clients. The API includes functionality for renting and returning books and offers both RESTful API endpoints and web-based views. The project is fully documented using Swagger for API exploration.

## Table of Contents

1. [Installation](#installation)
2. [Requirements](#requirements)
3. [Environment Variables](#environment-variables)
4. [Database Setup](#database-setup)
   1. [Creating the Database and User](#creating-the-database-and-user)
5. [API Documentation](#api-documentation)
6. [Routes](#routes)
   1. [Base URL](#base-url)
   2. [Authentication](#authentication)
   3. [Books Endpoints](#books-endpoints)
      1. [List All Books](#list-all-books)
      2. [Search Books](#search-books)
      3. [Get Book Details](#get-book-details)
      4. [Rent a Book](#rent-a-book)
      5. [Return a Book](#return-a-book)
   4. [Clients Endpoints](#clients-endpoints)
      1. [List All Clients](#list-all-clients)
      2. [Get Client Details](#get-client-details)
      3. [Create a New Client](#create-a-new-client)
      4. [Delete a Client](#delete-a-client)
   5. [Error Codes](#error-codes)
   6. [Swagger Integration](#swagger-integration)
   7. [Web Routes for MVC](#web-routes-for-mvc)
7. [User Interface (Tailwind and MVC)](#user-interface-tailwind-and-mvc)
8. [Running Tests](#running-tests)
9. [License](#license)

## Installation

To set up the Laravel Library API locally, follow these steps:

1. **Clone the repository**:
    ```bash
    git clone https://github.com/SaintAngeLs/laravel_library_api.git
    ```

2. **Navigate to the project directory**:
    ```bash
    cd laravel-library-api
    ```

3. **Install PHP dependencies**:
    ```bash
    composer install
    ```

4. **Install Node.js dependencies**:
    ```bash
    npm install
    ```

5. **Build frontend assets**:
    ```bash
    npm run build
    ```

6. **Set up environment variables**:
    Copy the `.env.example` to `.env` and configure it:
    ```bash
    cp .env.example .env
    ```

7. **Generate the application key**:
    ```bash
    php artisan key:generate
    ```

8. **Start the application**:
    If not using a virtual host, you can start the development server directly:
    ```bash
    php artisan serve
    ```

   Access the application at `http://localhost:8000`.

## Requirements

Ensure your system meets the following requirements to run the Laravel Library API:

- **PHP**: PHP 8.2.21 or higher
- **Composer**: Version 2.7.6 or higher
- **Node.js**: Version 18.19.1 or higher
- **npm**: Version 10.2.4 or higher
- **MySQL**: Version 5.7+ or MariaDB equivalent

## Environment Variables

Update the `.env` file with your local configuration. Example:

```env
APP_URL=http://laravel.library.api
L5_SWAGGER_CONST_HOST=http://laravel.library.api
L5_SWAGGER_BASE_PATH=http://laravel.library.api/v3

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_library_api_v3
DB_USERNAME=laravel_library_api_v3_user
DB_PASSWORD=laravel_library_api_v3_user_password
```

In the absence of a virtual host, the application can run using `localhost`, which is also acceptable:

```env
APP_URL=http://localhost:8000
L5_SWAGGER_CONST_HOST=http://localhost:8000
```

## Database Setup

### Creating the Database and User

1. **Access MySQL**:
    ```bash
    sudo mysql -u root -p
    ```

2. **Create the database**:
    ```sql
    CREATE DATABASE laravel_library_api_v3;
    ```

3. **Create a new MySQL user** and grant it the necessary privileges:
    ```sql
    CREATE USER 'laravel_library_api_v3_user'@'localhost' IDENTIFIED BY 'laravel_library_api_v3_user_password';
    GRANT ALL PRIVILEGES ON laravel_library_api_v3.* TO 'laravel_library_api_v3_user'@'localhost';
    FLUSH PRIVILEGES;
    ```

4. **Migrate the database**:
    ```bash
    php artisan migrate
    ```

5. **Optional**: Seed the database:
    ```bash
    php artisan db:seed
    ```






## Routes

Endpoints of the public API are listed below. You can also check some example **curl** requests in the `book_api_v3.rest` file located at the root of the repository.


---

## API Documentation

The API documentation is automatically generated using Swagger and can be accessed at:

- **With a virtual host**: `http://laravel.library.api/api/documentation`
- **Swagger UI Screenshot**:
  ![Swagger UI](storage/app/public/swagger_ui.png)

---

4. **Migrate the database**:
   ```bash
   php artisan migrate
   ```

5. **Optional**: Seed the database:
   ```bash
   php artisan db:seed
   ```

## User Interface (Tailwind and MVC)

In addition to the API, the user interface is built using **Tailwind CSS** and follows the **MVC** pattern. Below is a screenshot of the generated UI:

![Generated UI using Tailwind and MVC](src/storage/app/public/ui_mvc.png)




## API Documentation

The API documentation is automatically generated using Swagger and can be accessed at:

- **With virtual host**: `http://laravel.library.api/api/documentation`
- **Without virtual host**: `http://localhost:8000/api/documentation`

![Swagger UI](src/storage/app/public/swagger_ui.png)


Make sure the environment variable `L5_SWAGGER_CONST_HOST` is correctly set in your `.env` file to match your host URL.

## Routes

Endpoints of public api are listed, also, some **curl** requests are shown in the 'book_api_v3.rest' at the root of repository.

### **Base URL**
```
/v3
```

### **Authentication**
Currently, no authentication is required for this API.

---

### **Books Endpoints**

#### 1. **List All Books**
Retrieves a paginated list of books in the system.

```
GET /v3/books
```
- **Response (200)**
  - A list of books with pagination details.
  
- **Example Response:**
```json
[
  {
    "id": 1,
    "title": "Book Title 1",
    "author": "Author 1",
    "publisher": "Publisher 1",
    "year_of_publication": 2020,
    "is_rented": false,
    "rented_by": null
  },
  ...
]
```

#### 2. **Search Books**
Search for books by title, author, or publisher.

```
GET /v3/books/search?title={title}&author={author}&publisher={publisher}
```
- **Parameters**:
  - `title` (optional) — Filter by book title
  - `author` (optional) — Filter by book author
  - `publisher` (optional) — Filter by book publisher
  
- **Response (200)**
  - List of matching books.
  
- **Example Response:**
```json
[
  {
    "id": 2,
    "title": "Search Result Book",
    "author": "Author Name",
    "publisher": "Publisher Name",
    "year_of_publication": 2021,
    "is_rented": false,
    "rented_by": null
  }
]
```

#### 3. **Get Book Details**
Retrieve details of a specific book by its ID.

```
GET /v3/books/{id}
```
- **Parameters**:
  - `id` (required) — The ID of the book.

- **Response (200)**
  - Details of the requested book.
  
- **Response (404)**
  - Book not found.

- **Example Response:**
```json
{
  "id": 1,
  "title": "Book Title",
  "author": "Author Name",
  "publisher": "Publisher Name",
  "year_of_publication": 2021,
  "is_rented": false,
  "rented_by": null
}
```

#### 4. **Rent a Book**
Rent a book for a client by providing the client ID.

```
POST /v3/books/{bookId}/rent
```
- **Parameters**:
  - `bookId` (required) — The ID of the book to rent.

- **Request Body:**
```json
{
  "client_id": 1
}
```

- **Response (200)**:
  - Confirmation that the book was rented.
  
- **Response (404)**:
  - Book or client not found.
  
- **Response (409)**:
  - Book is already rented.
  
- **Example Response:**
```json
{
  "message": "Book rented successfully."
}
```

#### 5. **Return a Book**
Return a rented book.

```
POST /v3/books/{bookId}/return
```
- **Parameters**:
  - `bookId` (required) — The ID of the book to return.

- **Response (200)**:
  - Confirmation that the book was returned.
  
- **Response (404)**:
  - Book not found.
  
- **Response (409)**:
  - Book was not rented.
  
- **Example Response:**
```json
{
  "message": "Book returned successfully."
}
```

---

### **Clients Endpoints**

#### 1. **List All Clients**
Retrieve a list of all clients.

```
GET /v3/clients
```

- **Response (200)**:
  - A list of clients, each including their details and rented books.
  
- **Example Response:**
```json
[
  {
    "id": 1,
    "first_name": "John",
    "last_name": "Doe",
    "rentedBooks": [
      {
        "id": 1,
        "title": "Book Title",
        "author": "Author Name"
      }
    ]
  }
]
```

#### 2. **Get Client Details**
Retrieve details of a specific client by their ID.

```
GET /v3/clients/{id}
```
- **Parameters**:
  - `id` (required) — The ID of the client.

- **Response (200)**:
  - Details of the requested client.
  
- **Response (404)**:
  - Client not found.

- **Example Response:**
```json
{
  "id": 1,
  "first_name": "John",
  "last_name": "Doe",
  "rentedBooks": [
    {
      "id": 1,
      "title": "Book Title",
      "author": "Author Name"
    }
  ]
}
```

#### 3. **Create a New Client**
Add a new client to the system.

```
POST /v3/clients
```
- **Request Body:**
```json
{
  "first_name": "John",
  "last_name": "Doe"
}
```

- **Response (201)**:
  - The newly created client.

- **Example Response:**
```json
{
  "id": 2,
  "first_name": "John",
  "last_name": "Doe",
  "rentedBooks": []
}
```

#### 4. **Delete a Client**
Delete a client by their ID. If the client has rented books, they cannot be deleted.

```
DELETE /v3/clients/{id}
```
- **Parameters**:
  - `id` (required) — The ID of the client.

- **Response (200)**:
  - Confirmation that the client was deleted.

- **Response (404)**:
  - Client not found.
  
- **Response (400)**:
  - Client has rented books and cannot be deleted.

- **Example Response:**
```json
{
  "message": "Client deleted successfully."
}
```

---

### **Error Codes**

- **404 Not Found**: The requested resource (book or client) was not found.
- **400 Bad Request**: The client has rented books and cannot be deleted.
- **409 Conflict**: Book is already rented or cannot be returned because it was not rented.
- **500 Internal Server Error**: Server error occurred.

---

### **Swagger Integration**


You can access the API documentation in a user-friendly UI by visiting the Swagger UI at `/api/documentation`. The Swagger UI provides the ability to interact with the API directly from the browser.
----
### Web Routes for MVC

- **Books Pages**:
  - `GET /pages/books` - View all books
  - `GET /pages/books/{id}` - View a specific book
  - `POST /pages/books/{bookId}/rent` - Rent a book via the web interface
  - `POST /pages/books/{bookId}/return` - Return a book via the web interface

- **Clients Pages**:
  - `GET /pages/clients` - View all clients
  - `GET /pages/clients/{id}` - View a specific client
  - `POST /pages/clients` - Add a new client via the web interface
  - `DELETE /pages/clients/{id}` - Delete a client via the web interface

## Running Tests

To run unit and feature tests:

```bash
php artisan test
```

Ensure that the test environment is properly configured in your `.env.testing` file.

## License

This project is licensed under the Apache License 2.0. You may obtain a copy of the License at:

```
http://www.apache.org/licenses/LICENSE-2.0
```

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
