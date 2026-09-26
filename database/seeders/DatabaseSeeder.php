<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
=======
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    
        DB::table('roles')->insertOrIgnore([
            ['id_rol' => 1, 'nombre' => 'Administrador', 'descripcion' => 'Acceso total'],
            ['id_rol' => 2, 'nombre' => 'Donante', 'descripcion' => 'Usuario donador de alimentos'],
            ['id_rol' => 3, 'nombre' => 'Comedor', 'descripcion' => 'Representante de comedor comunitario'],
            ['id_rol' => 4, 'nombre' => 'Voluntario', 'descripcion' => 'Apoyo en logística y distribución'],
        ]);

      
        for ($i = 1; $i <= 11; $i++) {
            DB::table('usuarios')->insertOrIgnore([
                'id_usuario'     => $i,
                'id_rol'         => ($i === 1) ? 1 : (($i % 2 === 0) ? 2 : 3),
                'nombre'         => ($i === 1) ? 'Salma Betzabeth' : "Usuario $i",
                'apellido'       => ($i === 1) ? 'Flores' : "Apellido $i",
                'email'          => ($i === 1) ? 'salma.flores@gmail.com' : "usuario$i@ejemplo.com",
                'password'       => Hash::make('password123'),
                'teléfono'       => "330000000$i",
                'direccion'      => "Calle Falsa #$i",
                'tipo_login'     => 'local',
                'estado'         => 1,
                'fecha_registro' => now()->subDays(12 - $i),
            ]);
        }


        $alimentos = [
            ['nombre' => 'Manzanas Red', 'categoria' => 'Frutas y Verduras', 'cantidad' => 15, 'unidad' => 'Cajas', 'estado' => 'Disponible', 'descripcion' => 'Caja de manzanas rojas frescas.'],
            ['nombre' => 'Pan Blanco', 'categoria' => 'Panadería', 'cantidad' => 30, 'unidad' => 'Paquetes', 'estado' => 'Por Expirar', 'descripcion' => 'Paquetes de pan de caja.'],
            ['nombre' => 'Leche Entera', 'categoria' => 'Lácteos', 'cantidad' => 25, 'unidad' => 'Piezas', 'estado' => 'Disponible', 'descripcion' => 'Cartones de leche entera 1L.'],
            ['nombre' => 'Arroz Integral', 'categoria' => 'Granos', 'cantidad' => 40, 'unidad' => 'Kilos', 'estado' => 'Disponible', 'descripcion' => 'Bolsas de arroz integral 1kg.'],
            ['nombre' => 'Frijol Negro', 'categoria' => 'Granos', 'cantidad' => 50, 'unidad' => 'Kilos', 'estado' => 'Disponible', 'descripcion' => 'Bolsas de frijol negro 1kg.'],
            ['nombre' => 'Naranjas', 'categoria' => 'Frutas y Verduras', 'cantidad' => 10, 'unidad' => 'Cajas', 'estado' => 'Disponible', 'descripcion' => 'Cajas de naranja para jugo.'],
            ['nombre' => 'Zanahorias', 'categoria' => 'Frutas y Verduras', 'cantidad' => 20, 'unidad' => 'Bolsas', 'estado' => 'Disponible', 'descripcion' => 'Bolsas de zanahoria fresca.'],
            ['nombre' => 'Pasta Espagueti', 'categoria' => 'Enlatados y Secos', 'cantidad' => 60, 'unidad' => 'Paquetes', 'estado' => 'Disponible', 'descripcion' => 'Paquetes de pasta espagueti 500g.'],
            ['nombre' => 'Atún en Agua', 'categoria' => 'Enlatados y Secos', 'cantidad' => 80, 'unidad' => 'Latas', 'estado' => 'Disponible', 'descripcion' => 'Latas de atún en agua 140g.'],
            ['nombre' => 'Avena Natural', 'categoria' => 'Granos', 'cantidad' => 18, 'unidad' => 'Bolsas', 'estado' => 'Disponible', 'descripcion' => 'Bolsas de avena en hojuelas.'],
            ['nombre' => 'Lenteja', 'categoria' => 'Granos', 'cantidad' => 35, 'unidad' => 'Kilos', 'estado' => 'Disponible', 'descripcion' => 'Bolsas de lenteja 1kg.'],
        ];

        foreach ($alimentos as $index => $alimento) {
            DB::table('alimentos')->insertOrIgnore(array_merge($alimento, [
                'id_alimento'       => $index + 1,
                'id_usuario'        => ($index % 11) + 1,
                'fecha_publicacion' => now()->subDays(10 - $index),
                'fecha_caducidad'   => now()->addDays(15),
            ]));
        }

        
        for ($i = 1; $i <= 10; $i++) {
            DB::table('ordenes')->insertOrIgnore([
                'id_orden'   => $i,
                'id_usuario' => ($i % 11) + 1,
                'estado'     => ($i % 2 == 0) ? 'En Camino' : 'Entregado',
            ]);

            DB::table('orden_detalle')->insertOrIgnore([
                'id_orden'    => $i,
                'id_alimento' => ($i % 11) + 1,
                'cantidad'    => $i * 2,
            ]);
        }

        
        for ($i = 1; $i <= 10; $i++) {
            DB::table('carritos')->insertOrIgnore([
                'id_carrito' => $i,
                'id_usuario' => ($i % 11) + 1,
            ]);

            DB::table('carrito_detalles')->insertOrIgnore([
                'id_carrito'  => $i,
                'id_alimento' => ($i % 11) + 1,
                'cantidad'    => $i + 1,
            ]);
        }

        
        for ($i = 1; $i <= 10; $i++) {
            DB::table('lista_deseos')->insertOrIgnore([
                'id_lista'   => $i,
                'id_usuario' => ($i % 11) + 1,
            ]);

            DB::table('lista_deseos_detalles')->insertOrIgnore([
                'id_lista'    => $i,
                'id_alimento' => ($i % 11) + 1,
            ]);
        }

      
        for ($i = 1; $i <= 10; $i++) {
            DB::table('logs')->insertOrIgnore([
                'id_log'     => $i,
                'id_usuario' => ($i % 11) + 1,
                'accion'     => ($i % 2 == 0) ? 'Registro de insumo en catálogo' : 'Generación de orden de entrega',
                'fecha'      => now()->subHours($i * 3),
            ]);
        }
    }
}
>>>>>>> 0703bea (Actividad 2.5)
