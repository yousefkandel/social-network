# Social Network Platform – Laravel

## Project Overview
This is a social networking platform built with Laravel 12. The project implements a full-featured system allowing users to register, login, create profiles, manage posts, comments, likes, and friendships. The platform also provides a RESTful API secured with Laravel Sanctum, with real-time notifications for friend requests, comments, and likes using Pusher.

## Features Implemented
- **User Authentication**: Registration, login, logout, password reset using Laravel built-in auth. API authentication with Sanctum providing access tokens.  
- **User Profiles**: Each user has a profile containing name, email, profile picture, and bio. Users can edit profiles and update profile pictures.  
- **Posts**: Users can create, edit, and delete posts with optional image uploads. Posts are linked to comments and likes, showing author info, content, creation date, likes, and comments count.  
- **Comments & Likes**: Users can comment on posts, like/unlike posts, and view all likes. Comments and likes are linked to posts and users properly.  
- **Friend System**: Users can send, accept, or decline friend requests. Users can view friends list and pending requests, and delete friends if necessary.  
- **Search Functionality**: Users can search for other users by name or email.  
- **API Endpoints**: RESTful API implemented for posts, comments, likes, friends, and user authentication. Endpoints tested on Postman with proper request/response formats.  
- **Frontend**: Blade templates used to build a user-friendly interface for profiles, posts, comments, likes, friends, and search features. All routes configured for web access.  
- **Real-Time Notifications**: Implemented real-time notifications for friend requests, comments, and likes using Laravel Echo and Pusher.  
- **OOP & SOLID**: Project architecture follows OOP principles and SOLID design, with **Services**, **Repositories**, and **Interfaces** handling business logic and database interactions.  
- **Database & Seeders**: Laravel migrations and seeders used to set up database structure with tables for users, posts, comments, likes, friend requests, and more. Faker used for generating dummy data.  
- **API Testing**: All API endpoints tested using Postman, ensuring authentication and correct JSON response formats with proper HTTP status codes.  

## Installation
1. Clone the repository:
```bash
git clone https://github.com/username/repository-name.git
cd repository-name
Install dependencies:

bash
Copy code
composer install
npm install
npm run build
Configure environment:

bash
Copy code
cp .env.example .env
php artisan key:generate
Configure database in .env and run migrations & seeders:

bash
Copy code
php artisan migrate --seed
Clear caches:

bash
Copy code
php artisan config:clear
php artisan route:clear
php artisan cache:clear
Serve the application:

bash
Copy code
php artisan serve
API Endpoints
POST /api/register – Register a new user

POST /api/login – Login user and get token

POST /api/logout – Logout current token

GET /api/posts – List all posts

POST /api/posts – Create a new post

PUT /api/posts/{id} – Update a post

DELETE /api/posts/{id} – Delete a post

GET /api/comments?post_id={id} – List comments of a post

POST /api/posts/{post}/comments – Create a comment

DELETE /api/comments/{id} – Delete a comment

GET /api/posts/{post}/like – Toggle like/unlike

POST /api/friends/send/{user} – Send friend request

POST /api/friends/respond/{friendRequest}/{status} – Accept/decline friend request

GET /api/friends/pending – List pending requests

GET /api/friends – List accepted friends

Database Structure
users: id, name, email, password, profile_picture, bio

posts: id, user_id, content, image, created_at

comments: id, user_id, post_id, content, created_at

likes: id, user_id, post_id

friend_requests: id, sender_id, receiver_id, status (pending/accepted/declined)

Technologies Used
Laravel 12, PHP 8.2

MySQL

Blade Templates for frontend

Laravel Sanctum for API authentication

Pusher & Laravel Echo for real-time notifications

Composer & NPM for dependency management

Notes
.env file is excluded from GitHub.

vendor and node_modules are excluded via .gitignore.

Images uploaded via posts and profiles stored in storage/app/public.

Follow SOLID architecture: Controllers handle request logic, Services handle business logic, Repositories handle DB interactions, Interfaces define contracts.

API endpoints are fully tested in Postman with proper status codes and response formats.

Seeders and Faker are used to populate dummy data for testing.

Frontend and backend routes fully configured for web and API access.

Real-time notifications are fully functional for friends, comments, and likes.
