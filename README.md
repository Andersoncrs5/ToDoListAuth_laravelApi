# ToDoList with Auth - Laravel API

Start Date: 04/28
End Date: 04/29
📋 Project Description

This is a simple and functional To-Do List API built with Laravel, featuring full user authentication and task management. It follows the RESTful API structure and uses Laravel’s MVC pattern, middleware, and session handling.

## ✅ Features

### User Authentication

    Register new users

    User login and logout

    Get, update, and delete user data

    Session-based protection with custom middleware

### Task Management

    Create, read, update, and delete tasks

    Paginated list of all tasks for the authenticated user

    Change task completion status (done/undone)

    Each task is strictly associated with its owner

### Validation & Error Handling

    Custom validation class for checking IDs and entities

    Global exception handling with informative JSON responses

    All error messages are returned in English

### Security

    Routes protected by custom NoAuth and OnAuth middleware

    Only logged-in users can access task-related operations

    Tasks can only be modified by their respective owners

## 🛠 Technologies Used

    PHP 8.4.6

    Laravel 12

    postgresql 17.2

    Postman (for testing)

    Composer