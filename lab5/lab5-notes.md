# Lab 5: Build and Query the Peer Tutoring Hub Database

## Part 1: Create the Database Tables

### Table Names

Command used: `sqlite3 tutoring.db ".tables"`

Output:

```text
students     tutoring_requests
```

### Table Schema

Command used: `sqlite3 tutoring.db ".schema"`

Output:

```sql
CREATE TABLE students (
    student_id INTEGER PRIMARY KEY,
    student_name TEXT NOT NULL,
    student_email TEXT NOT NULL UNIQUE
);

CREATE TABLE tutoring_requests (
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
```

### Part 1 Questions

**1. Which column is the primary key in each table?**

The primary key in the students table is student_id, and the primary key in the tutoring_requests table is request_id. Each primary key uniquely identifies a record in its table.

**2. Which column is the foreign key, and what relationship does it represent?**

The student_id column in the tutoring_requests table is the foreign key. It connects each tutoring request to the student who submitted it. This creates a one-to-many relationship because one student can submit multiple tutoring requests.

**3. Why is student_email marked UNIQUE?**

The student_email column is marked UNIQUE to prevent multiple student records from using the same email address. This helps avoid duplicate student accounts and keeps the database organized.
```


## Part 2: Insert Students and Tutoring Requests

### INSERT Statements

The following SQL statements were used to add two students and three tutoring requests.

```sql
INSERT INTO students (student_id, student_name, student_email)
VALUES (1, 'Jordan Lee', 'jordan.lee@example.edu');

INSERT INTO students (student_id, student_name, student_email)
VALUES (2, 'Avery Patel', 'avery.patel@example.edu');

INSERT INTO tutoring_requests
    (request_id, student_id, course, topic, preferred_date, preferred_time)
VALUES
    (1, 1, 'IS 6465', 'Forms', '2026-11-16', '14:00');

INSERT INTO tutoring_requests
    (request_id, student_id, course, topic, preferred_date, preferred_time)
VALUES
    (2, 1, 'IS 6465', 'SQL SELECT', '2026-11-18', '15:00');

INSERT INTO tutoring_requests
    (request_id, student_id, course, topic, preferred_date, preferred_time)
VALUES
    (3, 2, 'IS 6465', 'SQLite CRUD', '2026-11-20', '13:00');
```

### Student Records

Query used:

```sql
SELECT * FROM students;
```

Output:

```text
student_id  student_name  student_email
----------  ------------  -----------------------
1           Jordan Lee    jordan.lee@example.edu
2           Avery Patel   avery.patel@example.edu
```

### Tutoring Request Records

Query used:

```sql
SELECT * FROM tutoring_requests;
```

Output:

```text
request_id  student_id  course   topic        preferred_date  preferred_time  status  created_at
----------  ----------  -------  -----------  --------------  --------------  ------  -------------------
1           1           IS 6465  Forms        2026-11-16      14:00           Open    2026-11-06 22:29:00
2           1           IS 6465  SQL SELECT   2026-11-18      15:00           Open    2026-11-06 22:29:00
3           2           IS 6465  SQLite CRUD  2026-11-20      13:00           Open    2026-11-06 22:29:00
```

### Part 2 Question

**Why does Jordan have one student row but two request rows?**

Jordan has one row in the students table because each student only needs one record to store their personal information. However, Jordan submitted two different tutoring requests, so there are two rows in the tutoring_requests table. Both requests use student_id = 1 to connect them to Jordan's student record. This is an example of a one-to-many relationship.


## Part 3: Read the Stored Data

### Query 1: Display All Students

```sql
SELECT * FROM students;
```

This query retrieves all student records.

### Query 2: Display All Tutoring Requests

```sql
SELECT * FROM tutoring_requests;
```

This query retrieves all tutoring requests.

### Query 3: Display Open Requests

```sql
SELECT * FROM tutoring_requests
WHERE status = 'Open';
```

This query retrieves only requests with an Open status. All three requests currently have an Open status.

### Query 4: Display One Request by ID

```sql
SELECT * FROM tutoring_requests
WHERE request_id = 1;
```

This query retrieves Jordan Lee's first tutoring request using its unique request ID.

### Query 5: JOIN Student and Request Information

```sql
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
```

Output:

```text
request_id  student_name  student_email            course   topic        preferred_date  preferred_time  status
----------  ------------  -----------------------  -------  -----------  --------------  --------------  ------
1           Jordan Lee    jordan.lee@example.edu   IS 6465  Forms        2026-11-16      14:00           Open
2           Jordan Lee    jordan.lee@example.edu   IS 6465  SQL SELECT   2026-11-18      15:00           Open
3           Avery Patel   avery.patel@example.edu  IS 6465  SQLite CRUD  2026-11-20      13:00           Open
```

### Part 3 Questions

**1. What does the JOIN condition connect?**

The JOIN condition connects the student_id column in the tutoring_requests table to the student_id column in the students table. This allows the database to match each tutoring request with the student who submitted it.

**2. What is the difference between the purpose of JOIN and WHERE?**

JOIN combines related information from multiple tables based on a matching column. WHERE filters the results to include only records that meet a specific condition. For example, JOIN can connect a tutoring request to a student's name, while WHERE can retrieve only requests with an Open status.

**3. Why should the application retrieve one request by request_id instead of by topic alone?**

The application should use request_id because it uniquely identifies each tutoring request. Multiple students could request tutoring on the same topic, so searching by topic alone could return multiple records or the wrong request.
```

## Part 4: Update One Request

### UPDATE Statement 1: Revise Jordan's Request

The following statement updates the topic of Jordan Lee's first tutoring request.

```sql
UPDATE tutoring_requests
SET topic = 'HTML Forms and Validation'
WHERE request_id = 1;
```

### Before the Update

```text
request_id  student_id  topic  preferred_date  preferred_time  status
----------  ----------  -----  --------------  --------------  ------
1           1           Forms  2026-11-16      14:00           Open
```

### After the Update

```text
request_id  student_id  topic                      preferred_date  preferred_time  status
----------  ----------  -------------------------  --------------  --------------  ------
1           1           HTML Forms and Validation  2026-11-16      14:00           Open
```

The topic was changed successfully without modifying the other fields.

### UPDATE Statement 2: Cancel Avery's Request

The following statement changes Avery Patel's tutoring request status to Cancelled.

```sql
UPDATE tutoring_requests
SET status = 'Cancelled'
WHERE request_id = 3;
```

### Request Statuses After Both Updates

```text
request_id  student_id  topic                      status
----------  ----------  -------------------------  ---------
1           1           HTML Forms and Validation  Open
2           1           SQL SELECT                 Open
3           2           SQLite CRUD                Cancelled
```

### Part 4 Questions

**1. Why is a specific WHERE clause essential in an UPDATE statement?**

A specific WHERE clause ensures that only the intended record is updated. Without a WHERE clause, the UPDATE statement could change every row in the table, which could accidentally modify other students' tutoring requests.

**2. Why does the Peer Tutoring Hub use a Cancelled status instead of immediately deleting a real request?**

Using a Cancelled status allows the application to preserve the original request and maintain a history of tutoring activity. This information can be useful for recordkeeping, reporting, and tracking cancellations. Deleting the request would permanently remove that information from the database.
```


## Part 5: Delete One Test Request

### INSERT Statement for Test Request

The following SQL statement was used to create a temporary tutoring request for deletion practice.

```sql
INSERT INTO tutoring_requests
    (request_id, student_id, course, topic, preferred_date, preferred_time)
VALUES
    (4, 1, 'IS 6465', 'Delete Practice', '2026-11-23', '10:00');
```

### DELETE Statement

The following SQL statement deletes only the temporary test request.

```sql
DELETE FROM tutoring_requests
WHERE request_id = 4;
```

### Verification After Deletion

The following query was used to verify that the test request was removed.

```sql
SELECT request_id, student_id, topic, status
FROM tutoring_requests
ORDER BY request_id;
```

Output:

```text
request_id  student_id  topic                      status
----------  ----------  -------------------------  ---------
1           1           HTML Forms and Validation  Open
2           1           SQL SELECT                 Open
3           2           SQLite CRUD                Cancelled
```

The results confirm that request_id = 4 was successfully deleted while the three original tutoring requests remained in the database.

### Part 5 Question

**Why is a WHERE clause essential in a DELETE statement?**

A WHERE clause identifies which specific records should be deleted. Without a WHERE clause, the DELETE statement would remove every row from the table. Using WHERE request_id = 4 ensures that only the temporary test request is removed and the other tutoring requests remain intact.
```


## Part 6: Reflect on the CRUD Workflow

### CRUD Summary

| CRUD Action | SQL Statement Used | Peer Tutoring Hub Example |
|-------------|--------------------|--------------------------|
| Create | INSERT | Added Jordan Lee and Avery Patel as students and created their tutoring requests. |
| Read | SELECT | Retrieved tutoring requests and used JOIN to display the students associated with each request. |
| Update | UPDATE | Changed Jordan's request topic and updated Avery's request status to Cancelled. |
| Delete | DELETE | Removed the temporary Delete Practice request without affecting the other records. |

### Part 6 Questions

**1. How does the database preserve the connection between a student and that student's requests?**

The database uses the student_id column to connect the two tables. Each student has a unique student_id in the students table, and each tutoring request includes a student_id that references the student who submitted it. This foreign key relationship allows one student to have multiple tutoring requests without duplicating their personal information.

**2. Which database constraint prevents two student rows from using the same email address?**

The UNIQUE constraint on the student_email column prevents two student records from having the same email address. This helps prevent duplicate student accounts and maintains data integrity.

**3. What could happen if an UPDATE or DELETE statement did not include a WHERE clause?**

Without a WHERE clause, an UPDATE statement could modify every record in a table, while a DELETE statement could remove every record. This could result in accidental changes or loss of important tutoring request information.

**4. When the application later receives values from an HTML form, why should PHP send those values as parameters instead of placing them directly into SQL text?**

PHP should use parameters with prepared SQL statements to prevent SQL injection attacks. Parameters keep user-provided values separate from the SQL commands, preventing someone from entering malicious SQL code through an HTML form. This makes the application more secure and helps handle user input safely.
