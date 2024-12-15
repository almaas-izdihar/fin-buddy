<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!"); ?>

<?php
// Include the database connection
require_once 'lib/koneksi.php';

// Handle delete request for expenses
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_expense_id'])) {
    $delete_expense_id = $_POST['delete_expense_id'];
    $stmt_delete_expense = $conn->prepare("UPDATE expenses SET soft_delete = 1 WHERE id = ?");
    $stmt_delete_expense->bind_param("i", $delete_expense_id);
    $stmt_delete_expense->execute();
    $stmt_delete_expense->close();
}

// Fetch the latest expenses data
$user_id = 1; // Replace with dynamic user ID as needed
$sql_latest_expenses = "
    SELECT e.id, e.description, e.amount, b.description AS budget_description
    FROM expenses e
    JOIN budgets b ON e.budget_id = b.id
    WHERE b.user_id = ? AND e.soft_delete = 0
    ORDER BY e.id DESC
    LIMIT 5;
";
$stmt_expenses = $conn->prepare($sql_latest_expenses);
$stmt_expenses->bind_param("i", $user_id);
$stmt_expenses->execute();
$result_expenses = $stmt_expenses->get_result();

// Close the connection
$conn->close();
?>

<div class="container">
    <h1 class="page-title">My Expenses</h1>

    <div class="card-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; grid-row: 1 / 2; height: 350px;">
        <!-- Add Expense Card -->
        <div class="card hover-card" onclick="window.location.href='?page=newExpense';" style="cursor: pointer;">
            <h1 class="card-title" style="margin-bottom: 40px;margin-top: 40px;">Add New Expense</h1>
            <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000000"><path d="M453-280h60v-166h167v-60H513v-174h-60v174H280v60h173v166Zm27.27 200q-82.74 0-155.5-31.5Q252-143 197.5-197.5t-86-127.34Q80-397.68 80-480.5t31.5-155.66Q143-709 197.5-763t127.34-85.5Q397.68-880 480.5-880t155.66 31.5Q709-817 763-763t85.5 127Q880-563 880-480.27q0 82.74-31.5 155.5Q817-252 763-197.68q-54 54.31-127 86Q563-80 480.27-80Zm.23-60Q622-140 721-239.5t99-241Q820-622 721.19-721T480-820q-141 0-240.5 98.81T140-480q0 141 99.5 240.5t241 99.5Zm-.5-340Z"/></svg>
        </div>

        <!-- Latest Expenses Card -->
        <?php while ($row_expense = $result_expenses->fetch_assoc()): ?>
        <div class="card hover-card" style="cursor: pointer;">
            <h1 class="card-title"><?php echo htmlspecialchars($row_expense['description']); ?></h1>
            <h3 class="card-subtitle mb-2 text-muted">Rp. <?php echo number_format($row_expense['amount'], 0, ',', '.'); ?></h3>
            <p class="card-text">Budget: <?php echo htmlspecialchars($row_expense['budget_description']); ?></p>
            <form method="post" style="margin-top: 10px;">
                <input type="hidden" name="delete_expense_id" value="<?php echo $row_expense['id']; ?>">
                <button type="submit" class="delete-btn">Delete</button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>
</div>