// Validating filter names + values
$invalid_filters = [];
if (!validateFilters($database_table, $filters, $invalid_filters))
{
    sendResponse(400, "Error, invalid filters: " . $invalid_filters);
    exit;
}

// Initialization
$query = "SELECT * FROM $database_table WHERE ";
$conditions = [];
$values = [];
foreach ($filters as $key => $value) {
    $conditions[] = "$key = :$key";
    $values[":$key"] = $value;
}

if (empty($conditions)) {
    sendResponse(400, 'Bad Request: No valid filters provided');
    exit;
}
// Filtering ends here.