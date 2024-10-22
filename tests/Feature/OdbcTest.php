<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class OdbcTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function databaseText(): void
    {
        try {
            DB::connection('accessMatfink')->getPdo();
            echo "Conexión a la base de datos exitosa.";
        } catch (\Exception $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
}
