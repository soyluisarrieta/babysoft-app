<style>
    .login-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #fff;
    }

    .login-form {
        width: 300px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .login-form-header {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .login-form-label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .login-form-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .login-form-submit {
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

    .login-form-submit:hover {
        background-color: #1565c0;
    }

    .login-form-link {
    display: block; /* Cambiado de block a inline-block para un mejor control de padding */
    margin-top: 10px;
    text-align: center;
    color: #1e88e5;
    text-decoration: none;
    padding: 10px 20px; /* Añade padding para un mejor aspecto visual */
    border-radius: 5px; /* Añade bordes redondeados */
    background-color: #f1f1f1; /* Añade un fondo para darle un aspecto de botón */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Añade transiciones para efectos visuales */
    box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Añade sombra para profundidad */
}

.login-form-link:hover {
    text-decoration: none; /* Elimina el subrayado al pasar el mouse */
    background-color: #e5e5e5; /* Cambia el color de fondo al pasar el mouse */
    transform: scale(1.05); /* Aumenta el tamaño del botón al pasar el mouse */
}

.login-form-link:active {
    transform: scale(0.95); /* Disminuye el tamaño del botón al hacer clic */
}

</style>
<title>Ingreso</title>
<div class="login-container">
    <img src="{{ asset('assets/LogoSinFondo.png') }}" alt="Logo" width="250px" height="130px">

    <div class="login-form">
        <div class="login-form-header">Ingreso</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email" class="login-form-label">Correo</label>
            <input id="email" type="email" class="login-form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <br>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br>
            <label for="password" class="login-form-label">Contraseña</label>
            <input id="password" type="password" class="login-form-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" minlength="8" maxlength="15">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            @if(session('error'))
              <span class="invalid-feedback" role="alert" >
                  <strong>{{ session('error') }}</strong>
              </span>
            @endif
            
            <br>
            <br>
            <button type="submit" class="login-form-submit">
                Ingresar
            </button>
            
            <br>
            <br>

            <!-- <a class="login-form-link" href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a> -->


            <a class="login-form-link" href="{{ route('password.request') }}">Olvidé mi contaseña</a>
            
        </form>
    </div>
</div>
