<?php
  include('utils/functions.php');

  $error_msg = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php require('inc/header.php'); ?>
<div class="container-fluid">
  <div class="jumbotron">
    <h1 class="display-4">Signup</h1>
    <p class="lead">This is the signup process</p>
    <hr class="my-4">
  </div>
  <form method="post" action="actions/signup.php">
    <div class="error">
      <?php echo $error_msg; ?>
    </div>
    <div class="form-group">
      <label for="firstname">First Name</label>
      <input id="firstname" class="form-control" type="text" name="firstname" required>
    </div>
    <div class="form-group">
      <label for="lastname">Last Name</label>
      <input id="lastname" class="form-control" type="text" name="lastname" required>
    </div>
    <div class="form-group">
      <label for="phone">Phone</label>
      <input id="phone" class="form-control" type="text" name="phone" required>
    </div>
    <div class="form-group">
      <label for="email">Email Address</label>
      <input id="email" class="form-control" type="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <input id="address" class="form-control" type="text" name="address" required>
    </div>
    <div class="form-group">
      <label for="country">Country</label>
      <input id="country" class="form-control" type="text" name="country" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" class="form-control" type="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Sign up</button>
  </form>
</div>
<?php require('inc/footer.php'); ?>
