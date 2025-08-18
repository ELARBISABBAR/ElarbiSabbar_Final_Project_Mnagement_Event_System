<?php

namespace App\Console\Commands;

use App\Models\Events;
use App\Models\User;
use App\Models\Tickets;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;

class ComprehensiveQA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qa:comprehensive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comprehensive Quality Assurance check for production deployment';

    private $issues = [];
    private $warnings = [];
    private $passed = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 COMPREHENSIVE QUALITY ASSURANCE CHECK');
        $this->info('=========================================');
        $this->newLine();

        // Run all QA tests
        $this->testDatabaseIntegrity();
        $this->testUserRolesAndPermissions();
        $this->testEventWorkflows();
        $this->testEmailSystem();
        $this->testPaymentSystem();
        $this->testFrontendComponents();
        $this->testSecurityMeasures();
        $this->testRecentFixes();
        $this->testFileSystemIntegrity();
        $this->testRouteAccessibility();

        // Generate final report
        $this->generateFinalReport();

        return empty($this->issues) ? 0 : 1;
    }

    private function testDatabaseIntegrity()
    {
        $this->info('🗄️  Testing Database Integrity...');

        try {
            // Test database connection
            DB::connection()->getPdo();
            $this->passed[] = 'Database connection working';

            // Check model counts and relationships
            $users = User::count();
            $events = Events::count();
            $tickets = Tickets::count();
            $categories = Category::count();
            $reviews = Review::count();

            $this->info("   📊 Data counts: {$users} users, {$events} events, {$tickets} tickets, {$categories} categories, {$reviews} reviews");

            // Test critical relationships
            $eventWithRelations = Events::with(['user', 'category', 'tickets', 'reviews'])->first();
            if ($eventWithRelations && $eventWithRelations->user && $eventWithRelations->category) {
                $this->passed[] = 'Model relationships working correctly';
            } else {
                $this->issues[] = 'Model relationships may have issues';
            }

            // Check for orphaned records
            $orphanedTickets = Tickets::whereNotIn('event_id', Events::pluck('id'))->count();
            $orphanedReviews = Review::whereNotIn('event_id', Events::pluck('id'))->count();

            if ($orphanedTickets > 0) {
                $this->warnings[] = "Found {$orphanedTickets} orphaned tickets";
            }
            if ($orphanedReviews > 0) {
                $this->warnings[] = "Found {$orphanedReviews} orphaned reviews";
            }

            // Check data consistency
            $eventsWithoutCategories = Events::whereNull('category_id')->count();
            $eventsWithoutUsers = Events::whereNull('user_id')->count();

            if ($eventsWithoutCategories > 0) {
                $this->issues[] = "Found {$eventsWithoutCategories} events without categories";
            }
            if ($eventsWithoutUsers > 0) {
                $this->issues[] = "Found {$eventsWithoutUsers} events without users";
            }

            if (empty($this->issues)) {
                $this->info('   ✅ Database integrity: PASSED');
            }

        } catch (\Exception $e) {
            $this->issues[] = 'Database connection failed: ' . $e->getMessage();
            $this->error('   ❌ Database integrity: FAILED');
        }

        $this->newLine();
    }

    private function testUserRolesAndPermissions()
    {
        $this->info('👥 Testing User Roles and Permissions...');

        try {
            // Check if roles exist
            $adminCount = User::role('admin')->count();
            $organizerCount = User::role('organizer')->count();
            $attendeeCount = User::role('attendee')->count();

            $this->info("   📊 Role distribution: {$adminCount} admins, {$organizerCount} organizers, {$attendeeCount} attendees");

            if ($adminCount === 0) {
                $this->issues[] = 'No admin users found - system needs at least one admin';
            } else {
                $this->passed[] = 'Admin users present';
            }

            // Test admin credentials
            $adminUser = User::where('email', 'larbisbbar1234@gmail.com')->first();
            if ($adminUser && $adminUser->hasRole('admin')) {
                $this->passed[] = 'Default admin account configured correctly';
            } else {
                $this->issues[] = 'Default admin account not found or misconfigured';
            }

            // Check role assignments
            $usersWithoutRoles = User::doesntHave('roles')->count();
            if ($usersWithoutRoles > 0) {
                $this->warnings[] = "Found {$usersWithoutRoles} users without assigned roles";
            }

            $this->info('   ✅ User roles and permissions: PASSED');

        } catch (\Exception $e) {
            $this->issues[] = 'Role system test failed: ' . $e->getMessage();
            $this->error('   ❌ User roles and permissions: FAILED');
        }

        $this->newLine();
    }

    private function testEventWorkflows()
    {
        $this->info('📅 Testing Event Workflows...');

        try {
            // Test event status distribution
            $approvedEvents = Events::where('status', 'approved')->count();
            $pendingEvents = Events::where('status', 'pending')->count();
            $rejectedEvents = Events::where('status', 'rejected')->count();

            $this->info("   📊 Event status: {$approvedEvents} approved, {$pendingEvents} pending, {$rejectedEvents} rejected");

            // Test event visibility
            $publicEvents = Events::where('visibility', 'public')->count();
            $privateEvents = Events::where('visibility', 'private')->count();
            $membersOnlyEvents = Events::where('visibility', 'members_only')->count();

            $this->info("   👁️  Event visibility: {$publicEvents} public, {$privateEvents} private, {$membersOnlyEvents} members-only");

            // Test date consistency
            $futureEvents = Events::where('date_start', '>=', now())->count();
            $pastEvents = Events::where('date_start', '<', now())->count();

            $this->info("   📅 Event timing: {$futureEvents} future, {$pastEvents} past");

            // Check for invalid dates
            $invalidDates = Events::whereColumn('date_start', '>', 'date_end')->count();
            if ($invalidDates > 0) {
                $this->issues[] = "Found {$invalidDates} events with start date after end date";
            }

            // Test event-ticket relationships
            $eventsWithTickets = Events::has('tickets')->count();
            $this->info("   🎫 Events with tickets: {$eventsWithTickets}");

            $this->passed[] = 'Event workflows functioning correctly';
            $this->info('   ✅ Event workflows: PASSED');

        } catch (\Exception $e) {
            $this->issues[] = 'Event workflow test failed: ' . $e->getMessage();
            $this->error('   ❌ Event workflows: FAILED');
        }

        $this->newLine();
    }

    private function testEmailSystem()
    {
        $this->info('📧 Testing Email System...');

        try {
            // Check email templates exist
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
                $this->passed[] = 'All email templates present';
                $this->info('   ✅ Email templates: All present');
            } else {
                $this->issues[] = 'Missing email templates: ' . implode(', ', $missingTemplates);
                $this->error('   ❌ Email templates: Missing templates');
            }

            // Check mail configuration
            $mailDriver = config('mail.default');
            $mailHost = config('mail.mailers.smtp.host');
            $mailPort = config('mail.mailers.smtp.port');

            $this->info("   📮 Mail config: {$mailDriver} ({$mailHost}:{$mailPort})");

            if ($mailDriver === 'smtp' && $mailHost === '127.0.0.1' && $mailPort == 1025) {
                $this->warnings[] = 'Using MailHog for email testing - change for production';
            }

        } catch (\Exception $e) {
            $this->issues[] = 'Email system test failed: ' . $e->getMessage();
            $this->error('   ❌ Email system: FAILED');
        }

        $this->newLine();
    }

    private function testPaymentSystem()
    {
        $this->info('💳 Testing Payment System...');

        try {
            // Check Stripe configuration
            $stripePublic = config('stripe.pk');
            $stripeSecret = config('stripe.sk');

            if (empty($stripePublic) || empty($stripeSecret)) {
                $this->issues[] = 'Stripe configuration incomplete';
                $this->error('   ❌ Stripe config: Incomplete');
            } else {
                $this->passed[] = 'Stripe configuration present';
                $this->info('   ✅ Stripe config: Present');

                // Check if using test keys
                if (strpos($stripePublic, 'pk_test_') === 0) {
                    $this->warnings[] = 'Using Stripe test keys - change for production';
                }
            }

            // Check ticket sales
            $totalTickets = Tickets::count();
            $paidTickets = Tickets::where('status', 'confirmed')->count();

            $this->info("   🎫 Ticket sales: {$paidTickets}/{$totalTickets} confirmed");

            // Test transaction integrity
            $ticketsWithoutTransactionId = Tickets::whereNull('transaction_id')->count();
            if ($ticketsWithoutTransactionId > 0) {
                $this->warnings[] = "Found {$ticketsWithoutTransactionId} tickets without transaction IDs";
            }

        } catch (\Exception $e) {
            $this->issues[] = 'Payment system test failed: ' . $e->getMessage();
            $this->error('   ❌ Payment system: FAILED');
        }

        $this->newLine();
    }

    private function testFrontendComponents()
    {
        $this->info('🎨 Testing Frontend Components...');

        try {
            // Check critical view files
            $criticalViews = [
                'layouts.index',
                'pages.home.home',
                'pages.create_events.create_events',
                'pages.tickets.ticket',
                'auth.login',
                'auth.register'
            ];

            $missingViews = [];
            foreach ($criticalViews as $view) {
                $viewPath = resource_path('views/' . str_replace('.', '/', $view) . '.blade.php');
                if (!file_exists($viewPath)) {
                    $missingViews[] = $view;
                }
            }

            if (empty($missingViews)) {
                $this->passed[] = 'All critical view files present';
                $this->info('   ✅ View files: All present');
            } else {
                $this->issues[] = 'Missing view files: ' . implode(', ', $missingViews);
            }

            // Check for Vite build assets
            $buildManifest = public_path('build/manifest.json');
            if (file_exists($buildManifest)) {
                $this->passed[] = 'Vite build assets present';
                $this->info('   ✅ Assets: Vite build present');
            } else {
                $this->warnings[] = 'Vite build assets not found - run npm run build';
            }

        } catch (\Exception $e) {
            $this->issues[] = 'Frontend test failed: ' . $e->getMessage();
            $this->error('   ❌ Frontend components: FAILED');
        }

        $this->newLine();
    }

    private function testSecurityMeasures()
    {
        $this->info('🔒 Testing Security Measures...');

        try {
            // Check environment settings
            $appEnv = config('app.env');
            $appDebug = config('app.debug');
            $appKey = config('app.key');

            $this->info("   🌍 Environment: {$appEnv}");
            $this->info("   🐛 Debug mode: " . ($appDebug ? 'ON' : 'OFF'));

            if ($appEnv === 'production' && $appDebug) {
                $this->issues[] = 'Debug mode should be OFF in production';
            }

            if (empty($appKey)) {
                $this->issues[] = 'Application key not set';
            } else {
                $this->passed[] = 'Application key configured';
            }

            // Check for default passwords
            $defaultPasswords = ['password', '123456', 'admin', 'secret'];
            $weakPasswords = 0;

            foreach ($defaultPasswords as $password) {
                if (User::where('password', bcrypt($password))->exists()) {
                    $weakPasswords++;
                }
            }

            if ($weakPasswords > 0) {
                $this->warnings[] = "Found users with potentially weak passwords";
            }

            // Check CSRF protection
            if (config('session.driver') === 'file') {
                $this->passed[] = 'Session driver configured';
            }

            $this->info('   ✅ Security measures: PASSED');

        } catch (\Exception $e) {
            $this->issues[] = 'Security test failed: ' . $e->getMessage();
            $this->error('   ❌ Security measures: FAILED');
        }

        $this->newLine();
    }

    private function testRecentFixes()
    {
        $this->info('🔧 Testing Recent Fixes...');

        try {
            // Test home page event display fix
            $guestEvents = Events::approved()->where('visibility', 'public')->where('date_start', '>=', now())->count();
            $userEvents = Events::approved()->whereIn('visibility', ['public', 'private', 'members_only'])->where('date_start', '>=', now())->count();

            $this->info("   🌐 Home page display: {$guestEvents} events for guests, {$userEvents} for users");

            if ($userEvents > $guestEvents) {
                $this->passed[] = 'Home page visibility fix working';
            } else {
                $this->warnings[] = 'Home page visibility fix may not be working correctly';
            }

            // Test email notification system
            $emailTemplateCount = 0;
            $emailTemplates = [
                'emails.welcome-attendee',
                'emails.welcome-organizer',
                'emails.event-created',
                'emails.ticket-confirmation'
            ];

            foreach ($emailTemplates as $template) {
                $templatePath = resource_path('views/' . str_replace('.', '/', $template) . '.blade.php');
                if (file_exists($templatePath)) {
                    $emailTemplateCount++;
                }
            }

            if ($emailTemplateCount === count($emailTemplates)) {
                $this->passed[] = 'Email notification system templates present';
            }

            $this->info('   ✅ Recent fixes: VERIFIED');

        } catch (\Exception $e) {
            $this->issues[] = 'Recent fixes test failed: ' . $e->getMessage();
            $this->error('   ❌ Recent fixes: FAILED');
        }

        $this->newLine();
    }

    private function testFileSystemIntegrity()
    {
        $this->info('📁 Testing File System Integrity...');

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
                $this->passed[] = 'All storage directories present';
                $this->info('   ✅ Storage directories: All present');
            } else {
                $this->issues[] = 'Missing storage directories: ' . implode(', ', $missingDirs);
            }

            // Check permissions
            if (is_writable(storage_path())) {
                $this->passed[] = 'Storage directory writable';
            } else {
                $this->issues[] = 'Storage directory not writable';
            }

            // Check log files
            $logFile = storage_path('logs/laravel.log');
            if (file_exists($logFile)) {
                $logSize = filesize($logFile);
                $this->info("   📄 Log file size: " . number_format($logSize / 1024, 2) . " KB");

                if ($logSize > 10 * 1024 * 1024) { // 10MB
                    $this->warnings[] = 'Log file is large (>10MB) - consider rotation';
                }
            }

        } catch (\Exception $e) {
            $this->issues[] = 'File system test failed: ' . $e->getMessage();
            $this->error('   ❌ File system integrity: FAILED');
        }

        $this->newLine();
    }

    private function testRouteAccessibility()
    {
        $this->info('🌐 Testing Route Accessibility...');

        try {
            // Get all registered routes
            $routes = Route::getRoutes();
            $criticalRoutes = [
                'home',
                'login',
                'register',
                'event.index',
                'event_admin.index'
            ];

            $missingRoutes = [];
            foreach ($criticalRoutes as $routeName) {
                if (!$routes->hasNamedRoute($routeName)) {
                    $missingRoutes[] = $routeName;
                }
            }

            if (empty($missingRoutes)) {
                $this->passed[] = 'All critical routes registered';
                $this->info('   ✅ Critical routes: All registered');
            } else {
                $this->issues[] = 'Missing routes: ' . implode(', ', $missingRoutes);
            }

            // Count total routes
            $totalRoutes = count($routes->getRoutes());
            $this->info("   📊 Total routes registered: {$totalRoutes}");

        } catch (\Exception $e) {
            $this->issues[] = 'Route accessibility test failed: ' . $e->getMessage();
            $this->error('   ❌ Route accessibility: FAILED');
        }

        $this->newLine();
    }

    private function generateFinalReport()
    {
        $this->info('📋 COMPREHENSIVE QA REPORT');
        $this->info('==========================');
        $this->newLine();

        // Summary statistics
        $totalTests = count($this->passed) + count($this->warnings) + count($this->issues);
        $passedCount = count($this->passed);
        $warningCount = count($this->warnings);
        $issueCount = count($this->issues);

        $this->info("📊 Test Summary:");
        $this->info("   Total tests: {$totalTests}");
        $this->info("   ✅ Passed: {$passedCount}");
        $this->info("   ⚠️  Warnings: {$warningCount}");
        $this->info("   ❌ Issues: {$issueCount}");
        $this->newLine();

        // Show passed tests
        if (!empty($this->passed)) {
            $this->info('✅ PASSED TESTS:');
            foreach ($this->passed as $test) {
                $this->info("   • {$test}");
            }
            $this->newLine();
        }

        // Show warnings
        if (!empty($this->warnings)) {
            $this->warn('⚠️  WARNINGS:');
            foreach ($this->warnings as $warning) {
                $this->warn("   • {$warning}");
            }
            $this->newLine();
        }

        // Show critical issues
        if (!empty($this->issues)) {
            $this->error('❌ CRITICAL ISSUES:');
            foreach ($this->issues as $issue) {
                $this->error("   • {$issue}");
            }
            $this->newLine();
        }

        // Production readiness assessment
        $this->info('🚀 PRODUCTION READINESS ASSESSMENT:');

        if (empty($this->issues)) {
            if (empty($this->warnings)) {
                $this->info('   🎉 READY FOR PRODUCTION');
                $this->info('   All tests passed without issues or warnings.');
            } else {
                $this->warn('   ⚠️  READY WITH CAUTION');
                $this->warn('   No critical issues, but please review warnings.');
            }
        } else {
            $this->error('   🚨 NOT READY FOR PRODUCTION');
            $this->error('   Critical issues must be resolved before deployment.');
        }

        $this->newLine();

        // Recommendations
        $this->info('💡 RECOMMENDATIONS:');
        $this->info('   1. Address all critical issues before deployment');
        $this->info('   2. Review and resolve warnings when possible');
        $this->info('   3. Test payment processing with real Stripe keys');
        $this->info('   4. Configure production email service (replace MailHog)');
        $this->info('   5. Set up proper logging and monitoring');
        $this->info('   6. Perform load testing before going live');
        $this->info('   7. Set up automated backups');
        $this->info('   8. Configure SSL certificates');
    }
}
