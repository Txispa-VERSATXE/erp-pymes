<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios
        Usuario::create([
            'nombre'   => 'Admin Principal',
            'email'    => 'admin@erp.com',
            'password' => Hash::make('admin123'),
            'rol'      => 'admin',
        ]);

        Usuario::create([
            'nombre'   => 'María González',
            'email'    => 'maria@erp.com',
            'password' => Hash::make('emp123'),
            'rol'      => 'empleado',
        ]);

        // Clientes
        $c1 = Cliente::create(['nombre' => 'Constructora Asturias SL', 'email' => 'info@constructoraasturias.com', 'telefono' => '985 123 456', 'direccion' => 'C/ Galiana 12, Oviedo']);
        $c2 = Cliente::create(['nombre' => 'Talleres Pérez e Hijos', 'email' => 'taller@perez.es', 'telefono' => '985 654 321', 'direccion' => 'Polígono Industrial Norte, Gijón']);
        $c3 = Cliente::create(['nombre' => 'Farmacia Central', 'email' => 'farmacia@central.com', 'telefono' => '984 112 233', 'direccion' => 'Av. de la Constitución 5, Avilés']);
        $c4 = Cliente::create(['nombre' => 'Restaurante El Puerto', 'email' => 'reservas@elpuerto.es', 'telefono' => '985 778 899', 'direccion' => 'Puerto Deportivo s/n, Avilés']);

        // Proveedores
        $p1 = Proveedor::create(['nombre' => 'TechDistrib SL', 'email' => 'ventas@techdistrib.com', 'telefono' => '91 234 5678']);
        $p2 = Proveedor::create(['nombre' => 'OfficeSupply SA', 'email' => 'pedidos@officesupply.es', 'telefono' => '93 987 6543']);

        // Productos
        $prod1 = Producto::create(['nombre' => 'Monitor 27" 4K', 'categoria' => 'Electrónica', 'precio' => 459.99, 'stock' => 12, 'umbral_min' => 3]);
        $prod2 = Producto::create(['nombre' => 'Teclado Mecánico RGB', 'categoria' => 'Periféricos', 'precio' => 89.95, 'stock' => 2, 'umbral_min' => 5]);
        $prod3 = Producto::create(['nombre' => 'Silla Ergonómica Pro', 'categoria' => 'Mobiliario', 'precio' => 349.00, 'stock' => 7, 'umbral_min' => 2]);
        $prod4 = Producto::create(['nombre' => 'Ratón Inalámbrico', 'categoria' => 'Periféricos', 'precio' => 44.90, 'stock' => 25, 'umbral_min' => 8]);
        $prod5 = Producto::create(['nombre' => 'Auriculares BT', 'categoria' => 'Audio', 'precio' => 199.00, 'stock' => 1, 'umbral_min' => 4]);
        $prod6 = Producto::create(['nombre' => 'Disco SSD 1TB', 'categoria' => 'Almacenamiento', 'precio' => 119.99, 'stock' => 18, 'umbral_min' => 5]);

        // Ventas
        $v1 = Venta::create(['cliente_id' => $c1->id, 'usuario_id' => 1, 'fecha_venta' => '2025-03-10', 'total' => 919.98, 'estado' => 'pagado']);
        DetalleVenta::create(['venta_id' => $v1->id, 'producto_id' => $prod1->id, 'cantidad' => 2, 'precio_unit' => 459.99]);

        $v2 = Venta::create(['cliente_id' => $c2->id, 'usuario_id' => 1, 'fecha_venta' => '2025-03-14', 'total' => 134.85, 'estado' => 'pagado']);
        DetalleVenta::create(['venta_id' => $v2->id, 'producto_id' => $prod2->id, 'cantidad' => 1, 'precio_unit' => 89.95]);
        DetalleVenta::create(['venta_id' => $v2->id, 'producto_id' => $prod4->id, 'cantidad' => 1, 'precio_unit' => 44.90]);

        $v3 = Venta::create(['cliente_id' => $c3->id, 'usuario_id' => 1, 'fecha_venta' => '2026-04-02', 'total' => 349.00, 'estado' => 'pendiente']);
        DetalleVenta::create(['venta_id' => $v3->id, 'producto_id' => $prod3->id, 'cantidad' => 1, 'precio_unit' => 349.00]);

        $v4 = Venta::create(['cliente_id' => $c4->id, 'usuario_id' => 1, 'fecha_venta' => '2026-04-10', 'total' => 199.00, 'estado' => 'pendiente']);
        DetalleVenta::create(['venta_id' => $v4->id, 'producto_id' => $prod5->id, 'cantidad' => 1, 'precio_unit' => 199.00]);

        // Compras
        $comp1 = Compra::create(['proveedor_id' => $p1->id, 'usuario_id' => 1, 'fecha_compra' => '2025-02-28', 'total' => 2399.95, 'estado' => 'recibido']);
        DetalleCompra::create(['compra_id' => $comp1->id, 'producto_id' => $prod1->id, 'cantidad' => 5, 'costo_unit' => 340.00]);
        DetalleCompra::create(['compra_id' => $comp1->id, 'producto_id' => $prod6->id, 'cantidad' => 10, 'costo_unit' => 89.99]);

        $comp2 = Compra::create(['proveedor_id' => $p2->id, 'usuario_id' => 1, 'fecha_compra' => '2025-03-15', 'total' => 699.80, 'estado' => 'recibido']);
        DetalleCompra::create(['compra_id' => $comp2->id, 'producto_id' => $prod4->id, 'cantidad' => 20, 'costo_unit' => 34.99]);
    }
}