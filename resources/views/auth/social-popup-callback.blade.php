<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticacao</title>
</head>
<body>
    <script>
        (function () {
            var payload = {
                type: 'google-auth-callback',
                success: @json($success),
                redirectUrl: @json($redirectUrl),
                message: @json($message),
            };

            if (window.opener && !window.opener.closed) {
                window.opener.postMessage(payload, window.location.origin);
                window.close();
                return;
            }

            window.location.href = payload.redirectUrl;
        })();
    </script>
</body>
</html>
