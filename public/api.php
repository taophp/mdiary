<?php
require_once 'classes/FileService.php';

require_once 'config.php';
$fileService = new FileService($root);

header('Content-Type: application/json');

$requestUrl = $_SERVER['REQUEST_URI'];
$path = str_replace('/api', '', strtok($requestUrl, '?'));

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $response['content'] = $fileService->read($path);
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if (json_last_error() != JSON_ERROR_NONE) {
                throw new Exception('Error in JSON: '.json_last_error_msg());
            }
            if (!array_key_exists('type', $data) || !in_array($data['type'], ['file', 'directory'])) {
                throw new Exception('Error in request: no creation type or invalide type set');
            }
            $fileService->create($path, $data['type'] === 'directory' ? null : ($data['content'] ?? ''));
            break;
        case 'DELETE':
            $fileService->delete($path);
            break;
        default:
            echo json_encode(['error' => 'Invalid request method']);
            exit;
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

if (empty($response)) {
    $response = ['success' => true];
}

echo json_encode($response);