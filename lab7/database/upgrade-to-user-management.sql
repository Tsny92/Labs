PRAGMA foreign_keys=ON;
BEGIN;
CREATE TABLE IF NOT EXISTS users (user_id INTEGER PRIMARY KEY, full_name TEXT NOT NULL, email TEXT NOT NULL UNIQUE COLLATE NOCASE, password_hash TEXT NOT NULL, role TEXT NOT NULL CHECK(role IN ('Student','Tutor','Administrator')), status TEXT NOT NULL DEFAULT 'Active' CHECK(status IN ('Active','Inactive')), created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);
ALTER TABLE students ADD COLUMN user_id INTEGER REFERENCES users(user_id);
CREATE UNIQUE INDEX students_user_id ON students(user_id);
COMMIT;
