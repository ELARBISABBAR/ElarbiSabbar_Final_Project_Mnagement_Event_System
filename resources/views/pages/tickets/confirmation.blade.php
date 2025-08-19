@extends('layouts.index')

@section('content')
<div class="min-h-screen bg-secondary-50 py-8">
    <div class="container-custom">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-soft overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2">Payment Successful!</h1>
                    <p class="text-green-100">Your tickets have been confirmed and are ready to use.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-soft overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-secondary-200">
                    <h2 class="text-xl font-semibold text-secondary-900">Ticket Details</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex items-start space-x-4 mb-6">
                        @if($ticket->event->image && file_exists(public_path('storage/img/' . $ticket->event->image)))
                            <img src="{{ asset('storage/img/' . $ticket->event->image) }}" 
                                 alt="{{ $ticket->event->title }}" 
                                 class="w-20 h-20 rounded-lg object-cover">
                        @else
                            <div class="w-20 h-20 bg-gradient-primary rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-secondary-900 mb-1">{{ $ticket->event->title }}</h3>
                            <div class="space-y-1 text-sm text-secondary-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $ticket->event->date_start->format('M j, Y \a\t g:i A') }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                    {{ $ticket->event->location }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-secondary-50 rounded-lg p-4">
                        <h4 class="font-medium text-secondary-900 mb-3">Purchase Summary</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-secondary-600">Ticket ID:</span>
                                <span class="font-mono text-sm">#{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary-600">Quantity:</span>
                                <span class="font-medium">{{ $ticket->quantity }} {{ Str::plural('ticket', $ticket->quantity) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary-600">Price per ticket:</span>
                                <span class="font-medium">${{ number_format($ticket->price, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary-600">Payment method:</span>
                                <span class="font-medium capitalize">{{ $ticket->payment_method }}</span>
                            </div>
                            <div class="border-t border-secondary-200 pt-2 mt-3">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-secondary-900">Total paid:</span>
                                    <span class="font-bold text-primary-600">${{ number_format($ticket->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-soft p-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('myorder.index') }}" class="btn-primary flex-1 text-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View My Orders
                    </a>
                    
                    @if($ticket->pdf)
                        <a href="{{ route('ticket.pdf', $ticket) }}" class="btn-outline-primary flex-1 text-center" target="_blank">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download PDF
                        </a>
                    @endif
                    
                    <a href="{{ route('home') }}" class="btn-outline-secondary flex-1 text-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Back to Events
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-soft p-6 mt-6">
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-2">Our Trusted Partners</h3>
                    <p class="text-sm text-secondary-600">Proudly supported by industry-leading companies</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center justify-items-center">
                    <a href="https://www.adidas.com" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center justify-center p-4 rounded-lg border border-secondary-200 hover:border-blue-300 hover:shadow-md transition-all duration-300 bg-white w-full h-20">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Adidas-Logo.png"
                             alt="Adidas - Official Sports Partner"
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="text-center hidden group-hover:scale-105 transition-transform duration-300">
                            <div class="text-lg font-bold text-gray-800">ADIDAS</div>
                            <div class="text-xs text-gray-500 mt-1">Sports Partner</div>
                        </div>
                    </a>

                    <a href="https://www.chanel.com" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center justify-center p-4 rounded-lg border border-secondary-200 hover:border-pink-300 hover:shadow-md transition-all duration-300 bg-white w-full h-20">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Chanel-Logo.png"
                             alt="Chanel - Luxury Fashion Partner"
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="text-center hidden group-hover:scale-105 transition-transform duration-300">
                            <div class="text-lg font-bold text-gray-800">CHANEL</div>
                            <div class="text-xs text-gray-500 mt-1">Fashion Partner</div>
                        </div>
                    </a>

                    <a href="https://www.nike.com" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center justify-center p-4 rounded-lg border border-secondary-200 hover:border-orange-300 hover:shadow-md transition-all duration-300 bg-white w-full h-20">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Nike-Logo.png"
                             alt="Nike - Athletic Apparel Partner"
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="text-center hidden group-hover:scale-105 transition-transform duration-300">
                            <div class="text-lg font-bold text-gray-800">NIKE</div>
                            <div class="text-xs text-gray-500 mt-1">Athletic Partner</div>
                        </div>
                    </a>

                    <a href="https://www.toyota.com" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center justify-center p-4 rounded-lg border border-secondary-200 hover:border-red-300 hover:shadow-md transition-all duration-300 bg-white w-full h-20">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Toyota-Logo.png"
                             alt="Toyota - Official Automotive Partner"
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="text-center hidden group-hover:scale-105 transition-transform duration-300">
                            <div class="text-lg font-bold text-gray-800">TOYOTA</div>
                            <div class="text-xs text-gray-500 mt-1">Auto Partner</div>
                        </div>
                    </a>

                    <a href="https://www.microsoft.com" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center justify-center p-4 rounded-lg border border-secondary-200 hover:border-green-300 hover:shadow-md transition-all duration-300 bg-white w-full h-20">
                        <img src="https://logos-world.net/wp-content/uploads/2020/06/Microsoft-Logo.png"
                             alt="Microsoft - Technology Partner"
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="text-center hidden group-hover:scale-105 transition-transform duration-300">
                            <div class="text-lg font-bold text-gray-800">MICROSOFT</div>
                            <div class="text-xs text-gray-500 mt-1">Tech Partner</div>
                        </div>
                    </a>

                    <a href="https://www.apple.com" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center justify-center p-4 rounded-lg border border-secondary-200 hover:border-purple-300 hover:shadow-md transition-all duration-300 bg-white w-full h-20">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Apple-Logo.png"
                             alt="Apple - Innovation Partner"
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="text-center hidden group-hover:scale-105 transition-transform duration-300">
                            <div class="text-lg font-bold text-gray-800">APPLE</div>
                            <div class="text-xs text-gray-500 mt-1">Innovation Partner</div>
                        </div>
                    </a>

                    <a href="https://www.bmw.com" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center justify-center p-4 rounded-lg border border-secondary-200 hover:border-yellow-300 hover:shadow-md transition-all duration-300 bg-white w-full h-20">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/BMW-Logo.png"
                             alt="BMW - Premium Automotive Partner"
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="text-center hidden group-hover:scale-105 transition-transform duration-300">
                            <div class="text-lg font-bold text-gray-800">BMW</div>
                            <div class="text-xs text-gray-500 mt-1">Premium Auto</div>
                        </div>
                    </a>

                    <a href="https://www.honda.com" target="_blank" rel="noopener noreferrer"
                       class="group flex items-center justify-center p-4 rounded-lg border border-secondary-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 bg-white w-full h-20">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Honda-Logo.png"
                             alt="Honda - Mobility Solutions Partner"
                             class="max-h-12 max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div class="text-center hidden group-hover:scale-105 transition-transform duration-300">
                            <div class="text-lg font-bold text-gray-800">HONDA</div>
                            <div class="text-xs text-gray-500 mt-1">Mobility Partner</div>
                        </div>
                    </a>
                </div>

                <div class="text-center mt-6 pt-4 border-t border-secondary-200">
                    <p class="text-xs text-secondary-500">
                        These partnerships help us deliver exceptional event experiences and exclusive benefits to our attendees.
                    </p>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-blue-900 mb-2">Important Information</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Please arrive at least 15 minutes before the event starts</li>
                            <li>• Bring a valid ID for verification</li>
                            <li>• Screenshots of this confirmation are acceptable for entry</li>
                            <li>• Contact the organizer if you have any questions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
