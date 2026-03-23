
# truemind-backend-api
Backend API for Truemind Innovations e-learning platform. Handles user authentication, courses, assignments, progress tracking, and notifications
=======
# Truemind Backend API

## Overview
This API handles user authentication, courses, assignments, submissions, progress tracking, and notifications for the Truemind platform.

## Quick Reference Table

| Module         | Endpoint              | Method | Body Example / Notes                                                            | Description                         |
| -------------- | -------------------  | ------ | ----------------------------------------------------------------------------- | ----------------------------------- |
| Authentication | `/register`          | POST   | `{ "name": "...", "email": "...", "password": "...", "password_confirmation": "..." }` | Register a new user                 |
| Authentication | `/login`             | POST   | `{ "email": "...", "password": "..." }`                                       | Login user & get token              |
| Courses        | `/courses`           | GET    | —                                                                             | Get all courses                     |
| Courses        | `/courses`           | POST   | `{ "name": "...", "description": "..." }`                                     | Create a new course                 |
| Courses        | `/courses/{id}`      | PUT    | `{ "name": "...", "description": "..." }`                                     | Update course                       |
| Courses        | `/courses/{id}`      | DELETE | —                                                                             | Delete course                       |
| Assignments    | `/assignments`       | GET    | —                                                                             | Get all assignments                 |
| Assignments    | `/assignments`       | POST   | `{ "title": "...", "instructions": "...", "course_id": 4, "due_date": "YYYY-MM-DD" }` | Create a new assignment             |
| Assignments    | `/assignments/{id}`  | PUT    | `{ "title": "...", "instructions": "..." }`                                   | Update assignment (optional fields) |
| Assignments    | `/assignments/{id}`  | DELETE | —                                                                             | Delete assignment                   |
| Submissions    | `/submissions`       | POST   | `{ "assignment_id": 2, "student_id": 7, "content": "...", "submitted_at": "YYYY-MM-DD HH:MM:SS" }` | Submit assignment                   |
| Submissions    | `/submissions/{id}`  | PUT    | `{ "content": "Updated content" }`                                           | Update submission                   |
| Submissions    | `/submissions/{id}`  | DELETE | —                                                                             | Delete submission                   |
| Progress       | `/progress`          | POST   | `{ "course_id": 4, "student_id": 7, "completion_percentage": 50 }`           | Create or update progress           |
| Progress       | `/progress`          | GET    | —                                                                             | Get all progress records            |
| Notifications  | `/notifications`     | POST   | `{ "user_id": 7, "type": "info", "message": "...", "read": false }`          | Create notification                 |
| Notifications  | `/notifications/{id}`| PUT    | `{ "read": true }`                                                           | Mark notification as read           |
| Notifications  | `/notifications/{id}`| DELETE | —                                                                             | Delete notification                 |
---

## Detailed Documentation

### Authentication

**Register User**
- **Endpoint:** `/register`
- **Method:** POST
- **Body Example:**
```json
{
  "name": "Cynthia",
  "email": "cynthia@test.com",
  "password": "password123",
  "password_confirmation": "password123"
}
Description: Registers a new user and returns an API token.

Login User

Endpoint: /login
Method: POST
Body Example:
{
  "email": "cynthia@test.com",
  "password": "password123"
}
Description: Logs in a user and returns an API token.
Courses

Get All Courses

Endpoint: /courses
Method: GET
Body: —
Description: Retrieves all courses.

Create Course

Endpoint: /courses
Method: POST
Body Example:
{
  "name": "Web Development",
  "description": "Learn HTML, CSS, JS and Laravel"
}
Description: Creates a new course.

Update Course

Endpoint: /courses/{id}
Method: PUT
Body Example:
{
  "name": "Updated Course Name",
  "description": "Updated description"
}
Description: Updates course details (fields optional).

Delete Course

Endpoint: /courses/{id}
Method: DELETE
Body: —
Description: Deletes a course.
Assignments

Get All Assignments

Endpoint: /assignments
Method: GET
Body: —
Description: Retrieves all assignments.

Create Assignment

Endpoint: /assignments
Method: POST
Body Example:
{
  "title": "Build API Endpoints",
  "instructions": "Create CRUD endpoints for courses and assignments",
  "course_id": 4,
  "due_date": "2026-04-01"
}
Description: Creates a new assignment.

Update Assignment

Endpoint: /assignments/{id}
Method: PUT
Body Example:
{
  "title": "Updated Title",
  "instructions": "Updated instructions"
}
Description: Updates an assignment (fields optional).

Delete Assignment

Endpoint: /assignments/{id}
Method: DELETE
Body: —
Description: Deletes an assignment.
Submissions

Submit Assignment

Endpoint: /submissions
Method: POST
Body Example:
{
  "assignment_id": 2,
  "student_id": 7,
  "content": "Here is my submission",
  "submitted_at": "2026-03-23 12:00:00"
}
Description: Submits an assignment.

Update Submission

Endpoint: /submissions/{id}
Method: PUT
Body Example:
{
  "content": "Updated submission content"
}
Description: Updates an existing submission.

Delete Submission

Endpoint: /submissions/{id}
Method: DELETE
Body: —
Description: Deletes a submission.
Progress Tracking

Create or Update Progress

Endpoint: /progress
Method: POST
Body Example:
{
  "course_id": 4,
  "student_id": 7,
  "completion_percentage": 50
}
Description: Tracks student course progress.

Get Progress Records

Endpoint: /progress
Method: GET
Body: —
Description: Retrieves all course progress records.
Notifications

Create Notification

Endpoint: /notifications
Method: POST
Body Example:
{
  "user_id": 7,
  "type": "info",
  "message": "Assignment graded",
  "read": false
}
Description: Creates a notification for a user.

Mark Notification as Read

Endpoint: /notifications/{id}
Method: PUT
Body Example:
{
  "read": true
}
Description: Marks a notification as read.

Delete Notification

Endpoint: /notifications/{id}
Method: DELETE
Body: —
Description: Deletes a notification.
Frontend Integration Notes
Base URL: Share the backend base URL with your frontend team, e.g.,
https://truemind-backend.example.com/api

Authentication:

Frontend should first call /register or /login.
Save the returned API token and attach it to all authenticated requests using headers:
Authorization: Bearer <token>

Calling APIs:

Example using fetch (JavaScript):
fetch('https://truemind-backend.example.com/api/courses', {
  headers: {
    'Authorization': 'Bearer ' + token,
    'Content-Type': 'application/json'
  }
})
.then(res => res.json())
.then(data => console.log(data));
Passing IDs:
Use IDs returned from /courses or /assignments for creating assignments or submissions.
Error Handling:
API returns standard HTTP status codes:
200 → Success
201 → Created
400 → Bad request
401 → Unauthorized
404 → Not found
Frontend should handle these codes to display proper messages.
Testing:
Frontend team can use tools like Postman or Insomnia to test endpoints before integrating them in the UI.
>>>>>>> a88df7b (Initial commit - complete Truemind backend API)
