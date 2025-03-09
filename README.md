# Task Management API

A RESTful API for task management with comments, authentication, and notifications built with Laravel.

## Features

- User authentication (Register/Login/Logout)
- CRUD operations for Tasks
- CRUD operations for Comments
- Relationship between Tasks and Comments
- Asynchronous email notifications for new comments
- API authentication using Laravel Sanctum
- Unit & Feature tests
- Queue system for background jobs
- Docker support (optional)

## Prerequisites

- PHP 8.2+
- Composer 2.0+
- MySQL 8.0+ / MariaDB / PostgreSQL / SQLite
- Mail server/credentials (or Mailtrap for development)

## Installation

1. **Clone repository**
   ```bash
   git clone https://github.com/mina-romany/white-helmet-task.git
   cd task-management-system

2. **Install dependencies**
    ```bash
    composer install

3. **Environment setup**
    ```bash
    cp .env.example .env
    php artisan key:generate

4. **Database configuration**   
    ```bash
    php artisan migrate --seed

5. **Queue worker (for notifications)**  
    ```bash
    php artisan queue:work

6. **Run tests**  
    ```bash
    php artisan test

## API Documentation

**Authentication** 
Colons can be used to align columns.

| Tables        | Are           | Cool  |
| ------------- |:-------------:| -----:|
| col 3 is      | right-aligned | $1600 |
| col 2 is      | centered      |   $12 |
| zebra stripes | are neat      |    $1 |

There must be at least 3 dashes separating each header cell.
The outer pipes (|) are optional, and you don't need to make the 
raw Markdown line up prettily. You can also use inline Markdown.

Markdown | Less | Pretty
--- | --- | ---
*Still* | `renders` | **nicely**
1 | 2 | 3

|    Method	|    Endpoint	    |  Description          |   Auth Required |
|:---------:|: ----------------:|:---------------------:|----------------:|
|    POST   |	/api/register   |	Register new user   |   No            |
|    POST	|   /api/login	    |   Login user          |   No            |
|    POST	|   /api/logout	    |   Logout user         |   Yes           |

**Required Headers**
    ```bash
    Accept: application/json
    Content-Type: application/json

**Tasks**
-----------------------------------------------------------------------
Method  |	Endpoint	        |   Description	     |   Auth Required
-----------------------------------------------------------------------
GET	    |   /api/tasks	        |    List all tasks  |   Yes
POST	|   /api/tasks	        |    Create new task |	 Yes
GET	    |   /api/tasks/{id}	    |    Get single task |	 Yes
PUT	    |   /api/tasks/{id}	    |    Update task	 |   Yes
DELETE	|   /api/tasks/{id}     |	 Delete task	 |   Yes
GET     |   /api/tasks/mytasks  |    Get my tasks    |   Yes


**Comments**
---------------------------------------------------------------------------
Method  |	Endpoint	         |    Description	        | Auth Required
---------------------------------------------------------------------------
GET	    |   /api/comments/{id}	 |   List single comment    |	Yes
POST	|   /api/comments	     |   Create comment	        |   Yes
PUT	    |   /api/comments/{id}	 |   Update comment	        |   Yes
DELETE	|   /api/comments/{id}	 |   Delete comment	        |   Yes

**Testing**
    ```bash
    php artisan serve
