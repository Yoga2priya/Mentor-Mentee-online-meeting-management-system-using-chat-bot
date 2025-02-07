CREATE TABLE staff (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    employee_id VARCHAR(50) UNIQUE NOT NULL,
    department VARCHAR(50) NOT NULL,
    designation VARCHAR(100) NOT NULL,
    mobile_no VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE staff_roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    staff_id INT,
    role ENUM('mentor', 'hod', 'principal') NOT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(id)
);

CREATE TABLE attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    subject_code VARCHAR(20),
    date DATE,
    status ENUM('present', 'absent') NOT NULL,
    marked_by INT,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (marked_by) REFERENCES staff(id)
);

CREATE TABLE remarks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    staff_id INT,
    remark TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (staff_id) REFERENCES staff(id)
);

CREATE TABLE placement_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    company_name VARCHAR(100),
    position VARCHAR(100),
    package DECIMAL(10,2),
    offer_date DATE,
    status ENUM('placed', 'not_placed', 'in_process') DEFAULT 'in_process',
    added_by INT,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (added_by) REFERENCES staff(id)
);