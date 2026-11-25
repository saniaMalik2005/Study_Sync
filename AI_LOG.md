# AI Log

## Entry 1: Database schema
- **Prompt:** Asked Claude to design tables for StudySync (users, subjects, assignments, study_sessions).
- **AI gave:** SQL schema with foreign keys and indexes.
- **What I changed and why:** I matched the table and column names to my submitted technical document (e.g. password, subject_name, due_date).

## Entry 2: Database connection
- **Prompt:** Asked Claude for a PDO database connection class for XAMPP running MySQL on port 3307.
- **AI gave:** config/database.php with constants and a Database class using a static PDO connection.
- **What I changed and why:** I set the port to 3307 because port 3306 was busy on my PC. I kept PDO exceptions on so errors are caught, and the user only sees a friendly message.

## Entry 3: Signup page
- **Prompt:** Asked Claude for a signup page with a User class, validation, CSRF token, and Bootstrap design.
- **AI gave:** functions.php (session, CSRF, flash helpers), User.php, header/footer, signup.php, and JavaScript validation.
- **What I changed and why:** I tested the form with empty fields, a short password and a duplicate email, and checked in phpMyAdmin that the password is stored as a hash and not as plain text.

## AI-free feature
- Subjects CRUD (I will write this myself without AI)