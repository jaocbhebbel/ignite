# Design Document for Backend Network & Database Architecture

## Purpose of the Backend for our website

The backend of our website will handle requests between a client and the database for various operations. Specifically, the backend should support HTTP requests like GET, POST, and DELETE. The backend will listen for these requests, and then initiate a command on the database to fulfill the client's request. Finally, the backend will respond with the resulting status of the operation

### Summary:
- support HTTP GET / POST / DELETE operations
- connect to / execute SQL commands on DB
- implement proper error handling so nothing breaks if something goes wrong



## Backend Design

Start with connecting the various files from the actors lab. Understand *why* they are necessacery for the program to function, then draw out how they communicate with each other. 

Now, rethink this system in the context of our project. What are the significant features? What is extraneous to our project?

Supported HTTP requests and their respective purpose:
- GET: for sending data for the frontend to display
- POST: when someone uploads a file
- DELETE: ?? probably not necessacery


## networks:

### client-server connection

When GETting our webpage:
- Client connects to server via http protocol when accessing the URL
- Client page has info from db, like which exams are available in which category.
- So during the client-server connection, the server must index the database for which exams are available.
- This involves doing this SQL query: `SELECT * FROM exams;`, then returning a formatted JSON

- if client clicks on an exam, they should be served a downloadable copy of the pdf with an edited name
- This means sending the file to the client. When they click on the page it loads a new one, with the pdf preview
- To make this happen, I need to send the PDF data to the client's computer. **how ?????**
- get the pdf's location inside the computer using the database to build the file's name
- run the SQL query `SELECT * FROM exams WHERE major='ITWS' AND course=1100 AND number=1;` to collect relevant file names
- retrieve the files and then **send them??** to the client

When uploading a PDF (POST to server):
- Client connects to server via http protocol when accessing the URL
- Client uploads a pdf to front end. Upon submitting, it sends the file in the POST request **as a blob??**
- Listen for the post request on the backend with `$_POST` variable
- take the file and the submitted info and name the file with the proper convention
- logically, the file should be reviewed for malicious content. Let's put it in a separate place for in-review exams
- update the tables `a few sql commands`
- respond to post request with confirmation, letting the client know the upload was successful

TODO: a way to delete files from the db?


## Database Design

We can identify exams in a few ways:
- By Major
- By Course #
- By CRN
- By Semester
- By Exam # 

### Important tables:
- Exams: has a column for exam id, and the associated file. **FIGURE OUT HOW TO STORE PDFS IN TABLE**
- Majors: a 4-letter major listing and an associated ID
- Courses: a 
- Relations: connects an exam id to a course, major, or at least a CRN. 
- In Review: an Exams table for material in-review

### overly complicated implementation
We could make a unique identifier for an exam using this info, maybe as a hash?
Have tables for each of the components of the hash, then use them to id an exam

### not a terrible implementation
have tables for each of these identifiers, with an id column and its value (id, CSCI)/(id, 4970)/(id, 332054)/(id, Fall)/(id, 2)
have an exams table with the exam's link and its id, with the id relating 

### PDF storage:
Option 1: store pdfs as files inside the azure server in a private directory, and in the DB store the PDF's relative link

Option 2: store pdfs as *BLOB* data inside the DB.

### Option 1
- I know how to do this
- will need to talk to plotka about *where* to store private, do-not-send-to-client files on azure instance
- involves making a lot of folders to separate exams based on table categories 

**folders are a construct to let humans understand data better**
maybe just store the table info in the name of the file, use delimiters for easy parsing, then send a renamed version to client???

### Option 2
- I need to figure out how to store/parse PDF data
- Larger DB load; what does this mean for lookup times?
- relatively simple solution (mostly because I don't know how the implementation looks *at this moment*)


