<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!"); ?>

<?php
// Include the database connection
require_once 'lib/koneksi.php';

// Fetch budgets for the dropdown
$budgets = [];
$result = $conn->query("SELECT id, description FROM budgets");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $budgets[] = $row;
    }
}

// Check if the form is submitted
$success = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $budget_id = $_POST['budget_id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO expenses (budget_id, date, description, amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $budget_id, $date, $description, $amount);

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
    <title>New Expense</title>
    <script>
        // Redirect if form submission was successful
        <?php if ($success): ?>
        window.location.href = '?page=expense';
        <?php endif; ?>
    </script>
</head>
<body>
    <h1>Add New Expense</h1>
    <form action="" method="post">
        <label for="budget_id">Budget:</label>
        <select id="budget_id" name="budget_id" required>
            <?php foreach ($budgets as $budget): ?>
                <option value="<?php echo $budget['id']; ?>"><?php echo $budget['description']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required><br><br>

        <input type="submit" value="Add Expense">
    </form>
</body>
</html>