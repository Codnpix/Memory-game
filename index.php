<?php
session_start();
if (isset($_POST['player'])) {
    $player_name = htmlspecialchars(strval($_POST['player']));
    $_SESSION['player'] = $player_name;
    $score_file = fopen($player_name .'-score.txt', 'a+');
    $best_score = intval(fgets($score_file));
    fclose($score_file);
    if ($best_score == 0) {$best_score = "---";}
    $_SESSION['best_score'] = $best_score;
    $players_list_file = fopen('players.txt', 'a+');
    fputs($players_list_file, $player_name .";");
    fclose($players_list_file);
    
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href='style.css' rel='stylesheet' type='text/css'>
        <title></title>
    </head>
    <body>
        <main id="main">
            <aside>
            </aside>
        </main>
        
        <button id='showAllButton'>SHOW</button><span id="score"></span>
        <span id="scoreSpan"><b>Score : </b><span id="counter">--------</span></span><br>
        <span id="bestScore"><span class="playerId"><b><?php echo $player_name ?> : </b></span><small>Meilleur score : <b><?php echo $best_score ?></b> coups.</small></span>
        
    </body>
    <script src='script.js'></script>
</html>
<?php
}
else {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href='style.css' rel='stylesheet' type='text/css'>
        <title></title>
    </head>
    <body>
        <section class="modalContainer">
            <section id ='enterPlayer'>
                <form method="post" action="index.php">
                    <label>Player : </label><br>
                    <input type="text" name="player" id="inputPlayer" autofocus> 
                    <input id='choosePlayerButton' value="OK" type="submit">
                    <div id="playersList">
                        <span class="listTitle">Joueurs : </span><br>
                    <?php
                    $players_list_file = fopen('players.txt', 'r');
                    fseek($players_list_file, 0);
                    $players_list = explode(";", fgets($players_list_file));
                    for($i = 0 ; $i < (count($players_list) -1) ; $i ++) {
                        $player = $players_list[$i];
                        $player_score_file = fopen($player .'-score.txt', 'r');
                        $player_score = fgets($player_score_file);
                        fclose($player_score_file);
                        echo '<b>' .$player .'</b> : Meilleur score &#62; ' .$player_score .' coups.<br>';
                    }
                    ?>
                    </div>
                </form>
            </section>
        </section>
    </body>
</html>
<?php
}




