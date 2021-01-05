<?php
    function displayBoard($isshow) {
        echo '<form action = "index.php" method = "post">';
        echo '<table border = "border">';
        for ($i = 0; $i < 4; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 4; $j++) {
                if ($_SESSION['matrix'][$i][$j]['flipped'] == 1 || $_SESSION['matrix'][$i][$j]['temp'] == 1) {
                    echo '<td>' . $_SESSION['matrix'][$i][$j]['card'] . '</td>';
                } else {
                    if ($isshow == 0)
                        echo '<td><button type="submit" name="submit" value="' . "this:" . $i . ":" . $j . '">'."<!--:$i:$j:--><img src".' = "memblank.bmp" /></button></td>';
                    if ($isshow == 1)
                        echo '<td><img src = "memblank.bmp" /></td>';
                }
            }
            echo "</tr>";
        }
        echo '</table><br />';
        if ($isshow == 1)
            echo '<input type = "submit" name = "submit" value = "Flip back over" />';
        echo '<input type = "submit" name = "submit" value = "Reset" /></form>';
    }

    function setMatrix() {
        $used = array(0, 0, 0, 0, 0, 0, 0, 0);
        $_SESSION['matrix'] = array(array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)), array(array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0), array('card' => 0, 'flipped' => 0)));
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $temp = rand(0, 7);
                while ($used[$temp] >= 2) {
                    $temp = rand(0, 7);
                }
                $used[$temp]++;
                $_SESSION['matrix'][$i][$j]['card'] = '<image src = "mem' . $temp . '.bmp" />';
            }
        }
        $_SESSION['flipped'] = 0;
    }

    function flippy() {
        $_SESSION['flipped'] = 0;
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $_SESSION['matrix'][$i][$j]['temp'] = 0;
            }
        }
				}
?>