# Lab 4 – Peer Tutoring Hub Exploration

## Part 1: Successful Form Submission

I opened the Peer Tutoring Hub request form and submitted a valid tutoring request using the following information:

- Course: IS 6465
- Topics: Exam review and Practice problems
- Preferred time: Afternoon
- Preferred date: November 5, 2026
- Request details: I need help understanding PHP arrays and foreach loops.

The application accepted the request and displayed a "Request received" confirmation page. It showed the course, request details, selected topics, and a status of "Pending review."

The confirmation page did not display the preferred date or preferred time.

## Part 2: Shared Templates and CSS

The Peer Tutoring Hub uses three shared PHP template files to keep the application consistent across its pages.

- **header.php:** Contains the opening HTML structure, page title, and links to Bootstrap and the custom CSS stylesheet.
- **nav.php:** Creates the shared navigation bar with links to the home page, tutoring requests, and the request form.
- **footer.php:** Displays the application footer, loads the Bootstrap JavaScript bundle, and closes the HTML document.

Using shared templates makes the application easier to maintain because changes to common elements can be made in one place rather than repeated across multiple pages.

The **styles.css** file controls the application's appearance, including colors, fonts, form layouts, buttons, tables, and spacing. The request form uses CSS Grid to organize its fields into two columns. A media query changes the layout to one column on smaller screens.

The stylesheet also hides a duplicate preferred-time dropdown because the form uses radio buttons for that selection.

Bootstrap provides additional styling and layout features, while the custom CSS gives the application its specific appearance.

## Part 3: Form Controls and PHP Values

The tutoring request form uses the POST method to send information from request-form.php to process-request.php.

The form includes several types of controls:

- Hidden input (form_name): Identifies the form as a tutoring request.
- Dropdown (course): Allows the student to select one course.
- Date input (preferreddate): Collects the preferred tutoring date.
- Textarea (reason): Allows the student to describe what they need help with.
- Checkboxes (topics[]): Allow the student to select multiple tutoring topics.
- Radio buttons (preferredtime): Allow the student to select one preferred time.

PHP retrieves the submitted values using the $_POST array. The null coalescing operator (??) provides a default value when a field is missing. The topics field uses an empty array as its default because multiple checkbox selections are submitted as an array.

The processing file validates the submitted information on the server. It checks the allowed courses and times, request description length, preferred date, selected topics, and form identifier.

If the request is valid, PHP displays a confirmation message. If validation fails, PHP displays the appropriate error messages. The htmlspecialchars() function is used when displaying submitted information to help prevent cross-site scripting.

## Part 4: Validation Tests

I tested the tutoring request form using three different scenarios to verify that the application accepts valid information and rejects invalid submissions.

### Test 1: Valid Request

I submitted a request with the following information:

- Course: IS 6465
- Topics: Exam review and Practice problems
- Preferred time: Afternoon
- Preferred date: November 5, 2026
- Request details: I need help understanding PHP arrays and foreach loops.

**Expected result:** The application accepts the request and displays a confirmation.

**Actual result:** The application displayed "Request received" with the submitted course, request details, selected topics, and a status of "Pending review."

**Result: PASS**

### Test 2: Invalid Request Description

I submitted a request using "PHP" as the request description, which is only three characters.

**Expected result:** The application rejects the request because the description must contain between 10 and 500 characters.

**Actual result:** The application displayed "Request could not be submitted" and the error message "Describe your request using 10 to 500 characters."

**Result: PASS**

### Test 3: Past Preferred Date

I submitted a request with October 1, 2026, as the preferred date.

**Expected result:** The application rejects the request because the preferred date cannot be in the past.

**Actual result:** The application displayed "Request could not be submitted" and the error message "Preferred date cannot be in the past."

**Result: PASS**

### Conclusion

All three tests produced the expected results. The application accepted a valid request and correctly rejected submissions containing an invalid description or a past preferred date. This demonstrates that the server-side validation is functioning correctly for the scenarios tested.

## Part 5: Automated Tests, CRUD Pages, and GET Parameters

### Automated Validation Tests

I opened tests/validation-tests.php in my browser and ran the automated validation tests.

The file contains 10 tests covering three validation functions:

- validatePreferredTime(): Tests valid, missing, and altered preferred-time values.
- validateTopics(): Tests multiple valid topics, missing topics, and an altered topic.
- validateReason(): Tests the minimum length (10 characters), maximum length (500 characters), a description that is too short (9 characters), and one that is too long (501 characters).

All 10 tests displayed PASS.

These tests demonstrate that the validation functions return the expected results for the specific valid and invalid inputs tested.

### CRUD Pages

The Peer Tutoring Hub includes pages that demonstrate the four CRUD operations: Create, Read, Update, and Delete.

- **Create:** request-form.php collects information for a new tutoring request. process-request.php validates the submission and displays a confirmation. However, the request is not saved to a database.
- **Read:** requests.php displays three sample tutoring requests stored in a PHP array. request-details.php displays the details of an individual request.
- **Update:** edit-request.php displays an editing form prepopulated with sample request information. However, the page does not process or save changes.
- **Delete:** delete-request.php displays a confirmation page for canceling a tutoring request. However, it does not actually delete a record.

The application demonstrates the structure and interfaces of CRUD operations, but it does not implement persistent data storage.

### GET Parameters

The application uses GET parameters to identify individual tutoring requests.

For example, clicking View for request 12 opens:

request-details.php?request_id=12

The request-details.php file retrieves the request ID using filter_input(INPUT_GET, 'request_id', FILTER_VALIDATE_INT).

It checks that the ID is a valid positive integer and searches the sample requests array for a matching record.

The details page also includes Edit and Cancel request links that pass the request ID through the URL.

The edit-request.php page currently uses hardcoded sample data instead of reading the GET parameter. The delete-request.php page reads and validates the GET parameter, but its hidden form field always contains request ID 12.

These examples demonstrate how GET parameters allow PHP pages to identify records, while also showing the limitations of the starter application's unfinished Update and Delete functionality.
