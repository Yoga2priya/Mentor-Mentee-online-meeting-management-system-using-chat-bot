-- Semester Marks Table
CREATE TABLE semester_marks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    semester INT,
    sub_code VARCHAR(20),
    sub_title VARCHAR(100),
    cia_1 FLOAT,
    cia_2 FLOAT,
    model FLOAT,
    internal FLOAT,
    ese_mark FLOAT,
    total FLOAT,
    attempts_1 BOOLEAN DEFAULT FALSE,
    attempts_2 BOOLEAN DEFAULT FALSE,
    passing_month VARCHAR(20),
    passing_year INT,
    percentage FLOAT,
    FOREIGN KEY (student_id) REFERENCES students(id)
);

-- Signatures Table
CREATE TABLE signatures (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mark_id INT,
    mentor_sign BOOLEAN DEFAULT FALSE,
    hod_sign BOOLEAN DEFAULT FALSE,
    principal_sign BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (mark_id) REFERENCES semester_marks(id)
);

-- Drop existing table if it exists
DROP TABLE IF EXISTS students;

-- Create updated students table
CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    reg_no VARCHAR(20) UNIQUE NOT NULL,
    address TEXT,
    gender ENUM('Male', 'Female', 'Other'),
    year INT,
    mobile_no VARCHAR(15),
    department VARCHAR(50),
    dob DATE,
    blood_group VARCHAR(5),
    photo_path VARCHAR(255),
    fathers_name VARCHAR(100),
    fathers_number VARCHAR(15),
    mothers_name VARCHAR(100),
    mothers_number VARCHAR(15),
    guardian_name VARCHAR(100),
    guardian_number VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Academic Records Table
CREATE TABLE academic_records (
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
