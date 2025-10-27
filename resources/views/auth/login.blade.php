<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TIMLY - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .main-container {
            background: white;
            border-radius: 24px;
            width: 100%;
            max-width: 1100px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left Section - Illustration */
        .left-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .left-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-30px, -30px); }
        }

        .left-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .left-header {
            background: rgba(255, 255, 255, 0.2);
            padding: 24px 28px;
            border-radius: 12px;
            margin-bottom: 32px;
            backdrop-filter: blur(10px);
        }

        .left-header h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .left-header p {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
        }

        .left-header small {
            font-size: 12px;
            opacity: 0.8;
            display: block;
            margin-top: 8px;
        }

        .illustration {
            margin: 40px 0;
        }

        .illustration svg {
            width: 100%;
            max-width: 350px;
            height: auto;
        }

        /* Right Section - Login Form */
        .right-section {
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 32px;
        }

        .form-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1e1e1e;
            margin-bottom: 12px;
        }

        .form-header p {
            font-size: 14px;
            color: #6b7280;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Google Login Button */
        .google-login-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 14px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            color: #1e1e1e;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-bottom: 24px;
        }

        .google-login-btn:hover {
            border-color: #667eea;
            background: #f8f9ff;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            color: #d1d5db;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 12px;
            font-size: 13px;
            color: #9ca3af;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .input-error {
            border-color: #ef4444 !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            font-size: 14px;
            padding: 0;
        }

        /* Remember Me & Forgot Password */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #6b7280;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-password {
            text-align: right;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            text-decoration: underline;
            gap: 10px;
        }

        .forgot-password a i {
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .forgot-password a:hover i {
            opacity: 1;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Register Link */
        .register-section {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
        }

        .register-section a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .register-section a:hover {
            text-decoration: underline;
        }

        /* Social Icons */
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 24px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #6b7280;
        }

        .social-icon:hover {
            border-color: #667eea;
            background: #f8f9ff;
            color: #667eea;
        }

        .social-icon i {
            font-size: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .left-section {
                display: none;
            }

            .right-section {
                padding: 40px 30px;
            }

            .form-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="left-content">
                <div class="left-header">
                    <h2>TIMLY</h2>
                    <p>Project Management</p>
                </div>

                <div class="illustration">
                    <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                        <!-- Background decorative circles with animation -->
                        <circle cx="350" cy="80" r="60" fill="rgba(255,255,255,0.08)">
                            <animate attributeName="r" values="60;70;60" dur="4s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="80" cy="320" r="50" fill="rgba(255,255,255,0.06)">
                            <animate attributeName="r" values="50;60;50" dur="5s" repeatCount="indefinite"/>
                        </circle>

                        <!-- Floating particles -->
                        <circle cx="100" cy="50" r="3" fill="rgba(255,255,255,0.4)">
                            <animate attributeName="cy" values="50;30;50" dur="3s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.4;0.8;0.4" dur="3s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="320" cy="300" r="4" fill="rgba(255,255,255,0.3)">
                            <animate attributeName="cy" values="300;280;300" dur="4s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.3;0.7;0.3" dur="4s" repeatCount="indefinite"/>
                        </circle>

                        <!-- Central Platform/Stage -->
                        <ellipse cx="200" cy="280" rx="120" ry="40" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2">
                            <animate attributeName="ry" values="40;42;40" dur="3s" repeatCount="indefinite"/>
                        </ellipse>

                        <!-- Laptop screens on platform -->
                        <g>
                            <!-- Laptop 1 -->
                            <rect x="140" y="265" width="35" height="22" rx="2" fill="#4F46E5" opacity="0.8"/>
                            <rect x="142" y="267" width="31" height="17" rx="1" fill="#818CF8"/>
                            <line x1="142" y1="270" x2="170" y2="270" stroke="#6366F1" stroke-width="1"/>
                            <line x1="142" y1="273" x2="165" y2="273" stroke="#6366F1" stroke-width="1"/>

                            <!-- Laptop 2 -->
                            <rect x="225" y="265" width="35" height="22" rx="2" fill="#7C3AED" opacity="0.8"/>
                            <rect x="227" y="267" width="31" height="17" rx="1" fill="#A78BFA"/>
                            <line x1="227" y1="270" x2="255" y2="270" stroke="#8B5CF6" stroke-width="1"/>
                            <line x1="227" y1="273" x2="250" y2="273" stroke="#8B5CF6" stroke-width="1"/>
                        </g>

                        <!-- Coffee cup -->
                        <g>
                            <ellipse cx="195" cy="268" rx="5" ry="2" fill="#A78BFA"/>
                            <path d="M 190 268 L 190 276 Q 190 278 192.5 278 L 197.5 278 Q 200 278 200 276 L 200 268" fill="#8B5CF6" stroke="#7C3AED" stroke-width="1"/>
                            <!-- Steam animation -->
                            <path d="M 192 264 Q 192 260 194 258" stroke="rgba(255,255,255,0.6)" stroke-width="1" fill="none" stroke-linecap="round">
                                <animate attributeName="opacity" values="0.6;0;0.6" dur="2s" repeatCount="indefinite"/>
                            </path>
                            <path d="M 198 264 Q 198 260 196 258" stroke="rgba(255,255,255,0.6)" stroke-width="1" fill="none" stroke-linecap="round">
                                <animate attributeName="opacity" values="0;0.6;0" dur="2s" repeatCount="indefinite"/>
                            </path>
                        </g>

                        <!-- Person 1 (Left) - Developer with laptop -->
                        <g>
                            <!-- Head -->
                            <circle cx="100" cy="180" r="24" fill="#FCD34D">
                                <animate attributeName="cy" values="180;178;180" dur="4s" repeatCount="indefinite"/>
                            </circle>
                            <!-- Hair -->
                            <path d="M 85 170 Q 100 160 115 170" fill="#78350F" opacity="0.8"/>
                            <!-- Eyes -->
                            <circle cx="93" cy="178" r="2.5" fill="#1e1e1e"/>
                            <circle cx="107" cy="178" r="2.5" fill="#1e1e1e"/>
                            <!-- Smile -->
                            <path d="M 93 188 Q 100 192 107 188" stroke="#1e1e1e" stroke-width="2" fill="none" stroke-linecap="round"/>
                            <!-- Body -->
                            <rect x="85" y="205" width="30" height="55" rx="15" fill="#3B82F6">
                                <animate attributeName="y" values="205;203;205" dur="4s" repeatCount="indefinite"/>
                            </rect>
                            <!-- Left arm (typing) -->
                            <path d="M 85 220 Q 70 225 65 235" stroke="#FCD34D" stroke-width="11" stroke-linecap="round">
                                <animate attributeName="d" values="M 85 220 Q 70 225 65 235; M 85 220 Q 70 223 65 233; M 85 220 Q 70 225 65 235" dur="1s" repeatCount="indefinite"/>
                            </path>
                            <!-- Right arm (typing) -->
                            <path d="M 115 220 Q 130 225 135 235" stroke="#FCD34D" stroke-width="11" stroke-linecap="round">
                                <animate attributeName="d" values="M 115 220 Q 130 225 135 235; M 115 220 Q 130 223 135 233; M 115 220 Q 130 225 135 235" dur="1s" repeatCount="indefinite" begin="0.5s"/>
                            </path>
                            <!-- Legs -->
                            <rect x="92" y="260" width="7" height="30" rx="3" fill="#1e293b"/>
                            <rect x="101" y="260" width="7" height="30" rx="3" fill="#1e293b"/>
                        </g>

                        <!-- Person 2 (Center) - Manager presenting -->
                        <g>
                            <!-- Head -->
                            <circle cx="200" cy="160" r="26" fill="#F59E0B">
                                <animate attributeName="cy" values="160;158;160" dur="3s" repeatCount="indefinite"/>
                            </circle>
                            <!-- Hair -->
                            <ellipse cx="200" cy="150" rx="20" ry="12" fill="#92400E"/>
                            <!-- Eyes -->
                            <circle cx="192" cy="158" r="3" fill="#1e1e1e"/>
                            <circle cx="208" cy="158" r="3" fill="#1e1e1e"/>
                            <!-- Smile -->
                            <path d="M 190 168 Q 200 173 210 168" stroke="#1e1e1e" stroke-width="2" fill="none" stroke-linecap="round"/>
                            <!-- Body -->
                            <rect x="182" y="187" width="36" height="60" rx="18" fill="#8B5CF6">
                                <animate attributeName="y" values="187;185;187" dur="3s" repeatCount="indefinite"/>
                            </rect>
                            <!-- Left arm (pointing) -->
                            <path d="M 182 205 Q 160 200 145 185" stroke="#F59E0B" stroke-width="12" stroke-linecap="round">
                                <animate attributeName="d" values="M 182 205 Q 160 200 145 185; M 182 205 Q 160 195 140 180; M 182 205 Q 160 200 145 185" dur="2s" repeatCount="indefinite"/>
                            </path>
                            <!-- Right arm (gesturing) -->
                            <path d="M 218 205 Q 240 200 255 185" stroke="#F59E0B" stroke-width="12" stroke-linecap="round">
                                <animate attributeName="d" values="M 218 205 Q 240 200 255 185; M 218 205 Q 240 195 260 180; M 218 205 Q 240 200 255 185" dur="2s" repeatCount="indefinite" begin="1s"/>
                            </path>
                            <!-- Legs -->
                            <rect x="192" y="247" width="7" height="35" rx="3" fill="#1e293b"/>
                            <rect x="201" y="247" width="7" height="35" rx="3" fill="#1e293b"/>
                        </g>

                        <!-- Person 3 (Right) - Designer with tablet -->
                        <g>
                            <!-- Head -->
                            <circle cx="300" cy="185" r="23" fill="#EC4899">
                                <animate attributeName="cy" values="185;183;185" dur="3.5s" repeatCount="indefinite"/>
                            </circle>
                            <!-- Hair (ponytail) -->
                            <circle cx="315" cy="180" r="8" fill="#9D174D"/>
                            <ellipse cx="300" cy="175" rx="18" ry="10" fill="#9D174D"/>
                            <!-- Eyes -->
                            <circle cx="293" cy="183" r="2.5" fill="#1e1e1e"/>
                            <circle cx="307" cy="183" r="2.5" fill="#1e1e1e"/>
                            <!-- Smile -->
                            <path d="M 293 192 Q 300 195 307 192" stroke="#1e1e1e" stroke-width="2" fill="none" stroke-linecap="round"/>
                            <!-- Body -->
                            <rect x="285" y="210" width="30" height="52" rx="15" fill="#10B981">
                                <animate attributeName="y" values="210;208;210" dur="3.5s" repeatCount="indefinite"/>
                            </rect>
                            <!-- Left arm (holding tablet) -->
                            <path d="M 285 225 Q 270 230 265 235" stroke="#EC4899" stroke-width="10" stroke-linecap="round"/>
                            <!-- Tablet -->
                            <rect x="255" y="230" width="25" height="18" rx="2" fill="#60A5FA" stroke="#3B82F6" stroke-width="1.5"/>
                            <!-- Right arm (touching tablet) -->
                            <path d="M 315 225 Q 295 235 280 240" stroke="#EC4899" stroke-width="10" stroke-linecap="round">
                                <animate attributeName="d" values="M 315 225 Q 295 235 280 240; M 315 225 Q 295 233 278 238; M 315 225 Q 295 235 280 240" dur="1.5s" repeatCount="indefinite"/>
                            </path>
                            <!-- Legs -->
                            <rect x="292" y="262" width="7" height="28" rx="3" fill="#1e293b"/>
                            <rect x="301" y="262" width="7" height="28" rx="3" fill="#1e293b"/>
                        </g>

                        <!-- Floating notification icons -->
                        <g>
                            <!-- Bell notification -->
                            <g transform="translate(50, 100)">
                                <circle cx="0" cy="0" r="12" fill="#EF4444" opacity="0.9">
                                    <animate attributeName="cy" values="0;-5;0" dur="2s" repeatCount="indefinite"/>
                                </circle>
                                <path d="M -4 -2 Q 0 -6 4 -2 L 4 2 Q 4 4 2 4 L -2 4 Q -4 4 -4 2 Z" fill="white"/>
                                <circle cx="0" cy="5" r="1" fill="white"/>
                            </g>

                            <!-- Message notification -->
                            <g transform="translate(350, 200)">
                                <circle cx="0" cy="0" r="12" fill="#3B82F6" opacity="0.9">
                                    <animate attributeName="cy" values="0;-5;0" dur="2.5s" repeatCount="indefinite"/>
                                </circle>
                                <rect x="-5" y="-3" width="10" height="6" rx="1" fill="white"/>
                                <path d="M -5 -3 L 0 1 L 5 -3" stroke="white" stroke-width="1" fill="none"/>
                            </g>

                            <!-- Check mark -->
                            <g transform="translate(140, 120)">
                                <circle cx="0" cy="0" r="10" fill="#10B981" opacity="0.9">
                                    <animate attributeName="cy" values="0;-4;0" dur="3s" repeatCount="indefinite"/>
                                </circle>
                                <path d="M -3 0 L -1 2 L 3 -2" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                        </g>

                        <!-- Connection lines between people (animated) -->
                        <g opacity="0.3">
                            <line x1="100" y1="200" x2="200" y2="180" stroke="white" stroke-width="2" stroke-dasharray="5,5">
                                <animate attributeName="stroke-dashoffset" from="0" to="10" dur="1s" repeatCount="indefinite"/>
                            </line>
                            <line x1="200" y1="180" x2="300" y2="200" stroke="white" stroke-width="2" stroke-dasharray="5,5">
                                <animate attributeName="stroke-dashoffset" from="0" to="10" dur="1s" repeatCount="indefinite"/>
                            </line>
                        </g>

                        <!-- Text bubbles with animation -->
                        <g>
                            <!-- Bubble 1 -->
                            <ellipse cx="60" cy="160" rx="28" ry="18" fill="rgba(255,255,255,0.95)">
                                <animate attributeName="ry" values="18;20;18" dur="2s" repeatCount="indefinite"/>
                            </ellipse>
                            <polygon points="50,175 42,185 55,178" fill="rgba(255,255,255,0.95)"/>
                            <text x="60" y="165" font-size="20" fill="#667eea" text-anchor="middle">💡</text>

                            <!-- Bubble 2 -->
                            <ellipse cx="340" cy="170" rx="28" ry="18" fill="rgba(255,255,255,0.95)">
                                <animate attributeName="ry" values="18;20;18" dur="2.5s" repeatCount="indefinite"/>
                            </ellipse>
                            <polygon points="350,185 358,195 345,188" fill="rgba(255,255,255,0.95)"/>
                            <text x="340" y="175" font-size="20" fill="#667eea" text-anchor="middle">✓</text>

                            <!-- Bubble 3 -->
                            <ellipse cx="200" cy="120" rx="30" ry="18" fill="rgba(255,255,255,0.95)">
                                <animate attributeName="ry" values="18;20;18" dur="3s" repeatCount="indefinite"/>
                            </ellipse>
                            <polygon points="195,135 190,145 200,138" fill="rgba(255,255,255,0.95)"/>
                            <text x="200" y="126" font-size="20" fill="#667eea" text-anchor="middle">🎯</text>
                        </g>

                        <!-- Success indicator (animated) -->
                        <g transform="translate(360, 340)">
                            <circle cx="0" cy="0" r="18" fill="#10B981" opacity="0.9">
                                <animate attributeName="r" values="18;20;18" dur="2s" repeatCount="indefinite"/>
                            </circle>
                            <path d="M -6 0 L -2 4 L 6 -4" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <animate attributeName="stroke-dasharray" values="0,100;100,0" dur="2s" repeatCount="indefinite"/>
                            </path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="form-header">
                <h1>Log in</h1>
                <p>Enter your credentials to continue</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Google Login Button -->
            <a href="#" class="google-login-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span>Continue with Google</span>
            </a>

            <div class="divider">
                <span>Or</span>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        autofocus
                        autocomplete="username"
                        value="{{ old('email') }}"
                        class="form-input @error('email') input-error @enderror"
                        placeholder="example@email.com">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-field">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="form-input @error('password') input-error @enderror"
                            placeholder="••••••••">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember_me">
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <div class="forgot-password">
                            <a href="{{ route('password.request') }}">
                                <span>Forgot password?</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>

                <button type="submit" class="login-btn">
                    Log in
                </button>
            </form>

            @if (Route::has('register'))
                <div class="register-section">
                    Don't have an account?
                    <a href="{{ route('register') }}">Register now</a>
                </div>
            @endif

            <div class="social-icons">
                <a href="#" class="social-icon" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-icon" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-icon" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const passwordEye = document.getElementById("password-eye");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordEye.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordEye.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</body>
</html>
