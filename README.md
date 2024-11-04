# CRUD Builder

Welcome to the **CRUD Builder** project! This tool empowers developers to generate fully functional CRUD applications with ease, offering flexible customization, automated CRUD operations, and seamless API documentation. Designed for Laravel, CRUD Builder simplifies backend development, allowing you to focus on building your application.

## Table of Contents

- [Features](#features)
- [Project Structure](#project-structure)
- [Installation](#installation)

## Features

- **Automated CRUD Generation**: Quickly create standard and API CRUD operations with controllers, models, migrations, and views.
- **Customizable Forms & Validation**: Define fields, select validation rules, and customize your forms to suit your application.
- **User Management & Permissions**: Easily manage users, roles, and permissions, enabling fine-grained access control.
- **Auto-Generated API Documentation**: Swagger API documentation is automatically generated for each CRUD operation.
- **Flexible Model Relations**: Effortlessly define and manage relationships between models.

## Project Structure

- **app/**: Contains the core application logic, including controllers, models, and policies.
- **resources/views/**: Holds the blade templates for the UI components.
- **routes/**: Defines the API and web routes for CRUD operations.
- **database/migrations/**: Contains migration files for creating database tables.
- **public/**: Contains publicly accessible files, such as assets.

## Installation

To install and set up the CRUD Builder, follow these steps:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/crud-builder.git
   cd crud-builder
   ```
2. **Install dependencies**:
    ```
    composer install
    npm install && npm run dev
    ```
3. **Environment setup**:
    ```
    cp .env.example .env
    php artisan key:generate
    ```
4. **Database configuration**:
    ```
    php artisan migrate:fresh --seed
    ```
