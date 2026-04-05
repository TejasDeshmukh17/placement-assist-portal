<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$code = $data['script'] ?? '';
$language = $data['language'] ?? '';

if (!$code || !$language) {
    echo json_encode(["output" => "Code or language is missing!"]);
    exit;
}

$file = "temp_code." . ($language === "python" ? "py" : ($language === "php" ? "php" : "c"));
file_put_contents($file, $code);

switch ($language) {
    case "python":
        $output = shell_exec("python $file 2>&1");
        break;
    case "php":
        $output = shell_exec("php $file 2>&1");
        break;
    case "c":
        shell_exec("gcc $file -o temp_code.out 2>&1");
        $output = shell_exec("./temp_code.out 2>&1");
        break;
    default:
        $output = "Unsupported language!";
}

unlink($file);
if (file_exists("temp_code.out")) unlink("temp_code.out");

echo json_encode(["output" => $output]);
