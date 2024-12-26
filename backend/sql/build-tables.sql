
/*
  Naming convention for primary/foreign ids:
    primary is always just id
    foreign is id_tableName

*/


CREATE TABLE exams (
    id INT NOT NULL AUTO_INCREMENT,
    exam_name TINYTEXT,  -- exam_name is the name of the pdf file of this exam id
    id_courses INT,
    id_dates INT,
    PRIMARY KEY(id),
    FOREIGN KEY(id_courses) REFERENCES courses(id),
    FOREIGN KEY(id_dates) REFERENCES dates(id)
);

CREATE TABLE dates (
    id INT NOT NULL AUTO_INCREMENT,
    semester VARCHAR(6),
    school_year INT,
    exam_number INT,
    PRIMARY KEY(id)
);

CREATE TABLE courses (
    id INT NOT NULL AUTO_INCREMENT,
    major CHAR(4),
    course_number INT,
    course_name VARCHAR(50),
    crn INT,
    teacher_name VARCHAR(50),
    PRIMARY KEY(course_id)
);