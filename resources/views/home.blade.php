<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <h1>Home</h1>
    <p>Welcome to the home page!</p>

    
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif


    <div>
        <h1>Register</h1>

        <form action="/register" method="POST">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name"><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>

            <button type="submit">Register</button>
        </form>
    </div>

     <div>
        <h1>Login</h1>
        <form action="/login" method="POST">
            @csrf
            <label for="loginname">Name:</label>
            <input type="text" id="loginname" name="loginname"><br><br>

            <label for="loginpassword">Password:</label>
            <input type="password" id="loginpassword" name="loginpassword"><br><br>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>