<!DOCTYPE html>
<html lang="es" class="h-full bg-red-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Error de Inicio de Sesión</title>
</head>

<body class="h-full flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-bold text-red-600 mb-4">Error de Inicio de Sesión</h1>
        <p class="text-gray-700 mb-6">El usuario o la contraseña son incorrectos. Por favor, inténtelo de nuevo.</p>
        <button onclick="window.location.href='/login.php';" 
                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Volver a Iniciar Sesión
        </button>
    </div>
</body>

</html>
