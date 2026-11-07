<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e60be">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'BUBA - Belajar, Bermain, Berkembang')</title>

    @include('layouts.partials.favicon')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --sky: #5ebef3;
            --sky-hover: #47ade7;
            --sky-deep: #3898cf;
            --blue: #1e60be;
            --blue-deep: #154a94;
            --green: #71bf4f;
            --green-deep: #5ba23c;
            --orange: #faa63a;
            --orange-deep: #e89427;
            --pink: #d8759c;
            --pink-deep: #b8567c;
            --yellow: #ffd629;
            --yellow-deep: #e0b400;
            --cream: #fff9ef;
            --ink: #24324a;
            --muted: #5b6b82;
            --line: #dbe7f3;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(20px, 4vw, 48px) clamp(14px, 3vw, 28px);
            overflow-x: hidden;
            color: var(--ink);
            background:
                radial-gradient(900px 620px at 12% 8%, rgba(94, 190, 243, 0.30), transparent 62%),
                radial-gradient(760px 520px at 88% 16%, rgba(255, 214, 41, 0.26), transparent 62%),
                radial-gradient(820px 620px at 50% 108%, rgba(216, 117, 156, 0.18), transparent 65%),
                var(--cream);
            font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: radial-gradient(rgba(30, 96, 190, 0.13) 1.6px, transparent 1.6px);
            background-size: 26px 26px;
            -webkit-mask-image: linear-gradient(to bottom, black, transparent 72%);
            mask-image: linear-gradient(to bottom, black, transparent 72%);
            opacity: 0.55;
            z-index: 0;
        }

        .bg-decor {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .blob {
            position: absolute;
            border-radius: 999px;
            filter: blur(60px);
            opacity: 0.55;
        }

        .blob-1 {
            width: 300px;
            height: 300px;
            top: -110px;
            left: -90px;
            background: rgba(94, 190, 243, 0.45);
        }

        .blob-2 {
            width: 260px;
            height: 260px;
            bottom: -90px;
            right: -70px;
            background: rgba(216, 117, 156, 0.32);
        }

        .blob-3 {
            width: 220px;
            height: 220px;
            top: 18%;
            right: -80px;
            background: rgba(255, 214, 41, 0.35);
        }

        .cloud {
            position: absolute;
            color: rgba(255, 255, 255, 0.92);
            filter: drop-shadow(0 8px 16px rgba(30, 96, 190, 0.10));
        }

        .cloud-1 {
            width: clamp(90px, 12vw, 150px);
            top: 9%;
            left: 5%;
            animation: cloud-drift 18s ease-in-out infinite;
        }

        .cloud-2 {
            width: clamp(110px, 15vw, 190px);
            top: 16%;
            right: 4%;
            animation: cloud-drift 24s ease-in-out infinite reverse;
        }

        .cloud-3 {
            width: clamp(80px, 11vw, 130px);
            bottom: 8%;
            left: 9%;
            opacity: 0.8;
            animation: float-soft 7s ease-in-out infinite;
        }

        .star {
            position: absolute;
            color: var(--yellow);
            filter: drop-shadow(0 4px 8px rgba(224, 180, 0, 0.35));
        }

        .star-1 {
            width: 30px;
            top: 13%;
            left: 24%;
            animation: wiggle 3.4s ease-in-out infinite;
        }

        .star-2 {
            width: 22px;
            top: 30%;
            right: 19%;
            animation: float-soft 5s ease-in-out infinite 0.6s;
        }

        .star-3 {
            width: 18px;
            bottom: 20%;
            right: 26%;
            color: var(--pink);
            animation: wiggle 4.2s ease-in-out infinite 0.3s;
        }

        .page {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 22px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 22px;
            outline: none;
            animation: float-soft 6s ease-in-out infinite;
        }

        .brand:focus-visible {
            box-shadow: 0 0 0 5px rgba(94, 190, 243, 0.45);
        }

        .brand img {
            display: block;
            width: auto;
            height: clamp(62px, 10vw, 86px);
            object-fit: contain;
            filter: drop-shadow(0 10px 18px rgba(30, 96, 190, 0.20));
            user-select: none;
            -webkit-user-drag: none;
        }

        .card {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: clamp(34px, 6vw, 52px) clamp(20px, 5vw, 52px) clamp(28px, 5vw, 40px);
            text-align: center;
            background: rgba(255, 255, 255, 0.94);
            border: 7px solid #ffffff;
            border-radius: clamp(30px, 6vw, 44px);
            box-shadow:
                0 26px 60px rgba(30, 96, 190, 0.18),
                0 10px 0 rgba(30, 96, 190, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            animation: card-pop 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0 0 auto 0;
            height: 8px;
            background: linear-gradient(90deg, var(--sky) 0%, var(--yellow) 28%, var(--green) 52%, var(--orange) 74%, var(--pink) 100%);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 auto 20px;
            padding: 8px 16px;
            border-radius: 999px;
            background: #fff8dd;
            border: 2px solid rgba(255, 214, 41, 0.75);
            color: #836700;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            box-shadow: 0 4px 0 rgba(255, 214, 41, 0.22);
        }

        .badge-dot {
            position: relative;
            display: inline-flex;
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: var(--yellow);
        }

        .badge-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: inherit;
            border: 2px solid rgba(255, 214, 41, 0.45);
            animation: pulse-ring 2.2s ease-out infinite;
        }

        .badge--sky {
            background: #eaf7fe;
            border-color: rgba(94, 190, 243, 0.75);
            color: #176a9c;
            box-shadow: 0 4px 0 rgba(94, 190, 243, 0.22);
        }

        .badge--sky .badge-dot {
            background: var(--sky);
        }

        .badge--sky .badge-dot::after {
            border-color: rgba(94, 190, 243, 0.45);
        }

        /* ---------- Ilustrasi 404 ---------- */
        .error-art {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: clamp(8px, 2vw, 16px);
            min-height: clamp(120px, 24vw, 168px);
            margin: 0 auto 26px;
        }

        .digit {
            position: relative;
            z-index: 1;
            display: grid;
            place-items: center;
            width: clamp(74px, 17vw, 108px);
            height: clamp(86px, 19vw, 122px);
            border: 6px solid #ffffff;
            border-radius: clamp(20px, 4vw, 30px);
            font-family: 'Baloo 2', 'Nunito', system-ui, sans-serif;
            font-size: clamp(48px, 11vw, 76px);
            font-weight: 800;
            line-height: 1;
            text-shadow: 0 3px 0 rgba(0, 0, 0, 0.10);
            user-select: none;
        }

        .digit--sky {
            background: linear-gradient(180deg, #7ccdf7 0%, var(--sky) 100%);
            color: #ffffff;
            transform: rotate(-7deg);
            box-shadow: 0 9px 0 var(--sky-deep), 0 16px 26px rgba(56, 152, 207, 0.30);
        }

        .digit--yellow {
            background: linear-gradient(180deg, #ffe37d 0%, var(--yellow) 100%);
            color: var(--blue);
            transform: translateY(-10px) rotate(2deg);
            box-shadow: 0 9px 0 var(--yellow-deep), 0 18px 28px rgba(224, 180, 0, 0.30);
            text-shadow: 0 3px 0 rgba(255, 255, 255, 0.45);
        }

        .digit--pink {
            background: linear-gradient(180deg, #e591b2 0%, var(--pink) 100%);
            color: #ffffff;
            transform: rotate(7deg);
            box-shadow: 0 9px 0 var(--pink-deep), 0 16px 26px rgba(184, 86, 124, 0.30);
        }

        .digit-spark {
            position: absolute;
            top: -10px;
            right: -10px;
            display: grid;
            place-items: center;
            width: 28px;
            height: 28px;
            border-radius: 999px;
            background: #ffffff;
            border: 3px solid #fff;
            color: var(--yellow);
            font-size: 15px;
            line-height: 1;
            box-shadow: 0 4px 10px rgba(30, 96, 190, 0.18);
            animation: wiggle 3s ease-in-out infinite;
        }

        .error-art .mini-cloud {
            position: absolute;
            left: 50%;
            bottom: -14px;
            width: clamp(160px, 40vw, 240px);
            transform: translateX(-50%);
            color: #eaf5fd;
            z-index: 0;
        }

        /* ---------- Ilustrasi development ---------- */
        .dev-art {
            position: relative;
            display: grid;
            place-items: center;
            width: clamp(150px, 32vw, 196px);
            height: clamp(150px, 32vw, 196px);
            margin: 0 auto 22px;
        }

        .dev-halo {
            position: absolute;
            inset: 8%;
            border-radius: 999px;
            background: radial-gradient(circle at 34% 28%, #dff3ff 0%, #bfe7fb 48%, #9fd8f5 100%);
            border: 6px solid #ffffff;
            box-shadow:
                0 14px 0 rgba(56, 152, 207, 0.28),
                0 22px 34px rgba(30, 96, 190, 0.20);
            animation: pulse-soft 4.2s ease-in-out infinite;
        }

        .dev-halo::after {
            content: '';
            position: absolute;
            inset: -18px;
            border-radius: inherit;
            border: 2px dashed rgba(94, 190, 243, 0.55);
            animation: spin-slow 24s linear infinite;
        }

        .dev-emoji {
            position: relative;
            z-index: 1;
            font-size: clamp(64px, 15vw, 92px);
            line-height: 1;
            filter: drop-shadow(0 10px 14px rgba(30, 96, 190, 0.22));
            animation: float-soft 4.5s ease-in-out infinite;
        }

        .dev-tool {
            position: absolute;
            right: 2%;
            bottom: 6%;
            z-index: 2;
            display: grid;
            place-items: center;
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: #ffffff;
            border: 4px solid #ffffff;
            font-size: 22px;
            box-shadow: 0 6px 14px rgba(30, 96, 190, 0.20);
            animation: wiggle 3.6s ease-in-out infinite;
        }

        .dev-spark {
            position: absolute;
            font-size: 20px;
            line-height: 1;
            filter: drop-shadow(0 4px 6px rgba(30, 96, 190, 0.18));
        }

        .dev-spark-1 {
            top: 6%;
            left: 4%;
            animation: float-soft 4s ease-in-out infinite 0.2s;
        }

        .dev-spark-2 {
            top: 12%;
            right: 4%;
            animation: wiggle 3.2s ease-in-out infinite;
        }

        .dev-spark-3 {
            bottom: 16%;
            left: 0;
            font-size: 15px;
            animation: float-soft 5.2s ease-in-out infinite 0.5s;
        }

        /* ---------- Teks & aksi ---------- */
        .title {
            margin: 0 0 12px;
            color: var(--blue);
            font-family: 'Baloo 2', 'Nunito', system-ui, sans-serif;
            font-size: clamp(1.65rem, 4.6vw, 2.55rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.01em;
        }

        .marker {
            position: relative;
            display: inline-block;
            z-index: 0;
        }

        .marker::after {
            content: '';
            position: absolute;
            left: -3px;
            right: -3px;
            bottom: 2px;
            height: 38%;
            border-radius: 8px;
            background: rgba(255, 214, 41, 0.55);
            z-index: -1;
            transform: rotate(-1deg);
        }

        .lead {
            max-width: 46ch;
            margin: 0 auto;
            color: var(--muted);
            font-size: clamp(0.94rem, 2vw, 1.04rem);
            font-weight: 600;
            line-height: 1.75;
        }

        .lead strong {
            color: var(--blue);
            font-weight: 900;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-top: clamp(24px, 4vw, 32px);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 14px 27px;
            border-radius: 999px;
            border: 3px solid #ffffff;
            font-family: 'Nunito', system-ui, sans-serif;
            font-size: 0.95rem;
            font-weight: 900;
            line-height: 1.2;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.16s ease, box-shadow 0.16s ease, background 0.16s ease;
            white-space: nowrap;
        }

        .btn svg {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
        }

        .btn-primary {
            color: #ffffff;
            background: linear-gradient(180deg, #6cc6f6 0%, var(--sky) 100%);
            box-shadow:
                0 7px 0 var(--sky-deep),
                0 14px 24px rgba(56, 152, 207, 0.30);
        }

        .btn-primary:hover {
            background: linear-gradient(180deg, var(--sky) 0%, var(--sky-hover) 100%);
            transform: translateY(-2px);
            box-shadow:
                0 9px 0 var(--sky-deep),
                0 18px 28px rgba(56, 152, 207, 0.32);
        }

        .btn-primary:active {
            transform: translateY(4px);
            box-shadow:
                0 2px 0 var(--sky-deep),
                0 6px 12px rgba(56, 152, 207, 0.24);
        }

        .btn-secondary {
            color: var(--blue);
            background: #ffffff;
            border-color: var(--line);
            box-shadow: 0 6px 0 var(--line);
        }

        .btn-secondary:hover {
            background: #f5fbff;
            transform: translateY(-2px);
            box-shadow: 0 8px 0 var(--line);
        }

        .btn-secondary:active {
            transform: translateY(4px);
            box-shadow: 0 1px 0 var(--line);
        }

        .btn:focus-visible {
            outline: none;
            box-shadow: 0 0 0 5px rgba(94, 190, 243, 0.40), 0 7px 0 var(--sky-deep);
        }

        .note {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin: 24px auto 0;
            padding: 9px 15px;
            border-radius: 999px;
            background: #f3f8fc;
            border: 1.5px dashed rgba(94, 190, 243, 0.55);
            color: #6a7d94;
            font-size: 0.76rem;
            font-weight: 800;
            line-height: 1.4;
        }

        .note span {
            font-size: 0.95rem;
            line-height: 1;
        }

        /* ---------- Progres development ---------- */
        .progress-box {
            margin: 26px auto 0;
            max-width: 420px;
            padding: 16px 18px 15px;
            border-radius: 20px;
            background: #f5fbff;
            border: 2px solid #e2eff9;
            text-align: left;
        }

        .progress-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 9px;
            color: #46617d;
            font-size: 0.78rem;
            font-weight: 900;
            letter-spacing: 0.03em;
        }

        .progress-head strong {
            color: var(--blue);
            font-size: 0.9rem;
        }

        .progress-track {
            position: relative;
            height: 14px;
            overflow: hidden;
            border-radius: 999px;
            background: #deeef9;
            box-shadow: inset 0 2px 3px rgba(30, 96, 190, 0.12);
        }

        .progress-fill {
            position: relative;
            display: block;
            width: 72%;
            height: 100%;
            border-radius: inherit;
            background:
                linear-gradient(45deg, rgba(255, 255, 255, 0.35) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.35) 50%, rgba(255, 255, 255, 0.35) 75%, transparent 75%) 0 0 / 22px 22px,
                linear-gradient(90deg, var(--sky) 0%, #6cc6f6 100%);
            animation: stripe-slide 1s linear infinite;
            box-shadow: 0 2px 5px rgba(56, 152, 207, 0.30);
        }

        .progress-caption {
            margin: 9px 0 0;
            color: #7b8da3;
            font-size: 0.72rem;
            font-weight: 700;
            line-height: 1.5;
        }

        .chips {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-top: 20px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 999px;
            border: 2px solid transparent;
            font-size: 0.76rem;
            font-weight: 900;
            line-height: 1.2;
        }

        .chip--green {
            color: var(--green-deep);
            background: rgba(113, 191, 79, 0.12);
            border-color: rgba(113, 191, 79, 0.38);
        }

        .chip--orange {
            color: var(--orange-deep);
            background: rgba(250, 166, 58, 0.12);
            border-color: rgba(250, 166, 58, 0.40);
        }

        .chip--pink {
            color: var(--pink-deep);
            background: rgba(216, 117, 156, 0.12);
            border-color: rgba(216, 117, 156, 0.40);
        }

        .chip--sky {
            color: #1a7eaf;
            background: rgba(94, 190, 243, 0.12);
            border-color: rgba(94, 190, 243, 0.42);
        }

        /* ---------- Footer ---------- */
        .page-footer {
            text-align: center;
            color: #8897aa;
            font-size: 0.74rem;
            font-weight: 700;
            line-height: 1.7;
        }

        .page-footer p {
            margin: 0;
        }

        .page-footer strong {
            color: var(--blue);
            font-weight: 900;
        }

        /* ---------- Animasi ---------- */
        @keyframes card-pop {
            0% {
                opacity: 0;
                transform: scale(0.94) translateY(18px);
            }

            70% {
                opacity: 1;
                transform: scale(1.01) translateY(-3px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes float-soft {
            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes cloud-drift {
            0%,
            100% {
                transform: translateX(-4%);
            }

            50% {
                transform: translateX(5%);
            }
        }

        @keyframes wiggle {
            0%,
            100% {
                transform: rotate(-5deg);
            }

            50% {
                transform: rotate(5deg);
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 0.9;
            }

            100% {
                transform: scale(1.8);
                opacity: 0;
            }
        }

        @keyframes pulse-soft {
            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.035);
            }
        }

        @keyframes spin-slow {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes stripe-slide {
            to {
                background-position: 22px 0;
            }
        }

        @media (max-width: 480px) {
            .actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
            }

            .note {
                border-radius: 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
            }
        }
    </style>
</head>

<body>
    <div class="bg-decor" aria-hidden="true">
        <span class="blob blob-1"></span>
        <span class="blob blob-2"></span>
        <span class="blob blob-3"></span>

        <svg class="cloud cloud-1" viewBox="0 0 100 60" fill="currentColor">
            <path
                d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
        </svg>
        <svg class="cloud cloud-2" viewBox="0 0 100 60" fill="currentColor">
            <path
                d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
        </svg>
        <svg class="cloud cloud-3" viewBox="0 0 100 60" fill="currentColor">
            <path
                d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
        </svg>

        <svg class="star star-1" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.9 6.2 6.8.9-5 4.8 1.3 6.7-6-3.3-6 3.3 1.3-6.7-5-4.8 6.8-.9z" />
        </svg>
        <svg class="star star-2" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.9 6.2 6.8.9-5 4.8 1.3 6.7-6-3.3-6 3.3 1.3-6.7-5-4.8 6.8-.9z" />
        </svg>
        <svg class="star star-3" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l2.9 6.2 6.8.9-5 4.8 1.3 6.7-6-3.3-6 3.3 1.3-6.7-5-4.8 6.8-.9z" />
        </svg>
    </div>

    <main class="page">
        <a class="brand" href="{{ url('/') }}" aria-label="BUBA - kembali ke beranda">
            <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA - Belajar, Bermain, Berkembang">
        </a>

        <section class="card">
            @yield('content')
        </section>

        <footer class="page-footer">
            <p><strong>BUBA</strong> &middot; Belajar, Bermain, Berkembang</p>
            <p>&copy; {{ date('Y') }} NAJATIF. All rights reserved.</p>
        </footer>
    </main>
</body>

</html>
