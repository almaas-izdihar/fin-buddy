<?php if (defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!"); ?>


<div class="container">
  <h1 class="username">Hi, Asep</h1>

  <div class="card-container">
    <div class="card">
      <h1 class="card-title">Total Budget</h1>
      <?php
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      // Query to get total budget
      $sql_total_budget = "
        SELECT SUM(amount) AS total_budget
        FROM budgets
        WHERE soft_delete = 0 AND user_id = 1;
    ";
      $result_total_budget = $conn->query($sql_total_budget);
      $total_budget = $result_total_budget->fetch_assoc()['total_budget'];
      ?>
      <h3 class="card-subtitle mb-2 text-muted">Rp. <?php echo number_format($total_budget, 0, ',', '.'); ?></h3>
    </div>
    <div class="card">
      <h1 class="card-title">Total Spent</h1>
      <?php
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      // Query to get total spent
      $sql_total_spent = "
        SELECT SUM(amount) AS total_spent
        FROM expenses
        WHERE budget_id IN (SELECT id FROM budgets WHERE soft_delete = 0 AND user_id = 1);
    ";
      $result_total_spent = $conn->query($sql_total_spent);
      $total_spent = $result_total_spent->fetch_assoc()['total_spent'];
      ?>
      <h3 class="card-subtitle mb-2 text-muted">Rp. <?php echo number_format($total_spent, 0, ',', '.'); ?></h3>
    </div>
    <div class="card">
      <h1 class="card-title">Total Income</h1>
      <?php
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      // Query to get total income
      $sql_total_income = "
        SELECT SUM(amount) AS total_income
        FROM incomes
        WHERE soft_delete = 0 AND user_id = 1;
    ";
      $result_total_income = $conn->query($sql_total_income);
      $total_income = $result_total_income->fetch_assoc()['total_income'];
      ?>
      <h3 class="card-subtitle mb-2 text-muted">Rp. <?php echo number_format($total_income, 0, ',', '.'); ?></h3>
    </div>
  </div>

  <div class="card-container">
    <div class="card" style="grid-column: 1 / span 3;">
      <h1 class="card-title">Financial Overview</h1>
      <?php
      require_once "chart/src/Antoineaugusti/EasyPHPCharts/Chart.php";

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Queries to get total budget, total spent, and total income
      $sql_total_budget = "
        SELECT SUM(amount) AS total_budget
        FROM budgets
        WHERE soft_delete = 0 AND user_id = 1;
    ";
      $result_total_budget = $conn->query($sql_total_budget);
      $total_budget = $result_total_budget->fetch_assoc()['total_budget'];

      $sql_total_spent = "
        SELECT SUM(amount) AS total_spent
        FROM expenses
        WHERE budget_id IN (SELECT id FROM budgets WHERE soft_delete = 0 AND user_id = 1);
    ";
      $result_total_spent = $conn->query($sql_total_spent);
      $total_spent = $result_total_spent->fetch_assoc()['total_spent'];

      $sql_total_income = "
        SELECT SUM(amount) AS total_income
        FROM incomes
        WHERE soft_delete = 0 AND user_id = 1;
    ";
      $result_total_income = $conn->query($sql_total_income);
      $total_income = $result_total_income->fetch_assoc()['total_income'];

      // Data for the bar chart
      $data_bar = [$total_income, $total_spent, $total_budget];
      $legend_bar = ['Total Income', 'Total Expenses', 'Total Budget'];

      $BarChart = new Antoineaugusti\EasyPHPCharts\Chart('bar', 'financialBar');
      $BarChart->set('data', $data_bar);
      $BarChart->set('legend', $legend_bar);
      $BarChart->set('displayLegend', true);

      $BarChart->set('width', 600);
      $BarChart->set('height', 400);

      echo $BarChart->returnFullHTML();

      ?>
    </div>
  </div>

  <div class="card-container">
    <div class="card" style="grid-column: 1 / span 3;">
      <h1 class="card-title">Activity</h1>
      <?php
      require_once "chart/src/Antoineaugusti/EasyPHPCharts/Chart.php";

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Query to get total budget and total expenses
      $sql = "
          SELECT 
              (SELECT SUM(amount) FROM budgets WHERE soft_delete = 0 AND user_id = 1) AS total_budget,
              (SELECT SUM(amount) FROM expenses WHERE budget_id IN (SELECT id FROM budgets WHERE soft_delete = 0 AND user_id = 1)) AS total_expenses;
      ";

      $result = $conn->query($sql);
      $row = $result->fetch_assoc();

      $total_budget = $row['total_budget'];
      $total_expenses = $row['total_expenses'];
      $remaining_budget = $total_budget - $total_expenses;

      $data = [$total_expenses, $remaining_budget];
      $legend = ['Pengeluaran', 'Sisa Budget'];

      $PieChart = new Antoineaugusti\EasyPHPCharts\Chart('pie', 'examplePie');
      $PieChart->set('data', $data);
      $PieChart->set('legend', $legend);
      $PieChart->set('displayLegend', true);

      $PieChart->set('width', 600);
      $PieChart->set('height', 600);

      echo $PieChart->returnFullHTML();

      ?>
    </div>
  </div>
  <div class="card-container">
    <div class="card" style="grid-column: 1 / span 3;">
      <h1 class="card-title">Expenses</h1>
      <?php
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // New query to get expenses by category
      $sql_expenses_by_category = "
          SELECT description, SUM(amount) as total_amount
          FROM expenses
          WHERE budget_id IN (SELECT id FROM budgets WHERE soft_delete = 0 AND user_id = 1)
          GROUP BY description;
      ";

      $result_expenses_by_category = $conn->query($sql_expenses_by_category);

      $data_expenses = [];
      $legend_expenses = [];

      while ($row = $result_expenses_by_category->fetch_assoc()) {
        $data_expenses[] = $row['total_amount'];
        $legend_expenses[] = $row['description'];
      }

      $PieChartExpenses = new Antoineaugusti\EasyPHPCharts\Chart('pie', 'expensesPie');
      $PieChartExpenses->set('data', $data_expenses);
      $PieChartExpenses->set('legend', $legend_expenses);
      $PieChartExpenses->set('displayLegend', true);

      $PieChartExpenses->set('width', 600);
      $PieChartExpenses->set('height', 600);

      echo $PieChartExpenses->returnFullHTML();


      $conn->close();
      ?>
    </div>
  </div>
</div>