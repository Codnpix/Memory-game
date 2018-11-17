<?php
session_start();
if (isset($_GET['score'])) {
    /*handle the current score value sent by the JS program*/
    $new_score = intval($_GET['score']);
    $file_path = $_SESSION['player'] .'-score.txt';
    /*in case of first score, set bestscore at 1000 to make sure enter in the condition $new_score < $current_score.*/
    if ($_SESSION['best_score'] == "---") {$_SESSION['best_score'] = 1000;}
    $current_score = $_SESSION['best_score'];
    /*update the best score in the players's score file*/
    if ($new_score < $current_score) {
        $score_file = fopen($file_path, 'w');
        fputs($score_file, $new_score);
        fclose($score_file);
    }
    /*redirect to index*/
    header('Location: index.php');
    exit;
}
else {
    echo 'error';
}