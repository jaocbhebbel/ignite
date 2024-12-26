# Backend Folder Structure + Logic

## SQL folder

### build-tables.sql
- holds the code building tables

- table 1 is dates, with the year, semester of the exam, exam number, and an id column
- table 2 is courses, with major, course number, crn, course name, teacher name and an id column
- table 3 is exams, with an exam id, exam file name, and foreign key columns

## PHP folder

holds all the files related to database operations

### get-exams.php
- structured as an API that the frontend calls to get exam info

- SQL statement is prepared to only complete SELECT
- Proper preventative SQL-injectioned measures will be taken

### delete-exams.php
- separate file for delete operation **does this make sense??**

### post-exams.php
- again does this make sense? **can this all be in one file????**
