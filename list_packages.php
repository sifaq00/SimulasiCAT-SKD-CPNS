<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Package;

$packages = Package::all();
foreach ($packages as $p) {
    echo "ID: {$p->id} | Name: {$p->name} | Slug: {$p->slug}\n";
}
