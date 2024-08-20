# Task Management System
### Description:

A simple web application built with Laravel for managing tasks. Users can create, view, update, and delete tasks, each with a title, description, status, and due date. Task assignment and user authentication are implemented, along with a REST API for interacting with the system.

### Key Features:

User Authentication: Secure user login and registration using Laravel's built-in authentication system.  
Task Management: Create, read, update, and delete tasks, each with a title, description, status, and due date.  
Task Assignment: Assign tasks to specific users, allowing for efficient task delegation and tracking.  
REST API: A well-structured REST API provides endpoints for managing tasks and user authentication.  
Laravel Sanctum: Secure the API using Laravel Sanctum for token-based authentication.

### Technology Stack:
Laravel  
MySQL  
Laravel Sanctum

## How to Install and Run the Project

1.  `git clone github@link.git`
2.  `docker-compose exec app composer install`
3.  Copy  `.env.example`  to  `.env`
4.  `docker-compose build`
5.  `docker compose up -d`
6.  You can see the project on  `127.0.0.1:8080`
