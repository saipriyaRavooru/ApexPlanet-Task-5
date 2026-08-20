# ApexPlanet-Task-5
# 🎓 Campus Placement Portal

A web-based **Campus Placement Portal** developed as part of **Task 5** of the Full Stack Web Development Internship at **ApexPlanet Software Pvt. Ltd.**

The system helps students explore placement opportunities, apply for jobs, and manage their applications, while providing administrators with tools to manage students, companies, job postings, and applications.

## 🚀 Features

### 👨‍🎓 Student

* Student registration and login
* Student profile management
* Browse available job opportunities
* View company and job details
* Apply for placement opportunities
* Track application status
* View applied jobs

### 🏢 Company / Recruiter

* Company registration/login
* Create and manage job postings
* View student applications
* Shortlist eligible candidates
* Update application status

### 👨‍💼 Admin

* Admin login
* Manage students
* Manage companies
* Manage job postings
* Monitor applications
* Manage placement records
* View overall placement information

## 🛠️ Technologies Used

* **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
* **Backend:** PHP
* **Database:** MySQL
* **Development Environment:** XAMPP
* **Editor:** Visual Studio Code

## 📂 Project Structure

```text
Campus-Placement-Portal/
│
├── admin/
│   ├── dashboard.php
│   ├── students.php
│   ├── companies.php
│   ├── jobs.php
│   └── applications.php
│
├── student/
│   ├── dashboard.php
│   ├── profile.php
│   ├── jobs.php
│   └── applications.php
│
├── company/
│   ├── dashboard.php
│   ├── post_job.php
│   ├── manage_jobs.php
│   └── applications.php
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── config/
│   └── database.php
│
├── index.php
├── login.php
├── register.php
├── logout.php
└── README.md
```

## ⚙️ Installation & Setup

### 1. Install XAMPP

Download and install XAMPP with:

* Apache
* MySQL

### 2. Clone the Repository

```bash
git clone https://github.com/yourusername/Campus-Placement-Portal.git
```

### 3. Move the Project

Copy the project folder into:

```text
C:\xampp\htdocs\
```

### 4. Start XAMPP

Open XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 5. Create Database

Open:

```text
http://localhost/phpmyadmin
```

Create a database:

```text
campus_placement
```

Import the provided SQL database file into the newly created database.

### 6. Configure Database

Update the database credentials in:

```text
config/database.php
```

Example:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "campus_placement";
```

### 7. Run the Project

Open your browser and visit:

```text
http://localhost/Campus-Placement-Portal/
```

## 🔐 User Roles

| Role    | Main Functions                                  |
| ------- | ----------------------------------------------- |
| Student | Profile, Jobs, Applications                     |
| Company | Job Posting, Candidate Management               |
| Admin   | Manage Students, Companies, Jobs & Applications |

## 📊 Placement Workflow

```text
Student Registration
        ↓
Create Profile
        ↓
Browse Job Opportunities
        ↓
Apply for Job
        ↓
Company Reviews Application
        ↓
Shortlist / Reject
        ↓
Application Status Updated
        ↓
Placement Completed
```

## 🎯 Objective

The main objective of this project is to provide a centralized platform for managing campus recruitment activities and to simplify communication between **students, recruiters, and administrators**.

## 🔮 Future Enhancements

* Email notifications
* Resume upload and management
* Advanced job search and filtering
* Automated eligibility checking
* Placement analytics dashboard
* Interview scheduling
* Online aptitude tests
* Real-time application notifications

## 👩‍💻 Internship

**Internship:** Full Stack Web Development Internship
**Organization:** ApexPlanet Software Pvt. Ltd.
**Task:** Task 5 – Campus Placement Portal

## 📜 License

This project was developed for educational and internship purposes.
