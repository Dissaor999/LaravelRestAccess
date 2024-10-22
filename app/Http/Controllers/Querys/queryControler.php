<?php

namespace App\Http\Controllers\Querys;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class queryControler extends Controller
{
    public function execQuery(Request $request): JsonResponse
    {
        $query = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $request['query']);
        try {
            $user = ""; //Si se requiere para acceder a Access
            $passa = ""; //Si se requiere para acceder a Access 
            $conacc = odbc_connect("Dissaor", $user, $passa) or die('Error connecting to server. Server says: ' . htmlspecialchars(odbc_errormsg()) . '');
            $queryrexec = odbc_exec($conacc, $query);
            $data = array();
            $i = 0;
            while ($row = odbc_fetch_object($queryrexec)) {
                $data[$i] = mb_convert_encoding($row, "UTF-8", "iso-8859-1");
                $i++;
            }
            $msg = [
                "query" => $query,
                "total" => $i,
                "mensaje" => $data
            ];
            odbc_close($conacc);
            return response()->json($msg, 200);
        } catch (\Exception $e) {
            //die("Error al conectar a la base de datos: " . $e->getMessage());
            $msg = ["query" => $query, "mensaje" => "Error en la base base de datos: " . $e->getMessage()];
            return response()->json($msg, 400);
        }
    }
}
