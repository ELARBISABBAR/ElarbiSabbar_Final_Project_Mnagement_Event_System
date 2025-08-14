<div class="card lg:w-[23.5%] w-[100%] sm:flex-wrap   bg-white shadow-md border border-gray-200 rounded-lg ">
    {{-- <img class="h-[40vh] rounded-t-lg" src = "{{ asset('/images/face-sb.jpg') }}" class="card-img-top" alt="..."> --}}
    <img class="h-[30vh] rounded-t-md" src="{{ asset('storage/img/' . $event->image) }}" class="card-img-top"
        alt="...">
    <div class="card-body p-4">
        <h3 class="card-title text-gray-900 font-bold text-2xl tracking-tight">{{ $event->title }}</h3>
        {{-- <p class="card-text m-0">{{ $event->description }}</p> --}}
        <div class="flex gap-2 items-center  pt-1 pb-1 ">
            <div><i class="fa-solid fa-location-dot"></i></div>
            <p class="m-0  font-normal text-gray-700">{{ $event->location }}</p>
        </div>
        <div class="flex gap-2 items-center  pt-1  ">
            <div class=""><i class="fa-regular fa-clock"></i></div>
            <p class="m-0 font-normal text-gray-700 ">{{ substr($event->date_start, 0, 10) }} at {{ substr($event->date_start, 11, 15) }} </p>
        </div>
        <div class="flex justify-between items-center  pt-1  ">
            <div class="pl-1 text-xl text-red-600">{{ $event->price }} MAD</div>
            <form action="{{ route('ticket.show', $event) }}" method="get">
                <button class="cursor-pointer bg-blue-600 px-4 py-2 rounded-xl text-white font-semibold">Buy</button>
            </form>
        </div>

    </div>
</div>


