<h1>Bienvenue sur votre compte</h1>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Khrej (Logout)</button>
</form>