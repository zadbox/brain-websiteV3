<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #4CAF50; /* Couleur de l'en-tête */
            padding: 20px;
            text-align: center;
        }
        .email-header img {
            max-width: 120px; /* Taille du logo */
            border-radius: 50%;
        }
        .email-body {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .email-body h2 {
            color: #4CAF50;
            font-size: 22px;
            margin-top: 0;
        }
        .email-body p {
            margin: 8px 0;
            font-size: 16px;
        }
        .footer {
            background-color: #f4f4f4;
            color: #888888;
            font-size: 14px;
            text-align: center;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{asset('/images/a4.png')}}" width="100px" alt="Logo"> <!-- Remplacez par l'URL de votre logo -->
        </div>
        <div class="email-body">
            <h2>Nouveau message de contact</h2>
            <p><strong>Nom :</strong> {{ $data['user-name'] }}</p>
            <p><strong>Email :</strong> {{ $data['user-email'] }}</p>
            <p><strong>Sujet :</strong> {{ $data['user-subject'] }}</p>
            <p><strong>Message :</strong> {{ $data['user-message'] }}</p>
        </div>
        <div class="footer">
            &copy; 2024 BrainGenTech - Tous droits réservés.
        </div>
    </div>
</body>
</html>
