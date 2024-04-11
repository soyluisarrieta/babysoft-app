<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql;
use Spatie\DbDumper\Exceptions\CannotStartDump;

class BackupController extends Controller
{
    public function createBackup()
    {
        try {
            $backupPath = 'backup.sql';

            MySql::create()
                ->setDumpBinaryPath(env('DUMP_BINARY_PATH'))
                ->setDbName(env('DB_DATABASE'))
                ->setUserName(env('DB_USERNAME'))
                ->setPassword(env('DB_PASSWORD'))
                ->dumpToFile(storage_path($backupPath));

            // Descargar el archivo
            return response()->download(storage_path($backupPath));
        } catch (CannotStartDump $exception) {
            return redirect()->back()->with('error', 'Error al crear la copia de seguridad: ' . $exception->getMessage());
        }
    }
}