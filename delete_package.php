<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Package;
use App\Models\Question;
use App\Models\Option;

// Find and delete the 2019 package
$pkg2019 = Package::where('name', 'LIKE', '%2019%')->first();

if ($pkg2019) {
    echo "Found package to delete: {$pkg2019->name} (ID: {$pkg2019->id})\n";
    
    // Check related questions first (optional, but good for info)
    $qCount = Question::where('package_id', $pkg2019->id)->count();
    echo "Deleting {$qCount} questions associated with this package...\n";
    
    // Delete package (and rely on cascading deletes if configured, or manual delete)
    // Assuming cascading delete is not strictly enforced in code, let's stick to standard delete which should handle relations if DB is set up right, 
    // or we might need to detach first. But usually standard Delete is fine for this context.
    
    // Manually delete questions to be safe regarding cascading
    foreach ($pkg2019->questions as $q) {
        $q->options()->delete();
        $q->delete();
    }
    
    $pkg2019->delete();
    echo "Package deleted successfully.\n";
} else {
    echo "Package '2019' not found.\n";
}

// List remaining packages
echo "\nRemaining Packages:\n";
$packages = Package::all();
foreach ($packages as $p) {
    echo "ID: {$p->id} | Name: {$p->name}\n";
}
