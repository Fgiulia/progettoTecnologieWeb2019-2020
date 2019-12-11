<?php
function find($beanName, $model) {
	global $beansMaps;

	$response = (Object) [
		"status" => false
		,"response" => "init"
	];

	$sqlTableName	= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->sqlTableName)	? $beansMaps->{$beanName}->sqlTableName	: null;
	$sqlFieldsMap	= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->sqlFieldsMap)	? $beansMaps->{$beanName}->sqlFieldsMap	: null;
	$joins			= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->joins)			? $beansMaps->{$beanName}->joins		: [];
	$children		= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->children)		? $beansMaps->{$beanName}->children		: null;
	$dbh			= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->dbh)			? $beansMaps->{$beanName}->dbh			: null;

	$virgoletta_open = "";
	$virgoletta_close = "";
	if (!$beanName) {
		$response->response = "beanName is null";
	} else if (!isset($beansMaps->{$beanName})) {
		$response->response = "bean '$beanName' not found";
	} else if (!$sqlTableName) {
		$response->response = "tableName is null";
	} else if (!$sqlFieldsMap) {
		$response->response = "fieldsMap is null";
	} else if (!$dbh) {
		$response->response = "dbh is null";
	} else {
		if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "mysql") {
			$virgoletta_open = "`";
			$virgoletta_close = "`";
		} else if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "dblib") {
			$virgoletta_open = "[";
			$virgoletta_close = "]";
		} else {
			$virgoletta_open = "`";
			$virgoletta_close = "`";
		}
		$sqlFields = "";
		foreach ($sqlFieldsMap as $jsField => $sqlField) {
			$sqlFieldName = $sqlField->name;
			if (isset($sqlField->options) && isset($sqlField->options->type)) switch ($sqlField->options->type) {
				case "date":
					$sqlFieldName = "$virgoletta_open$sqlFieldName$virgoletta_close";
					if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "mysql") {
						$sqlFieldName = "DATE_FORMAT($sqlFieldName, '%Y-%m-%dT%TZ')"; # nella insert date("c", strtotime($sqldata['time']));
					} else if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "dblib") {
						$sqlFieldName = "CASE WHEN $sqlFieldName IS NULL THEN NULL ELSE CONVERT(VARCHAR(19), $sqlFieldName, 126) + 'Z' END";
					}
					break;
				case "base64":
					$sqlFieldName = "NULL";
					break;
				default:
					$sqlFieldName = "$virgoletta_open$sqlFieldName$virgoletta_close";
			} else {
				$sqlFieldName = "$virgoletta_open$sqlFieldName$virgoletta_close";
			}
			$sqlFields .= ($sqlFields != "" ? "," : "") . "$sqlFieldName AS $virgoletta_open$jsField$virgoletta_close";
		}

		$sql_joins = "";
		if ($joins) foreach ($joins as $joinTable => $join) {
			if (isset($join->joinFieldsMap) && $join->joinFieldsMap && count($join->joinFieldsMap) > 0) foreach ($join->joinFieldsMap as $jsField => $joinData) {
				$sqlField = $beansMaps->{$join->beanName}->sqlFieldsMap->{$joinData->name};
				$sqlFieldName = $sqlField->name;
				if (isset($sqlField->options) && isset($sqlField->options->type)) switch ($sqlField->options->type) {
					case "date":
						$sqlFieldName = "$virgoletta_open$sqlFieldName$virgoletta_close";
						if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "mysql") {
							$sqlFieldName = "DATE_FORMAT($sqlFieldName, '%Y-%m-%dT%TZ')"; # nella insert date("c", strtotime($sqldata['time']));
						} else if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "dblib") {
							$sqlFieldName = "CASE WHEN $sqlFieldName IS NULL THEN NULL ELSE CONVERT(VARCHAR(19), $sqlFieldName, 126) + 'Z' END";
						}
						break;
					case "base64":
						$sqlFieldName = "NULL";
						break;
					default:
						$sqlFieldName = "$virgoletta_open$sqlFieldName$virgoletta_close";
				} else {
					$sqlFieldName = "$virgoletta_open$sqlFieldName$virgoletta_close";
				}
				$sqlFields .= ($sqlFields != "" ? "," : "") . "$sqlFieldName AS $virgoletta_open$jsField$virgoletta_close";
			}
			$sql_joins .= " " . $join->type . " JOIN $virgoletta_open" . $beansMaps->{$join->beanName}->sqlTableName . "$virgoletta_close AS $virgoletta_open$joinTable"."s$virgoletta_close ON 1=1";
			if (isset($join->onFieldsMap) && $join->onFieldsMap && count($join->onFieldsMap) > 0) foreach ($join->onFieldsMap as $jsField => $joinData) {
				$sql_joins .= " AND ";
				$sql_joins .= "$virgoletta_open$beanName"."s$virgoletta_close.$virgoletta_open" . $beansMaps->{$beanName}->sqlFieldsMap->{$jsField}->name . $virgoletta_close;
				$sql_joins .= " " . $joinData->operator . " ";
				$sql_joins .= "$virgoletta_open$joinTable"."s$virgoletta_close.$virgoletta_open" . $beansMaps->{$join->beanName}->sqlFieldsMap->{$joinData->name}->name . $virgoletta_close;
			}
		}

		$params = [];
		$where = "";
		if ($model) {
			$models = is_array($model) ? $model : [$model];
			foreach ($models as $model) {
				$model = (Array) $model;
				$where .= ($where != "" ? " OR " : "") . "(1=1";
				foreach ($model as $key => $value) {
					if (isset($sqlFieldsMap->{$key}) && isset($value)) {
						$where .= " AND $virgoletta_open" . $sqlFieldsMap->{$key}->name . "$virgoletta_close = ?";
						$params[] = $value;
					}
				}
				$where .= ")";
			}
		}
		$where = $where ? "WHERE $where" : "";

		$sql = "SELECT $sqlFields FROM $virgoletta_open$sqlTableName$virgoletta_close AS $virgoletta_open$beanName"."s$virgoletta_close$sql_joins $where";
		$query = query($dbh, $sql, $params);
		$rows = [];
		if ($query->status) {
			$rows = $query->rows && count($query->rows) > 0 ? $query->rows : [];
		} else {
			$response->response = $query->error;
		}

		if ($query->status && $children) {
			foreach ($rows as &$row) {
				foreach ($children as $childName => $child) {
					$model = (Object) [];
					$fks = isset($child->fksMap) ? $child->fksMap : [];

					$fl_ci_rinuncio = false;
					foreach ($fks as $jsField => $fk) {
						if ($fk->name && isset($row->{$fk->name})) {
							@$model->{$jsField} = $row->{$fk->name};
						} else {
							# TODO: CRIBBIO. non supporto i null nei model!
							$fl_ci_rinuncio = true;
							break;
						}
					}
					if ($fl_ci_rinuncio) {
						$row->{$childName} = isset($child->flGetFirst) && $child->flGetFirst ? null : [];
					} else {
						$find = find($child->beanName, [$model]);
						if ($find->status) {
							$row->{$childName} = isset($child->flGetFirst) && $child->flGetFirst ? (count($find->response) > 0 ? $find->response[0] : null) : $find->response;
						} else {
							$response = $find;
							$query->status = false;
							break;
						}
					}
				}
				if (!$query->status) {
					break;
				}
			}
		}

		if ($query->status) {
			$response->response = $rows;
			$response->status = true;
		}
	}
	return $response;
}
?>