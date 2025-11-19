<form method="POST" action="{{ route('admin.login.submit') }}" class="admin-login-form">
    @csrf

    <div class="field">
        <label for="identifier">Identifiant</label>
        <input id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" required>
    </div>

    <div class="field">
        <label for="password">Mot de passe</label>
        <input id="password" type="password" name="password" required>
    </div>

    @if($errors->has('identifier'))
        <p class="login-error">Identifiants incorrects.</p>
    @endif

    <button type="submit" class="btn btn-primary">
        Se connecter
    </button>
</form>
