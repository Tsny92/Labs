# Lab 7 Notes

## Part 1 — AI-assisted application generation

**Prompt:** Generate code for all user management use cases UM-01 through UM-10 in the User Management Design Document. Use the Application Builder, Test Harness Generator, and Traceability Auditor documents as implementation guidance. Follow the authentication, authorization, session management, password hashing, CSRF protection, and role based access practices in the Authentication Reading Handout. Use lab6.zip as the existing Peer Tutoring Hub application to extend. Preserve the Lab 6 three tier architecture and update the application as needed to support user registration, login, logout, profile management, administrator access, and protected tutoring request workflows. Return a complete Lab 7 application package with all updated and new files.

**Source materials:** Peer Tutoring Hub User Management Design Document; Application Builder, Test Harness Generator and Traceability Auditor (skills pack.zip); IS6465 Authentication Reading Handout v1.2; lab6.zip.

The generated package extends the Lab 6 presentation, application and data tiers with user pages, shared session protection, user services, prepared account queries and a database migration. See README.md for design decisions and traceability. Permanent deletion is blocked because the retention policy is unresolved.


### Verified Code Example — Role-Based Access Control

I reviewed `includes/auth.php` and `php/request-form.php` to verify how the generated application implements authentication and authorization.

The `requireRole()` function in `includes/auth.php` checks whether the authenticated user's role is included in the permitted roles. If the role is not authorized, the function returns an HTTP 403 response and stops execution.

I verified that `request-form.php` calls the following functions before displaying any HTML:

```php
$user = requireLogin($pdo);
requireRole($user, ['Student']);
```

This ensures that only authenticated users with the Student role can access the tutoring request form. These checks are performed on the server rather than relying on hidden navigation links or client-side restrictions. This demonstrates the difference between authentication, which verifies a user's identity, and authorization, which determines what the user is permitted to access.

Verification method: Manual inspection of both generated PHP files in GitHub. Runtime testing will be conducted in later parts of the lab.

## Parts 2–10

Complete with actual commands, observations, screenshots and test outputs as each part is performed. No student execution evidence recorded yet.
