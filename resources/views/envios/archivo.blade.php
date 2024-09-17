<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio PDF</title>
    <style>
        /* Agrega estilos para que se vea bien en el PDF */
        body {
            font-family: 'Arial', sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Envio: {{ $envio->id }}</h1>

    <p><strong>Prestador:</strong> {{ $envio->PRESTADOR }}</p>
    <p><strong>Obra Social:</strong> {{ $envio->OBRASOCIAL }}</p>
    <p><strong>Afiliado:</strong> {{ $envio->AFILIADO }}</p>
    <p><strong>Periodo:</strong> {{ $envio->PERIODO }}</p>
    <p><strong>Prestación:</strong> {{ $envio->PRESTACION }}</p>
    <p><strong>Documento:</strong></p>
    <a href="{{ asset('storage/' . $envio->DOCUMENTACION) }}" target="_blank">Ver Documento</a></p>
</body>
</html>