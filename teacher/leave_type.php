<?php
session_start();
include '../includes/db_connection.php';

$current_page = basename($_SERVER['PHP_SELF']);

$user_id = $_SESSION['user_id'];
$user_query = "SELECT firstname, lastname FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

if ($_SESSION['role'] != 'Teacher') {
    echo "Unauthorized access.";
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM leave_requests WHERE user_id = '$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Type</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/t_sidebar.css">
    
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <?php include '../includes/t_sidebar.php'; ?>

       
        <div class="content" id="page-content-wrapper">
            
            <?php include '../includes/t_navbar.php'; ?>


            <div class="container-fluid mt-2">
    <h2 class="Form-Head">Leave Types</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Type of Leave</th>
                <th scope="col">Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Vacation Leave</td>
                <td><button class="btn" onclick="toggleDescription(1)">Read</button></td>
            </tr>
            <tr id="description1" class="description" style="display: none;"> 
                <td colspan="3"><strong>Sec. 51 Rule VXI Omnibus Rules Implementing Executive Order No. 292</strong>
                <br><br>It allows government employees to take annual leave for personal rest and relaxation. Employees are entitled to a five-day annual vacation leave, which must be used within the calendar year; otherwise, it will be forfeited. Applications for vacation leave should be submitted at least five days in advance using the prescribed form.</td>
            </tr>

            <tr>
                <th scope="row">2</th>
                <td>Mandatory/Forced Leave</td>
                <td><button class="btn" onclick="toggleDescription(2)">Read</button></td>
            </tr>
            <tr id="description2" class="description" style="display: none;">
                <td colspan="3"><strong>Mandatory/Forced Leave under Section 25, Rule XVI of the Omnibus Rules Implementing Executive Order No. 292</strong>
                <br><br>It requires government employees with 10 or more vacation leave credits to take a minimum of five working days of vacation leave annually. This leave can be taken continuously or intermittently. The purpose is to ensure that employees take necessary rest and avoid accumulating excessive leave credits.</td>
            </tr>
            
            <tr>
                <th scope="row">3</th>
                <td>Sick Leave</td>
                <td><button class="btn" onclick="toggleDescription(3)">Read</button></td>
            </tr>
            <tr id="description3" class="description" style="display: none;">
                <td colspan="3"><strong>Sick Leave under Section 43, Rule XVI of the Omnibus Rules Implementing Executive Order No. 292</strong>
                <br><br>It allows government employees to take leave due to illness or injury. Employees are entitled to 15 days of sick leave per year, which can be used for their own illness or for attending to the illness of an immediate family member. Sick leave can be availed of continuously or intermittently, and a medical certificate may be required for extended sick leave.</td>
            </tr>

            <tr>
                <th scope="row">4</th>
                <td>Maternity Leave</td>
                <td><button class="btn" onclick="toggleDescription(4)">Read</button></td>
            </tr>
            <tr id="description4" class="description" style="display: none;">
                <td colspan="3"><strong>Republic Act No. 11210 The 105-Day Expanded Maternity Leave Law</strong>
                <br><br>It grants 105 days of paid maternity leave for childbirth, with an option to extend for 30 more days without pay. Solo parents get an extra 15 days. The law also allows 60 days of paid leave for miscarriage or emergency pregnancy termination, covering public and private sector workers, including informal and voluntary Social Security System contributors. Leave must be taken continuously.</td>
            </tr>

            <tr>
                    <th scope="row">5</th>
                    <td>Parternity Leave</td>
                    <td><button class="btn" onclick="toggleDescription(5)">Read</button></td>
                </tr>
                <tr id="description5" class="description" style="display: none;">
                    <td colspan="3"><strong>Republic Act No. 8187 Paternity Leave Act of 1996</strong>
                  <br><br>It grants seven days of paid paternity leave to married male employees in both the private and public sectors for the first four deliveries of their legitimate spouse with whom they are cohabiting. 
                  This leave can be used for childbirth or miscarriage, allowing fathers to support their spouses during recovery and newborn care.</td>
                </tr>

                <tr>
                    <th scope="row">6</th>
                    <td>Special Privelege</td>
                    <td><button class="btn" onclick="toggleDescription(6)">Read</button></td>
                </tr>
                <tr  id="description6" class="description" style="display: none;">
                    <td colspan="3"><strong> Special Privilege Leave under Section 21, Rule XVI of the Omnibus Rules Implementing Executive Order No. 292</strong>
                  <br><br> It allows government employees to take leave for specific personal reasons, such as attending to family matters, personal emergencies, or other important personal needs.
                   This leave is non-cumulative and non-commutable, meaning it cannot be accumulated or converted into cash</td>
                </tr>

                <tr>
                    <th scope="row">7</th>
                    <td>Solo Parent Leave</td>
                    <td><button class="btn" onclick="toggleDescription(7)">Read</button></td>
                </tr>
                <tr id="description7" class="description" style="display: none;">
                    <td colspan="3"><strong>Republic Act No. 8972 Solo Parents' Welfare Act of 2000</strong>
                  <br><br>One of the key provisions is the parental leave, which grants solo parents seven days of paid leave per year to attend to their parental duties and responsibilities. 
                  This leave is non-cumulative and non-commutable, meaning it cannot be accumulated or converted into cash2. To be eligible, solo parents must have rendered at least six months of service
                  and must notify their employer within a reasonable time</td>
                </tr>

                <tr>
                    <th scope="row">8</th>
                    <td>Study Leave</td>
                    <td><button class="btn" onclick="toggleDescription(8)">Read</button></td>
                </tr>
                <tr id="description8" class="description" style="display: none;">
                    <td colspan="3"><strong>Section 68 of the Omnibus Rules Implementing Executive Order No. 292</strong>
                  <br><br>To be eligible, an employee must have rendered at least two years of continuous service with a performance rating of at least "very satisfactory" for the last two rating periods. 
                  The leave can be availed for pursuing further studies or training that will enhance the employee's skills and knowledge relevant to their position.</td>
                </tr>

                <tr>
                    <th scope="row">9</th>
                    <td>10-Days VAWC</td>
                    <td><button class="btn" onclick="toggleDescription(9)">Read</button></td>
                </tr>
                <tr id="description9" class="description" style="display: none;">
                    <td colspan="3"><strong>Republic Act No. 9262, also known as the Anti-Violence Against Women and Their Children Act of 2004</strong>
                  <br><br>It provides 10 days of paid leave for government employees who are victims of violence or their children are victims of violence. 
                  This leave is in addition to other paid leaves under the Labor Code and Civil Service Rules and Regulations, and it can be extended if necessary1</td>
                </tr>

                <tr>
                    <th scope="row">10</th>
                    <td>Rehabilitation Leave</td>
                    <td><button class="btn" onclick="toggleDescription(10)">Read</button></td>
                </tr>
                <tr id="description10" class="description" style="display: none;">
                    <td colspan="3"><strong>Section 55 of the Omnibus Rules Implementing Executive Order No. 292</strong>
                  <br><br>This leave is granted for a maximum period of six months for wounds or injuries sustained while performing official duties. The duration, frequency, and terms of the leave are based on medical recommendations, and it can be availed on a full-time, half-time, or intermittent basis1. 
                  During this period, employees receive their salaries and regular benefits, but they do not accumulate sick or vacation leave credits.</td>
                </tr>

                <tr>
                    <th scope="row">11</th>
                    <td>Special Leave Benefits for Women</td>
                    <td><button class="btn" onclick="toggleDescription(11)">Read</button></td>
                </tr>
                <tr id="description11" class="description" style="display: none;">
                    <td colspan="3"><strong>Republic Act No. 9710, also known as the Magna Carta of the Women</strong>
                  <br><br>Female employees who have rendered at least six months of continuous aggregate employment in the last twelve months are entitled to two months of paid leave with full pay following surgery caused by gynecological disorders. 
                  This leave can be availed of for surgeries such as dilation and curettage, myomectomy, hysterectomy, ovariectomy, and mastectomy.</td>
                </tr>

                <tr>
                    <th scope="row">12</th>
                    <td>Emergency Calamity Leave</td>
                    <td><button class="btn" onclick="toggleDescription(12)">Read</button></td>
                </tr>
                <tr id="description12" class="description" style="display: none;">
                    <td colspan="3"><strong>Special Emergency Calamity Leave under CSC Memorandum Circular No. 2, s. 2012</strong>
                  <br><br>allows government employees to take up to five days of leave in a year when they are affected by natural calamities or disasters. This leave can be availed within 30 days from the occurrence of the calamity and can be used for urgent repair and clean-up of damaged property,
                  being stranded in affected areas, illness due to the calamity, or caring for immediate family members affected by the disaster. 
                  The leave is non-deductible from earned leave credits and is granted based on the declaration of a state of calamity by the President or the Local Sanggunian1.</td>
                </tr>

                <tr>
                    <th scope="row">13</th>
                    <td>Adoption Leave</td>
                    <td><button class="btn" onclick="toggleDescription(13)">Read</button></td>
                </tr>
                <tr id="description13" class="description" style="display: none;">
                    <td colspan="3"><strong>Adoption Leave under Republic Act No. 8552 The Domestic Adoption Act of 1998</strong>
                  <br><br> It allows qualified adoptive parents in the government service to avail of 60 days of paid leave. This leave is intended to help the adoptive parent bond with the adoptee1. The leave must be taken continuously and uninterrupted. For male employees, 
                  the legitimate spouse of the female employee entitled to adoption leave can also avail of seven days of paid leave.</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <script>
    function toggleDescription(id) {
        var descriptionElement = document.getElementById('description' + id);
        var buttonElement = document.querySelector('button[onclick="toggleDescription(' + id + ')"]');

        if (descriptionElement.style.display === "none" || descriptionElement.style.display === "") {
            descriptionElement.style.display = "table-row";
            buttonElement.textContent = "Hide";
        } else {
            descriptionElement.style.display = "none";
            buttonElement.textContent = "Read";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var descriptions = document.querySelectorAll('.description');
        descriptions.forEach(function(description) {
            description.style.display = 'none';
        });
    });
</script>



    <script src="../assets/javascript/sidebar_toggle.js"></script>
</body>
</html>
