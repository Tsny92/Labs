# Lab 7 Notes

## Part 1 — AI-assisted application generation

**Prompt:** Generate code for all user management use cases UM-01 through UM-10 in the User Management Design Document. Use the Application Builder, Test Harness Generator, and Traceability Auditor documents as implementation guidance. Follow the authentication, authorization, session management, password hashing, CSRF protection, and role based access practices in the Authentication Reading Handout. Use lab6.zip as the existing Peer Tutoring Hub application to extend. Preserve the Lab 6 three tier architecture and update the application as needed to support user registration, login, logout, profile management, administrator access, and protected tutoring request workflows. Return a complete Lab 7 application package with all updated and new files.

**Source materials:** Peer Tutoring Hub User Management Design Document; Application Builder, Test Harness Generator and Traceability Auditor (skills pack.zip); IS6465 Authentication Reading Handout v1.2; lab6.zip.

The generated package extends the Lab 6 presentation, application and data tiers with user pages, shared session protection, user services, prepared account queries and a database migration. See README.md for design decisions and traceability. Permanent deletion is blocked because the retention policy is unresolved.

**Code example to inspect and verify:** `includes/auth.php`, `requireRole()` and `php/request-form.php`, which calls it with the Student role before any HTML output. Record your own verification here after inspecting the files.

## Parts 2–10

Complete with actual commands, observations, screenshots and test outputs as each part is performed. No student execution evidence recorded yet.
