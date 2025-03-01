<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BetTogether</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand" href="#">BetTogether</a>
        <nav class="nav">
            <a class="nav-link text-white" href="{{route('register')}}">{{__('messages.landingPage.signUp')}}</a>
            <a class="nav-link text-white" href="{{route('login')}}">{{__('messages.landingPage.signIn')}}</a>
        </nav>
    </div>
</nav>

<header class="bg-primary text-white py-20">
    <div class="container text-center">
        <h1 class="text-4xl font-bold">{{__('messages.landingPage.title')}}</h1>
        <p class="mt-4 text-xl">{{__('messages.landingPage.joinCommunities')}}</p>
        <a href="{{ route('register') }}" class="mt-6 inline-block bg-yellow-500 text-black px-6 py-3 rounded-full text-lg hover:bg-yellow-600 transition-all">{{__('messages.landingPage.getStarted')}}</a>
    </div>
</header>

<section class="py-20 bg-gray-50" id="features">
    <div class="container text-center">
        <h2 class="text-3xl font-semibold text-gray-800">{{__('messages.landingPage.amazingFeatures')}}</h2>
        <div class="row mt-8">
            <div class="col-md-4">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">{{__('messages.landingPage.createCommunities')}}</h3>
                    <p class="mt-4 text-gray-600">{{__('messages.landingPage.createCommunitiesText')}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">{{__('messages.landingPage.placeBets')}}</h3>
                    <p class="mt-4 text-gray-600">{{__('messages.landingPage.placeBetsText')}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">{{__('messages.landingPage.leaderboards')}}</h3>
                    <p class="mt-4 text-gray-600">{{__('messages.landingPage.leaderboardsText')}}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-gradient-to-r from-green-400 to-blue-500 py-20 text-white" id="sign-up">
    <div class="container text-center">
        <h2 class="text-3xl font-semibold">{{__('messages.landingPage.joinUs')}}</h2>
        <p class="mt-4 text-xl">{{__('messages.landingPage.joinUsText')}}</p>
        <a href="#" class="mt-6 inline-block bg-yellow-500 text-black px-6 py-3 rounded-full text-lg hover:bg-yellow-600 transition-all">{{__('messages.landingPage.signUp')}}</a>
    </div>
</section>

<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p>&copy; 2025 Mathis Burger</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="/privacy-policy" class="text-white">{{__('messages.landingPage.privacyPolicy')}}</a></li>
            <li class="list-inline-item"><a href="{{route('impress')}}" class="text-white">{{__('messages.landingPage.imprint')}}</a></li>
        </ul>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
