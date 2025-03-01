<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Community & Betting Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">BetTogether</a>
    </div>
</nav>

<header class="bg-primary text-white py-20">
    <div class="container text-center">
        <h1 class="text-4xl font-bold">Create Communities, Place Bets, and Have Fun!</h1>
        <p class="mt-4 text-xl">Join a community, make fun bets, and climb the leaderboards.</p>
        <a href="{{ route('register') }}" class="mt-6 inline-block bg-yellow-500 text-black px-6 py-3 rounded-full text-lg hover:bg-yellow-600 transition-all">Get Started</a>
    </div>
</header>

<section class="py-20 bg-gray-50" id="features">
    <div class="container text-center">
        <h2 class="text-3xl font-semibold text-gray-800">Amazing Features</h2>
        <div class="row mt-8">
            <div class="col-md-4">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">Create Communities</h3>
                    <p class="mt-4 text-gray-600">Easily create and join communities with your friends and other people.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">Place Bets</h3>
                    <p class="mt-4 text-gray-600">Create fun and engaging bets within your communities. See who can win the most bets!</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">Leaderboards</h3>
                    <p class="mt-4 text-gray-600">Track your progress with leaderboards. Compete with friends and others to become the best!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-gradient-to-r from-green-400 to-blue-500 py-20 text-white" id="sign-up">
    <div class="container text-center">
        <h2 class="text-3xl font-semibold">Join Us Today!</h2>
        <p class="mt-4 text-xl">Create your community, place your bets, and start climbing the leaderboards now!</p>
        <a href="#" class="mt-6 inline-block bg-yellow-500 text-black px-6 py-3 rounded-full text-lg hover:bg-yellow-600 transition-all">Sign Up</a>
    </div>
</section>

<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p>&copy; 2025 BetTogether. All rights reserved.</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#" class="text-white">Privacy Policy</a></li>
            <li class="list-inline-item"><a href="#" class="text-white">Terms of Service</a></li>
        </ul>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
