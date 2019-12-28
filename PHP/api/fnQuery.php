<?php

function beginTransaction($dbhs) {
	if ($dbhs) foreach ($dbhs as $dbh) {
		if ($dbh) $dbh->beginTransaction();
	}
}

function commit($dbhs) {
	if ($dbhs) foreach ($dbhs as $dbh) {
		if ($dbh) $dbh->commit();
	}
}

function rollBack($dbhs) {
	if ($dbhs) foreach ($dbhs as $dbh) {
		if ($dbh) $dbh->rollBack();
	}
}

function query($dbh, $sql, $params) {
	$params = $params ? $params : [];

	$status = false;
	$rows = null;
	$lastInsertId = null;
	$rowCount = null;
	$error = null;

	if ($dbh) {
		try {
			$sql_params = [];
			$sql_params_index_deleted = [];
			for ($sql_param_index = 0; $sql_param_index < count($params); $sql_param_index++) {
				if (isset($params[$sql_param_index])) {
					$sql_params[] = $params[$sql_param_index];
				} else {
					$sql_params_index_deleted[] = $sql_param_index;
				}
			}
			if (count($sql_params_index_deleted) > 0) {
				$sql_parts = explode("?", $sql);
				$sql = "";
				for ($sql_part_index = 0; $sql_part_index < count($sql_parts); $sql_part_index++) {
					$sql .= ($sql_part_index > 0 ? (in_array($sql_part_index - 1, $sql_params_index_deleted) ? "NULL" : "?") : "") . $sql_parts[$sql_part_index];
				}
			}
		
			// ESEGUI QUERY
			$stmt = $dbh->prepare($sql);
			$stmt->execute($sql_params);
		
			// RETURN QUERY
			$rowCount = $stmt->rowCount();
			$rows = [];
			try {
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($rows as &$row) {
					$row = (Object) array_map(function($data) {
						return isset($data) && $data && is_string($data) && !preg_match('!\S!u', $data) ? utf8_encode($data) : $data;
					}, $row);
				}
			} catch (Exception $e) {
				// Non sono in una select
			}
			$lastInsertId = $dbh->lastInsertId();
			$status = true;
		} catch (PDOException $e) {
			$error = $e->getMessage() . "\n\r\n\rMore info: \n\rSQL:\n\r\n\r$sql\n\rParams:\n\r" . json_encode($params);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	} else {
		$error = "dbh is null";
	}

	return (Object) [
		"status"		=> $status
		,"rows"			=> $rows
		,"lastInsertId"	=> $lastInsertId
		,"rowCount"		=> $rowCount
		,"error"		=> $error
	];
}

?>