<?php
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

$filePath = __DIR__ . $uri;

// Si l'URI commence par "/api", on appelle l'API
if (strpos($uri, '/api') === 0) {
    include('api.php');
} elseif ($uri !== '/' && is_file($filePath)) {
    // Si c'est un fichier, on le sert
    return false;
} else {
    // Si ce n'est pas un fichier, on essaie avec les fichiers d'index
    $indexFiles = ['index.php', 'index.htm', 'index.html'];
    $found = false;

    foreach ($indexFiles as $indexFile) {
        $indexFilePath = $filePath . '/' . $indexFile;

        if (is_file($indexFilePath)) {
            include($indexFilePath);
            $found = true;
            break;
        }
    }

    // Si aucun fichier d'index trouvé, retourner une erreur 404
    if (!$found) {
        http_response_code(404);
        echo 'Not Found';
    }
}
