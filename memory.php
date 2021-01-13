<?php
    function displayBoard($isshow) {
        echo "<p>Turns: " . $_SESSION['turn_count'];
        echo '<form action = "index.php" method = "post">';
        echo '<table>';
        for ($i = 0; $i < 4; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 5; $j++) {
                if ($_SESSION['matrix'][$i][$j]['flipped'] == 1 || $_SESSION['matrix'][$i][$j]['temp'] == 1) {
                    echo '<td>' . $_SESSION['matrix'][$i][$j]['card'] . '</td>';
                } else {
                    if ($isshow)
                        echo '<td><img src = "memblank.bmp" /></td>';
                    else
                        echo '<td><button type="submit" name="submit" value="' . "this:" . $i . ":" . $j . '">'."<!--:$i:$j:--><img src".' = "memblank.bmp" /></button></td>';
                    
                }
            }
            echo "</tr>";
        }
        echo '</table><br />';
        if ($isshow)
            echo '<input type = "submit" name = "submit" value = "Flip back over" />';
        echo '<input type = "submit" name = "submit" value = "Reset" /></form>';
    }

    function setMatrix() {
        $used = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $_SESSION['matrix'] = array(array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)));
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $temp = rand(0, 9);
                while ($used[$temp] >= 2) {
                    $temp = rand(0, 9);
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
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $_SESSION['matrix'][$i][$j]['temp'] = 0;
            }
        }
	}
?>