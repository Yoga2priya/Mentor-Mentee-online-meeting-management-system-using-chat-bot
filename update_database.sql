-- Add new columns to students table
ALTER TABLE students
ADD email VARCHAR(100) UNIQUE NOT NULL,
ADD password VARCHAR(255) NOT NULL,
ADD fathers_name VARCHAR(100),
ADD fathers_number VARCHAR(15),
ADD mothers_name VARCHAR(100),
ADD mothers_number VARCHAR(15),
ADD guardian_name VARCHAR(100),
ADD guardian_number VARCHAR(15);

-- Create academic_records table if not exists
CREATE TABLE IF NOT EXISTS academic_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    tenth_school VARCHAR(100),
    tenth_marks FLOAT,
    tenth_percentage FLOAT,
    eleventh_school VARCHAR(100),
    eleventh_marks FLOAT,
    eleventh_percentage FLOAT,
    twelfth_school VARCHAR(100),
    twelfth_marks FLOAT,
    twelfth_percentage FLOAT,
    diploma_percentage FLOAT,
    ug_college VARCHAR(100),
    ug_degree VARCHAR(100),
    ug_percentage FLOAT,
    FOREIGN KEY (student_id) REFERENCES students(id)
);