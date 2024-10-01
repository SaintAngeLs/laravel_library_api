# Laravel Library API

The **Laravel Library API** provides a structured and efficient way to manage a library system, handling the management of books and clients. The API includes functionality for renting and returning books and offers both RESTful API endpoints and web-based views. The project is fully documented using Swagger for API exploration.

## Table of Contents

- [Installation](#installation)
- [Requirements](#requirements)
- [Environment Variables](#environment-variables)
- [Database Setup](#database-setup)
- [API Documentation](#api-documentation)
- [Routes](#routes)
  - [API Routes](#api-routes)
  - [Web Routes](#web-routes)
- [Running Tests](#running-tests)
- [License](#license)

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

## API Documentation

The API documentation is automatically generated using Swagger and can be accessed at:

- **With virtual host**: `http://laravel.library.api/api/documentation`
- **Without virtual host**: `http://localhost:8000/api/documentation`

Make sure the environment variable `L5_SWAGGER_CONST_HOST` is correctly set in your `.env` file to match your host URL.

## Routes

### API Routes

The API exposes the following routes:

- **Books**:
  - `GET /v3/books` - Retrieve all books
  - `GET /v3/books/{id}` - Get a specific book by ID
  - `POST /v3/books/{bookId}/rent` - Rent a book
  - `POST /v3/books/{bookId}/return` - Return a rented book

- **Clients**:
  - `GET /v3/clients` - Retrieve all clients
  - `GET /v3/clients/{id}` - Get a specific client by ID
  - `POST /v3/clients` - Add a new client
  - `DELETE /v3/clients/{id}` - Delete a client

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
