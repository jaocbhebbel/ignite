

-- not in use anymore


DELIMITER $$

CREATE TRIGGER before_insert_exams
BEFORE INSERT ON exams
FOR EACH ROW
BEGIN
  -- declaring variables to use
  DECLARE course_major CHAR(4);
  DECLARE course_number INT;
  DECLARE semester VARCHAR(6);
  DECLARE school_year INT;
  DECLARE exam_number INT;

  -- assigns course_major and course_number from the courses table where IDs match
  SELECT major, course_number INTO course_major, course_number
  FROM courses
  WHERE id = NEW.id_courses;

  -- assigns semester, school_year, and exam_number from the dates table where IDs match
  SELECT semester, school_year, exam_number INTO semester, school_year, exam_number
  FROM dates
  WHERE id = NEW.id_dates;

  -- concats the new exam name
  SET NEW.exam_name = CONCAT(course_major, course_number, '-', semester, '-', school_year, '-', exam_number);
END$$

DELIMITER ;