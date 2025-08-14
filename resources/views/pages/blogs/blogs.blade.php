@extends('layouts.index')
@section('content')
<!-- component -->
<style>
    .w-70 {
        width: 20rem;
    }
</style>

<section class="blog text-gray-700 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900"> Blog</h1>
            <p class="lg:w-1/2 w-full leading-relaxed text-base">
                I like to share my knowledge and interesting research, to do so I set up a personal blog. We cover several interesting topics and I give some tips and advice to young developers to do better.</p>
        </div>
        <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4">
            <div class="lg:p-4 md:w-1/3 md:mb-0 mb-6 flex flex-col justify-center items-center max-w-sm mx-auto">
                <div class="bg-gray-300 h-56 w-full rounded-lg shadow-md bg-cover bg-center"
                    style="background-image: url('images/blog-ideas.jpg') ; background-origin:initial">
                </div>

                <div class=" w-[95%] bg-white -mt-10 shadow-lg rounded-lg overflow-hidden lg:p-5 p-3    ">

                    <div class="header-content inline-flex ">
                        <div class="category-badge flex-1  h-4 w-4 m rounded-full m-1 bg-purple-100">
                            <div class="h-2 w-2 rounded-full m-1 bg-purple-500 "></div>
                        </div>
                        <div class="category-title flex-1 text-sm"> cat1</div>
                    </div>
                    <div class="title-post font-bold">Ideas</div>

                    <div class="summary-post text-base text-justify">Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Perspiciatis veritatis vel suscipit ex dolore possimus iure.
                        <button class="bg-blue-100 text-blue-500 mt-4 block rounded p-2 text-sm "><span
                                class="">Lire plus</span></button>
                    </div>

                </div>
            </div>

            <div class="lg:p-4 md:w-1/3 md:mb-0 mb-6 flex flex-col justify-center items-center max-w-sm mx-auto">
                <div class="bg-gray-300 h-56 w-full rounded-lg shadow-md bg-cover bg-center"
                    style="background-image: url('images/blog-ExIntrovert.jpeg')">
                </div>

                <div class=" w-[95%] bg-white -mt-10 shadow-lg rounded-lg overflow-hidden lg:p-5 p-3 ">

                    <div class="header-content inline-flex  ">
                        <div class="category-badge flex-1  h-4 w-4 m rounded-full m-1 bg-yellow-100">
                            <div class="h-2 w-2 rounded-full m-1 bg-yellow-500 "></div>
                        </div>
                        <div class="category-title flex-1 text-sm pt-1">cat2</div>
                    </div>
                    <div class="title-post font-bold">In/Extrovert</div>

                    <div class="summary-post text-base text-justify">Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Perspiciatis veritatis vel suscipit ex dolore possimus iure.
                        <button class="bg-blue-100 text-blue-500 px-2 mt-4 block rounded p-2 text-sm"><span
                                class="">Lire plus</span></button>
                    </div>

                </div>
            </div>

            <div class="lg:p-4 md:w-1/3 md:mb-0 mb-6 flex flex-col justify-center items-center max-w-sm mx-auto">
                <div class=" bg-gray-300 h-56 w-full rounded-lg shadow-md bg-cover bg-center"
                    style="background-image: url('images/blog-Laughter.jpg')">
                </div>

                <div class=" w-[95%] bg-white -mt-10 shadow-lg rounded-lg overflow-hidden lg:p-5 p-3 ">

                    <div class="header-content inline-flex ">
                        <div class="category-badge flex-1  h-4 w-4 m rounded-full m-1 bg-green-100">
                            <div class="h-2 w-2 rounded-full m-1 bg-green-500 "></div>
                        </div>
                        <div class="category-title flex-1 text-sm"> cat3</div> 
                    </div> 
                    <div class="title-post font-bold">Laughter</div>

                    <div class="summary-post text-base text-justify">Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Perspiciatis veritatis vel suscipit ex dolore possimus iure.
                        <button class="bg-blue-100 text-blue-500 px-2 mt-4 block rounded p-2 text-sm"><span
                                class="">Lire plus</span></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

    
@endsection