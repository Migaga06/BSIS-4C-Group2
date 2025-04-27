<?php
session_start();
include '../includes/db_connection.php';

$current_page = basename($_SERVER['PHP_SELF']);

// Fetch the logged-in user’s details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

if ($_SESSION['role'] != 'Teacher') {
    echo "Unauthorized access.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['user_id']; // Make sure this is set
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

    $query = "INSERT INTO leave_requests (user_id, leave_type, start_date, end_date, leave_details, commutation, specify_abroad, specify_illness_hospital, specify_illness_outpatient, specify_special_leave_women, status) 
              VALUES ('$user_id', '$leave_type', '$start_date', '$end_date', '$leave_details', '$commutation', '$specify_abroad', '$specify_illness_hospital', '$specify_illness_outpatient', '$specify_special_leave_women', 'Pending')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['toast_success'] = "Leave request submitted successfully.";
        header('Location: apply_leave.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Apply Leave</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/t_sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <?php include '../includes/t_sidebar.php'; ?>

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div class="content" id="page-content-wrapper">
        <?php include '../includes/t_navbar.php'; ?>

            <div class="container-fluid mt-4 form-container">
            <p class="Form-Head-Application">Application for Leave Request / Form 6</p>
            <div>

            <div class="container-fluid mt-4 form-container">
                <form method="POST" action="apply_leave.php">
                    <div class="form-group">
                        <label for="leave_type">6.A. Type of Leave to be Availed of:</label>
                        <select class="form-control" id="leave_type" name="leave_type" required onchange="toggleOtherField(this)">
                            <option value="Vacation Leave">Vacation Leave</option>
                            <option value="Mandatory Forced Leave">Mandatory Forced Leave</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                            <option value="Special Privilege">Special Privilege</option>
                            <option value="Solo Parent Leave">Solo Parent Leave</option>
                            <option value="Study Leave">Study Leave</option>
                            <option value="10-Day VAWC">10-Day VAWC</option>
                            <option value="Rehabilitation">Rehabilitation</option>
                            <option value="Special Leave Benefits for Women">Special Leave Benefits for Women</option>
                            <option value="Adoption Leave">Adoption Leave</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="form-group" id="other_leave_type_group" style="display:none;">
                        <label for="other_leave_type">Please Specify:</label>
                        <input type="text" class="form-control" id="other_leave_type" name="other_leave_type">
                    </div>
                    <div class="form-group">
                <label for="leave_details">6.B. Details of Leave:</label>
                <select class="form-control" id="leave_details" name="leave_details" required onchange="toggleDetailsField(this)">
                    <option value="Within the Philippines">Within the Philippines</option>
                    <option value="Abroad">Abroad</option>
                    <option value="In Hospital">In Hospital</option>
                    <option value="Out Patient">Out Patient</option>
                    <option value="Completion of Master's Degree">Completion of Master's Degree</option>
                    <option value="BAR/Board Examination Review">BAR/Board Examination Review</option>
                    <option value="Monetization of Leave Credits">Monetization of Leave Credits</option>
                    <option value="Terminal Leave">Terminal Leave</option>
            </select>
            </div>
                <div class="form-group" id="specify_abroad" style="display:none;">
                    <label for="specify_abroad_text">Specify Abroad:</label>
                    <input type="text" class="form-control" id="specify_abroad_text" name="specify_abroad">
                </div>
                <div class="form-group" id="specify_illness_hospital" style="display:none;">
                <label for="specify_illness_hospital_text">Specify Illness (In Hospital):</label>
             <input type="text" class="form-control" id="specify_illness_hospital_text" name="specify_illness_hospital">
            </div>
            <div class="form-group" id="specify_illness_outpatient" style="display:none;">
            <label for="specify_illness_outpatient_text">Specify Illness (Out Patient):</label>
         <input type="text" class="form-control" id="specify_illness_outpatient_text" name="specify_illness_outpatient">
            </div>
            <div class="form-group" id="specify_special_leave_women" style="display:none;">
            <label for="specify_special_leave_women_text">Specify Illness (Special Leave Benefits for Women):</label>
            <input type="text" class="form-control" id="specify_special_leave_women_text" name="specify_special_leave_women">
            </div>
                <div class="form-group">
                        <label for="start_date">6.C. Duration of Leave: Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">6.C. Duration of Leave: End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="commutation">6.D. Commutation:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="commutation_requested" name="commutation" value="Requested" required>
                            <label class="form-check-label" for="commutation_requested">Requested</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="commutation_not_requested" name="commutation" value="Not Requested" required>
                            <label class="form-check-label" for="commutation_not_requested">Not Requested</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Leave</button>
                </form>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <div class="toast" id="successToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: fixed; bottom: 1rem; right: 1rem;">
  <div class="toast-header">
    <strong class="mr-auto text-success">Success</strong>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Leave request submitted successfully.
  </div>
</div>



    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script src="../assets/javascript/sidebar_toggle.js"></script>

    <script>
        $(document).ready(function() {
        <?php if (isset($_SESSION['toast_success'])): ?>
        $('#successToast').toast('show');
        <?php unset($_SESSION['toast_success']); ?>
    <?php endif; ?>
            });

            function toggleOtherField(selectElement) {
    var otherFieldGroup = document.getElementById('other_leave_type_group');
    if (selectElement.value === 'Others') {
        otherFieldGroup.style.display = 'block';
    } else {
        otherFieldGroup.style.display = 'none';
    }
}

function toggleDetailsField(selectElement) {
    // Hide all specify fields
    document.getElementById('specify_abroad').style.display = 'none';
    document.getElementById('specify_illness_hospital').style.display = 'none';
    document.getElementById('specify_illness_outpatient').style.display = 'none';
    document.getElementById('specify_special_leave_women').style.display = 'none';

    // Show specific field based on selected value
    if (selectElement.value === 'Abroad') {
        document.getElementById('specify_abroad').style.display = 'block';
    } else if (selectElement.value === 'In Hospital') {
        document.getElementById('specify_illness_hospital').style.display = 'block';
    } else if (selectElement.value === 'Out Patient') {
        document.getElementById('specify_illness_outpatient').style.display = 'block';
    } else if (selectElement.value === 'Special Leave Benefits for Women') {
        document.getElementById('specify_special_leave_women').style.display = 'block';
    }
}

</script>


</body>
</html>
