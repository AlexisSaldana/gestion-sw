<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            text-align: center;
            position: fixed;
            width: 100%;
        }
        .header {
            top: 0;
        }
        .footer {
            bottom: 0;
        }
        .content {
            margin: 50px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Consulta Médica</h1>
    </div>

    <div class="content">
        <h2>Datos de la Consulta</h2>
        <p><strong>Médico:</strong> {{ $consulta->cita->usuarioMedico->nombres }} {{ $consulta->cita->usuarioMedico->apepat }}</p>
        <p><strong>Enfermera:</strong> 
        @if ($consulta->cita->enfermera)
            {{ $consulta->cita->enfermera->nombres }} {{ $consulta->cita->enfermera->apepat }}
        @else
            No asignada
        @endif      
        <p><strong>Paciente:</strong> {{ $consulta->cita->paciente->nombres }} {{ $consulta->cita->paciente->apepat }} {{ $consulta->cita->paciente->apemat }}</p>
        <p><strong>Fecha:</strong> {{ $consulta->cita->fecha }}</p>
        <p><strong>Hora:</strong> {{ $consulta->cita->hora }}</p>
        <p><strong>Estado:</strong> {{ $consulta->estado }}</p>

        <h3>Motivo de la Consulta</h3>
        <p>{{ $consulta->motivo }}</p>

        <h3>Datos Médicos</h3>
        <p><strong>Talla:</strong> {{ $consulta->talla }}</p>
        <p><strong>Temperatura:</strong> {{ $consulta->temperatura }}</p>
        <p><strong>Saturación de Oxígeno:</strong> {{ $consulta->saturacion_oxigeno }}</p>
        <p><strong>Frecuencia Cardíaca:</strong> {{ $consulta->frecuencia_cardiaca }}</p>
        <p><strong>Peso:</strong> {{ $consulta->peso }}</p>
        <p><strong>Tensión Arterial:</strong> {{ $consulta->tension_arterial }}</p>
        <p><strong>Padecimiento:</strong> {{ $consulta->padecimiento }}</p>

        <h3>Productos</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consulta->productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->pivot->cantidad }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->precio * $producto->pivot->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Servicios</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consulta->servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->precio }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total a Pagar</h3>
        <p>{{ $consulta->total_pagar }}</p>
    </div>

    <div class="footer">
        <p>Consulta generada el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
