<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['periodResults'])) {
    header("Location: AdminPage.php");
    exit();
}

$results = $_SESSION['periodResults'];
unset($_SESSION['periodResults']); // Clear session data after use
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Period Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="AdminPage.php">Back to Admin Page</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Period Search Results</h2>
        <?php if (empty($results)): ?>
            <p class="text-center mt-4">No reservations found for the specified period.</p>
        <?php else: ?>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <?php foreach (array_keys($results[0]) as $column): ?>
                                <th><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $column))); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <?php foreach ($row as $value): ?>
                                    <td><?php echo htmlspecialchars($value); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <button onclick="window.location.href='AdminPage.php'" class="btn btn-primary mt-4">Return to Admin Page</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
