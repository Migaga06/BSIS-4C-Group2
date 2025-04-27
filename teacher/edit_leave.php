<?php
session_start();
include '../includes/db_connection.php';

if ($_SESSION['role'] != 'Teacher') {
    echo "Unauthorized access.";
    exit;
}

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $leave_details = $_POST['leave_details'];
    $commutation = $_POST['commutation'];
    $other_leave_type = $_POST['other_leave_type'] ?? null;
    $specify_abroad = $_POST['specify_abroad'] ?? null;
    $specify_illness_hospital = $_POST['specify_illness_hospital'] ?? null;
    $specify_illness_outpatient = $_POST['specify_illness_outpatient'] ?? null;
    $specify_special_leave_women = $_POST['specify_special_leave_women'] ?? null;

    // Set the leave type to the 'Other' input if it's filled
    if ($leave_type == 'Others' && !empty($other_leave_type)) {
        $leave_type = $other_leave_type;
    }

    $query = "UPDATE leave_requests SET 
        leave_type = '$leave_type', 
        start_date = '$start_date', 
        end_date = '$end_date', 
        leave_details = '$leave_details', 
        commutation = '$commutation', 
        specify_abroad = '$specify_abroad', 
        specify_illness_hospital = '$specify_illness_hospital', 
        specify_illness_outpatient = '$specify_illness_outpatient', 
        specify_special_leave_women = '$specify_special_leave_women' 
        WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header('Location: leave_status.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
} else {
    $query = "SELECT * FROM leave_requests WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Leave Request</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/edit_leave.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-4 form-container">
        <h2>Edit Leave Request</h2>
        <form method="POST">
        <div class="form-group">
            <h6>6.A. Type of Leave to be Availed of:</h6>
    <label for="leave_type">Leave Type:</label>
    <select class="form-control" id="leave_type" name="leave_type" required>
        <option value="Vacation Leave" <?= $row['leave_type'] == 'Vacation Leave' ? 'selected' : '' ?>>Vacation Leave</option>
        <option value="Mandatory Forced Leave" <?= $row['leave_type'] == 'Mandatory Forced Leave' ? 'selected' : '' ?>>Mandatory Forced Leave</option>
        <option value="Sick Leave" <?= $row['leave_type'] == 'Sick Leave' ? 'selected' : '' ?>>Sick Leave</option>
        <option value="Maternity Leave" <?= $row['leave_type'] == 'Maternity Leave' ? 'selected' : '' ?>>Maternity Leave</option>
        <option value="Paternity Leave" <?= $row['leave_type'] == 'Paternity Leave' ? 'selected' : '' ?>>Paternity Leave</option>
        <option value="Special Privilege" <?= $row['leave_type'] == 'Special Privilege' ? 'selected' : '' ?>>Special Privilege</option>
        <option value="Solo Parent Leave" <?= $row['leave_type'] == 'Solo Parent Leave' ? 'selected' : '' ?>>Solo Parent Leave</option>
        <option value="Study Leave" <?= $row['leave_type'] == 'Study Leave' ? 'selected' : '' ?>>Study Leave</option>
        <option value="10-Day VAWC" <?= $row['leave_type'] == '10-Day VAWC' ? 'selected' : '' ?>>10-Day VAWC</option>
        <option value="Rehabilitation" <?= $row['leave_type'] == 'Rehabilitation' ? 'selected' : '' ?>>Rehabilitation</option>
        <option value="Special Leave Benefits for Women" <?= $row['leave_type'] == 'Special Leave Benefits for Women' ? 'selected' : '' ?>>Special Leave Benefits for Women</option>
        <option value="Adoption Leave" <?= $row['leave_type'] == 'Adoption Leave' ? 'selected' : '' ?>>Adoption Leave</option>
        <option value="Others" <?= $row['leave_type'] == 'Others' ? 'selected' : '' ?>>Others</option>
    </select>
</div>
<div class="form-group" id="other_leave_type_group" style="display: <?= $row['leave_type'] == 'Others' ? 'block' : 'none' ?>;">
    <label for="other_leave_type">Please Specify:</label>
    <input type="text" class="form-control" id="other_leave_type" name="other_leave_type" value="<?= $row['leave_type'] == 'Others' ? $row['leave_type'] : '' ?>">
</div>

<div class="form-group">
    <h6>6.B. Details of Leave:</h6>
    <label for="leave_details">Details of Leave:</label>
    <select class="form-control" id="leave_details" name="leave_details" required onchange="toggleDetailsField(this)">
        <option value="Within the Philippines" <?= $row['leave_details'] == 'Within the Philippines' ? 'selected' : '' ?>>Within the Philippines</option>
        <option value="Abroad" <?= $row['leave_details'] == 'Abroad' ? 'selected' : '' ?>>Abroad</option>
        <option value="In Hospital" <?= $row['leave_details'] == 'In Hospital' ? 'selected' : '' ?>>In Hospital</option>
        <option value="Out Patient" <?= $row['leave_details'] == 'Out Patient' ? 'selected' : '' ?>>Out Patient</option>
        <option value="Completion of Master's Degree" <?= $row['leave_details'] == "Completion of Master's Degree" ? 'selected' : '' ?>>Completion of Master's Degree</option>
        <option value="BAR/Board Examination Review" <?= $row['leave_details'] == 'BAR/Board Examination Review' ? 'selected' : '' ?>>BAR/Board Examination Review</option>
        <option value="Monetization of Leave Credits" <?= $row['leave_details'] == 'Monetization of Leave Credits' ? 'selected' : '' ?>>Monetization of Leave Credits</option>
        <option value="Terminal Leave" <?= $row['leave_details'] == 'Terminal Leave' ? 'selected' : '' ?>>Terminal Leave</option>
        <option value="Special Leave Benefits for Women" <?= $row['leave_details'] == 'Special Leave Benefits for Women' ? 'selected' : '' ?>>Special Leave Benefits for Women</option>
    </select>
</div>
<div class="form-group" id="specify_abroad_group" style="display: <?= $row['leave_details'] == 'Abroad' ? 'block' : 'none' ?>;">
    <label for="specify_abroad">Specify Abroad:</label>
    <input type="text" class="form-control" id="specify_abroad" name="specify_abroad" value="<?= $row['specify_abroad'] ?>">
</div>
    <div class="form-group" id="specify_illness_hospital_group" style="display: <?= $row['leave_details'] == 'In Hospital' ? 'block' : 'none' ?>;">
    <label for="specify_illness_hospital">Specify Illness (In Hospital):</label>
    <input type="text" class="form-control" id="specify_illness_hospital" name="specify_illness_hospital" value="<?= $row['specify_illness_hospital'] ?>">
</div>
<div class="form-group" id="specify_illness_outpatient_group" style="display: <?= $row['leave_details'] == 'Out Patient' ? 'block' : 'none' ?>;">
    <label for="specify_illness_outpatient">Specify Illness (Out Patient):</label>
    <input type="text" class="form-control" id="specify_illness_outpatient" name="specify_illness_outpatient" value="<?= $row['specify_illness_outpatient'] ?>">
</div>
<div class="form-group" id="specify_special_leave_women_group" style="display: <?= $row['leave_details'] == 'Special Leave Benefits for Women' ? 'block' : 'none' ?>;">
    <label for="specify_special_leave_women">Specify Illness (Special Leave Benefits for Women):</label>
    <input type="text" class="form-control" id="specify_special_leave_women" name="specify_special_leave_women" value="<?= $row['specify_special_leave_women'] ?>">
</div>
<div class="form-group">
    <h6>6.C. Duration of Leave: Start Date:</h6>
    <label for="start_date">Start Date:</label>
    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $row['start_date'] ?>" required>
</div>
<div class="form-group">
<h6>6.C. Duration of Leave: End Date:</h6>
    <label for="end_date">End Date:</label>
    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $row['end_date'] ?>" required>
</div>
<div class="form-group">
<h6>6.D. Commutation:</h6>
    <label for="commutation">Commutation:</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" id="commutation_requested" name="commutation" value="Requested" <?= $row['commutation'] == 'Requested' ? 'checked' : '' ?> required>
        <label class="form-check-label" for="commutation_requested">Requested</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" id="commutation_not_requested" name="commutation" value="Not Requested" <?= $row['commutation'] == 'Not Requested' ? 'checked' : '' ?> required>
        <label class="form-check-label" for="commutation_not_requested">Not Requested</label>
    </div>
</div>
<button type="submit" class="btn btn-secondary">Update Leave Request</button>
<a href="leave_status.php" class="btn btn-secondary">Cancel</a>
</form>
</div>

<script>
function toggleOtherField(selectElement) {
    var otherFieldGroup = document.getElementById('other_leave_type_group');
    if (selectElement.value === 'Others') {
        otherFieldGroup.style.display = 'block';
    } else {
        otherFieldGroup.style.display = 'none';
    }
}

function toggleDetailsField(selectElement) {
    document.getElementById('specify_abroad_group').style.display = 'none';
    document.getElementById('specify_illness_hospital_group').style.display = 'none';
    document.getElementById('specify_illness_outpatient_group').style.display = 'none';
    document.getElementById('specify_special_leave_women_group').style.display = 'none';

    if (selectElement.value === 'Abroad') {
        document.getElementById('specify_abroad_group').style.display = 'block';
    } else if (selectElement.value === 'In Hospital') {
        document.getElementById('specify_illness_hospital_group').style.display = 'block';
    } else if (selectElement.value === 'Out Patient') {
        document.getElementById('specify_illness_outpatient_group').style.display = 'block';
    } else if (selectElement.value === 'Special Leave Benefits for Women') {
        document.getElementById('specify_special_leave_women_group').style.display = 'block';
    }
}

document.getElementById('leave_type').addEventListener('change', function() {
    toggleOtherField(this);
});

document.getElementById('leave_details').addEventListener('change', function() {
    toggleDetailsField(this);
});
</script>
</body>
</html>
