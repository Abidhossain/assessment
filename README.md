# Coding Test Project

Welcome to the Coding Test Project! This project is designed to assess your coding skills and understanding of Laravel.
It includes a set of tasks or challenges for you to complete within a specified time frame.

## Introduction

The Coding Test Project is a Laravel-based application created specifically for coding tests. It provides a platform for
administering coding challenges and evaluating candidates based on their solutions.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP (8.2)
- Composer
- Node.js (>= 18.x)
- MySQL or any other preferred database system

## Installation

To set up the Coding Test Project, follow these steps:

1. Clone the repository:

   ```bash
   git clone git@github.com:Abidhossain/assessment.git

2. Navigate to the project directory:
    ```bash 
   cd assessment

3. Install PHP dependencies:
    ```bash
   composer install

4. Create a copy of the .env.example file and name it .env:
    ```bash
   cp .env.example .env

5. Generate an application key:
    ```bash
   php artisan key:generate

6. Configure your database settings in the .env file.

7. Run database migrations:
    ```bash
   php artisan migrate:fresh --seed

8. Install JavaScript dependencies:
    ```bash
   npm install
    # or
    yarn
9. Compile assets:
   ```bash
   npm run dev
   # or
   yarn dev

## Usage

1. Start the development server:
    ```bash
   php artisan serve

2. Open your web browser and navigate to `http://localhost:8000` (or the URL provided by the serve command).


