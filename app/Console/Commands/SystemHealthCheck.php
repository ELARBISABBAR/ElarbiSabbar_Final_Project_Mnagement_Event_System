<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Events;
use App\Models\Tickets;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SystemHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:health-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comprehensive system health check for Evenext application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏥 Evenext System Health Check');
        $this->info('================================');
        $this->newLine();

        $issues = [];
        $warnings = [];

        // 1. Database Health Check
        $this->info('🗄️  Database Health Check...');
        try {
            DB::connection()->getPdo();
            $this->info('   ✅ Database connection: OK');

            // Check model counts
            $userCount = User::count();
            $eventCount = Events::count();
            $ticketCount = Tickets::count();
            $categoryCount = Category::count();

            $this->info("   📊 Data integrity: {$userCount} users, {$eventCount} events, {$ticketCount} tickets, {$categoryCount} categories");

            // Test relationships
            $event = Events::with(['user', 'category', 'tickets'])->first();
            if ($event && $event->user && $event->category) {
                $this->info('   ✅ Model relationships: OK');
            } else {
                $warnings[] = 'Some model relationships may have issues';
                $this->warn('   ⚠️  Model relationships: Some issues detected');
            }

        } catch (\Exception $e) {
            $issues[] = 'Database connection failed: ' . $e->getMessage();
            $this->error('   ❌ Database connection: FAILED');
        }

        // 2. Email System Check
        $this->newLine();
        $this->info('📧 Email System Check...');
        try {
            // Check mail configuration
            $mailDriver = config('mail.default');
            $mailHost = config('mail.mailers.smtp.host');
            $mailPort = config('mail.mailers.smtp.port');

            $this->info("   📮 Mail driver: {$mailDriver}");
            $this->info("   🌐 Mail host: {$mailHost}:{$mailPort}");

            // Test email templates exist
            $emailTemplates = [
                'emails.layout',
                'emails.welcome-attendee',
                'emails.welcome-organizer',
                'emails.new-organizer-notification',
                'emails.event-created',
                'emails.new-event-notification',
                'emails.ticket-confirmation',
                'emails.sales-notification'
            ];

            $missingTemplates = [];
            foreach ($emailTemplates as $template) {
                $templatePath = resource_path('views/' . str_replace('.', '/', $template) . '.blade.php');
                if (!file_exists($templatePath)) {
                    $missingTemplates[] = $template;
                }
            }

            if (empty($missingTemplates)) {
                $this->info('   ✅ Email templates: All present');
            } else {
                $issues[] = 'Missing email templates: ' . implode(', ', $missingTemplates);
                $this->error('   ❌ Email templates: Missing templates detected');
            }

        } catch (\Exception $e) {
            $issues[] = 'Email system check failed: ' . $e->getMessage();
            $this->error('   ❌ Email system: FAILED');
        }

        // 3. File System Check
        $this->newLine();
        $this->info('📁 File System Check...');
        try {
            // Check storage directories
            $storageDirectories = [
                'storage/app',
                'storage/logs',
                'storage/framework/cache',
                'storage/framework/sessions',
                'storage/framework/views'
            ];

            $missingDirs = [];
            foreach ($storageDirectories as $dir) {
                if (!is_dir($dir)) {
                    $missingDirs[] = $dir;
                }
            }

            if (empty($missingDirs)) {
                $this->info('   ✅ Storage directories: All present');
            } else {
                $issues[] = 'Missing storage directories: ' . implode(', ', $missingDirs);
                $this->error('   ❌ Storage directories: Missing directories');
            }

            // Check if storage is writable
            if (is_writable(storage_path())) {
                $this->info('   ✅ Storage permissions: Writable');
            } else {
                $issues[] = 'Storage directory is not writable';
                $this->error('   ❌ Storage permissions: Not writable');
            }

        } catch (\Exception $e) {
            $issues[] = 'File system check failed: ' . $e->getMessage();
            $this->error('   ❌ File system: FAILED');
        }

        // 4. Application Configuration Check
        $this->newLine();
        $this->info('⚙️  Application Configuration Check...');
        try {
            // Check environment
            $environment = app()->environment();
            $debug = config('app.debug');
            $appKey = config('app.key');

            $this->info("   🌍 Environment: {$environment}");
            $this->info("   🐛 Debug mode: " . ($debug ? 'ON' : 'OFF'));

            if (empty($appKey)) {
                $issues[] = 'Application key is not set';
                $this->error('   ❌ App key: Not set');
            } else {
                $this->info('   ✅ App key: Set');
            }

            // Check critical config values
            $stripeKey = config('stripe.pk');
            $stripeSecret = config('stripe.sk');

            if (empty($stripeKey) || empty($stripeSecret)) {
                $warnings[] = 'Stripe configuration may be incomplete';
                $this->warn('   ⚠️  Stripe config: Incomplete');
            } else {
                $this->info('   ✅ Stripe config: Set');
            }

        } catch (\Exception $e) {
            $issues[] = 'Configuration check failed: ' . $e->getMessage();
            $this->error('   ❌ Configuration: FAILED');
        }

        // 5. Queue System Check
        $this->newLine();
        $this->info('🔄 Queue System Check...');
        try {
            $queueDriver = config('queue.default');
            $this->info("   📋 Queue driver: {$queueDriver}");

            // Check for failed jobs
            $failedJobs = DB::table('failed_jobs')->count();
            if ($failedJobs > 0) {
                $warnings[] = "There are {$failedJobs} failed queue jobs";
                $this->warn("   ⚠️  Failed jobs: {$failedJobs} jobs failed");
            } else {
                $this->info('   ✅ Failed jobs: None');
            }

        } catch (\Exception $e) {
            $warnings[] = 'Queue system check failed: ' . $e->getMessage();
            $this->warn('   ⚠️  Queue system: Issues detected');
        }

        // Summary
        $this->newLine();
        $this->info('📋 Health Check Summary');
        $this->info('======================');

        if (empty($issues) && empty($warnings)) {
            $this->info('🎉 System Status: HEALTHY');
            $this->info('   All systems are functioning properly!');
        } else {
            if (!empty($issues)) {
                $this->error('❌ Critical Issues Found:');
                foreach ($issues as $issue) {
                    $this->error("   • {$issue}");
                }
            }

            if (!empty($warnings)) {
                $this->warn('⚠️  Warnings:');
                foreach ($warnings as $warning) {
                    $this->warn("   • {$warning}");
                }
            }

            $this->newLine();
            if (!empty($issues)) {
                $this->error('🚨 System Status: NEEDS ATTENTION');
                $this->error('   Please address the critical issues above.');
            } else {
                $this->warn('⚠️  System Status: MOSTLY HEALTHY');
                $this->warn('   Consider addressing the warnings above.');
            }
        }

        $this->newLine();
        $this->info('💡 Recommendations:');
        $this->info('   • Run this health check regularly');
        $this->info('   • Monitor application logs for errors');
        $this->info('   • Keep dependencies updated');
        $this->info('   • Test email functionality periodically');

        return empty($issues) ? 0 : 1;
    }
}
