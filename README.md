# Restaurant Reservation and Ordering API

This project is a RESTful API for a restaurant reservation and ordering system built with Laravel 11. It demonstrates the implementation of the Repository Pattern and Service Pattern to create a scalable, maintainable, and testable application.

## Table of Contents

- [Restaurant Reservation and Ordering API](#restaurant-reservation-and-ordering-api)
  - [Table of Contents](#table-of-contents)
  - [Features](#features)
  - [Architecture](#architecture)
    - [Design Patterns Used](#design-patterns-used)
  - [Installation](#installation)
    - [Prerequisites](#prerequisites)
    - [Setup Steps](#setup-steps)

## Features

- **Check Table Availability**: Check if a table is available during a certain date and time for a specific number of guests.
- **Reserve a Table**: Reserve a table for a customer at the requested date and time.
- **Waiting List**: Add customers to a waiting list if the maximum capacity of tables is reached.
- **List Menu Items**: Display all items on the menu with availability and discounts applied.
- **Place an Order**: Customers can place orders for their table, applying all discounts for each meal.
- **Checkout and Invoice**: Checkout an order and print an invoice for a table.

## Architecture

### Design Patterns Used

- **Repository Pattern**: Separates the data access logic and maps it to the business entities in the business logic. This promotes a loose coupling between the business logic and data access logic.
- **Service Pattern**: Encapsulates the business logic of the application, making controllers thinner and focused on handling HTTP requests and responses.
- **Dependency Injection**: Used throughout the application to inject dependencies, making the code more testable and maintainable.
- **SOLID Principles**: Applied to ensure a clean and scalable codebase.

## Installation

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL or any other supported database
- Git

### Setup Steps

1. **Clone the repository**:

    ```sh
    git clone https://github.com/ahmdsadik/whatsapp-clone-chat.git
    cd whatsapp-clone-chat
    ```

2. **Install dependencies**:

    ```sh
    composer install
    npm install
    ```

3. **Copy the example environment file and configure the environment variables**:

    ```sh
    cp .env.example .env
    ```

4. **Generate an application key**:

    ```sh
    php artisan key:generate
    ```

5. **Run database migrations**:

    ```sh
    php artisan migrate
    ```

6. **Run database seeder**:

    ```sh
    php artisan db:seed
    ```

7. **Run the development server**:

    ```sh
    php artisan serve
    ```

Your application should now be up and running on `http://localhost:8000`.
