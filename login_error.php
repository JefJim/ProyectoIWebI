<!DOCTYPE html>
<html lang="es" class="h-full bg-red-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login error</title>
</head>

<body class="h-full flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-bold text-red-600 mb-4">Login error</h1>
        <p class="text-gray-700 mb-6">The username or password is incorrect. Please try again.</p>
        <button onclick="window.location.href='/login.php';" 
                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Back to login
        </button>
    </div>
</body>

</html>
