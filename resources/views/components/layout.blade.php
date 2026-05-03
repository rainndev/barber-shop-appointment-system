<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Layout</title>
</head>
<body>
    <header>
        <h1>Welcome to the Barber Shop Appointment System</h1>
        <nav>
            <a href="/dashboard">Dashboard</a>
            <a href="/create">Create appointments</a>
            <a href="/contact">Contact</a>
        </nav>
    </header>

    <main class="container">
        {{ $slot }}
    </main>
</body>
</html>