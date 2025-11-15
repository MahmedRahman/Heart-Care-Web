<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Heart Care Dashboard</title>

    <!-- Material Design 3 -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --md-sys-color-primary: #0D268D;
            --md-sys-color-on-primary: #FFFFFF;
            --md-sys-color-primary-container: #D6E0FF;
            --md-sys-color-on-primary-container: #001A5C;
            --md-sys-color-secondary: #1E3FA8;
            --md-sys-color-on-secondary: #FFFFFF;
            --md-sys-color-error: #BA1A1A;
            --md-sys-color-on-error: #FFFFFF;
            --md-sys-color-surface: #FFFFFF;
            --md-sys-color-on-surface: #1C1B1F;
            --md-sys-color-surface-variant: #E8EDF7;
            --md-sys-color-on-surface-variant: #49454F;
            --md-sys-color-outline: #79747E;
            --md-sys-color-outline-variant: #CAC4D0;
            --md-sys-color-shadow: #000000;
            --md-sys-color-inverse-surface: #313033;
            --md-sys-color-inverse-on-surface: #F4EFF4;
            --md-sys-color-inverse-primary: #B3C7FF;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #E8EDF7 0%, #D6E0FF 50%, #B3C7FF 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .login-card {
            background: var(--md-sys-color-surface);
            border-radius: 28px;
            padding: 48px;
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.30), 
                        0px 4px 8px 3px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .heart-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--md-sys-color-primary) 0%, var(--md-sys-color-secondary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            animation: heartbeat 1.5s ease-in-out infinite;
            box-shadow: 0px 2px 8px rgba(13, 38, 141, 0.3);
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .heart-icon .material-symbols-outlined {
            font-size: 48px;
            color: white;
        }

        .login-title {
            font-size: 28px;
            font-weight: 400;
            color: var(--md-sys-color-on-surface);
            margin-bottom: 8px;
            letter-spacing: 0;
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--md-sys-color-on-surface-variant);
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .mdc-text-field {
            position: relative;
            display: inline-flex;
            align-items: center;
            width: 100%;
            height: 56px;
            background-color: transparent;
        }

        .mdc-text-field--outlined {
            border: 1px solid var(--md-sys-color-outline);
            border-radius: 4px;
            padding: 0 16px;
            transition: all 0.2s ease;
        }

        .mdc-text-field--outlined:focus-within {
            border-color: var(--md-sys-color-primary);
            border-width: 2px;
        }

        .mdc-text-field--outlined.filled {
            border-color: var(--md-sys-color-primary);
            border-width: 2px;
        }

        .mdc-text-field__input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
            color: var(--md-sys-color-on-surface);
            padding: 0;
            height: 100%;
        }

        .mdc-text-field__input::placeholder {
            color: transparent;
        }

        .mdc-floating-label {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: var(--md-sys-color-on-surface-variant);
            pointer-events: none;
            transition: all 0.2s ease;
            background: var(--md-sys-color-surface);
            padding: 0 4px;
        }

        .mdc-text-field--outlined:focus-within .mdc-floating-label,
        .mdc-text-field--outlined.filled .mdc-floating-label {
            top: 0;
            transform: translateY(-50%) scale(0.75);
            color: var(--md-sys-color-primary);
        }

        .mdc-text-field__input:not(:placeholder-shown) + .mdc-floating-label {
            top: 0;
            transform: translateY(-50%) scale(0.75);
            color: var(--md-sys-color-primary);
        }

        .mdc-text-field__icon {
            color: var(--md-sys-color-on-surface-variant);
            margin-left: 12px;
            display: flex;
            align-items: center;
        }

        .mdc-text-field__icon .material-symbols-outlined {
            font-size: 24px;
        }

        .form-options {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mdc-checkbox {
            position: relative;
            width: 18px;
            height: 18px;
        }

        .mdc-checkbox__native-control {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .mdc-checkbox__background {
            width: 18px;
            height: 18px;
            border: 2px solid var(--md-sys-color-outline);
            border-radius: 2px;
            position: relative;
            transition: all 0.2s ease;
        }

        .mdc-checkbox__native-control:checked ~ .mdc-checkbox__background {
            background-color: var(--md-sys-color-primary);
            border-color: var(--md-sys-color-primary);
        }

        .mdc-checkbox__checkmark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            color: white;
            transition: transform 0.2s ease;
        }

        .mdc-checkbox__native-control:checked ~ .mdc-checkbox__background .mdc-checkbox__checkmark {
            transform: translate(-50%, -50%) scale(1);
        }

        .checkbox-label {
            color: var(--md-sys-color-on-surface);
            cursor: pointer;
        }

        .mdc-button {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 20px;
            background-color: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
            font-size: 14px;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 0.1px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.30), 
                        0px 4px 8px 3px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .mdc-button:hover {
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.30), 
                        0px 4px 8px 3px rgba(0, 0, 0, 0.15),
                        0px 2px 6px rgba(13, 38, 141, 0.3);
        }

        .mdc-button:active {
            box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.30), 
                        0px 1px 3px 1px rgba(0, 0, 0, 0.15);
        }

        .mdc-button:disabled {
            opacity: 0.38;
            cursor: not-allowed;
        }

        .error-message {
            background-color: #FEE;
            border: 1px solid var(--md-sys-color-error);
            border-radius: 4px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .error-message .material-symbols-outlined {
            color: var(--md-sys-color-error);
            font-size: 20px;
        }

        .error-content {
            flex: 1;
        }

        .error-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--md-sys-color-error);
            margin-bottom: 4px;
        }

        .error-list {
            font-size: 12px;
            color: var(--md-sys-color-error);
            list-style: none;
            padding: 0;
        }

        .error-list li {
            margin-bottom: 2px;
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: var(--md-sys-color-on-surface-variant);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }

            .login-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="heart-icon">
                    <span class="material-symbols-outlined">favorite</span>
                </div>
                <h1 class="login-title">Heart Care</h1>
                <p class="login-subtitle">Healthcare Dashboard</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="error-message">
                    <span class="material-symbols-outlined">error</span>
                    <div class="error-content">
                        <div class="error-title">Login Error</div>
                        <ul class="error-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <div class="mdc-text-field mdc-text-field--outlined" id="email-field">
                        <span class="mdc-text-field__icon">
                            <span class="material-symbols-outlined">email</span>
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="mdc-text-field__input" 
                            placeholder="Email"
                            value="{{ old('email') }}"
                            required 
                            autofocus
                        >
                        <label for="email" class="mdc-floating-label">Email</label>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <div class="mdc-text-field mdc-text-field--outlined" id="password-field">
                        <span class="mdc-text-field__icon">
                            <span class="material-symbols-outlined">lock</span>
                        </span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="mdc-text-field__input" 
                            placeholder="Password"
                            required
                        >
                        <label for="password" class="mdc-floating-label">Password</label>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="form-options">
                    <div class="checkbox-group">
                        <div class="mdc-checkbox">
                            <input 
                                type="checkbox" 
                                id="remember" 
                                name="remember" 
                                class="mdc-checkbox__native-control"
                            >
                            <div class="mdc-checkbox__background">
                                <span class="mdc-checkbox__checkmark material-symbols-outlined">check</span>
                            </div>
                        </div>
                        <label for="remember" class="checkbox-label">Remember me</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="mdc-button">
                    Sign In
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} Heart Care. All rights reserved.
        </div>
    </div>

    <script>
        // Material Design 3 Text Field Interactions
        document.querySelectorAll('.mdc-text-field__input').forEach(input => {
            const field = input.closest('.mdc-text-field');
            
            input.addEventListener('focus', () => {
                field.classList.add('filled');
            });
            
            input.addEventListener('blur', () => {
                if (!input.value) {
                    field.classList.remove('filled');
                }
            });
            
            // Check if field has value on load
            if (input.value) {
                field.classList.add('filled');
            }
        });
    </script>
</body>
</html>
