<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?><?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?>


<div class="container">
    <h1 class="page-title">My Budget Streams</h1>

    <div class="card-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;grid-row: 1 / 2; height: 350px;">
        <!-- Total Income Card -->
        <div class="card hover-card" onclick="window.location.href='?page=newBudget';" style="cursor: pointer;">
            <h1 class="card-title" style="margin-bottom: 40px;margin-top: 40px;">Create New Budgets</h1>
            <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000000"><path d="M453-280h60v-166h167v-60H513v-174h-60v174H280v60h173v166Zm27.27 200q-82.74 0-155.5-31.5Q252-143 197.5-197.5t-86-127.34Q80-397.68 80-480.5t31.5-155.66Q143-709 197.5-763t127.34-85.5Q397.68-880 480.5-880t155.66 31.5Q709-817 763-763t85.5 127Q880-563 880-480.27q0 82.74-31.5 155.5Q817-252 763-197.68q-54 54.31-127 86Q563-80 480.27-80Zm.23-60Q622-140 721-239.5t99-241Q820-622 721.19-721T480-820q-141 0-240.5 98.81T140-480q0 141 99.5 240.5t241 99.5Zm-.5-340Z"/></svg>
        </div>

        <!-- Latest Budget Card -->
        <div class="card hover-card" onclick="window.location.href='?page=newIncome';" style="cursor: pointer;">
            <h1 class="card-title" style="margin-top: 80px; font_size: 100px;">Home Decor</h1>
            <h3 class="card-subtitle mb-2 text-muted">Rp. 10.000.000</h3>
        </div>
    </div>
</div>
