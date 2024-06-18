<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Electrodoméstico</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="./css/tailwind.css">
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Registrar Electrodoméstico</h1>
    <form id="formulario" action="" method="POST" class="w-full">
        <div class="mb-5">
            <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre del Electrodoméstico:</label>
            <input type="text" id="nombre" name="nombre" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        <div class="mb-5">
            <label for="color" class="block text-gray-700 font-semibold mb-2">Color:</label>
            <select id="color" name="color" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                <option value="Blanco">Blanco</option>
                <option value="Gris">Gris</option>
                <option value="Negro">Negro</option>
            </select>
        </div>
        <div class="mb-5">
            <label for="consumo" class="block text-gray-700 font-semibold mb-2">Consumo Energético (letras entre A y C):</label>
            <select id="consumo" name="consumo" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>
        <div class="mb-5">
            <label for="peso" class="block text-gray-700 font-semibold mb-2">Peso (en kg):</label>
            <input type="number" id="peso" name="peso" step="0.01" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
        </div>
        <div class="flex items-center justify-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Registrar</button>
        </div>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Función para guardar los datos del formulario en un array asociativo
    function guardarDatosFormulario($postData) {
        return [
            "Nombre" => $postData["nombre"],
            "Color" => $postData["color"],
            "Consumo Energético" => $postData["consumo"],
            "Peso (kg)" => $postData["peso"]
        ];
    }

    // Función para calcular el descuento basado en el color
    function calcularDescuentoColor($color) {
        $descuentos = [
            "Blanco" => 0.05,
            "Gris" => 0.07,
            "Negro" => 0.10
        ];

        return isset($descuentos[$color]) ? $descuentos[$color] : 0;
    }

    // Función para calcular el precio basado en el consumo energético
    function calcularPrecioConsumo($consumo) {
        $precios = [
            "A" => 100,
            "B" => 80,
            "C" => 60
        ];

        return isset($precios[$consumo]) ? $precios[$consumo] : 0;
    }

    // Función para calcular el precio basado en el peso
    function calcularPrecioPeso($peso) {
        $precios = [
            "0-19" => 10,
            "20-49" => 50
        ];

        foreach ($precios as $rango => $precio) {
            list($min, $max) = explode('-', $rango);
            if ($peso >= $min && $peso <= $max) {
                return $precio;
            }
        }

        return 1;
    }

    // Función para mostrar una tabla de datos
    function mostrarTabla($titulo, $datos) {
        echo "<table class='w-full bg-white border border-gray-200 mb-4'>";
        echo "<thead>";
        echo "<tr><th colspan='2' class='py-2 px-2 bg-gray-200 text-gray-700 text-sm'>$titulo</th></tr>";
        echo "<tr><th class='py-2 px-2 border-t text-sm'>Atributo</th><th class='py-2 px-2 border-t text-sm'>Valor</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($datos as $atributo => $valor) {
            echo "<tr>";
            echo "<td class='py-2 px-2 border-t text-sm'>$atributo</td>";
            echo "<td class='py-2 px-2 border-t text-sm'>$valor</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    // Obtener los valores del formulario y guardarlos en un array asociativo
    $datosElectrodomestico = guardarDatosFormulario($_POST);

    // Calcular el descuento
    $descuento = calcularDescuentoColor($datosElectrodomestico["Color"]);

    // Calcular el precio del producto
    $precioConsumo = calcularPrecioConsumo($datosElectrodomestico["Consumo Energético"]);
    $precioPeso = calcularPrecioPeso($datosElectrodomestico["Peso (kg)"]);
    $precio = $precioConsumo * $precioPeso;

    // Calcular el precio con descuento
    $precioDescuento = $precio * $descuento;

    // Agregar el precio y el descuento al array asociativo
    $datosElectrodomestico["Precio del Producto"] = $precio;
    $datosElectrodomestico["Descuento"] = $precioDescuento;

    // Mostrar los datos del electrodoméstico registrado
    echo "<div class='max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-6'>";
    echo "<h2 class='text-2xl font-bold mb-4 text-center text-blue-600'>Electrodoméstico Registrado</h2>";
    mostrarTabla("Atributos", $datosElectrodomestico);
    echo "</div>";

    // Mostrar las tablas adicionales
    echo "<div class='flex flex-wrap justify-center gap-4 max-w-lg mx-auto mt-6'>";
    mostrarTabla("Colores", [
        "Blanco" => "5%",
        "Gris" => "7%",
        "Negro" => "10%"
    ]);
    mostrarTabla("Consumo Energético", [
        "A" => "$100",
        "B" => "$80",
        "C" => "$60"
    ]);
    mostrarTabla("Peso", [
        "Entre 0 y 19 kg" => "$10",
        "Entre 20 y 49 kg" => "$50"
    ]);
    echo "</div>";
}
?>
<script src="./js/validation.js"></script>
</body>
</html>
