<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php
		echo htmlspecialchars($_GET['page'] ?? 'FinBuddy');  // Sanitize output
		?>
	</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="./style.css" rel="stylesheet">
	<link rel="stylesheet" href="./modules/chart-php/examples/chart.css">
	<script src="./modules/chart-php/examples/ChartJS.min.js"></script>

</head>

<body class="bg-body-secondary">

	<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
		<symbol id="check2" viewBox="0 0 16 16">
			<path
				d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
		</symbol>
		<symbol id="circle-half" viewBox="0 0 16 16">
			<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
		</symbol>
		<symbol id="moon-stars-fill" viewBox="0 0 16 16">
			<path
				d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
			<path
				d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
		</symbol>
		<symbol id="sun-fill" viewBox="0 0 16 16">
			<path
				d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
		</symbol>
	</svg>

	<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
		<symbol id="bootstrap" viewBox="0 0 118 94">
			<title>Bootstrap</title>
			<path fill-rule="evenodd" clip-rule="evenodd"
				d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z">
			</path>
		</symbol>
	</svg>
	<!-- <button class="btn btn-outline-secondary" id="sidebarToggle"><i class="bi bi-arrows-expand-vertical"></i></button> -->

	<aside class="collapse show collapse-horizontal col-sm-2 p-3 border-end bg-body-tertiary d-flex flex-column justify-content-between" id="collapseWidthExample">
		<div>
			<a href="?page=dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
				<svg class="bi pe-none me-2" width="40" height="32">
					<use xlink:href="#bootstrap" />
				</svg>
				<span class="d-print-block">FinBuddy</span>
			</a>
			<hr>
			<ul class="nav nav-pills flex-column mb-auto">
				<li>
					<a href="?page=dashboard" class="nav-link link-body-emphasis">
						<p class="bi bi-speedometer2" style="position:fixed;">Dashboard</p><br>
					</a>
				</li>
				<li>
					<a href="?page=incomes" class="nav-link link-body-emphasis">
						<p class="bi bi-table" style="position:fixed;">Incomes</p><br>
					</a>
				</li>
				<li>
					<a href="?page=budget" class="nav-link link-body-emphasis">
						<p class="bi bi-grid" style="position:fixed;">Budget</p><br>
					</a>
				</li>
				<li>
					<a href="?page=expenses" class="nav-link link-body-emphasis">
						<p class="bi bi-person-circle" style="position:fixed;">Expenses</p><br>
					</a>
				</li>
			</ul>
			<hr>
		</div>
		<div class="dropdown">
			<a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
				data-bs-toggle="dropdown" aria-expanded="true">
				<img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
				<span class="d-print-block"><strong>Anika Visser</strong></span>
			</a>
			<ul class="dropdown-menu text-small shadow">
				<li><a class="dropdown-item" href="#">Profile</a></li>
				<li>
					<hr class="dropdown-divider">
				</li>
				<li><a class="dropdown-item" href="#">Sign out</a></li>
			</ul>
		</div>
	</aside>

	<main class="col-sm-10 bg-body-tertiary" id="main">
		<div class="container-fluid my-4">
			<?php
			ini_set("display_errors", false);  // Disable error display in production
			define("LEWAT_INDEX", true);

			require_once('config/database.php');

			// Define a whitelist of allowed pages
			$allowed_pages = ['dashboard', 'incomes', 'budget', 'expenses'];
			$page = isset($_GET['page']) && in_array($_GET['page'], $allowed_pages) ? $_GET['page'] : 'dashboard';

			$page_to_open = "pages/" . $page . ".php";

			// Check if file exists, else redirect to 404
			if (!file_exists($page_to_open)) {
				header("Location: 404.php");
				exit;
			}

			require_once($page_to_open);
			?>
		</div>

	</main>




	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>