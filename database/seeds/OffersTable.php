<?php

use Illuminate\Database\Seeder;

class OffersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('roles')->insert([
          'name' => 'admin',
          'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
          'name' => 'broker',
          'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
          'name' => 'manager',
          'guard_name' => 'web',
        ]);
        
        DB::table('role_has_permissions')->insert([
          'permission_id' => 1,
          'role_id' => 1,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 2,
          'role_id' => 1,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 3,
          'role_id' => 1,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 4,
          'role_id' => 1,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 5,
          'role_id' => 1,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 6,
          'role_id' => 1,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 7,
          'role_id' => 1,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 8,
          'role_id' => 1,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 1,
          'role_id' => 2,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 2,
          'role_id' => 2,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 3,
          'role_id' => 2,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 4,
          'role_id' => 2,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 5,
          'role_id' => 3,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 6,
          'role_id' => 3,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 7,
          'role_id' => 3,
        ]);
        DB::table('role_has_permissions')->insert([
          'permission_id' => 8,
          'role_id' => 3,
        ]);
        
        DB::table('users')->insert([
          'name' => 'tsyganok',
          'email' => 'tsyganok@pharmapark.ru',
          'password' => '$2y$10$29Joq3zcmwU0V7q0.Qlx.uWUYbVBWGDlTk.wWXk7F3lB9L.UudKI.'    
        ]);
        
        DB::table('model_has_roles')->insert([
          'role_id' => 1,
          'model_type' => 'App\User',
          'model_id' => 1    
        ]);
        
        
        DB::table('propertys')->delete();
        DB::table('propertys')->insert([
          'name' => 'Количество этажей в здании',
          'type' => 'cat',
        ]); 
        DB::table('propertys')->insert([
          'name' => 'Год постройки',
          'type' => 'cat',
        ]);      
        DB::table('propertys')->insert([
          'name' => 'Серия дома',
          'type' => 'cat',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Высота потолков, м',
          'type' => 'cat',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Количество пассажирских лифтов',
          'type' => 'cat',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Количество грузовых лифтов',
          'type' => 'cat',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Удаленность от метро',
          'type' => 'cat',
        ]);
        
        
        DB::table('propertys')->insert([
          'name' => 'Площадь комнат, м²',
          'type' => 'offer',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Жилая площадь, м²',
          'type' => 'offer',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Площадь кухни, м²',
          'type' => 'offer',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Количество лоджий',
          'type' => 'offer',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Количество балконов',
          'type' => 'offer',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Количество раздельных с/у',
          'type' => 'offer',
        ]);
        DB::table('propertys')->insert([
          'name' => 'Количество совместных с/у',
          'type' => 'offer',
        ]);
		DB::table('propertys')->insert([
          'name' => 'Высота потолков, м',
          'type' => 'offer',
        ]);

    }
}
