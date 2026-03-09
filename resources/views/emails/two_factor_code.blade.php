<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto;
        }
        .code-display {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748;
            background: #f7fafc;
            padding: 15px;
            text-align: center;
            border: 1px dashed #cbd5e0;
            letter-spacing: 5px;
            margin: 20px 0;
        }
        .footer {
            font-size: 12px;
            color: #718096;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Autenticação de Dois Fatores</h2>
        <p>Olá,</p>
        <p>Recebemos uma solicitação de login para a sua conta. Use o código abaixo para prosseguir:</p>
        
        <div class="code-display">
            {{ $code }}
        </div>

        <p>Este código expira em breve. Se você não solicitou este acesso, por favor, ignore este e-mail ou altere sua senha.</p>
        
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>