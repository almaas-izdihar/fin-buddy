<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!"); ?>

<?php
// Include the database connection
require_once 'lib/koneksi.php';

// Fetch budgets for the dropdown with user_id filter
$budgets = [];
$stmt = $conn->prepare("SELECT id, description FROM budgets WHERE user_id = ? AND soft_delete = 0");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
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

    // If "Other" is selected, use the custom description from the input
    if (isset($_POST['custom_description']) && !empty($_POST['custom_description'])) {
        $description = $_POST['custom_description'];
    }

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef;
        }
        .container {
            max-width: 1000px;
            margin-top: 50px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .submit-btn {
            margin-top: 10px;
            padding: 10px 15px;
        }
        .text-end {
            text-align: end;
        }
        /* Custom style for dropdown */
        .form-control-select {
            transition: all 0.3s ease; /* Smooth transition for hover effect */
        }
        .form-control-select:hover {
            background-color: #f1f1f1; /* Change background color on hover */
            border-color: #007bff; /* Change border color on hover */
        }
        .form-control-select:focus {
            background-color: #f8f9fa; /* Lighten background when focused */
            border-color: #007bff; /* Highlight border on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add subtle shadow for focus */
        }
        /* Hide custom description input by default */
        #custom_description_div {
            display: none;
        }
    </style>
    <script>
        // Show the custom description input if 'Other' is selected
        function toggleCustomDescription() {
            var budgetSelect = document.getElementById('budget_id');
            var customDescriptionDiv = document.getElementById('custom_description_div');
            if (budgetSelect.value == 'other') {
                customDescriptionDiv.style.display = 'block';
            } else {
                customDescriptionDiv.style.display = 'none';
            }
        }
        
        // Redirect if form submission was successful
        <?php if ($success): ?>
        window.location.href = '?page=expense';
        <?php endif; ?>
    </script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="text-center mb-4">Add New Expense</h1>
            <form action="" method="post" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="budget_id" class="form-label">Budget</label>
                    <select id="budget_id" name="budget_id" class="form-control form-control-select submit-btn" required onchange="toggleCustomDescription()">
                        <option value="">Select a Budget</option>
                        <?php foreach ($budgets as $budget): ?>
                            <option value="<?php echo $budget['id']; ?>"><?php echo $budget['description']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a budget.</div>
                </div>

                <div id="custom_description_div" class="mb-3">
                    <label for="custom_description" class="form-label">Enter Custom Description</label>
                    <input type="text" id="custom_description" name="custom_description" class="form-control submit-btn">
                    <div class="invalid-feedback">Please enter a custom description.</div>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" id="date" name="date" class="form-control submit-btn" required>
                    <div class="invalid-feedback">Please select a date.</div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" id="description" name="description" class="form-control submit-btn" placeholder="Masukkan deskripsi..." required>
                    <div class="invalid-feedback">Please enter a description.</div>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" id="amount" name="amount" class="form-control submit-btn" placeholder="Masukkan nominal..." step="1000" required>
                    <div class="invalid-feedback">Please enter a valid amount.</div>
                </div>

                <div class="text-end">
                    <button type="submit" class="submit-btn">Add Expense</button>
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
