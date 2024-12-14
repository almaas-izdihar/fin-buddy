<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?><div class="container">

<div class="container">
  <div class="register-container">
    <h1>Register</h1>
    <form action="index.php?page=proses_register" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="submit-btn">Register</button>
    </form>
  </div>
</div>
