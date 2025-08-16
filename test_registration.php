<?php

// Test script to verify organizer registration works
require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

// Simulate the registration process
echo "=== ORGANIZER REGISTRATION TEST ===\n";

// 1. Check if roles exist
$roles = Role::pluck('name')->toArray();
echo "Available roles: " . implode(', ', $roles) . "\n";

if (!in_array('organizer', $roles)) {
    echo "ERROR: Organizer role not found!\n";
    exit(1);
}

// 2. Test user creation
$testData = [
    'name' => 'Test Organizer Registration',
    'email' => 'test_reg_organizer@example.com',
    'password' => Hash::make('password123'),
    'phone' => '1234567890',
    'role' => 'organizer'
];

try {
    // Delete existing test user if exists
    User::where('email', $testData['email'])->delete();
    
    // Create new user
    $user = User::create($testData);
    echo "User created successfully: {$user->email}\n";
    
    // Assign role
    $user->assignRole('organizer');
    echo "Role assigned successfully\n";
    
    // Verify role
    if ($user->hasRole('organizer')) {
        echo "Role verification: PASSED\n";
    } else {
        echo "Role verification: FAILED\n";
        exit(1);
    }
    
    // Test redirect route
    $redirectRoute = route('event.index');
    echo "Redirect route: {$redirectRoute}\n";
    
    echo "=== REGISTRATION TEST PASSED ===\n";
    
    // Clean up
    $user->delete();
    echo "Test user cleaned up\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
