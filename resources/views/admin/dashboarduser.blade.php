<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Restreint</title>
    <style>
        /* Styles généraux */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        /* Conteneur principal */
        .container {
            background: linear-gradient(135deg, #FFA3B5, #FF758F);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(255, 163, 181, 0.4);
            max-width: 500px;
            width: 90%;
            animation: fadeIn 1s ease-in-out;
        }

        /* Animation d’apparition */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            font-size: 2em;
            color: #121212;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.1em;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .warning {
            font-weight: bold;
            color: #8B0000;
            font-size: 1.2em;
        }

        /* Bouton de téléchargement */
        .download-btn {
            background-color: #121212;
            color: #FFA3B5;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            background-color: white;
            color: #121212;
            transform: scale(1.05);
        }

        /* Bouton de déconnexion */
        .logout-link {
            display: block;
            margin-top: 20px;
            color: white;
            text-decoration: none;
            font-size: 1em;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .logout-link:hover {
            color: #FFEBEB;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Bonjour {{ Auth::user()->name }}</h1>
        <p>Vous ne pouvez pas accéder au site web.</p>
        <p class="warning">Même si vous avez un compte, il faut installer l'application <strong>Accent Flow</strong> pour continuer.</p>
        <a href="https://example.com/accentflow" class="download-btn">📥 Télécharger l'application</a>
    </div>

    <a href="{{ route('logout') }}" 
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
        class="logout-link">
        🚪 Déconnexion
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</body>
</html>
