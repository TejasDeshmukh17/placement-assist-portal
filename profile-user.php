<?php 
session_start();
require "connection.php";

if (!isset($_SESSION['email'])) {
    header("Location: login-user.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM userform.usertable WHERE email = '$email'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $user_id = $user['id'];
} else {
    echo "User not found.";
    exit();
}

// Fetch test scores
$sql_scores = "SELECT * FROM mcq_test.test_results WHERE user_id = '$user_id'";
$result_scores = mysqli_query($con, $sql_scores);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profileImage'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["profileImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    
    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFilePath)) {
        $updateQuery = "UPDATE userform.usertable SET profile_image='$fileName' WHERE id='$user_id'";
        mysqli_query($con, $updateQuery);
        header("Location: profile-user.php"); 
        exit();
    }
}
$profileImage = !empty($user['profile_image']) ? "uploads/" . $user['profile_image'] : "uploads/default.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?= htmlspecialchars($user['name']) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #121212;
            color: #fff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 90%;
            max-width: 900px;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 0 15px rgba(0, 255, 150, 0.2);
            text-align: center;
            opacity: 0;
            transform: scale(0.9);
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        h2 {
            margin-bottom: 15px;
        }
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #00ff99;
            margin: 10px auto;
        }
        .upload-form {
            margin-top: 10px;
        }
        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            background: #00ff99;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-block;
            transition: 0.3s;
            font-weight: bold;
            color: black;
        }
        .custom-file-upload:hover {
            background: #00cc77;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #252525;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #333;
            text-align: center;
        }
        th {
            background: #00ff99;
            color: #000;
        }
        tr:nth-child(even) {
            background: #2a2a2a;
        }
        tr:hover {
            background: rgba(0, 255, 150, 0.3);
            transition: 0.3s;
        }
        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .btn {
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
            font-weight: bold;
        }
        .home { background: #4da6ff; color: white; }
        .home:hover { background: #0066cc; }
        .graph { background: #00ff99; color: black; }
        .graph:hover { background: #00cc77; }
        .logout { background: #ff4d4d; color: white; }
        .logout:hover { background: #cc0000; }

        @media (max-width: 600px) {
            .container { width: 95%; padding: 20px; }
            .buttons { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($user['name']) ?></h2>

    <img src="<?= $profileImage ?>" alt="Profile Image" class="profile-pic" id="profilePicPreview">

    <form class="upload-form" action="" method="post" enctype="multipart/form-data">
        <label for="profileImage" class="custom-file-upload">Change Profile Picture</label>
        <input type="file" id="profileImage" name="profileImage" accept="image/*" onchange="previewImage(event)">
        <button type="submit" class="custom-file-upload" style="margin-top: 10px;">Upload</button>
    </form>

    <h3>Your Test Scores</h3>
    <table>
        <tr>
            <th>Test ID</th>
            <th>Subject</th>
            <th>Score</th>
            <th>Total Questions</th>
        </tr>
        <?php
        if ($result_scores && mysqli_num_rows($result_scores) > 0) {
            while ($row = mysqli_fetch_assoc($result_scores)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['subject']}</td>
                        <td>{$row['score']}</td>
                        <td>{$row['total_questions']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No test scores found.</td></tr>";
        }
        ?>
    </table>

    <div class="buttons">
        <a href="home.php" class="btn home">Home</a>
        <a href="graph.php" class="btn graph">View Score Graph</a>
        <a href="logout-user.php" class="btn logout">Logout</a>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('profilePicPreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>
