<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?>
<?php if(defined("LEWAT_INDEX") == false) die("Tidak boleh akses langsung!");?><div class="container">

<div class="container">
  <div class="login-container">
    <h1>Login</h1>
    <form action="index.php?page=proses_login" method="GET">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="submit-btn">Login</button>
      <p>Already have an account? <a href="index.php?page=register">Register</a></p>
    </form>
  </div>
</div>
