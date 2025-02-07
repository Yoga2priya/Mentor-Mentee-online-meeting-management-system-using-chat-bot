<?php
require_once 'config/db.php';
require_once 'includes/auth.php';

function createUploadDirectory($path) {
    if (!file_exists($path)) {
        if (!mkdir($path, 0777, true)) {
            throw new Exception("Failed to create upload directory");
        }
        chmod($path, 0777);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $conn = $database->getConnection();
    
    try {
        $conn->beginTransaction();
        
        // Handle photo upload
        $photo_path = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $target_dir = "uploads/photos/";
            
            // Create directory if it doesn't exist
            createUploadDirectory($target_dir);
            
            $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
            $file_name = uniqid() . "." . $file_extension;
            $target_file = $target_dir . $file_name;
            
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo_path = $target_file;
            } else {
                throw new Exception("Error uploading photo: " . error_get_last()['message']);
            }
        }
        
        // Hash password
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Insert into students table
        $stmt = $conn->prepare("INSERT INTO students (
            name, reg_no, email, password, address, gender, year, 
            mobile_no, department, dob, blood_group, photo_path,
            fathers_name, fathers_number, mothers_name, mothers_number,
            guardian_name, guardian_number
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_POST['name'],
            $_POST['reg_no'],
            $_POST['email'],
            $hashed_password,
            $_POST['address'],
            $_POST['gender'],
            $_POST['year'],
            $_POST['mobile_no'],
            $_POST['department'],
            $_POST['dob'],
            $_POST['blood_group'],
            $photo_path,
            $_POST['fathers_name'],
            $_POST['fathers_number'],
            $_POST['mothers_name'],
            $_POST['mothers_number'],
            $_POST['guardian_name'],
            $_POST['guardian_number']
        ]);
        
        $student_id = $conn->lastInsertId();
        
        // Insert academic records
        $stmt = $conn->prepare("INSERT INTO academic_records (
            student_id, tenth_school, tenth_marks, tenth_percentage,
            eleventh_school, eleventh_marks, eleventh_percentage,
            twelfth_school, twelfth_marks, twelfth_percentage,
            diploma_percentage, ug_college, ug_degree, ug_percentage
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $student_id,
            $_POST['tenth_school'],
            $_POST['tenth_marks'],
            $_POST['tenth_percentage'],
            $_POST['eleventh_school'],
            $_POST['eleventh_marks'],
            $_POST['eleventh_percentage'],
            $_POST['twelfth_school'],
            $_POST['twelfth_marks'],
            $_POST['twelfth_percentage'],
            $_POST['diploma_percentage'] ?? null,
            $_POST['ug_college'] ?? null,
            $_POST['ug_degree'] ?? null,
            $_POST['ug_percentage'] ?? null
        ]);
        
        $conn->commit();
        header('Location: login.php?registered=true');
        exit();
    } catch(Exception $e) {
        $conn->rollBack();
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="registration-container">
        <div class="registration-box">
            <a href="index.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
            
            <div class="registration-header">
                <i class="fas fa-user-graduate registration-icon"></i>
                <h2>Student Registration</h2>
            </div>

            <form method="POST" class="registration-form" enctype="multipart/form-data">
                <div class="form-sections">
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-user"></i> Personal Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" name="name" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-id-card"></i> Registration Number</label>
                                <input type="text" name="reg_no" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-venus-mars"></i> Gender</label>
                                <select name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-calendar"></i> Date of Birth</label>
                                <input type="date" name="dob" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-tint"></i> Blood Group</label>
                                <select name="blood_group">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Mobile Number</label>
                                <input type="tel" name="mobile_no" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-home"></i> Address</label>
                                <textarea name="address" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="password">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <div class="password-input">
                                    <input type="password" id="password" name="password" required>
                                    <i class="fas fa-eye toggle-password"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">
                                    <i class="fas fa-lock"></i> Confirm Password
                                </label>
                                <div class="password-input">
                                    <input type="password" id="confirm_password" name="confirm_password" required>
                                    <i class="fas fa-eye toggle-password"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-calendar"></i> Year</label>
                                <select name="year" required>
                                    <option value="">Select Year</option>
                                    <option value="1">First Year</option>
                                    <option value="2">Second Year</option>
                                    <option value="3">Third Year</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-building"></i> Department</label>
                                <select name="department" required>
                                    <option value="">Select Department</option>
                                    <option value="BSc Computer Science">BSc Computer Science</option>
                                    <option value="BSc Mathematics">BSc Mathematics</option>
                                    <option value="BSc Physics">BSc Physics</option>
                                    <option value="BSc Chemistry">BSc Chemistry</option>
                                    <option value="BA English">BA English</option>
                                    <option value="BA Tamil">BA Tamil</option>
                                    <option value="BCom">BCom</option>
                                    <option value="BBA">BBA</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Family Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-users"></i> Family Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Father's Name</label>
                                <input type="text" name="fathers_name" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Father's Number</label>
                                <input type="tel" name="fathers_number" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Mother's Name</label>
                                <input type="text" name="mothers_name" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Mother's Number</label>
                                <input type="tel" name="mothers_number" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Guardian's Name</label>
                                <input type="text" name="guardian_name">
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Guardian's Number</label>
                                <input type="tel" name="guardian_number">
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-graduation-cap"></i> Academic Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label><i class="fas fa-school"></i> 10th Details</label>
                                <input type="text" name="tenth_school" placeholder="School Name" required>
                                <input type="text" name="tenth_marks" placeholder="Marks" required>
                                <input type="number" step="0.01" name="tenth_percentage" placeholder="Percentage" required>
                                <input type="number" name="tenth_year" placeholder="Year of Passing" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-school"></i> 11th Details</label>
                                <input type="text" name="eleventh_school" placeholder="School Name">
                                <input type="text" name="eleventh_marks" placeholder="Marks">
                                <input type="number" step="0.01" name="eleventh_percentage" placeholder="Percentage">
                                <input type="number" name="eleventh_year" placeholder="Year of Passing">
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-school"></i> 12th Details</label>
                                <input type="text" name="twelfth_school" placeholder="School Name" required>
                                <input type="text" name="twelfth_marks" placeholder="Marks" required>
                                <input type="number" step="0.01" name="twelfth_percentage" placeholder="Percentage" required>
                                <input type="number" name="twelfth_year" placeholder="Year of Passing" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-university"></i> UG Details</label>
                                <input type="text" name="ug_college" placeholder="College Name">
                                <input type="text" name="ug_degree" placeholder="Degree">
                                <input type="number" step="0.01" name="ug_percentage" placeholder="Percentage">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-info-circle"></i> Additional Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label><i class="fas fa-ring"></i> Marital Status</label>
                                <select name="marital_status" required>
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div class="form-section">
                        <h3><i class="fas fa-camera"></i> Profile Photo</h3>
                        <div class="form-group">
                            <label><i class="fas fa-upload"></i> Upload Photo</label>
                            <input type="file" name="photo" accept="image/*" required>
                            <small class="form-text">Upload a passport size photo (Max size: 2MB)</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all toggle password buttons
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Find the closest password input to this toggle button
                const passwordInput = this.parentElement.querySelector('input');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        });
    });
    </script>
</body>
</html>
