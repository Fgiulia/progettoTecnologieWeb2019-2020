<?php
function save($beanName, $model) {
	global $beansMaps;

	$response = (Object) [
		"status" => false
		,"response" => "init"
	];

	$sqlTableName	= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->sqlTableName)	? $beansMaps->{$beanName}->sqlTableName	: null;
	$sqlFieldsMap	= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->sqlFieldsMap)	? $beansMaps->{$beanName}->sqlFieldsMap	: null;
	$pksMap			= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->pksMap)			? $beansMaps->{$beanName}->pksMap		: null;
	$children		= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->children)		? $beansMaps->{$beanName}->children		: null;
	$dbh			= $beanName && isset($beansMaps->{$beanName}) && isset($beansMaps->{$beanName}->dbh)			? $beansMaps->{$beanName}->dbh			: null;

	if (!$beanName) {
		$response->response = "beanName is null";
	} else if (!isset($beansMaps->{$beanName})) {
		$response->response = "bean '$beanName' not found";
	} else if (!$sqlTableName) {
		$response->response = "tableName is null";
	} else if (!$sqlFieldsMap) {
		$response->response = "fieldsMap is null";
	} else if (empty(isset($model) && $model ? $model : [])) {
		$response->response = [];
		$response->status = true;
	} else if (!$dbh) {
		$response->response = "dbh is null";
	} else {
		$models = is_array($model) ? $model : [$model];
		$rows = [];
		$query = (Object) ["status" => true]; # mi serve che inizi con true. altrimenti rischio di dare errore se non ci sono chiavi primarie.
		foreach ($models as &$model) {
			$flUpdate = false;
			if ($pksMap && count($pksMap) > 0) {
				# controllo se devo inserire o aggiornare.
				$params = [];
				$where = "";
				foreach ($pksMap as $pkName => $pk) {
					$where .= ($where != "" ? " AND " : "") . $sqlFieldsMap->{$pkName}->name;
					if (isset($model->{$pkName})) {
						$where .= " = ?";
						$params[] = $model->{$pkName};
					} else {
						$where .= " IS NULL";
					}
				}
				$sql = "SELECT NULL FROM $sqlTableName WHERE $where";
				$query = query($dbh, $sql, $params);
				if ($query->status) {
					$flUpdate = $query->rows && count($query->rows) > 0;
				} else {
					$response->response = $query->error;
					break;
				}
			}

			if ($flUpdate && $query->status) {
				# UPDATE

				$params = [];

				$values = "";
				foreach ($sqlFieldsMap as $jsField => $sqlField) {
					$value = isset($model->{$jsField}) ? $model->{$jsField} : null;
					if (isset($sqlField->options) && isset($sqlField->options->type)) switch ($sqlField->options->type) {
						case "date":
							if ($value) {
								$value = new DateTime();
								if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "mysql") {
									$value->setTimestamp(strtotime($model->{$jsField}));
									$value->setTimeStamp($value->getTimestamp() - $value->getTimezone()->getOffset($value));
								} else if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "dblib") {
									$value->setTimestamp(strtotime($model->{$jsField}));
									$value->setTimeStamp($value->getTimestamp() - $value->getTimezone()->getOffset($value));
								}
								$value = $value->format("Y-m-d H:i:s");

								$values .= ($values != "" ? "," : "") . $sqlField->name . "=?";
								$params[] = $value;
							} else {
								$values .= ($values != "" ? "," : "") . $sqlField->name . "=NULL";
							}
							break;
						case "base64":
							if (isset($sqlField->options->path) && $sqlField->options->path) {
								if ($value && isset($model->{$sqlField->options->path}) && $model->{$sqlField->options->path}) {
									if (!file_put_contents($model->{$sqlField->options->path}, base64_decode($value))) {
										throw new Exception("Failed to save blob in '" . $model->{$sqlField->options->path} . "'");
									};
									$model->{$jsField} = null; // meglio eliminare il blob...
								}
							} else {
								throw new Exception("path is null in base64field $sqlTableName." . $sqlField->name . " map");
							}
							break;
						default:
							if ($value !== null) {
								$values .= ($values != "" ? "," : "") . $sqlField->name . "=?";
								$params[] = $value;
							} else {
								$values .= ($values != "" ? "," : "") . $sqlField->name . "=NULL";
							}
					} else if ($value !== null) {
							$values .= ($values != "" ? "," : "") . $sqlField->name . "=?";
							$params[] = $value;
					} else {
						$values .= ($values != "" ? "," : "") . $sqlField->name . "=NULL";
					}
				}

				$where = "";
				foreach ($pksMap as $pkName => $pk) {
					$where .= ($where != "" ? " AND " : "") . $sqlFieldsMap->{$pkName}->name;
					if (isset($model->{$pkName})) {
						$where .= " = ?";
						$params[] = $model->{$pkName};
					} else {
						$where .= " IS NULL";
					}
				}

				$sql = "UPDATE $sqlTableName SET $values WHERE $where";
				$query = query($dbh, $sql, $params);
				if ($query->status) {
					$rows[] = $model;
				} else {
					$response->response = $query->error;
					break;
				}
			} else if ($query->status) {
				# INSERT
				$values = "";
				$params = [];

				$sqlFields = "";
				foreach ($sqlFieldsMap as $jsField => $sqlField) {
					if (isset($model->{$jsField})) {
						$value = $model->{$jsField};
						if (isset($sqlField->options) && isset($sqlField->options->type)) switch ($sqlField->options->type) {
							case "date":
								$value = new DateTime();
								if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "mysql") {
									$value->setTimestamp(strtotime($model->{$jsField}));
									$value->setTimeStamp($value->getTimestamp() - $value->getTimezone()->getOffset($value));
								} else if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == "dblib") {
									$value->setTimestamp(strtotime($model->{$jsField}));
									$value->setTimeStamp($value->getTimestamp() - $value->getTimezone()->getOffset($value));
								}
								$value = $value->format("Y-m-d H:i:s");

								$sqlFields	.= ($sqlFields != "" ? "," : "") . $sqlField->name;
								$values		.= ($values != "" ? "," : "") . "?";
								$params[]	= $value;
								break;
							case "base64":
								if (isset($sqlField->options->path) && $sqlField->options->path) {
									if ($value && isset($model->{$sqlField->options->path}) && $model->{$sqlField->options->path}) {
										if (!file_put_contents($model->{$sqlField->options->path}, base64_decode($value))) {
											throw new Exception("Failed to save blob in '" . $model->{$sqlField->options->path} . "'");
										};
										$model->{$jsField} = null; // meglio eliminare il blob...
									}
								} else {
									throw new Exception("path option is null in base64field $sqlTableName." . $sqlField->name . " map");
								}
								break;
							default:
								$sqlFields	.= ($sqlFields != "" ? "," : "") . $sqlField->name;
								$values		.= ($values != "" ? "," : "") . "?";
								$params[]	= $value;
						} else {
							$sqlFields	.= ($sqlFields != "" ? "," : "") . $sqlField->name;
							$values		.= ($values != "" ? "," : "") . "?";
							$params[]	= $value;
						}
					}
				}
				$sql = "INSERT INTO $sqlTableName ($sqlFields) VALUES ($values)";
				$query = query($dbh, $sql, $params);
				if ($query->status) {
					if ($pksMap) foreach ($pksMap as $pkName => $pk) {
						if (isset($pk->options) && isset($pk->options->autoincrement) && $pk->options->autoincrement) {
							$model->{$pkName} = $query->lastInsertId;
						}
					}
					$rows[] = $model;
				} else {
					$response->response = $query->error;
					break;
				}
			}

			if ($query->status && $children) {
				foreach ($rows as &$row) {
					foreach ($children as $childName => $child) {
						if (!(isset($child->flReadOnly) && $child->flReadOnly) && isset($row->{$childName}) && $row->{$childName}) {
							$child_models = isset($child->flGetFirst) && $child->flGetFirst ? [$row->{$childName}] : $row->{$childName};
							$fks = isset($child->fksMap) ? $child->fksMap : [];
							if ($fks && count($fks) > 0 ) foreach ($child_models as &$model) {
								foreach ($fks as $jsField => $fk) {
									if ($fk->name) {
										$model->{$jsField} = isset($row->{$fk->name}) ? $row->{$fk->name} : null;
									}
								}
								$model = (Object)$model;
							}
							$save = save($child->beanName, $child_models);
							if ($save->status) {
								$row->{$childName} = isset($child->flGetFirst) && $child->flGetFirst ? $save->response[0] : $save->response;
							} else {
								$response = $save;
								$query->status = false;
								break;
							}
						} else {
							$row->{$childName} = isset($child->flGetFirst) && $child->flGetFirst ? null : [];
						}
					}
					if (!$query->status) {
						break;
					}
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