<style>
  .password-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background-color: #fff;
  }

  .password-form {
      width: 300px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .password-form-header {
      text-align: center;
      margin-bottom: 20px;
      font-size: 24px;
      font-weight: bold;
      color: #333;
  }

  .password-form-label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: #333;
  }

  .password-form-input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
  }

  .password-form-submit {
      width: 100%;
      padding: 10px;
      background-color: #1e88e5;
      border: none;
      border-radius: 4px;
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
  }

  .password-form-submit:hover {
      background-color: #1565c0;
  }

  .alert-success {
      width: 300px;
      padding: 20px;
      border: 1px solid #a0ddac;
      color: #207431;
      border-radius: 4px;
      background-color: #c5eccd;
      margin-bottom: 20px;
  }
</style>
<title>Recuperar contraseña</title>
<div class="password-container">
  <img src="{{ asset('assets/LogoSinFondo.png') }}" alt="Logo" width="250px" height="130px">

  @if (session('status'))
      <div class="alert-success" role="alert">
          {{ session('status') }}
      </div>
  @endif

  <div class="password-form">
      <div class="password-form-header">Recuperar contraseña</div>

      <form method="POST" action="{{ route('password.update') }}">
          @csrf
          
          <input type="hidden" name="token" value="{{ $token }}">

          <label for="email" class="password-form-label">Correo</label>
          <input id="email" type="email" class="password-form-input @error('email') is-invalid @enderror"
              name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
          <br>
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
          <br>
          <label for="password" class="password-form-label">Nueva contraseña</label>
          <input id="password" type="password" class="password-form-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" minlength="8" maxlength="15">

          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror

          <br>
          <label for="password-confirm" class="password-form-label">Confirmar contraseña</label>
          <input id="password-confirm" type="password" class="password-form-input @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" minlength="8" maxlength="15">

          
          <br>
          <br>
          <button type="submit" class="password-form-submit">
            Restablecer la contraseña
          </button>

          <br>
          <br>
      </form>
  </div>
</div>
