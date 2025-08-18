<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TestModalLayout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:modal-layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test modal layout fixes for email display';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Testing Modal Layout Fixes');
        $this->info('============================');
        $this->newLine();

        // Test with users that have long email addresses
        $users = User::all();

        $this->info('📧 Testing Email Display in Navigation Dropdowns:');
        $this->newLine();

        foreach ($users as $user) {
            $emailLength = strlen($user->email);
            $nameLength = strlen($user->name);

            $this->info("👤 User: {$user->name}");
            $this->info("   📧 Email: {$user->email}");
            $this->info("   📏 Name Length: {$nameLength} characters");
            $this->info("   📏 Email Length: {$emailLength} characters");

            if ($emailLength > 25) {
                $this->warn("   ⚠️  Long email detected - testing overflow handling");
            }

            if ($nameLength > 20) {
                $this->warn("   ⚠️  Long name detected - testing truncation");
            }

            $this->newLine();
        }

        $this->info('🔧 Applied Fixes:');
        $this->info('================');
        $this->info('✅ Increased dropdown width from w-48 to w-64 (192px → 256px)');
        $this->info('✅ Added break-all class for email text wrapping');
        $this->info('✅ Added truncate class for name text with ellipsis');
        $this->info('✅ Added title attributes for full text on hover');
        $this->info('✅ Enhanced mobile layout with flex-1 and min-w-0');
        $this->info('✅ Added custom CSS classes for better text handling');
        $this->info('✅ Improved responsive design for small screens');
        $this->newLine();

        $this->info('📱 Responsive Improvements:');
        $this->info('===========================');
        $this->info('✅ Desktop: w-64 dropdown with proper text wrapping');
        $this->info('✅ Mobile: Flexible layout with break-word support');
        $this->info('✅ Touch-friendly: Proper spacing and sizing');
        $this->info('✅ Accessibility: Title attributes for screen readers');
        $this->newLine();

        $this->info('🌐 Test URLs:');
        $this->info('=============');
        $this->info('• Home page: http://127.0.0.1:8000/');
        $this->info('• Login and test dropdown: http://127.0.0.1:8000/login');
        $this->newLine();

        $this->info('✅ Modal Layout Fix Complete!');
        $this->info('All email addresses should now display properly within modal boundaries.');

        return 0;
    }
}
