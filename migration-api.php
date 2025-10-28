<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Route::post('/api/migrate', function (Request $request) {
    // Simple security check
    $token = $request->input('token');
    $expectedToken = env('MIGRATION_TOKEN', 'default-migration-token');
    
    if ($token !== $expectedToken) {
        Log::warning('Unauthorized migration attempt', ['ip' => $request->ip()]);
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    try {
        // Run migrations
        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();
        
        Log::info('Migrations completed via API', ['output' => $output]);
        
        return response()->json([
            'success' => true,
            'message' => 'Migrations completed successfully',
            'output' => $output
        ]);
        
    } catch (\Exception $e) {
        Log::error('Migration failed via API', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});