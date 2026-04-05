<?php
include('db/config.php'); // make sure this path is correct

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MCQ Test | Select Subject</title>
  <link rel="stylesheet" href="css/style1.css"/>

  <style>
    body {
      background-color: #121212;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }
    .select-box {
      background: #1e1e1e;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0, 255, 150, 0.15);
      width: 90%;
      max-width: 500px;
      text-align: center;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    select, button {
      width: 100%;
      padding: 15px;
      margin: 15px 0;
      border-radius: 8px;
      border: none;
      font-size: 16px;
    }
    select {
      background: #2a2a2a;
      color: #fff;
    }
    button {
      background: #00ff99;
      color: #000;
      cursor: pointer;
    }
    button:hover {
      background: #00cc77;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 25px;
      background: #00ff99;
      color: #000;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      text-decoration: none;
    }
    .btn:hover {
      background: #00cc77;
    }
  </style>
</head>
<body>
  <div class="select-box">
    <h2>Start Your Test</h2>
    <form action="test.php" method="GET">
      <label for="subject">Select Subject:</label>
      <select name="subject" id="subject" required>
        <option value="">-- Select Subject --</option>
        <?php
        // Fetch subjects dynamically
        $query = "SELECT DISTINCT subject FROM questions";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['subject'] . "'>" . ucfirst($row['subject']) . "</option>";
          }
        } else {
          echo "<option disabled>No subjects available</option>";
        }
        ?>
      </select>
      <button type="submit">Start Test</button>
    </form>
  </div>
  <a href="test_history.php" class="btn">View Test History</a>
</body>  
</html>
