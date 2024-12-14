<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?>


<div class="container">
    <h1 class="username">Hi, Asep</h1>

    <div class="card-container">
        <div class="card">
            <h1 class="card-title">Total Budget</h1>
            <h3 class="card-subtitle mb-2 text-muted">Rp. 10.000.000</h3>
        </div>
        <div class="card">
            <h1 class="card-title">Total Spent</h1>
            <h3 class="card-subtitle mb-2 text-muted">Rp. 2.500.000</h3>
        </div>
        <div class="card">
            <h1 class="card-title">No. Of Budget</h1>
            <h3 class="card-subtitle mb-2 text-muted">1</h3>
        </div>
    </div>

		<div class="card-container" style="grid-template-columns: repeat(3, 1fr);">
			<div class="card">
            <h1 class="card-title">Total Income</h1>
            <h3 class="card-subtitle mb-2 text-muted">Rp. 10.000.000</h3>
      </div>
			<div class="card">
            <h1 class="card-title">Latest Budget</h1>
						<h2 class="card-subtitle" style="margin-top: 10px;">Home Decor</h2>
            <h3 class="card-subtitle mb-2 text-muted">Rp. 10.000.000</h3>
      </div>
			<div class="card">
            <h1 class="card-title">Latest Expense</h1>
						<h2 class="card-subtitle" style="margin-top: 10px;">Bedroom Decor</h2>
            <h3 class="card-subtitle mb-2 text-muted">Rp. 10.000.000</h3>
      </div>
    </div>
		<div class="card-container">
        <div class="card" style="grid-column: 1 / span 3;">
            <h1 class="card-title">Activity</h1>
              <?php
              require_once "chart/src/Antoineaugusti/EasyPHPCharts/Chart.php";

              $data = [2500000, 7500000]; 
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
</div>
