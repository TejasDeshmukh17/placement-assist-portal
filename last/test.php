<?php 
include('db/config.php');
session_start();

if (!isset($_GET['subject'])) {
    header("Location: index.php");
    exit();
}

$subject = mysqli_real_escape_string($conn, $_GET['subject']);
$query = "SELECT * FROM mcq_test.questions WHERE subject='$subject' ORDER BY RAND() LIMIT 10";
$result = mysqli_query($conn, $query);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - <?php echo ucfirst($subject); ?></title>
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
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 600px;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 255, 150, 0.3);
            animation: fadeIn 0.5s ease-in-out;
        }
        
        /* Title */
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #00ff99;
            text-shadow: 0 0 10px #00ff99;
            animation: slideIn 0.8s ease-in-out;
        }

        /* Question Box */
        .question-box {
            background: #252525;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 255, 150, 0.2);
            transform: scale(1);
            transition: all 0.3s ease-in-out;
        }
        .question-box:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 20px rgba(0, 255, 150, 0.5);
        }

        /* Radio Buttons */
        .option {
            display: block;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
        }
        .option:hover {
            background: rgba(0, 255, 150, 0.3);
            cursor: pointer;
        }
        input[type="radio"] {
            accent-color: #00ff99;
            margin-right: 10px;
        }

        /* Submit Button */
        .btn-submit {
            background: #00ff99;
            color: black;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease-in-out;
            margin-top: 20px;
            width: 100%;
        }
        .btn-submit:hover {
            background: #00cc77;
            transform: scale(1.05);
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
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
    <h1>Test: <?php echo ucfirst($subject); ?></h1>
    <form action="result.php" method="POST">
        <input type="hidden" name="subject" value="<?php echo $subject; ?>">

        <?php foreach($questions as $index => $q): ?>
            <div class="question-box">
                <h3>Q<?php echo $index + 1; ?>. <?php echo $q['question']; ?></h3>
                <input type="hidden" name="qid[]" value="<?php echo $q['id']; ?>">

                <label class="option">
                    <input type="radio" name="answer_<?php echo $q['id']; ?>" value="A">
                    <?php echo $q['option_a']; ?>
                </label>
                <label class="option">
                    <input type="radio" name="answer_<?php echo $q['id']; ?>" value="B">
                    <?php echo $q['option_b']; ?>
                </label>
                <label class="option">
                    <input type="radio" name="answer_<?php echo $q['id']; ?>" value="C">
                    <?php echo $q['option_c']; ?>
                </label>
                <label class="option">
                    <input type="radio" name="answer_<?php echo $q['id']; ?>" value="D">
                    <?php echo $q['option_d']; ?>
                </label>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn-submit">Submit</button>
    </form>
</div>

</body>
</html>
