<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!"); ?>

<?php
// Include the database connection
require_once 'lib/koneksi.php';

// Initialize variables
$success = false;
$budget_id = $_GET['budget_id'] ?? null;
$description = '';
$amount = 0.00;

// Fetch existing budget data
if ($budget_id) {
    $stmt = $conn->prepare("SELECT description, amount FROM budgets WHERE id = ? AND soft_delete = 0");
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $stmt->bind_result($description, $amount);
    $stmt->fetch();
    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE budgets SET description = ?, amount = ? WHERE id = ?");
    $stmt->bind_param("sdi", $description, $amount, $budget_id);

    // Execute the statement
    if ($stmt->execute()) {
        $success = true; // Set success flag
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Budget</title>
    <script>
        // Redirect if form submission was successful
        <?php if ($success): ?>
        window.location.href = '?page=budget';
        <?php endif; ?>
    </script>
</head>
<body>
    <h1>Edit Budget</h1>
    <form action="" method="post">
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($description); ?>" required><br><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" value="<?php echo htmlspecialchars($amount); ?>" required><br><br>

        <input type="submit" value="Update Budget">
    </form>
</body>
</html>