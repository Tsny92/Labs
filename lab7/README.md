# Lab 7 — Peer Tutoring Hub

Classroom PHP 8 / PDO / SQLite application extending the supplied Lab 6. Requires PDO SQLite; mbstring recommended. Run commands from lab7 root unless noted.

```sh
cd database
sqlite3 tutoring.db < setup-database.sql
sqlite3 tutoring.db < upgrade-to-user-management.sql
sqlite3 tutoring.db '.tables'
php create-admin.php "Test Administrator" admin@example.com "TestPassword123"
cd ..
php -S 0.0.0.0:8000 php/router.php
```

Use the router rather than the bare server command in the assignment to prevent direct downloads of the database and SQL files. Keep the forwarded port private. The migration is a one-time operation; don't rerun it on an upgraded database. Do not commit the generated database or real credentials. The sample administrator password is for isolated classroom use only.

Open `/php/login.php`. Register a Student, sign in, create a request, view/edit/cancel it, edit profile, change password and log out. Sign in as administrator and inspect user management and all requests. Register a Tutor and confirm request routes are denied. Test direct access to other students' requests, protected pages after logout, missing CSRF tokens, inactive accounts, and session expiry after 20 minutes.

## Architecture / decisions
- Presentation: original PHP pages and Bootstrap, new account pages and shared auth guard. All modifying forms use POST and CSRF. Identity comes from session, not form input.
- Application: userService.php validates account fields, hashes passwords and coordinates transactions; requestService.php retains original validation and JSON topic format and adds authenticated submission.
- Data: userPDO.php holds account/linked-student queries; requestPDO.php applies owner IDs on reads. SQLite adds users and a unique nullable students.user_id FK. Existing seed rows remain unlinked, visible only to administrators; no automatic email-based claim of legacy identities. A legacy email collision on student registration is rejected by the existing constraint; resolve manually after verifying ownership.
- Password policy chosen for this exercise: 12–72 bytes, matching confirmation. Public roles Student/Tutor only. Admin can change roles/status but cannot remove the last active administrator. Permanent deletion remains blocked pending approved retention policy (UM-08); related records explicitly checked. Tutors have profile access only. Student rows survive role changes to preserve requests.
- Original Lab 6 service functions remain for regression tests; web controllers exclusively use authenticated submission. Original integration test fixture has seed-count assumptions and is retained unchanged. Tests must run only in private CLI; do not publish this application as production-ready. Rate limiting, verified-email recovery, stronger deployment configuration and concurrent-administrator policy hardening are outside scope.

## Tests
```sh
php tests/validation-tests.php
php tests/user-management-tests.php
php tests/integration-tests.php
```
The new harness uses in-memory SQLite, applies both SQL scripts, and checks services and ownership queries. Browser session/route/CSRF denial tests still required. Original validation harness prints assertions; original integration harness may report three seed-related failures. No tests have been edited to hide failures.

Generation environment: PHP 8.4.24, all 32 PHP files linted successfully, all 10 validation assertions passed; both SQL scripts executed with Python SQLite and produced the three expected tables. PDO SQLite unavailable in generation environment, so PHP database integration and browser tests remain unverified.

## Traceability (implementation, not runtime proof)
| ID | Page / guard | Service / repository | Table | Evidence / gap |
|---|---|---|---|---|
| UM-01 | register.php, CSRF | registerUser / insertUser, createStudentLink | users, students | harness duplicate/role/password/valid registration; unverified |
| UM-02 | profile.php, requireLogin | findUserById | users | harness profile lookup; manual own-session check |
| UM-03 | manage-users.php, requireRole | searchUsers | users | harness search; manual non-admin denial |
| UM-04 | edit-profile.php, CSRF | saveProfile / updateUserProfile | users, students | harness synchronization; manual forged role denial |
| UM-05 | change-password.php, CSRF | changePassword / updateUserPassword | users | harness old/new credentials |
| UM-06 | manage-user.php, admin guard | changeAccess / updateUserAccess | users, students | harness authorization and role link |
| UM-07 | manage-user.php, confirmation | changeAccess / activeAdminCount | users | harness inactive and last admin |
| UM-08 | manage-user.php, confirmation | deleteAccount / relatedRequestCount | users, students, tutoring_requests | policy block implemented; actual deletion intentionally unavailable |
| UM-09 | login.php, CSRF | authenticateUser / findUserByEmail, startLogin | users, session | harness credentials; manual regeneration |
| UM-10 | logout.php, POST/CSRF | logoutSession, requireLogin | session | manual logout and direct route denial |
| UC01/02 | request pages, role guard | submitAuthenticatedRequest / findRequest / listRequests | students, tutoring_requests | harness forged identity and owner scope; original regression suite |
