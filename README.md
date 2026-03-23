Truemind Backend API
Overview

This API handles user authentication, courses, assignments, submissions, progress tracking, and notifications for the Truemind platform.

Base URL

Use your backend server’s base URL for API requests:
http://localhost:8000/api

| Module         | Endpoint                | Method | Body Example / Notes                                                                               | Description                        |
| -------------- | ----------------------- | ------ | -------------------------------------------------------------------------------------------------- | ---------------------------------- |
| Authentication | `/register`             | POST   | `{ "name": "...", "email": "...", "password": "...", "password_confirmation": "..." }`             | Register a new user                |
| Authentication | `/login`                | POST   | `{ "email": "...", "password": "..." }`                                                            | Login user & get token             |
| Courses        | `/courses`              | GET    | —                                                                                                  | Get all courses                    |
| Courses        | `/courses`              | POST   | `{ "name": "...", "description": "..." }`                                                          | Create a new course                |
| Courses        | `/courses/{id}`         | PUT    | `{ "name": "...", "description": "..." }`                                                          | Update course                      |
| Courses        | `/courses/{id}`         | DELETE | —                                                                                                  | Delete course                      |
| Assignments    | `/assignments`          | GET    | —                                                                                                  | Get all assignments                |
| Assignments    | `/assignments`          | POST   | `{ "title": "...", "instructions": "...", "course_id": 4, "due_date": "YYYY-MM-DD" }`              | Create a new assignment            |
| Assignments    | `/assignments/{id}`     | PUT    | `{ "title": "...", "instructions": "..." }`                                                        | Update assignment                  |
| Assignments    | `/assignments/{id}`     | DELETE | —                                                                                                  | Delete assignment                  |
| Submissions    | `/submissions`          | POST   | `{ "assignment_id": 2, "student_id": 7, "content": "...", "submitted_at": "YYYY-MM-DD HH:MM:SS" }` | Submit assignment                  |
| Submissions    | `/submissions/{id}`     | PUT    | `{ "content": "Updated content" }`                                                                 | Update submission                  |
| Submissions    | `/submissions/{id}`     | DELETE | —                                                                                                  | Delete submission                  |
| Progress       | `/progress`             | POST   | `{ "course_id": 4, "student_id": 7, "completion_percentage": 50 }`                                 | Create or update progress          |
| Progress       | `/progress`             | GET    | —                                                                                                  | Get all progress records           |
| Progress       | `/progress/course/{id}` | GET    | —                                                                                                  | Get progress for a specific course |
| Progress       | `/progress/course/{id}` | PUT    | `{ "completion_percentage": 75 }`                                                                  | Update progress for a course       |
| Notifications  | `/notifications`        | POST   | `{ "user_id": 7, "type": "info", "message": "...", "read": false }`                                | Create notification                |
| Notifications  | `/notifications/{id}`   | PUT    | `{ "read": true }`                                                                                 | Mark notification as read          |
| Notifications  | `/notifications/{id}`   | DELETE | —                                                                                                  | Delete notification                |

Detailed Documentation
Authentication

Register User

POST /register
{
"name": "Cynthia",
"email": "cynthia@test.com",
"password": "password123",
"password_confirmation": "password123"
}

Login User

POST /login
{
"email": "cynthia@test.com",
"password": "password123"
}
Courses

Get All Courses

GET /courses

Create Course

POST /courses
{
"title": "Web Development",
"description": "Learn HTML, CSS, JS, and Laravel"
}

Update Course

PUT /courses/{id}
{
"title": "Updated Course Name",
"description": "Updated description"
}

Delete Course

DELETE /courses/{id}
Assignments

Get All Assignments for a Course

GET /courses/{course_id}/assignments

Create Assignment

POST /courses/{course_id}/assignments
{
"title": "Build API Endpoints",
"instructions": "Create CRUD endpoints for courses and assignments",
"due_date": "2026-04-01"
}

Update Assignment

PUT /courses/{course_id}/assignments/{id}
{
"title": "Updated Title",
"instructions": "Updated instructions"
}

Delete Assignment

DELETE /courses/{course_id}/assignments/{id}
Submissions

Submit Assignment

POST /assignments/{assignment_id}/submissions
{
"content": "Here is my submission"
}

Update Submission

PUT /assignments/{assignment_id}/submissions/{id}
{
"content": "Updated submission content"
}

Delete Submission

DELETE /assignments/{assignment_id}/submissions/{id}
Progress

Get All Progress

GET /progress

Get Progress for a Course

GET /progress/course/{course_id}

Update Progress

PUT /progress/course/{course_id}
{
"completion_percentage": 50
}
Notifications

Get All Notifications

GET /notifications

Mark Notification as Read

PUT /notifications/{id}
{
"read": true
}

Delete Notification

DELETE /notifications/{id}

Frontend Integration Notes
Authentication:
Frontend should first call /register or /login.

Save the returned API token and attach it to all authenticated requests:

Authorization: Bearer <token>
Calling APIs Example (JavaScript):
fetch('http://localhost:8000/api/courses', {
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
Testing:
Frontend team can use Postman or Insomnia to test endpoints before integrating them in the UI.
