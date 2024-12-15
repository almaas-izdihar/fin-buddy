<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="stylesheet" href="chart/examples/chart.css">
	<script src="chart/examples/ChartJS.min.js"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1,0">
	<title>Home</title>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="app.js" defer></script>
</head>
<body>
	<nav id="sidebar">
		<ul>
			<li>
			<span class="logo">FinBuddy</span>
        <button onclick=toggleSidebar() id="toggle-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z"/></svg>
        </button>
			</li>
			<li>
				<a href="?page=dashboard">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
					<span>Dashboard</span>
				</a>
			</li>
			<li>
				<a href="?page=income">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M704-200 532-372q-11-11-11.5-27.5T531-428q11-12 28-12t29 12l172 172v-144q0-17 11.5-28.5T800-440q17 0 28.5 11.5T840-400v240q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160q0-17 11.5-28.5T560-200h144ZM240-320h-80q-17 0-28.5-11.5T120-360q0-17 11.5-28.5T160-400h200v-120H200q-33 0-56.5-23.5T120-600v-120q0-33 23.5-56.5T200-800h40q0-17 11.5-28.5T280-840q17 0 28.5 11.5T320-800h80q17 0 28.5 11.5T440-760q0 17-11.5 28.5T400-720H200v120h160q33 0 56.5 23.5T440-520v120q0 33-23.5 56.5T360-320h-40q0 17-11.5 28.5T280-280q-17 0-28.5-11.5T240-320Z"/></svg>
					<span>Incomes</span>
				</a>
			</li>
			<li>
				<a href="?page=budget">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-200v-560 560Zm0 80q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v100h-80v-100H200v560h560v-100h80v100q0 33-23.5 56.5T760-120H200Zm320-160q-33 0-56.5-23.5T440-360v-240q0-33 23.5-56.5T520-680h280q33 0 56.5 23.5T880-600v240q0 33-23.5 56.5T800-280H520Zm280-80v-240H520v240h280Zm-160-60q25 0 42.5-17.5T700-480q0-25-17.5-42.5T640-540q-25 0-42.5 17.5T580-480q0 25 17.5 42.5T640-420Z"/></svg>
					<span>Budget</span>
				</a>
			</li>
			<li>
				<a href="?page=expense">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M560-440q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM280-320q-33 0-56.5-23.5T200-400v-320q0-33 23.5-56.5T280-800h560q33 0 56.5 23.5T920-720v320q0 33-23.5 56.5T840-320H280Zm80-80h400q0-33 23.5-56.5T840-480v-160q-33 0-56.5-23.5T760-720H360q0 33-23.5 56.5T280-640v160q33 0 56.5 23.5T360-400Zm400 240H120q-33 0-56.5-23.5T40-240v-400q0-17 11.5-28.5T80-680q17 0 28.5 11.5T120-640v400h640q17 0 28.5 11.5T800-200q0 17-11.5 28.5T760-160ZM280-400v-320 320Z"/></svg>
					<span>Expenses</span>
				</a>
			</li>
			<li>
			<button onclick=toggleSubMenu(this) class="dropdown-btn">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
					<span>Profile</span>
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
				</button>
				<ul class="sub-menu">
					<div>
						<li><a href="?page=login">Login</a></li>
						<li><a href="?page=register">Register</a></li>
						<li><a href="?page=logout" style="color:tomato">Logout</a></li>
					</div>
				</ul>
			</li>
		</ul>
	</nav>
	<div class="container1">
        <?php 
            define("LEWAT_INDEX",true);

            require_once("lib/koneksi.php");

            if(!isset($_GET['page'])){
                $page = "home";
                
                return;

            }
            $page =  $_GET["page"];
            $page_to_open = "pages/".$page.".php";

            //cek esistensi file
            if(!file_exists($page_to_open)){
                $page_to_open = "pages/404.php";
            }

            require_once($page_to_open);
        ?>

    </div>
</body>
</html>