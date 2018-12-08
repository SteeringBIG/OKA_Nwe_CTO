	<br>
	<hr>
	<form name="serverInfo" method="POST" accept-charset="UTF-8" action="<?= $uri ?>"><br />
		<table> <!--для ровного расположения элементов -->
			<tr>
				<td><input type="hidden" name="showServerInfo" value="<?= $showInfo ?>"></td>
				<td><input type="submit" value="<?= $textBaton ?>"></td>
			</tr>
		</table>
	</form>
	
<?php
	if ($showInfo === "0") {
		echo "<br>SERVER:";
		echo "<br><br>";
		echo var_dump($_SERVER);
	}
?>