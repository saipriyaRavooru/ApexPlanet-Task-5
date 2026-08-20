CREATE DATABASE campus_placement;
USE campus_placement;

-- ==========================
-- USERS TABLE
-- ==========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','company','admin') NOT NULL,
    otp VARCHAR(6),
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================
-- STUDENTS TABLE
-- ==========================
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    roll_no VARCHAR(20) UNIQUE,
    department VARCHAR(100),
    year INT,
    cgpa DECIMAL(3,2),
    phone VARCHAR(15),
    gender ENUM('Male','Female','Other'),
    dob DATE,
    skills TEXT,
    resume VARCHAR(255),
    address TEXT,
    profile_photo VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ==========================
-- COMPANIES TABLE
-- ==========================
CREATE TABLE companies (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    website VARCHAR(255),
    industry VARCHAR(100),
    location VARCHAR(100),
    description TEXT,
    logo VARCHAR(255),
    status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ==========================
-- JOBS TABLE
-- ==========================
CREATE TABLE jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    job_title VARCHAR(150) NOT NULL,
    description TEXT,
    eligibility VARCHAR(100),
    location VARCHAR(100),
    salary VARCHAR(50),
    job_type ENUM('Full-Time','Part-Time','Internship'),
    last_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE
);

-- ==========================
-- APPLICATIONS TABLE
-- ==========================
CREATE TABLE applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    student_id INT NOT NULL,
    status ENUM('Applied','Shortlisted','Rejected','Selected') DEFAULT 'Applied',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

-- ==========================
-- INTERVIEWS TABLE
-- ==========================
CREATE TABLE interviews (
    interview_id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    interview_date DATE,
    interview_time TIME,
    interview_mode ENUM('Online','Offline'),
    meeting_link VARCHAR(255),
    result ENUM('Pending','Selected','Rejected') DEFAULT 'Pending',
    FOREIGN KEY (application_id) REFERENCES applications(application_id) ON DELETE CASCADE
);

-- ==========================
-- NOTIFICATIONS TABLE
-- ==========================
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ==========================
-- PASSWORD RESET TABLE
-- ==========================
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    otp VARCHAR(6),
    expires_at DATETIME
);

-- ==========================
-- ADMIN TABLE
-- ==========================
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);