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

<!-- editBudget -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Budget</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
        }
        body {
            background-color: #e9ecef;
        }
        .submit-btn {
            margin-top: 10px;
            padding: 10px 15px;
        }
        .text-end {
            text-align: end;
        }
    </style>
    <script>
        // Redirect if form submission was successful
        <?php if ($success): ?>
        window.location.href = '?page=budget';
        <?php endif; ?>
    </script>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h1 class="text-center mb-4">Edit Budget</h1>
            <form action="" method="post" class="needs-validation" novalidate>
                <!-- Description Field -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <input type="text" id="description" name="description" class="form-control submit-btn" 
                           placeholder="Enter description..." 
                           value="<?php echo htmlspecialchars($description); ?>" required>
                    <div class="invalid-feedback">Please enter a description.</div>
                </div>

                <!-- Amount Field -->
                <div class="mb-3">
                    <label for="amount" class="form-label fw-bold">Amount</label>
                    <input type="number" id="amount" name="amount" class="form-control submit-btn" 
                           placeholder="Enter amount..." step="0.01" 
                           value="<?php echo htmlspecialchars($amount); ?>" required>
                    <div class="invalid-feedback">Please enter a valid amount.</div>
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary submit-btn">Update Budget</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
