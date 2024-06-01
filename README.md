# Laravel REST API with Access Control List

This project is a Laravel-based REST API that incorporates an Access Control List (ACL) for managing permissions. It uses Sanctum for authentication and Pint for code styling and linting. The setup is containerized using Docker Compose, making it easy to deploy and manage.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Running the Application](#running-the-application)
5. [Using the API](#using-the-api)
6. [Code Styling with Pint](#code-styling-with-pint)
7. [License](#license)

## Prerequisites

Make sure you have the following installed on your local development machine:

- Docker
- Docker Compose

## Installation

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/Bruno-bhab/acl-api-laravel.git
    cd acl-api-laravel
    ```

2. **Set Up Environment Variables:**

    Copy the example environment file and adjust the variables as needed:

    ```bash
    cp .env.example .env
    ```

3. **Build Docker Containers:**

    ```bash
    docker-compose up -d --build
    ```

## Configuration

1. **Laravel Setup:**

    Start the containers, access the app container and install PHP dependencies:

    ```bash
    docker-compose up -d
    docker-compose exec app bash
    composer install
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    ```

## Running the Application

1. **Start Docker Containers:**

    ```bash
    docker-compose up -d
    ```

2. **Access the Application:**

    Open your web browser and navigate to `http://localhost:8989`.

## Using the API

You can list the application routes with the following command:

- **List routes:**

    ```bash
    php artisan route:list
    ```
Some routes need to receive a login token:

- **Example:**
    ```http
    GET /me
    Authorization: Bearer {token}
    ```

## Code Styling with Pint

Laravel Pint is a zero-configuration code styling tool for PHP. To run Pint within your Docker container:

1. **Access the app container:**

    ```bash
    docker-compose exec app bash
    ```

2. **Run Pint:**

    ```bash
    composer pint
    ```

## License

This project is open-source and available under the [MIT license](LICENSE).

---

By following these steps, you will have a Laravel REST API with Sanctum for authentication, and Pint for code styling, all running smoothly in Docker containers. If you encounter any issues, please refer to the official Laravel, Sanctum, and Docker documentation for further assistance.
