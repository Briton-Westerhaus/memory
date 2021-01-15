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
        echo '<form action = "index.php" method = "post">';
        echo '<table>';
        for ($i = 0; $i < $_SESSION['height']; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $_SESSION['width']; $j++) {
                if ($_SESSION['matrix'][$i][$j]['flipped'] == 1 || $_SESSION['matrix'][$i][$j]['temp'] == 1) {
                    echo '<td>' . $_SESSION['matrix'][$i][$j]['card'] . '</td>';
                } else {
                    if ($isshow)
                        echo '<td><img src = "memblank.png" /></td>';
                    else
                        echo '<td><button type="submit" name="submit" value="' . "this:" . $i . ":" . $j . '">'."<!--:$i:$j:--><img src".' = "memblank.png" /></button></td>';
                    
                }
            }
            echo "</tr>";
        }
        echo '</table><br />';
        if ($isshow)
            echo '<input type = "submit" name = "submit" value = "Flip back over" />';
        echo '<input type = "submit" name = "submit" value = "Reset" /></form>';
    }

    function setMatrix($height, $width) {
        $_SESSION['height'] = $height;
        $_SESSION['width'] = $width;
        $array_size = $_SESSION['width'] * $_SESSION['height'] / 2;
        $used = array_fill(0, $array_size, 0);
        $_SESSION['matrix'] = array_fill(0, $_SESSION['height'], array_fill(0, $_SESSION['width'], array('card' => 0, 'flipped' => 0)));
        //array( (array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)));
        for ($i = 0; $i < $_SESSION['height']; $i++) {
            for ($j = 0; $j < $_SESSION['width']; $j++) {
                $temp = rand(0, $array_size - 1);
                while ($used[$temp] >= 2) {
                    $temp = rand(0, $array_size - 1);
                }
                $used[$temp]++;
                $_SESSION['matrix'][$i][$j]['card'] = '<image src = "mem' . $temp . '.png" />';
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