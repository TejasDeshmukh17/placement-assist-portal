<?php
include('../db/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $subject = $_POST['subject'];
  $question = $_POST['question'];
  $option_a = $_POST['option_a'];
  $option_b = $_POST['option_b'];
  $option_c = $_POST['option_c'];
  $option_d = $_POST['option_d'];
  $correct = $_POST['correct_answer'];

  $sql = "INSERT INTO questions (subject, question, option_a, option_b, option_c, option_d, correct_answer) 
          VALUES ('$subject', '$question', '$option_a', '$option_b', '$option_c', '$option_d', '$correct')";

  mysqli_query($conn, $sql);
  $message = "Question added successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/style1.css" />
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes glow {
      0% { box-shadow: 0 0 5px rgba(0, 255, 150, 0.3); }
      50% { box-shadow: 0 0 20px rgba(0, 255, 150, 0.6); }
      100% { box-shadow: 0 0 5px rgba(0, 255, 150, 0.3); }
    }

    body {
      background: #121212;
      font-family: 'Poppins', sans-serif;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .admin-box {
      background: #1f1f1f;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0, 255, 150, 0.2);
      width: 90%;
      max-width: 600px;
      animation: fadeIn 0.8s ease-in-out;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #00ff99;
    }
    input, select, textarea {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      background: #2a2a2a;
      border: none;
      color: #fff;
      border-radius: 8px;
      transition: 0.3s;
    }
    input:focus, select:focus, textarea:focus {
      outline: none;
      transform: scale(1.02);
      box-shadow: 0 0 8px rgba(0, 255, 150, 0.5);
    }
    button {
      background: #00ff99;
      color: #000;
      padding: 12px 25px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s ease-in-out;
      animation: glow 2s infinite alternate;
    }
    button:hover {
      background: #00cc77;
      transform: scale(1.05);
    }
    .message {
      color: #00ff99;
      text-align: center;
      animation: fadeIn 0.5s ease-in-out;
    }
  </style>
</head>
<body>

  <div class="admin-box">
    <h1>Admin Dashboard</h1>
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
      <label>Select Subject</label>
      <select name="subject" required>
        <option value="java">Java</option>
        <option value="dsa">DSA</option>
        <option value="cpp">C++</option>
        <option value="c">C</option>
        <option value="mysql">MySQL</option>
      </select>
      <label>Question</label>
      <textarea name="question" placeholder="Enter your question here..." required></textarea>
      <label>Option A</label>
      <input type="text" name="option_a" placeholder="Enter option A" required>
      <label>Option B</label>
      <input type="text" name="option_b" placeholder="Enter option B" required>
      <label>Option C</label>
      <input type="text" name="option_c" placeholder="Enter option C" required>
      <label>Option D</label>
      <input type="text" name="option_d" placeholder="Enter option D" required>
      <label>Correct Answer</label>
      <select name="correct_answer" required>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>
      <button type="submit">Add Question</button>
    </form>
  </div>

</body>
</html>
