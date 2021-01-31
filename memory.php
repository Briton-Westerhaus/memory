<?php
    /*
    $_SESSION variables:
    matrix - the 2d array of the cards and their info
    turn_count - the number of turns the player has taken
    flipped - the number of flipped cards
    height - height of the game matrix
    width - width of the game matrix.
    */

    function displayBoard($isshow) {
        echo "<p>Turns: " . $_SESSION['turn_count'];
        echo '<form action="index.php" method="post" id="TheForm">';
        echo '<div class="aspect-ratio-maintainer">';
        echo '<div class="inner-ratio-maintainer">';
        echo '<table>';
        for ($i = 0; $i < $_SESSION['height']; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $_SESSION['width']; $j++) {
                if ($_SESSION['matrix'][$i][$j]['temp'] == 1) {
                    echo '<td id="Flipper"><img src="memblank.png" /><img src="' . $_SESSION['matrix'][$i][$j]['card'] . '" /></td>';
                    $_SESSION['matrix'][$i][$j]['temp']++;
                } else if ($_SESSION['matrix'][$i][$j]['flipped'] == 1 || $_SESSION['matrix'][$i][$j]['temp'] > 0) {
                    echo '<td><img src="' . $_SESSION['matrix'][$i][$j]['card'] . '" /></td>';
                } else {
                    if ($isshow)
                        echo '<td><img src = "memblank.png" /></td>';
                    else
                        echo '<td><button type="submit" name="submitButton" value="' . "this:" . $i . ":" . $j . '">'."<!--:$i:$j:--><img src".' = "memblank.png" /></button></td>';
                    
                }
            }
            echo "</tr>";
        }
        echo '</table>';
        echo '</div>';
        echo '</div>';
        if ($isshow) {
            echo '<input type="hidden" name="submitButton" value="Flip back over" />';
            echo '<script type="text/javascript">displayNotification("Flipping back over in 5 seconds.");';   
            echo 'window.setTimeout(function() {document.getElementById("TheForm").submit();}, 5000);';
            echo '</script>';
            echo '<input type="submit" name="submitButton" value="Flip back over" />';
        }            
        echo '<input type="submit" name="submitButton" value="New Game" /></form>';
        $gameEnd = true;
        for ($i = 0; $i < $_SESSION['height']; $i++) {
            for ($j = 0; $j < $_SESSION['width']; $j++) {
                if ($_SESSION['matrix'][$i][$j]['flipped'] == 0) {
                    $gameEnd = false;
                    break;
                }
                if (!$gameEnd)
                    break;
            }
        }
        if ($gameEnd)
            echo '<script type="text/javascript">displayNotification("You have won in ' . $_SESSION['turn_count'] . ' moves!");</script>';
    }

    function setMatrix($height, $width) {
        $_SESSION['height'] = $height;
        $_SESSION['width'] = $width;
        $_SESSION['flipped'] = 0;
        echo '<style type="text/css">';
        echo '  .aspect-ratio-maintainer {';
        echo '    padding-bottom: ' . ($_SESSION['height'] / $_SESSION['width'] * 100) . '%;';
        echo '  }';
        echo '	td {';
        echo '		height: ' . (100 / $_SESSION['height']) . '%;';
        echo '		width: ' . (100 / $_SESSION['width']) . '%;';
        echo '	}';
        echo '</style>';
        $array_size = $_SESSION['width'] * $_SESSION['height'] / 2;
        $used = array_fill(0, $array_size, 0);
        $_SESSION['matrix'] = array_fill(0, $_SESSION['height'], array_fill(0, $_SESSION['width'], array('card' => 0, 'flipped' => 0)));
        
        for ($i = 0; $i < $_SESSION['height']; $i++) {
            for ($j = 0; $j < $_SESSION['width']; $j++) {
                $temp = rand(0, $array_size - 1);
                while ($used[$temp] >= 2) {
                    $temp = rand(0, $array_size - 1);
                }
                $used[$temp]++;
                $_SESSION['matrix'][$i][$j]['card'] = 'mem' . $temp . '.png';
            }
        }
        $_SESSION['flipped'] = 0;
        $_SESSION['turn_count'] = 0;
    }

    function flippy() {
        $_SESSION['flipped'] = 0;
        for ($i = 0; $i < $_SESSION['height']; $i++) {
            for ($j = 0; $j < $_SESSION['width']; $j++) {
                $_SESSION['matrix'][$i][$j]['temp'] = 0;
            }
        }
	}
?>