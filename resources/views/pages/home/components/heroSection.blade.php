

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="absolute inset-0" style="background-image: url('{{ asset('images/scene2.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;"></div>
    <div class="absolute inset-0 "></div>

    <!-- Content -->
    <div class="relative container-custom py-24 lg:py-32">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Hero Logo -->
            <div class="flex justify-center mb-8 animate-fade-in">
                <div class="logo-container logo-animated">
                    <div class="logo-icon-hero">
                        <div class="logo-geometric"></div>
                        <span class="logo-letter-lg">E</span>
                    </div>
                    <div class="flex flex-col items-start">
                        <span class="logo-text-white logo-text-xl leading-none">EvenXt</span>
                        <span class="text-lg text-white font-semibold tracking-widest opacity-90">EVENTS PLATFORM</span>
                    </div>
                </div>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black mb-6 animate-fade-in">
                Discover Amazing
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-400 to-accent-300">
                    Events
                </span>
                Near You
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-white mb-8 animate-slide-up">
                From conferences to concerts, workshops to festivals - find experiences that inspire and connect you with like-minded people.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-slide-up">
                <a href="#events" onclick="scrollToEvents(event)" class="btn-primary btn-lg bg-white text-primary-700 hover:bg-primary-50 shadow-large transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Explore Events
                </a>

                @auth
                    @if(Auth::user()->hasRole('organizer') || Auth::user()->hasRole('admin') || Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                        <a href="{{ route('event.index') }}" class="btn-outline btn-lg border-white text-white hover:bg-white hover:text-primary-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Event
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-outline btn-lg border-white text-white hover:bg-black hover:text-primary-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        Join EvenXt
                    </a>
                @endauth
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mt-16 pt-8 border-t border-primary-400/30">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">{{ \App\Models\Events::count() }}+</div>
                    <div class="text-primary-200">Events Created</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">{{ \App\Models\User::where('role', 'attendee')->count() }}+</div>
                    <div class="text-primary-200">Happy Attendees</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">{{ \App\Models\User::where('role', 'organizer')->count() }}+</div>
                    <div class="text-primary-200">Event Organizers</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<script>
function scrollToEvents(event) {
    event.preventDefault();

    // Find the events section - it could be the search section or the events section
    const searchSection = document.querySelector('section.bg-white.py-8.border-b');
    const eventsSection = document.querySelector('section.py-12.bg-secondary-50');

    // Prefer the search section if it exists, otherwise use events section
    const targetSection = searchSection || eventsSection;

    if (targetSection) {
        const headerHeight = document.querySelector('nav').offsetHeight || 64;
        const targetPosition = targetSection.offsetTop - headerHeight;

        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
}
</script>
