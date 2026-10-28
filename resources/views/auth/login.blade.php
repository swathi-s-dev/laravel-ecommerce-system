
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | ShopAdmin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

<style>    
      :root {
            --primary: #5b5ce2;
            --sidebar: #171b35;
            --background: #f5f6fb;
            --muted: #8b90a5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: #252943;
        }

        .login-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        .welcome-panel {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 65px 9%;
            color: #fff;
            background: linear-gradient(145deg, #171b35, #25275e);
        }

        .welcome-panel::before,
        .welcome-panel::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(91, 92, 226, .18);
        }

        .welcome-panel::before {
            top: -150px;
            right: -100px;
        }

        .welcome-panel::after {
            bottom: -180px;
            left: -120px;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
            max-width: 480px;
            margin: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 55px;
            font-size: 25px;
            font-weight: 750;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: var(--primary);
            font-size: 23px;
        }

        .welcome-panel h1 {
            margin-bottom: 12px;
            font-size: clamp(34px, 4vw, 49px);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .welcome-panel h1 span {
            color: #9696ff;
        }

        .welcome-subtitle {
            margin-bottom: 38px;
            color: #b8c1e6;
            font-size: 16px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 25px;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: rgba(91, 92, 226, .38);
            font-size: 19px;
        }

        .feature strong {
            display: block;
            margin-bottom: 4px;
            font-size: 15px;
        }

        .feature small {
            color: #b8c1e6;
            font-size: 13px;
        }

        .login-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .login-card {
            width: 100%;
            max-width: 470px;
            padding: 42px;
            border: 1px solid #eceef5;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 15px 45px rgba(35, 42, 80, .08);
        }

        .login-brand-icon {
            width: 65px;
            height: 65px;
            display: grid;
            place-items: center;
            margin: 0 auto 20px;
            border-radius: 18px;
            background: var(--primary);
            color: white;
            font-size: 29px;
        }

        .login-card h2 {
            margin-bottom: 10px;
            text-align: center;
            font-size: 29px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .login-description {
            margin-bottom: 32px;
            text-align: center;
            color: var(--muted);
            font-size: 14px;
        }

        .form-label {
            margin-bottom: 9px;
            color: #353952;
            font-size: 13px;
            font-weight: 650;
        }

        .form-control {
            min-height: 49px;
            padding: 12px 15px;
            border: 1px solid #dfe3f1;
            border-radius: 11px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(91, 92, 226, .12);
        }

        .btn-login {
            width: 100%;
            min-height: 50px;
            margin-top: 10px;
            border: 0;
            border-radius: 11px;
            background: var(--primary);
            color: white;
            font-weight: 700;
            transition: .2s ease;
        }

        .btn-login:hover {
            background: #4849c7;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 7px 18px rgba(91, 92, 226, .22);
        }

        .secure-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #edf0f7;
            text-align: center;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 850px) {
            .login-layout {
                grid-template-columns: 1fr;
            }

            .welcome-panel {
                padding: 35px 25px;
            }

            .welcome-content {
                width: 100%;
            }

            .brand {
                margin-bottom: 30px;
            }

            .welcome-panel h1 {
                font-size: 35px;
            }

            .feature {
                margin-bottom: 16px;
            }

            .login-panel {
                padding: 30px 18px;
            }

            .login-card {
                padding: 32px 24px;
            }
        }
</style>
</head>

<body>
<div class="login-layout">

    <!-- Left welcome panel -->
    <section class="welcome-panel">
        <div class="welcome-content">

            <div class="brand">
                <div class="brand-icon">
                    <i class="bi bi-bag-check-fill"></i>
                </div>
                <span>ShopSphere</span>
            </div>

            <h1>Welcome <span>Back!</span></h1>

            <p class="welcome-subtitle">
                Manage your store with confidence.
            </p>

            <div class="feature">
                <div class="feature-icon">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>
                <div>
                    <strong>Sales Overview</strong>
                    <small>Track your revenue and growth</small>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div>
                    <strong>Product Management</strong>
                    <small>Manage your store inventory</small>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <div>
                    <strong>Order Tracking</strong>
                    <small>Keep track of customer orders</small>
                </div>
            </div>

        </div>
    </section>

    <!-- Right login panel -->
    <section class="login-panel">
        <div class="login-card">

            <div class="login-brand-icon">
                <i class="bi bi-bag-check"></i>
            </div>

            <h2>Admin Sign In</h2>

            <p class="login-description">
                Enter your credentials to access your dashboard.
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Sign In
                </button>
            </form>

            <div class="secure-footer">
                <i class="bi bi-shield-check me-1"></i>
                Secure Admin Access
            </div>

        </div>
    </section>

</div>
</body>
</html>
