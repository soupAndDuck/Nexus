<?php

global $mysqli;
include 'artifact-db.php';
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (isset($data['id'], $data['name'], $data['section_id'], $data['description'])) {
    $id = $data['id'];
    $name = htmlspecialchars(trim($data['name']), ENT_QUOTES, 'UTF-8'); // Sanitize the 'name' input
    $sectionId = $data['section_id'];
    $catalogId = isset($data['catalog_id']) && is_numeric($data['catalog_id']) ? $data['catalog_id'] : 0; // Handle null case
    $subcatalogId = isset($data['subcatalog_id']) && is_numeric($data['subcatalog_id']) ? $data['subcatalog_id'] : 0; // Handle null case
    $description = htmlspecialchars(trim($data['description']), ENT_QUOTES, 'UTF-8'); // Sanitize the 'description' input

    // Prepare and execute the update query
    $query = "
        UPDATE artifact_info
        SET name = ?, section_id = ?, catalogue_id = ?, subcat_id = ?, description = ?
        WHERE artifact_id = ?
    ";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param('siissi', $name, $sectionId, $catalogId, $subcatalogId, $description, $id);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Artifact with ID ' . $id . ' updated successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Database error on execute: ' . $stmt->error];
        }

        // Close the statement
        $stmt->close();
    } else {
        $response = ['success' => false, 'message' => 'Failed to prepare statement: ' . $mysqli->error];
    }

    // Close the connection
    $mysqli->close();
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid input. Ensure all required fields are provided.',
        'invalidFields' => [
            'id' => isset($data['id']) ? $data['id'] : null,
            'name' => isset($data['name']) ? $data['name'] : null,
            'section_id' => isset($data['section_id']) ? $data['section_id'] : null,
            'description' => isset($data['description']) ? $data['description'] : null,
        ]
    ];
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
