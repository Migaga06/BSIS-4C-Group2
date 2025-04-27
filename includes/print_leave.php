<?php
session_start();
include '../includes/db_connection.php';

// Check if the user is a Teacher
if ($_SESSION['role'] != 'Teacher') {
    echo "Unauthorized access.";
    exit;
}

// Fetch the leave request details
$id = $_GET['id'];
$query = "SELECT * FROM leave_requests WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Fetch the user's name for the printout and user id
$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname FROM users WHERE user_id='$row[user_id]'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Prepare values for printing
$leave_type = htmlspecialchars($row['leave_type']);
$leave_details = htmlspecialchars($row['leave_details']);
$start_date = htmlspecialchars($row['start_date']);
$end_date = htmlspecialchars($row['end_date']);
$commutation = htmlspecialchars($row['commutation']);
$firstname = htmlspecialchars($user['firstname']);
$lastname = htmlspecialchars($user['lastname']);

// Prepare specific details if needed
$specify_abroad = !empty($row['specify_abroad']) ? htmlspecialchars($row['specify_abroad']) : '';
$specify_illness_hospital = !empty($row['specify_illness_hospital']) ? htmlspecialchars($row['specify_illness_hospital']) : '';
$specify_illness_outpatient = !empty($row['specify_illness_outpatient']) ? htmlspecialchars($row['specify_illness_outpatient']) : '';
$specify_special_leave_women = !empty($row['specify_special_leave_women']) ? htmlspecialchars($row['specify_special_leave_women']) : '';
?>


<!DOCTYPE html>
<html>
<head>
    <title>Print Leave Request</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/print.css">
</head>
<body>
    <div class="container">
        <h2>Leave Application / Form 6</h2>
        <p class="name"><strong>Name:</strong> <?= $firstname . ' ' . $lastname ?></p>
        <p class="teacher_id"><strong>Teacher's ID:</strong> <?= $user_id?></p>
 
 <!-- 6A. TYPE OF LEAVE TO BE AVAILED OF -->
 <h5>6A. TYPE OF LEAVE TO BE AVAILED OF:</h5>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Vacation Leave' ? 'checked' : '' ?> disabled> Vacation Leave (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Mandatory Forced Leave' ? 'checked' : '' ?> disabled> Mandatory/Forced Leave (Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Sick Leave' ? 'checked' : '' ?> disabled> Sick Leave (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Maternity Leave' ? 'checked' : '' ?> disabled> Maternity Leave (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Paternity Leave' ? 'checked' : '' ?> disabled> Paternity Leave (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Special Privilege Leave' ? 'checked' : '' ?> disabled> Special Privilege Leave (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Solo Parent Leave' ? 'checked' : '' ?> disabled> Solo Parent Leave (R.A. No. 8972 / CSC MC No. 15, s. 2004)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Study Leave' ? 'checked' : '' ?> disabled> Study Leave (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == '10-Day VAWC Leave' ? 'checked' : '' ?> disabled> 10-Day VAWC Leave (R.A. No. 9262 / CSC MC No. 1, s. 2005)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Rehabilitation Leave' ? 'checked' : '' ?> disabled> Rehabilitation Leave (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Special Leave Benefits for Women' ? 'checked' : '' ?> disabled> Special Leave Benefits for Women (R.A. No. 9710/ CSC MC No. 25, s. 2010)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Special Emergency (Calamity) Leave' ? 'checked' : '' ?> disabled> Special Emergency (Calamity) Leave (CSC MC No. 2, s. 2012, as amended)</p>
<p><input type="radio" name="leave_type" <?= $leave_type == 'Adoption Leave' ? 'checked' : '' ?> disabled> Adoption Leave (R.A. No. 8552)</p>
<p><input type="radio" name="leave_type" <?= !in_array($leave_type, ['Vacation Leave', 'Mandatory Forced Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave', 'Special Privilege Leave', 'Solo Parent Leave', 'Study Leave', '10-Day VAWC Leave', 'Rehabilitation Leave', 'Special Leave Benefits for Women', 'Special Emergency (Calamity) Leave', 'Adoption Leave']) ? 'checked' : '' ?> disabled> OTHERS: <?= htmlspecialchars($leave_type) ?></p>

<!-- 6B. DETAILS OF LEAVE -->
<h5>6B. DETAILS OF LEAVE:</h5>
<p>In case of Vacation/Special Privilege Leave:</p>
<p><input type="radio" name="details_vacation" <?= $leave_details == 'Within the Philippines' ? 'checked' : '' ?> disabled> Within the Philippines ___________________________</p>
<p><input type="radio" name="details_vacation" <?= $leave_details == 'Abroad' ? 'checked' : '' ?> disabled> Abroad (Specify): <?= $specify_abroad ?></p>

<p>In case of Sick Leave:</p>
<p><input type="radio" name="details_sick" <?= $leave_details == 'In Hospital' ? 'checked' : '' ?> disabled> In Hospital (Specify Illness):___________________________ <?= $specify_illness_hospital ?></p>
<p><input type="radio" name="details_sick" <?= $leave_details == 'Out Patient' ? 'checked' : '' ?> disabled> Out Patient (Specify Illness):___________________________ <?= $specify_illness_outpatient ?></p>

<p>In case of Special Leave Benefits for Women:</p>
<p><input type="radio" name="details_women" <?= $leave_details == 'Special Leave Benefits for Women' ? 'checked' : '' ?> disabled> (Specify Illness):___________________________ <?= $specify_special_leave_women ?></p>

<p>In case of Study Leave:</p>
<p><input type="radio" name="details_study" <?= $leave_details == "Completion of Master's Degree" ? 'checked' : '' ?> disabled> Completion of Master's Degree</p>
<p><input type="radio" name="details_study" <?= $leave_details == 'BAR/Board Examination Review' ? 'checked' : '' ?> disabled> BAR/Board Examination Review</p>

<p>Other purpose:</p>
<p><input type="radio" name="other_purpose" <?= $leave_details == 'Monetization of Leave Credits' ? 'checked' : '' ?> disabled> Monetization of Leave Credits</p>
<p><input type="radio" name="other_purpose" <?= $leave_details == 'Terminal Leave' ? 'checked' : '' ?> disabled> Terminal Leave</p>

<!-- 6C. DURATION OF LEAVE -->
<h5>6C. DURATION OF LEAVE:</h5>
<p><strong>Start Date:</strong> <?= $start_date ?></p>
<p><strong>End Date:</strong> <?= $end_date ?></p>

<!-- 6D. COMMUTATION -->
<h5>6D. COMMUTATION:</h5>
<p><input type="radio" name="commutation" <?= $commutation == 'Not Requested' ? 'checked' : '' ?> disabled> Not Requested</p>
<p><input type="radio" name="commutation" <?= $commutation == 'Requested' ? 'checked' : '' ?> disabled> Requested</p>


</body>
</html>

<script>
window.onload = function() { window.print(); };
</script>