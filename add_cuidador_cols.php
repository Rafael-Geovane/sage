<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;

try {
    DB::statement("ALTER TABLE cuidador ADD COLUMN notificar_push TINYINT(1) DEFAULT 1");
    DB::statement("ALTER TABLE cuidador ADD COLUMN notificar_sms TINYINT(1) DEFAULT 1");
    DB::statement("ALTER TABLE cuidador ADD COLUMN notificar_ligacao TINYINT(1) DEFAULT 1");
    echo "Columns added to cuidador table successfully.";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
