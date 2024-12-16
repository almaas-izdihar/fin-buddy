<?php
if (defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");

?>


<div class="container">
  <h1 class="username">Hi, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>

  <div class="card-container">
    <div class="card">
      <h1 class="card-title">Total Budget</h1>
      <?php

      // Query to get total budget
      $sql_total_budget = "
      SELECT SUM(amount) AS total_budget
      FROM budgets
      WHERE soft_delete = 0 AND user_id = ?;
    ";
      $stmt_total_budget = $conn->prepare($sql_total_budget);
      $stmt_total_budget->bind_param("i", $user_id);
      $stmt_total_budget->execute();
      $result_total_budget = $stmt_total_budget->get_result();
      $total_budget = $result_total_budget->fetch_assoc()['total_budget'];
      ?>
      <h3 class="card-subtitle mb-2 text-muted">Rp. <?php echo number_format($total_budget, 0, ',', '.'); ?></h3>
    </div>
    <div class="card">
      <h1 class="card-title">Total Spent</h1>
      <?php

      // Query to get total spent
      $sql_total_spent = "
        SELECT SUM(amount) AS total_spent
        FROM expenses
        WHERE budget_id IN (SELECT id FROM budgets WHERE soft_delete = 0 AND user_id = ?);
      ";
      $stmt_total_spent = $conn->prepare($sql_total_spent);
      $stmt_total_spent->bind_param("i", $user_id);
      $stmt_total_spent->execute();
      $result_total_spent = $stmt_total_spent->get_result();
      $total_spent = $result_total_spent->fetch_assoc()['total_spent'];
      ?>
      <h3 class="card-subtitle mb-2 text-muted">Rp. <?php echo number_format($total_spent, 0, ',', '.'); ?></h3>
    </div>
    <div class="card">
      <h1 class="card-title">Total Income</h1>
      <?php

      // Query to get total income
      $sql_total_income = "
        SELECT SUM(amount) AS total_income
        FROM incomes
        WHERE soft_delete = 0 AND user_id = ?;
      ";
      $stmt_total_income = $conn->prepare($sql_total_income);
      $stmt_total_income->bind_param("i", $user_id);
      $stmt_total_income->execute();
      $result_total_income = $stmt_total_income->get_result();
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



      // Queries to get total budget, total spent, and total income
      $sql_total_budget = "
      SELECT SUM(amount) AS total_budget
      FROM budgets
      WHERE soft_delete = 0 AND user_id = ?;
    ";
      $stmt_total_budget = $conn->prepare($sql_total_budget);
      $stmt_total_budget->bind_param("i", $user_id);
      $stmt_total_budget->execute();
      $result_total_budget = $stmt_total_budget->get_result();
      $total_budget = $result_total_budget->fetch_assoc()['total_budget'];

      $sql_total_spent = "
      SELECT SUM(amount) AS total_spent
      FROM expenses
      WHERE budget_id IN (SELECT id FROM budgets WHERE soft_delete = 0 AND user_id = ?);
    ";
      $stmt_total_spent = $conn->prepare($sql_total_spent);
      $stmt_total_spent->bind_param("i", $user_id);
      $stmt_total_spent->execute();
      $result_total_spent = $stmt_total_spent->get_result();
      $total_spent = $result_total_spent->fetch_assoc()['total_spent'];

      $sql_total_income = "
      SELECT SUM(amount) AS total_income
      FROM incomes
      WHERE soft_delete = 0 AND user_id = ?;
    ";
      $stmt_total_income = $conn->prepare($sql_total_income);
      $stmt_total_income->bind_param("i", $user_id);
      $stmt_total_income->execute();
      $result_total_income = $stmt_total_income->get_result();
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

      // Query to get total budget and total expenses
      $sql = "
          SELECT 
              (SELECT SUM(amount) FROM budgets WHERE soft_delete = 0 AND user_id = ?) AS total_budget,
              (SELECT SUM(amount) FROM expenses WHERE budget_id IN (SELECT id FROM budgets WHERE soft_delete = 0 AND user_id = ?)) AS total_expenses;
      ";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ii", $user_id, $user_id);
      $stmt->execute();
      $result = $stmt->get_result();
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

      // New query to get expenses by category
      $sql_expenses_by_category = "
        SELECT description, SUM(amount) as total_amount
        FROM expenses
        WHERE budget_id IN (SELECT id FROM budgets WHERE soft_delete = 0 AND user_id = ?)
        GROUP BY description;
      ";

      $stmt_expenses_by_category = $conn->prepare($sql_expenses_by_category);
      $stmt_expenses_by_category->bind_param("i", $user_id);
      $stmt_expenses_by_category->execute();
      $result_expenses_by_category = $stmt_expenses_by_category->get_result();

      $data_expenses = [0];
      $legend_expenses = [''];

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