# LMS Admin API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication
All protected endpoints require a Sanctum token. Include the token in the Authorization header:
```
Authorization: Bearer {your_token}
```

## Endpoints Overview

### 🔐 Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user (protected)

### 👤 Profile Management
- `GET /api/profile` - Get user profile (protected)
- `PUT /api/profile` - Update user profile (protected)

### 📊 Dashboard
- `GET /api/dashboard` - Get dashboard data (protected)

### 📚 Courses
- `GET /api/courses` - List all courses
- `POST /api/courses` - Create new course
- `GET /api/courses/{id}` - Get course details
- `PUT /api/courses/{id}` - Update course
- `DELETE /api/courses/{id}` - Delete course
- `PATCH /api/courses/{id}/publish` - Publish course
- `PATCH /api/courses/{id}/unpublish` - Unpublish course
- `GET /api/instructor/courses` - Get instructor's courses

### 📂 Categories
- `GET /api/categories` - List all categories
- `POST /api/categories` - Create new category
- `GET /api/categories/{id}` - Get category details
- `PUT /api/categories/{id}` - Update category
- `DELETE /api/categories/{id}` - Delete category

### 🏷️ Tags
- `GET /api/tags` - List all tags
- `POST /api/tags` - Create new tag
- `GET /api/tags/{id}` - Get tag details
- `PUT /api/tags/{id}` - Update tag
- `DELETE /api/tags/{id}` - Delete tag

### 📖 Course Sections
- `GET /api/courses/{course}/sections` - List sections for a course
- `POST /api/courses/{course}/sections` - Create new section
- `GET /api/courses/{course}/sections/{section}` - Get section details
- `PUT /api/courses/{course}/sections/{section}` - Update section
- `DELETE /api/courses/{course}/sections/{section}` - Delete section
- `POST /api/courses/{course}/sections/reorder` - Reorder sections
- `GET /api/courses/{course}/sections/with-lessons` - Get sections with lessons

### 📝 Lessons
- `GET /api/courses/{course}/sections/{section}/lessons` - List lessons for a section
- `POST /api/courses/{course}/sections/{section}/lessons` - Create new lesson
- `GET /api/courses/{course}/sections/{section}/lessons/{lesson}` - Get lesson details
- `PUT /api/courses/{course}/sections/{section}/lessons/{lesson}` - Update lesson
- `DELETE /api/courses/{course}/sections/{section}/lessons/{lesson}` - Delete lesson
- `PATCH /api/courses/{course}/sections/{section}/lessons/{lesson}/publish` - Publish lesson
- `PATCH /api/courses/{course}/sections/{section}/lessons/{lesson}/unpublish` - Unpublish lesson
- `POST /api/courses/{course}/sections/{section}/lessons/reorder` - Reorder lessons

### 📈 Progress Tracking
- `GET /api/lesson-views` - List all lesson views (admin)
- `GET /api/lesson-views/{id}` - Get lesson view details
- `POST /api/lessons/{lesson}/start` - Start a lesson
- `POST /api/lessons/{lesson}/track-progress` - Track lesson progress
- `POST /api/lessons/{lesson}/complete` - Complete a lesson
- `GET /api/lessons/{lesson}/progress` - Get lesson progress
- `GET /api/courses/{course}/progress` - Get course progress
- `GET /api/lessons/{lesson}/progress-view` - Get lesson progress view (admin)
- `GET /api/users/{user}/lesson-progress` - Get user progress (admin)
- `GET /api/courses/{course}/progress-view` - Get course progress view (admin)

### 🧠 Quizzes
- `GET /api/quizzes` - List all quizzes
- `POST /api/quizzes` - Create new quiz
- `GET /api/quizzes/{id}` - Get quiz details
- `PUT /api/quizzes/{id}` - Update quiz
- `DELETE /api/quizzes/{id}` - Delete quiz
- `PATCH /api/quizzes/{id}/toggle-active` - Toggle quiz active status
- `GET /api/lessons/{lesson}/quizzes` - Get quizzes for a lesson

### 📁 Media Management
- `GET /api/media` - List all media files
- `POST /api/media` - Upload new media file
- `GET /api/media/{id}` - Get media file details
- `DELETE /api/media/{id}` - Delete media file
- `POST /api/media/upload` - Upload file via AJAX
- `GET /api/media/get-media` - Get media files for selection
- `POST /api/media/get-by-path` - Get file info by path
- `POST /api/media/bulk-delete` - Bulk delete media files

---

## Detailed Examples

### 🔐 Authentication

#### Register User
```bash
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Login User
```bash
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

Response:
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "1|abc123..."
    }
}
```

### 📚 Course Management

#### Create Course
```bash
POST /api/courses
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "title": "Laravel Masterclass",
    "slug": "laravel-masterclass",
    "description": "Learn Laravel from scratch to advanced",
    "price": 99.99,
    "category_id": 1,
    "tags": [1, 2, 3],
    "thumbnail_path": [file],
    "trailer_path": [file]
}
```

#### Get Courses
```bash
GET /api/courses
Authorization: Bearer {token}
```

Response:
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "Laravel Masterclass",
                "slug": "laravel-masterclass",
                "description": "Learn Laravel from scratch to advanced",
                "price": "99.99",
                "thumbnail_path": "course_thumbnails/1234567890_abc123.jpg",
                "is_published": true,
                "published_at": "2025-08-21T10:00:00.000000Z",
                "categories": [...],
                "tags": [...],
                "creator": {...},
                "sections_count": 5,
                "lessons_count": 25
            }
        ],
        "total": 1
    }
}
```

### 📖 Section Management

#### Create Section
```bash
POST /api/courses/1/sections
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Introduction to Laravel",
    "sort_order": 1
}
```

#### Get Sections with Lessons
```bash
GET /api/courses/1/sections/with-lessons
Authorization: Bearer {token}
```

### 📝 Lesson Management

#### Create Lesson
```bash
POST /api/courses/1/sections/1/lessons
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "What is Laravel?",
    "content": "Laravel is a web application framework...",
    "content_type": "video",
    "duration_minutes": 15,
    "video_provider": "youtube",
    "video_ref": "https://youtube.com/watch?v=abc123"
}
```

### 📈 Progress Tracking

#### Start Lesson
```bash
POST /api/lessons/1/start
Authorization: Bearer {token}
```

#### Track Progress
```bash
POST /api/lessons/1/track-progress
Authorization: Bearer {token}
Content-Type: application/json

{
    "position_seconds": 300,
    "total_seconds": 900
}
```

#### Complete Lesson
```bash
POST /api/lessons/1/complete
Authorization: Bearer {token}
```

### 🧠 Quiz Management

#### Create Quiz
```bash
POST /api/quizzes
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Laravel Basics Quiz",
    "description": "Test your Laravel knowledge",
    "lesson_id": 1,
    "time_limit_minutes": 30,
    "passing_score": 70,
    "max_attempts": 3,
    "is_active": true,
    "settings": {
        "shuffle_questions": true,
        "show_results": true
    }
}
```

### 📁 Media Management

#### Upload Media
```bash
POST /api/media
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "file": [file],
    "disk": "public"
}
```

#### Get Media Files
```bash
GET /api/media?type=image&search=logo
Authorization: Bearer {token}
```

---

## Response Format

All API responses follow this standard format:

### Success Response
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        // Response data here
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error description",
    "errors": {
        "field": ["Error message"]
    }
}
```

### Pagination Response
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [...],
        "first_page_url": "...",
        "from": 1,
        "last_page": 5,
        "last_page_url": "...",
        "next_page_url": "...",
        "path": "...",
        "per_page": 15,
        "prev_page_url": null,
        "to": 15,
        "total": 75
    }
}
```

---

## Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

---

## File Upload

For file uploads, use `multipart/form-data` content type. Supported file types:

- **Images**: jpeg, png, jpg, gif (max 2MB)
- **Videos**: mp4, avi, mov (max 10MB)
- **Documents**: pdf, doc, docx, txt (max 10MB)

---

## Rate Limiting

API endpoints are rate-limited to prevent abuse. Limits are applied per user/IP address.

---

## Testing the API

You can test these endpoints using tools like:
- Postman
- Insomnia
- cURL
- Laravel Tinker

### Example cURL Commands

#### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'
```

#### Get Courses (with token)
```bash
curl -X GET http://localhost:8000/api/courses \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## Notes

1. All timestamps are in ISO 8601 format
2. File URLs are relative to the storage disk
3. Pagination is applied to list endpoints by default
4. Relationships are loaded automatically where needed
5. Validation errors include field-specific messages
6. File uploads are validated for type and size
7. Progress tracking is real-time and persistent
8. Quiz settings are stored as JSON for flexibility
