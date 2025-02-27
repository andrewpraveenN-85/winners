<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT id, name FROM players ORDER BY RAND() LIMIT 1");
$winner = $stmt->fetch(PDO::FETCH_ASSOC);

if ($winner) {
    // Insert into winners table
    $prizes = ['$100', '$200', '$500', '$1000', 'Grand Prize'];
    $prize = $prizes[array_rand($prizes)];
    
    $stmt = $pdo->prepare("INSERT INTO winners (player_id, prize) VALUES (?, ?)");
    $stmt->execute([$winner['id'], $prize]);
    
    echo json_encode([
        'winner' => $winner['name'],
        'prize' => $prize
    ]);
} else {
    echo json_encode(['error' => 'No players found']);
}
?>