<?php
session_start();
?>
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Briton Westerhaus - Memory</title>
<meta name="description" content="An online version of the memory game." />
<meta name="keywords" content="media, entertainment, fun, games" />
<meta name="author" content="Briton Westerhaus" />
<p class="titlebar"></p>
<div class="content">
<?php
$isshowing = 0;
if(!IsSet($_SESSION['matrix'])){
	setmatrix();
	View();
}
else{
	if($_SESSION['flipped'] == 0){
		$temp = explode(":", $_POST['submit']);
		$_SESSION['matrix'][$temp[1]][$temp[2]]['temp'] = 1;
		$_SESSION['flipped']++;
	}
	else{
		if($_SESSION['flipped'] == 1 && $_POST['submit'] != 'Flip back over'){
			$isshowing = 1;
			$temp = explode(":", $_POST['submit']);
			$_SESSION['matrix'][$temp[1]][$temp[2]]['temp'] = 1;
			$firsti = 5;
			$firstj = 5;
			for($i = 0; $i < 4; $i++){
				for($j = 0; $j < 4; $j++){
					if($_SESSION['matrix'][$i][$j]['temp'] == 1){
						if($firsti == 5){
							$firsti = $i;
							$firstj = $j;
						}
						else{
							if($_SESSION['matrix'][$firsti][$firstj]['card'] == $_SESSION['matrix'][$i][$j]['card']){
								$_SESSION['matrix'][$firsti][$firstj]['flipped'] = 1;
								$_SESSION['matrix'][$i][$j]['flipped'] = 1;
								flippy();
								$isshowing = 0;
							}
						}
					}
				}
			}
		}
	}
	if($_POST['submit'] == 'Reset')
		setmatrix();
	if($_POST['submit'] == 'Flip back over')
		flippy();
}
displayboard($isshowing);
function displayboard($isshow){
echo '<form action = "index.php" method = "post">';
echo '<table border = "border">';
for($i = 0; $i < 4; $i++){
	echo "<tr>";
	for($j = 0; $j < 4; $j++){
		if($_SESSION['matrix'][$i][$j]['flipped'] == 1 || $_SESSION['matrix'][$i][$j]['temp'] == 1)
			echo '<td>' . $_SESSION['matrix'][$i][$j]['card'] . '</td>';
		else{
			if($isshow == 0)
				echo '<td><button type="submit" name="submit" value="' . "this:" . $i . ":" . $j . '">'."<!--:$i:$j:--><img src".' = "memblank.bmp" /></button></td>';
			if($isshow == 1)
				echo '<td><img src = "memblank.bmp" /></td>';
		}
	}
	echo "</tr>";
}
echo '</table><br />';
if($isshow == 1)
	echo '<input type = "submit" name = "submit" value = "Flip back over" />';
echo '<input type = "submit" name = "submit" value = "Reset" /></form>';
}

function setmatrix(){
	$used = array(0, 0, 0, 0, 0, 0, 0, 0);
	$_SESSION['matrix'] = array(array(array(card => 0, flipped => 0), array(card => 0, flipped => 0), array(card => 0, flipped => 0), array(card => 0, flipped => 0)), array(array(card => 0, flipped => 0), array(card => 0, flipped => 0), array(card => 0, flipped => 0), array(card => 0, flipped => 0)), array(array(card => 0, flipped => 0), array(card => 0, flipped => 0), array(card => 0, flipped => 0), array(card => 0, flipped => 0)), array(array(card => 0, flipped => 0), array(card => 0, flipped => 0), array(card => 0, flipped => 0), array(card => 0, flipped => 0)));
	for($i = 0; $i < 4; $i++){
		for($j = 0; $j < 4; $j++){
			$temp = rand(0, 7);
			while($used[$temp] >= 2){
				$temp = rand(0, 7);
			}
			$used[$temp]++;
			$_SESSION['matrix'][$i][$j]['card'] = '<image src = "mem' . $temp . '.bmp" />';
		}
	}
	$_SESSION['flipped'] = 0;
}
function flippy(){
	$_SESSION['flipped'] = 0;
	for($i = 0; $i < 4; $i++){
		for($j = 0; $j < 4; $j++){
			$_SESSION['matrix'][$i][$j]['temp'] = 0;
		}
	}
}
?>
<br />
<a href="comment.php?category=games&content=Memory">Comment</a>
<br />
<?php
	if(file_exists("comments/games/Memory")):
	$comments = fopen("comments/games/Memory", "r+");
		$oneline = fgets($comments);
		echo "<b>Comments: $oneline ";
		$oneline = fgets($comments);
		echo "Average Rating: $oneline</b><br />";
		$oneline = fgets($comments);
	endif;
?>
</div>
</center>
</div>
</body>
</html>