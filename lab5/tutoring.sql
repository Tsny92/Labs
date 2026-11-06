-- Part 1: Create the database tables

CREATE TABLE IF NOT EXISTS students (
    student_id INTEGER PRIMARY KEY,
    student_name TEXT NOT NULL,
    student_email TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS tutoring_requests (
    request_id INTEGER PRIMARY KEY,
    student_id INTEGER NOT NULL,
    course TEXT NOT NULL,
    topic TEXT NOT NULL,
    preferred_date TEXT NOT NULL,
    preferred_time TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'Open',
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);


-- Part 2: Insert students and tutoring requests

-- Insert student records
INSERT INTO students (student_id, student_name, student_email)
VALUES (1, 'Jordan Lee', 'jordan.lee@example.edu');

INSERT INTO students (student_id, student_name, student_email)
VALUES (2, 'Avery Patel', 'avery.patel@example.edu');


-- Insert tutoring requests

-- Jordan Lee: First request
INSERT INTO tutoring_requests
    (request_id, student_id, course, topic, preferred_date, preferred_time)
VALUES
    (1, 1, 'IS 6465', 'Forms', '2026-11-16', '14:00');

-- Jordan Lee: Second request
INSERT INTO tutoring_requests
    (request_id, student_id, course, topic, preferred_date, preferred_time)
VALUES
    (2, 1, 'IS 6465', 'SQL SELECT', '2026-11-18', '15:00');

-- Avery Patel: First request
INSERT INTO tutoring_requests
    (request_id, student_id, course, topic, preferred_date, preferred_time)
VALUES
    (3, 2, 'IS 6465', 'SQLite CRUD', '2026-11-20', '13:00');


-- Part 3: Read the stored data

-- Query 1: Display all students
SELECT * FROM students;

-- Query 2: Display all tutoring requests
SELECT * FROM tutoring_requests;

-- Query 3: Display only open requests
SELECT * FROM tutoring_requests
WHERE status = 'Open';

-- Query 4: Display one request by its request ID
SELECT * FROM tutoring_requests
WHERE request_id = 1;


-- Query 5: Display tutoring requests with student information
SELECT
    r.request_id,
    s.student_name,
    s.student_email,
    r.course,
    r.topic,
    r.preferred_date,
    r.preferred_time,
    r.status
FROM tutoring_requests AS r
JOIN students AS s
    ON r.student_id = s.student_id
ORDER BY r.preferred_date;


-- Part 4: Update one request

-- Update Jordan Lee's first tutoring request
UPDATE tutoring_requests
SET topic = 'HTML Forms and Validation'
WHERE request_id = 1;


-- Cancel Avery Patel's tutoring request
UPDATE tutoring_requests
SET status = 'Cancelled'
WHERE request_id = 3;


-- Part 5: Delete one test request

-- Insert a temporary request for DELETE practice
INSERT INTO tutoring_requests
    (request_id, student_id, course, topic, preferred_date, preferred_time)
VALUES
    (4, 1, 'IS 6465', 'Delete Practice', '2026-11-23', '10:00');


-- Delete only the temporary test request
DELETE FROM tutoring_requests
WHERE request_id = 4;

-- Verify the remaining tutoring requests
SELECT request_id, student_id, topic, status
FROM tutoring_requests
ORDER BY request_id;
