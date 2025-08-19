<div class="bg-white rounded-xl shadow-soft overflow-hidden">
    <div class="p-6 border-b border-secondary-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-secondary-900">Reviews & Ratings</h3>
                <p class="text-secondary-600 text-sm mt-1">
                    @if($event->total_reviews > 0)
                        {{ $event->total_reviews }} {{ Str::plural('review', $event->total_reviews) }} • 
                        Average rating: {{ number_format($event->average_rating, 1) }}/5
                    @else
                        No reviews yet
                    @endif
                </p>
            </div>
            
            @if($event->total_reviews > 0)
                <div class="text-right">
                    <div class="flex items-center justify-end mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($event->average_rating) ? 'text-yellow-400' : 'text-secondary-300' }}" 
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-2xl font-bold text-secondary-900">{{ number_format($event->average_rating, 1) }}</span>
                </div>
            @endif
        </div>
    </div>

    @if($canReview)
        <div class="p-6 bg-secondary-50 border-b border-secondary-200">
            <h4 class="font-medium text-secondary-900 mb-4">Write a Review</h4>
            <form action="{{ route('reviews.store', $event) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-secondary-700 mb-2">Rating</label>
                    <div class="flex items-center space-x-1" x-data="{ rating: 0, hover: 0 }">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    @click="rating = {{ $i }}"
                                    @mouseenter="hover = {{ $i }}"
                                    @mouseleave="hover = 0"
                                    class="focus:outline-none">
                                <svg class="w-6 h-6 transition-colors duration-200"
                                     :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-secondary-300'"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                        <input type="hidden" name="rating" :value="rating" required>
                    </div>
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-secondary-700 mb-2">Comment (Optional)</label>
                    <textarea name="comment" id="comment" rows="3" 
                              class="form-input w-full" 
                              placeholder="Share your experience with this event..."></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    @endif

    @if($userReview)
        <div class="p-6 bg-blue-50 border-b border-secondary-200">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-medium text-secondary-900">Your Review</h4>
                <button onclick="toggleEditReview()" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Edit Review
                </button>
            </div>
            
            <div id="currentReview" class="space-y-2">
                <div class="flex items-center space-x-1">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $userReview->rating ? 'text-yellow-400' : 'text-secondary-300' }}" 
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                    <span class="text-sm text-secondary-600 ml-2">{{ $userReview->created_at->format('M j, Y') }}</span>
                </div>
                @if($userReview->comment)
                    <p class="text-secondary-700">{{ $userReview->comment }}</p>
                @endif
            </div>

            <form id="editReviewForm" action="{{ route('reviews.update', $userReview) }}" method="POST" 
                  class="space-y-4 hidden">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-medium text-secondary-700 mb-2">Rating</label>
                    <div class="flex items-center space-x-1" x-data="{ rating: {{ $userReview->rating }}, hover: 0 }">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    @click="rating = {{ $i }}"
                                    @mouseenter="hover = {{ $i }}"
                                    @mouseleave="hover = 0"
                                    class="focus:outline-none">
                                <svg class="w-6 h-6 transition-colors duration-200"
                                     :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-secondary-300'"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                        <input type="hidden" name="rating" :value="rating" required>
                    </div>
                </div>

                <div>
                    <label for="edit_comment" class="block text-sm font-medium text-secondary-700 mb-2">Comment (Optional)</label>
                    <textarea name="comment" id="edit_comment" rows="3" 
                              class="form-input w-full">{{ $userReview->comment }}</textarea>
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="deleteReview({{ $userReview->id }})" 
                            class="text-red-600 hover:text-red-700 text-sm font-medium">
                        Delete Review
                    </button>
                    <div class="space-x-2">
                        <button type="button" onclick="toggleEditReview()" 
                                class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Update Review</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <div class="divide-y divide-secondary-200">
        @forelse($reviews as $review)
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h5 class="font-medium text-secondary-900">{{ $review->user->name }}</h5>
                                <div class="flex items-center space-x-2 mt-1">
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-secondary-300' }}" 
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    @if($review->is_verified)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Verified Attendee
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <span class="text-sm text-secondary-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        
                        @if($review->comment)
                            <p class="text-secondary-700 leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-6 text-center">
                <svg class="w-12 h-12 text-secondary-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h4 class="text-lg font-medium text-secondary-900 mb-2">No reviews yet</h4>
                <p class="text-secondary-600">Be the first to share your experience with this event!</p>
            </div>
        @endforelse
    </div>

    @if($reviews->hasPages())
        <div class="p-6 border-t border-secondary-200">
            {{ $reviews->links() }}
        </div>
    @endif
</div>

<script>
function toggleEditReview() {
    const currentReview = document.getElementById('currentReview');
    const editForm = document.getElementById('editReviewForm');
    
    if (editForm.classList.contains('hidden')) {
        currentReview.classList.add('hidden');
        editForm.classList.remove('hidden');
    } else {
        currentReview.classList.remove('hidden');
        editForm.classList.add('hidden');
    }
}

function deleteReview(reviewId) {
    if (confirm('Are you sure you want to delete your review? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/reviews/${reviewId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
