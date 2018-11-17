<?php
session_start();
if (isset($_GET['score'])) {
    $new_score = intval($_GET['score']);
    $file_path = $_SESSION['player'] .'-score.txt';
    if ($_SESSION['best_score'] == "---") {$_SESSION['best_score'] = 1000;}
    $current_score = $_SESSION['best_score'];
    if ($new_score < $current_score) {
        $score_file = fopen($file_path, 'w');
        fputs($score_file, $new_score);
        fclose($score_file);
    }
    header('Location: index.php');
    exit;
}
else {
    echo 'error';
}