@extends('layouts.index')
@section('content')
    {{-- <h1 class="pl-20 pt-10">my orders :</h1> --}}

    <header class="bg-white dark:bg-gray-800 shadow mb-12">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My orders :') }}
            </h2>
        </div>
    </header>


@if ($tickets->count()>0 )

    <section class="container  mx-auto mb-10">
        <div class="flex flex-col items-center">
            <div class=" -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-[85%]">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 ">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 px-4 text-sm font-normal text-center rtl:text-right text-gray-500 dark:text-gray-400">

    
                                                #


                                    </th>


                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Date
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Event_title
                                    </th>

                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Ticket_price
                                    </th>

                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Quantity
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Total
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal  rtl:text-right text-gray-500 dark:text-gray-400 text-left">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($tickets as $ticket)
                                    @if ($ticket->user->id == Auth::user()->id)
                                        <tr>
                                            <td
                                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap text-center">
                                                <div class="inline-flex items-center gap-x-3">
                                                    <span>{{ $numberEvent++ }}</span>
                                                </div>
                                            </td>
                                            <td
                                                class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                {{ substr($ticket->event->date_start, 0, 10) }}</td>
                                            <td
                                                class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                {{ $ticket->event->title }}</td>
                                            <td
                                                class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                {{ $ticket->price }} MAD</td>
                                            <td
                                                class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap text-center">
                                                {{ $ticket->quantity }}</td>
                                            <td
                                                class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                {{ $ticket->price * $ticket->quantity }} MAD</td>
                                            <td
                                                class="px-4 py-2 text-sm font-medium text-gray-700 whitespace-nowrap w-[10vw] text-center">
                                                @if ($ticket->payedBolean)
                                                    <div class="flex gap-2 ">
                                                        <div
                                                            class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-emerald-500  bg-emerald-100/60 dark:bg-gray-800">
                                                            <svg width="12" height="12" viewBox="0 0 12 12"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M10 3L4.5 8.5L2 6" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>

                                                            <h2 class="text-sm font-normal m-0 ">Paid</h2>
                                                        </div>
                                                        <a href=""><i class="fa-solid fa-download bg-blue-200 px-1 text-blue-600  rounded-lg py-2 gap-x-2"> </i></a>

                                                    </div>
                                                @else
                                                    <div
                                                        class="inline-flex items-center px-3 py-1 text-red-500 rounded-full gap-x-2 bg-red-100/60 dark:bg-gray-800">
                                                        <svg width="12" height="12" viewBox="0 0 12 12"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9 3L3 9M3 3L9 9" stroke="currentColor"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                        <h2 class="text-sm font-normal m-0">Cancelled</h2>
                                                    </div>
                                                @endif
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach






                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@else
    <div class=" w-full flex flex-col items-center">
        <h1>You don't have any tickets ! <br>
        </h1>
        <h3>Explore a world of possibilities - the perfect event for you is just a click away.</h3>
        
        <img class="" src="{{ asset('images/myorder-vide.png') }}" alt="">
    </div>
@endif
@endsection
