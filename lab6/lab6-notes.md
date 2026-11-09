# Lab 6: PHP, PDO, and SQLite Integration

**Course:** IS 6465 – Web Based Applications

## Part 1: Database Setup

I created the SQLite database using the following command from the `lab6` directory:

```bash
sqlite3 database/tutoring.db < database/setup-database.sql
```

I then opened the database using `sqlite3 database/tutoring.db` and executed the `.tables` command to verify that the database was created correctly.

The output confirmed that both required tables exist:

```text
students     tutoring_requests
```

**Result:** PASS – The SQLite database was successfully created, and both required tables were verified.

## Part 2: Run the Application

I started the PHP development server from the `lab6` directory using:

```bash
php -S 0.0.0.0:8000
```

I opened the application in my browser at:

https://potential-broccoli-74g6gj4g7p52rq6r-8000.app.github.dev/php/request-form.php

I submitted a tutoring request using fictional student information for Alex Johnson, selecting IS 6465, Exam review and Practice problems, November 16, 2026, and Afternoon.

The application successfully saved the submission and redirected to the request details page. The confirmation displayed Request #2 with the correct student information, course, topics, preferred date and time, and a status of Open.

**Result:** PASS – The application successfully processed, saved, and displayed the tutoring request.

### Request Confirmation Screenshot

![Request #2 confirmation](request-confirmation.png)

## Part 3: Browser Test Results

| Test | What I Did | Expected Result | Actual Result | Pass or Fail |
|---|---|---|---|---|
| 1. Valid submission | Submitted a tutoring request for Alex Johnson in IS 6465. | A new Open request is created and its details are displayed. | Request #2 was created with the correct student, course, topics, date, time, and Open status. | Pass |
| 2. View all requests | Opened the All Requests page. | All stored tutoring requests appear. | Both Request #1 (Maria Lopez) and Request #2 (Alex Johnson) appeared. | Pass |
| 3. Filter requests | Filtered by IS 6465 and Open, then by IS 6495 and Open before editing Request #2. | Matching records appear; unmatched filters show no results. | Both IS 6465 requests appeared for the first filter. The second filter displayed "No matching requests." | Pass |
| 4. Edit an Open request | Edited Request #2, changing its course to IS 6495, description, and selected topics. | The existing request is updated without changing its ID. | Request #2 displayed the updated information, retained its ID, and remained Open. | Pass |
| 5. Cancel an Open request | Cancelled Request #2 using the cancellation workflow. | Status changes to Cancelled while the record is retained. | Request #2 remained accessible with its information intact and status Cancelled. | Pass |
| 6. Modify a cancelled request | Attempted to access the edit and cancellation pages for Request #2 directly using their URLs. | Editing and repeated cancellation are blocked. | The edit page displayed "Only Open requests may be edited." The cancellation page displayed "Only Open requests can be cancelled" and offered only a Keep request link. | Pass |


## Part 4: Application Workflow

### Workflow Questions

**1. Which file displays the tutoring request form?**

`php/request-form.php` displays the form where students enter their name, email, course, tutoring needs, preferred date, topics, and preferred time.

**2. Which file receives the submitted form data?**

`php/process-request.php` receives the form data through an HTTP POST request. It checks the request method and form identifier before passing the information to the service layer.

**3. Which file creates the PDO database connection?**

`config/db.php` creates the PDO connection to `database/tutoring.db`. It also configures error handling, associative-array results, and SQLite foreign-key enforcement.

**4. Which file coordinates validation and database transactions?**

`services/requestService.php` validates submitted information and coordinates student lookup and request creation. It uses a database transaction so related operations can be committed together or rolled back if an error occurs.

**5. Which files contain the repository SQL statements?**

`repositories/studentPDO.php` contains SQL for finding and inserting students. `repositories/requestPDO.php` contains SQL for creating, retrieving, filtering, updating, and cancelling tutoring requests.

**6. What information is stored in the students table?**

The `students` table stores each student's unique ID, name, and email address. The email field has a UNIQUE constraint to prevent duplicate email addresses.

**7. What information is stored in the tutoring_requests table?**

The `tutoring_requests` table stores each request's ID, associated student ID, course, topic information, preferred date and time, status, and creation timestamp.

**8. How is a tutoring request connected to a student?**

The `student_id` column in `tutoring_requests` is a foreign key referencing `students.student_id`. This creates a one-to-many relationship, allowing one student to submit multiple tutoring requests.

### Why SQL Belongs in the Repository Layer

Keeping SQL statements in the repository files separates database operations from the form pages and application logic. The PHP pages handle user interactions, while the service layer manages validation and the submission workflow. The repositories handle database queries using PDO and prepared statements. This organization makes the application easier to maintain, troubleshoot, and update without spreading SQL throughout multiple PHP files.

## Part 5: Integration Tests

I ran the provided integration test script from the `lab6` directory using:

```bash
php tests/integration-tests.php
```

The initial run passed 11 of 14 checks, with three failures caused by the sample records loaded from `setup-database.sql`. The tests expected empty tables, but the setup script inserted an existing student and tutoring request.

To resolve this, I added two statements to `tests/integration-tests.php` after the database setup and before the test cases:

```php
$pdo->exec('DELETE FROM tutoring_requests');
$pdo->exec('DELETE FROM students');
```

These statements clear the sample records from the temporary in-memory test database without affecting the application's actual SQLite database.

After rerunning the tests, all 14 checks passed. The tests verified request creation, duplicate-student handling, filtering, validation, editing, cancellation, foreign-key enforcement, and database integrity.

**Final Result: PASS — All integration checks passed (14/14).**

## Part 6: AI Skills Pack

### Activity 1: Application Builder

**Prompt:**

Explain how a tutoring request moves from php/request-form.php through PHP, PDO, and SQLite in this project. Identify the responsibility of each file.

**AI Response (Summary):**

The AI explained that `php/request-form.php` collects student information and submits it to `php/process-request.php` using POST. The handler calls `openDatabase()` from `config/db.php` to establish a PDO connection and passes the submitted data to `submitRequest()` in `services/requestService.php`.

The service validates the information and coordinates a database transaction. It uses `repositories/studentPDO.php` to find or create the student and `repositories/requestPDO.php` to insert the tutoring request. The data is stored in `database/tutoring.db`, using the tables defined in `database/setup-database.sql`. After a successful submission, the application redirects to the new request's details page.

**Evaluation Against the Actual Code:**

I verified the AI's statement that the service layer manages the database transaction and coordinates student lookup and request creation. In `services/requestService.php`, the `submitRequest()` function calls `beginTransaction()`, `insertStudentIfAbsent()`, `findStudentByEmail()`, `insertTutoringRequest()`, and `commit()`. This confirms that the AI accurately described the service layer's responsibilities. The explanation also helped me understand why the application separates the form, service, and repository layers.

### Activity 2: Traceability Auditor

**Prompt:**

Act as a Traceability Auditor for my IS 6465 Peer Tutoring Hub Lab 6 application. Create a traceability table showing how the requirements for creating, listing/filtering, editing, and cancelling tutoring requests are implemented. Use these columns: Requirement | Application Page | Service or Validation | Repository or SQL | Database Table | Test Evidence. Base your analysis on the PHP, PDO, SQLite, and integration test files we previously reviewed. Identify any gaps or limitations rather than assuming functionality exists.

**AI Response (Summary):**

The AI traced the four primary requirements through the application layers and identified supporting integration tests.

| Requirement | Application Page | Service or Validation | Repository or SQL | Database Table | Test Evidence |
|---|---|---|---|---|---|
| Create request | `request-form.php`, `process-request.php` | `submitRequest()`, `validateSubmission()` | `insertStudentIfAbsent()`, `insertTutoringRequest()` | `students`, `tutoring_requests` | UC01 create and Open; duplicate email |
| List/filter requests | Request listing page | Filter parameters | `listRequests()` | `students`, `tutoring_requests` | UC02 course and status filter; empty filter result |
| Edit request | Request editing page | `reviseRequest()` | `updateOpenRequest()` | `tutoring_requests` | Edit Open request; updated reason persisted |
| Cancel request | Request cancellation action | Open-status restriction | `cancelOpenRequest()` | `tutoring_requests` | Cancel Open request; cancelled row retained; second cancellation rejected |

The AI identified limitations in the available evidence, including unconfirmed filenames for some application pages and incomplete coverage of invalid input scenarios.

**Evaluation Against the Actual Code:**

I verified the AI's explanation of request cancellation against `repositories/requestPDO.php`. The `cancelOpenRequest()` function uses a status-restricted update so only Open requests can be cancelled. The integration tests also confirmed that a cancelled record remains in the database and cannot be cancelled a second time.

I agree with the AI's observation that passing all 14 integration tests does not guarantee every possible input has been tested. The traceability table helped me connect each application requirement to the code responsible for implementing it and the tests that verify its behavior.

### Activity 3: Test Harness Generator

**Prompt:**

Act as a Test Harness Generator for my IS 6465 Peer Tutoring Hub Lab 6 application. Review the 14 passing integration tests in tests/integration-tests.php that we previously examined. Identify one meaningful behavior that the existing tests do not explicitly cover. Propose an additional PHP integration test using the application's existing PDO and SQLite functions. Explain what the test checks, why it matters, and what result should be expected. Do not assume the new test passes without executing it.

**AI Response (Summary):**

The AI identified that the existing integration tests verified that cancelled requests could not be cancelled again, but did not explicitly verify that cancelled requests could not be edited. It recommended adding a test that attempts to edit a cancelled request using the existing `reviseRequest()` function.

The AI proposed the following PHP test:

```php
$editCancelled = $sample;
$editCancelled['reason'] = 'Attempt to edit a cancelled request.';

check(
    !reviseRequest($pdo, $id, $editCancelled),
    'Cancelled request cannot be edited'
);
```

**Implementation and Test Results:**

I added the proposed test to `tests/integration-tests.php` immediately after the existing cancellation checks. I then ran the integration test suite using `php tests/integration-tests.php`.

The new test returned:

```text
PASS Cancelled request cannot be edited
All integration checks passed
```

The complete test suite now passes all 15 integration checks.

**Evaluation Against the Actual Code:**

The AI correctly identified a missing test scenario. The new test uses the existing `reviseRequest()` service function and verifies that an edit attempt on a cancelled request is rejected. This is consistent with the Open-status restriction in `updateOpenRequest()` within `repositories/requestPDO.php`.

I verified the AI's recommendation by adding and executing the test rather than assuming it would pass. Although the test confirms that the edit operation is rejected, an additional check of the stored record would provide stronger evidence that its contents remain unchanged.

### AI Skills Pack Reflection

Using AI during this lab helped me better understand how the different parts of the application work together. The Application Builder explained how information moves from the PHP form through the service and repository layers into SQLite, while the Traceability Auditor helped connect application requirements to the code and tests that support them. The Test Harness Generator was especially useful because it identified a missing test scenario that I was able to implement and verify, increasing the number of passing integration tests from 14 to 15. I also learned that AI-generated explanations and code should be checked against the actual application rather than assumed to be correct. Overall, these activities showed me how AI can help with understanding, testing, and improving an application while still requiring my own verification.

## Part 7: SQL JOIN Query

I executed a SQL JOIN query against the application's SQLite database using the following command:

```bash
sqlite3 -header -column database/tutoring.db "SELECT r.request_id, s.student_name, s.student_email, r.course, r.topic, r.preferred_date, r.preferred_time, r.status FROM tutoring_requests AS r JOIN students AS s ON r.student_id = s.student_id ORDER BY r.request_id;"
```

**Query Results:**

| Request ID | Student Name | Email | Course | Preferred Date | Preferred Time | Status |
|---|---|---|---|---|---|---|
| 1 | Maria Lopez | maria.lopez@example.com | IS 6465 | 2026-11-03 | 14:00 | Open |
| 2 | Alex Johnson | alex.johnson@example.com | IS 6495 | 2026-11-16 | Afternoon | Cancelled |

The query also returned the `topic` field. Maria's record contained a plain-text tutoring topic, while Alex's record contained JSON with his tutoring reason and selected topics.

**Explanation:**

The JOIN connects the `tutoring_requests` and `students` tables by matching `tutoring_requests.student_id` with `students.student_id`. This allows the query to display each student's name and email alongside the corresponding tutoring request information without duplicating student details in the requests table.

The results confirmed that both requests were stored correctly and that Alex Johnson's cancelled request remained in the database with a status of `Cancelled`.

**Result: PASS — The SQL JOIN successfully retrieved the related student and tutoring request records.**
