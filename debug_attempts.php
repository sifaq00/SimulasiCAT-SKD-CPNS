<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TestAttempt;
use App\Models\User;
use App\Models\Transaction;

echo "--- USERS ---\n";
foreach (User::all() as $u) {
    echo "ID: {$u->id} | Email: {$u->email} | Name: {$u->name}\n";
}

echo "\n--- TRANSACTIONS ---\n";
foreach (Transaction::all() as $tr) {
    echo "ID: {$tr->id} | User: {$tr->user_id} | Status: {$tr->status} | Pkg: {$tr->package_id}\n";
}

echo "\n--- TEST ATTEMPTS ---\n";
foreach (TestAttempt::all() as $t) {
    echo "ID: {$t->id} | User: {$t->user_id} | Pkg: {$t->package_id} | Status: {$t->status} | Start: {$t->started_at}\n";
}
