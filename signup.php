<?php
  include('utils/functions.php');
  $error_msg = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php require('inc/header.php'); ?>
<div class="flex items-center justify-center min-h-screen bg-green-100 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-center text-green-900">Signup</h1>
    <p class="text-center text-green-700 mb-4">This is the signup process</p>
    <form method="post" action="actions/signup.php" class="space-y-6">
      <!-- Error message -->
      <?php if ($error_msg): ?>
        <div class="text-red-500 text-sm text-center"><?php echo $error_msg; ?></div>
      <?php endif; ?>

      <!-- First Name -->
      <div>
        <label for="firstname" class="block text-sm font-medium text-green-900">First Name</label>
        <input id="firstname" class="mt-1 block w-full px-3 py-2 rounded-md border-0 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm" type="text" name="firstname" required>
      </div>

      <!-- Last Name -->
      <div>
        <label for="lastname" class="block text-sm font-medium text-green-900">Last Name</label>
        <input id="lastname" class="mt-1 block w-full px-3 py-2 rounded-md border-0 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm" type="text" name="lastname" required>
      </div>

      <!-- Phone -->
      <div>
        <label for="phone" class="block text-sm font-medium text-green-900">Phone</label>
        <input id="phone" class="mt-1 block w-full px-3 py-2 rounded-md border-0 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm" type="text" name="phone" required>
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-green-900">Email Address</label>
        <input id="email" class="mt-1 block w-full px-3 py-2 rounded-md border-0 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm" type="email" name="email" required>
      </div>

      <!-- Address -->
      <div>
        <label for="address" class="block text-sm font-medium text-green-900">Address</label>
        <input id="address" class="mt-1 block w-full px-3 py-2 rounded-md border-0 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm" type="text" name="address" required>
      </div>

      <!-- Country -->
      <div>
        <label for="country" class="block text-sm font-medium text-green-900">Country</label>
        <input id="country" class="mt-1 block w-full px-3 py-2 rounded-md border-0 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm" type="text" name="country" required>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-green-900">Password</label>
        <input id="password" 
        class="mt-1 block w-full px-3 py-2 rounded-md border-0 shadow-sm ring-1 ring-inset ring-green-300 focus:ring-2 focus:ring-green-600 sm:text-sm" 
        type="password" name="password" minlength="8" required >
      </div>

      <!-- Submit Button -->
      <div class="flex justify-center">
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
          Sign up
        </button>
      </div>
    </form>
  </div>
</div>
<?php require('inc/footer.php'); ?>
