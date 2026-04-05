<?php 
include('db/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    $total = count($_POST['qid']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $user_email = $_SESSION['email'];

    $userQuery = "SELECT id FROM userform.usertable WHERE email='$user_email'";
    $userResult = mysqli_query($conn, $userQuery);
    $userRow = mysqli_fetch_assoc($userResult);
    $user_id = $userRow['id'];

    foreach ($_POST['qid'] as $qid) {
        $userAnswer = $_POST['answer_' . $qid] ?? '';
        $query = "SELECT correct_answer FROM mcq_test.questions WHERE id = '$qid'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row['correct_answer'] === $userAnswer) {
            $score++;
        }
    }

    $insertQuery = "INSERT INTO mcq_test.test_results (user_id, subject, score, total_questions) 
                    VALUES ('$user_id', '$subject', '$score', '$total')";
    mysqli_query($conn, $insertQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Result</title>
    <style>
        /* General Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            overflow: hidden;
        }
        .container {
            background: rgba(30, 30, 30, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 255, 150, 0.3);
            width: 90%;
            max-width: 500px;
            animation: fadeIn 0.7s ease-in-out;
        }
        h1 {
            font-size: 28px;
            color: #00ff99;
            text-shadow: 0 0 10px #00ff99;
            margin-bottom: 10px;
            animation: slideDown 0.6s ease-in-out;
        }
        p {
            font-size: 18px;
            margin: 8px 0;
        }
        .highlight {
            font-size: 22px;
            font-weight: bold;
            color: #00ff99;
            text-shadow: 0 0 10px #00ff99;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            background: #00ff99;
            color: black;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin: 10px 5px;
            transition: 0.3s ease-in-out;
        }
        .btn:hover {
            background: #00cc77;
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 255, 150, 0.5);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Test Result</h1>
    <p>Subject: <span class="highlight"><?php echo ucfirst($subject); ?></span></p>
    <p>Your Score: <span class="highlight"><?php echo $score; ?></span> out of <span class="highlight"><?php echo $total; ?></span></p>
    <a href="http://localhost/otp/Aptitude.html" class="btn">Take Another Test</a>
    <a href="http://localhost/otp/profile-user.php" class="btn">View Profile</a>
</div>

</body>
</html>
