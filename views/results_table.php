<?php

include __DIR__ . '/../database_config.php'; 
$sql = "SELECT * FROM status_history";
$statement = $db->query($sql);
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<html lang="pl-PL">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Changes made to the Registry</title>
		<h2>Changes made to the Registry</h2>
			<table style='border: 1px solid black; border-collapse: collapse'>
				<tr>
					<th style='border: 1px solid black'>ID</th>
					<th style='border: 1px solid black'>Name</th>
					<th style='border: 1px solid black'>Entity type</th>
					<th style='border: 1px solid black'>Previous status</th>
					<th style='border: 1px solid black'>Current status</th>
					<th style='border: 1px solid black'>Change date</th>
				</tr>
				<?php 
				foreach ($data as $result) {
					echo 
					"<tr>
					<td style='border: 1px solid black'>" . $result["registry_no"] . "</td>
					<td style='border: 1px solid black'>" . $result["name"] . "</td> 
					<td style='border: 1px solid black'>" . $result["entity_type"] . "</td>
					<td style='border: 1px solid black'>" . $result["old_status"] . "</td> 
					<td style='border: 1px solid black'>" . $result["new_status"] . "</td>
					<td style='border: 1px solid black'>" . $result["change_date"] . "</td>
					</tr>";
				} ?>
			</table>
	</head>
</html>