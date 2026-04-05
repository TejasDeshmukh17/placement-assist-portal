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

$sql_scores = "SELECT subject, score, test_date FROM mcq_test.test_results WHERE user_id = '$user_id' ORDER BY test_date ASC";
$result_scores = mysqli_query($con, $sql_scores);

$test_results = [];
$subjects = [];
$progress = [];

if ($result_scores && mysqli_num_rows($result_scores) > 0) {
    while ($row = mysqli_fetch_assoc($result_scores)) {
        $test_results[] = $row;
        if (!isset($subjects[$row['subject']])) {
            $subjects[$row['subject']] = ['first' => $row['score'], 'last' => $row['score']];
        } else {
            $subjects[$row['subject']]['last'] = $row['score'];
        }
    }
}

$totalProgress = 0;
$subjectCount = count($subjects);

foreach ($subjects as $subject => $scores) {
    $initial = $scores['first'];
    $latest = $scores['last'];
    
    if ($initial == 0) {
        $progress[$subject] = 100;  
    } else {
        $progress[$subject] = round((($latest - $initial) / $initial) * 100, 2);
    }
    $totalProgress += $progress[$subject];
}

$overallProgress = ($subjectCount > 0) ? round($totalProgress / $subjectCount, 2) : 0;

$test_results_json = json_encode($test_results);
$subjects_json = json_encode(array_keys($subjects));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Graph - <?= htmlspecialchars($user['name']) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            text-align: center;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 900px;
            background: #1e1e1e;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 0 15px rgba(0, 255, 150, 0.3);
            position: relative;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeIn 0.8s ease-in-out forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .progress-box {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 255, 150, 0.1);
            padding: 10px 15px;
            border-radius: 10px;
            font-weight: bold;
            color: #00ff99;
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards 0.5s;
        }
        h2 {
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards 0.3s;
        }
        canvas {
            max-width: 100%;
            margin-top: 20px;
        }
        .filters {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
            align-items: center;
        }
        select {
            padding: 10px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        select:hover {
            transform: scale(1.05);
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }
        .back {
            background: #00ff99;
            color: black;
            box-shadow: 0px 4px 10px rgba(0, 255, 150, 0.3);
        }
        .back:hover {
            background: #00cc77;
            transform: scale(1.1);
        }
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 20px;
            }
            .filters {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Test Score Graph - <?= htmlspecialchars($user['name']) ?></h2>

    <div class="progress-box">
        Progress: <span id="progress-value"><?= $overallProgress ?>%</span>
    </div>

    <div class="filters">
        <label for="subjectFilter">Select Subject:</label>
        <select id="subjectFilter" onchange="filterData()">
            <option value="all">All Subjects</option>
            <?php foreach ($subjects as $sub => $scores): ?>
                <option value="<?= htmlspecialchars($sub) ?>"><?= htmlspecialchars($sub) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <canvas id="scoreChart"></canvas>

    <a href="profile-user.php" class="btn back">Back to Profile</a>
</div>

<script>
    const testResults = <?= $test_results_json ?>;
    const ctx = document.getElementById('scoreChart').getContext('2d');

    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: testResults.map(test => test.subject), 
            datasets: [{
                label: 'Test Scores',
                data: testResults.map(test => test.score),
                backgroundColor: 'rgba(0, 255, 150, 0.5)',
                borderColor: 'rgba(0, 255, 150, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let index = tooltipItem.dataIndex;
                            let test = testResults[index];
                            return `Score: ${test.score}, Date: ${test.test_date}`;
                        }
                    }
                }
            }
        }
    });

    function filterData() {
        const subjectFilter = document.getElementById('subjectFilter').value;
        let filteredResults = testResults.filter(test => subjectFilter === "all" || test.subject === subjectFilter);
        let labels = filteredResults.map(test => test.subject);
        let scores = filteredResults.map(test => test.score);
        chart.data.labels = labels;
        chart.data.datasets[0].data = scores;
        chart.update();
    }
</script>

</body>
</html>
