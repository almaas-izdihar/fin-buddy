<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!"); ?>

<?php
// Include the database connection
require_once 'lib/koneksi.php';

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $stmt_delete = $conn->prepare("UPDATE incomes SET soft_delete = 1 WHERE id = ?");
    $stmt_delete->bind_param("i", $delete_id);
    $stmt_delete->execute();
    $stmt_delete->close();
}

// Fetch the latest income data
$user_id = 1; // Replace with dynamic user ID as needed
$sql_latest_incomes = "
    SELECT id, description, amount
    FROM incomes
    WHERE user_id = ? AND soft_delete = 0
    ORDER BY date DESC
    LIMIT 5;
";
$stmt = $conn->prepare($sql_latest_incomes);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container" style="height: 100dvh;">
    <h1 class="page-title">My Income Streams</h1>

    <div class="card-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; grid-row: 1 / 2; height: 350px;">
        <!-- Total Income Card -->
        <div class="card hover-card" onclick="window.location.href='?page=newIncome';" style="cursor: pointer;">
            <h1 class="card-title" style="margin-bottom: 40px; margin-top: 40px;">Create New Income Source</h1>
            <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000000">
                <path d="M453-280h60v-166h167v-60H513v-174h-60v174H280v60h173v166Zm27.27 200q-82.74 0-155.5-31.5Q252-143 197.5-197.5t-86-127.34Q80-397.68 80-480.5t31.5-155.66Q143-709 197.5-763t127.34-85.5Q397.68-880 480.5-880t155.66 31.5Q709-817 763-763t85.5 127Q880-563 880-480.27q0 82.74-31.5 155.5Q817-252 763-197.68q-54 54.31-127 86Q563-80 480.27-80Zm.23-60Q622-140 721-239.5t99-241Q820-622 721.19-721T480-820q-141 0-240.5 98.81T140-480q0 141 99.5 240.5t241 99.5Zm-.5-340Z"/>
            </svg>
        </div>

        <!-- Latest Income Cards -->
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card hover-card" style="cursor: pointer;">
            <h1 class="card-title" style="margin-top: 80px;"><?php echo htmlspecialchars($row['description']); ?></h1>
            <h3 class="card-subtitle mb-2 text-muted">Rp. <?php echo number_format($row['amount'], 0, ',', '.'); ?></h3>
            <form method="post" style="margin-top: 10px;">
                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="delete-btn">Delete</button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
// Close the connection
$conn->close();
?>