<?php
session_start();
if (isset($_POST['player'])) {
    /*remove accent from player name*/
    $trans_accent_chars = array(
                        'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    
    $player_name = htmlspecialchars(strval($_POST['player']));
    $player_name = strtr($player_name, $trans_accent_chars);
    
    $_SESSION['player'] = $player_name;
    /*open or create the score file for the player*/
    $score_file = fopen($player_name .'-score.txt', 'a+');
    $best_score = intval(fgets($score_file));
    fclose($score_file);
    
    /*if bestscore hasn't been set yet, init bestscore to ---*/
    if ($best_score == 0) {$best_score = "---";}
    
    /*store data in session to handle it in the score.php page
    * at the end of the game*/
    $_SESSION['best_score'] = $best_score;
    
    /*update the list of differents players in a file*/
    $players_list_file = fopen('players.txt', 'a+');
    
    /*check the current list of players in the file and retrieve it in an array*/
    $players_current_list = [];
    
    fseek($players_list_file, 0);
    while (!feof($players_list_file)) {
        $player = trim(fgets($players_list_file));
        array_push($players_current_list, $player);
    }
    
    /*add the player's name in the file only if it isn't already there */
    if (in_array($player_name, $players_current_list)) {
        fclose($players_list_file);
    }
    else {
        fputs($players_list_file, $player_name .PHP_EOL);
        fclose($players_list_file);
    }
    
    ?>
<!--if thename of the player has been posted from the starting form, display the game-->
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
<!--
if the player name hasn't been set yet, display the starting form : 
-->
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
                <form id ="introForm" method="post" action="index.php">
                    <label>Nom de joueur : </label><br>
                    <span id="indicationSpan"><small><i>Crée un joueur automatiquement si nouveau nom.</i></small></span>
                    <input type="text" name="player" id="inputPlayer" autofocus> 
                    <input id='choosePlayerButton' value="OK" type="submit">
                    <div id="playersList">
                        <span class="listTitle">Joueurs : </span><br>
                        <?php
//      Check the list of players in the file :
                        $players_list_file = fopen('players.txt', 'r');
                        while (!feof($players_list_file)) {
                            $player = trim(fgets($players_list_file));
//      prevent the display of an empty line :
                            if ($player != "") {
//      Check and display best score for each player :
                                $player_score_file = fopen($player .'-score.txt', 'r');
                                $player_score = fgets($player_score_file);
                                fclose($player_score_file);
                                echo '<b>' .$player .'</b> : Meilleur score &#62; ' .$player_score .' coups.<br>';
                            }
                        }
                        ?>
                    </div>
                </form>
                <script>
                    let introForm = document.getElementById("introForm");
                    let playerInput = document.getElementById('inputPlayer');
                    
                    introForm.onsubmit = function(e) {
                        let playerNameVal = document.getElementById('inputPlayer').value;
                        if (playerNameVal === "") {
                            e.preventDefault();
                            playerInput.focus();
                            playerInput.placeholder = "Entrez un nom de joueur";
                        }
                    }
                </script>
            </section>
        </section>
    </body>
</html>
<?php
}