@extends('layouts.index')
@section('content')
    <div class="flex  mt-12 flex-col items-center mb-6">
        {{-- <h3 >welcome {{ Auth::user()->name }} to the event :</h3> --}}
        <h3 class="text-center text-4xl pb-4"> {{ $event->title }}</h3>
        <div class=" lg:w-[80%] w-[95%] shadow-sm rounded-lg p-2 h-[fit-content]">
            <div class="h-full flex lg:flex-row flex-col justify-between ">
                <div class="lg:w-[60%] rounded-xl lg:h-[65vh] ">
                    <img class="h-[100%] w-full rounded-sm ml-1" src="{{ asset('storage/img/' . $event->image) }}"
                        class="card-img-top" alt="...">
                </div>
                <div class=" lg:w-[35%]  rounded-xl  p-4 shadow-sm h-[fit-content]">
                    <div class="flex gap-2 items-center  pt-1 pb-1 text-xl">
                        <div><i class="fa-solid fa-location-dot"></i></div>
                        <p class="m-0 ">{{ $event->location }}</p>
                    </div>
                    <div class="flex gap-2 items-center  pt-1 text-xl ">
                        <div><i class="fa-regular fa-clock"></i></div>
                        <p class="m-0 ">{{ substr($event->date_start, 0, 10) }} at {{ substr($event->date_start, 11, 15) }} </p>
                    </div>
                    <h1 class="text-center pt-4 text-xl">Quickly !! Buy your tickets quickly</h1>
                    <p class="pt-2 text-center text-red-500 text-xl">From {{ $event->price }} MAD !! </p>
                    <form action="{{ route('ticket.post') }}" method="post">
                        @csrf
                        <div class="flex flex-col pb-3">
                            <label for="" class="pb-1">Price</label>
                            <select name="price" required id="" class="rounded-lg">
                                <option value="" disabled selected>Price</option>
                                <option value="{{ $event->price }}">{{ $event->price }} MAD</option>
                            </select>
                        </div>
                        <div class="flex flex-col pb-3">
                            <label for="" class="pb-1">Quantity</label>
                            <input min="1" type="number" placeholder="insert a number" name="quantity" required class="rounded-lg">
                        </div>
                        <input type="text" value="{{ $event->id }}" class="hidden" name="eventId">
                        <button  id="formTicket"
                        class="bg-blue-500 text-white px-4 py-1 rounded-lg text-base">Register</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="lg:w-[80%] w-[95%] mt-4 shadow-sm rounded-lg">
            <div class="p-2 flex flex-col items-start ">
                <h2 class="pt-2 text-xl">Description :</h2>
                <p class="pt-2 pl-2">{{ $event->description }}</p>
            </div>
        </div>
    </div>
@endsection
