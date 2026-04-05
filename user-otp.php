<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: url('img/Pattern/logo.png') no-repeat center center fixed;
            background-size: cover;
        }
        .auth-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: rgba(30, 30, 30, 0.9);
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 255, 150, 0.3);
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }
        .alert-success, .alert-danger {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .alert-success {
            background: rgba(0, 255, 150, 0.2);
            color: #00ff99;
            border: 1px solid #00ff99;
        }
        .alert-danger {
            background: rgba(255, 0, 0, 0.2);
            color: #ff6666;
            border: 1px solid #ff6666;
        }
        .form-control {
            border-radius: 8px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        .btn-primary {
            background: #00ff99;
            border: none;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
            width: 100%;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #00cc77;
            transform: scale(1.05);
            box-shadow: 0px 0px 12px rgba(0, 255, 150, 0.5);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <h2 class="text-center text-white">Code Verification</h2>

        <?php if(isset($_SESSION['info'])): ?>
            <div class="alert alert-success text-center">
                <?php echo $_SESSION['info']; ?>
            </div>
        <?php endif; ?>

        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger text-center">
                <?php foreach($errors as $showerror) echo $showerror; ?>
            </div>
        <?php endif; ?>

        <form action="user-otp.php" method="POST" autocomplete="off">
            <div class="form-group">
                <input class="form-control" type="number" name="otp" placeholder="Enter verification code" required>
            </div>
            <button class="btn-primary" type="submit" name="check">Submit</button>
        </form>
    </div>

</body>
</html>
