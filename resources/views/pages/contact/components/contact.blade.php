    <!-- component -->
    <!-- format the code its messy  -->

    <div class="lg:mb-16 ">
        <!-- {/* top container with tagline and backgroundImage  */} -->
        <div class="relative">
            <!-- {/* image section  */} -->
            <section class="w-full h-[50vh] lg:h-[64vh] bg-cover bg-center brightness-75 ">
                <div class="absolute top-0 w-full h-full bg-center bg-cover"
                    style="
            background-image: url('images/contact.jpg');
            background-attachment: fixed;
          ">
            </section>
            <!-- {/* tagline division  */} -->
            <div class="absolute top-1/2 left-[50%] md:left-[50%] -translate-y-1/2 text-white text-center">
                <h1 class="text-3xl md:text-5xl  font-bold">Get In Touch</h1>
                <p class="text-sm md:text-lg pb-4">
                    Need Help ? We're Here 24/7
                </p>
            </div>
        </div>
        <!-- {/* bottom relative container  */} -->
        <div class="w-full h-[1100px] md:h-[60vh] lg:h-[80vh]  relative">

            <!-- {/* division with floating form  */} -->
            <div
                class="absolute -top-[3%] md:-top-[10%] left-1/2 -translate-x-1/2 grid grid-cols-1 md:grid-cols-3 h-fit w-4/5 md:w-[90%] lg:w-4/5 rounded shadow overflow-hidden text-white">
                <!-- {/* form / left div  */} -->
                <div class="p-2 md:p-4 h-full bg-[#2c323f] col-span-2">
                    <form action="{{ route('contact.store') }} " method="post">
                        @csrf
                        <!-- {/* form top part containing mail icon and heading  */} -->
                        <div class="flex flex-col md:flex-row justify-around items-start md:items-center pt-8 p-4">
                            <!-- {/* heading  */} -->
                            <h2 class="text-2xl md:text-3xl font-semibold">Send Us A Message</h2>

                            <!-- {/* mail svg icon  */} -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-forward"
                                width="33" height="33" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" />
                                <path d="M3 6l9 6l9 -6" />
                                <path d="M15 18h6" />
                                <path d="M18 15l3 3l-3 3" />
                            </svg>
                        </div>

                        <!-- {/* bottom form with input fields  */} -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-6 px-4 md:py-12 md:px-8 text-sm">
                            <!-- {/* name input  */} -->
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">
                                    Name <span class="text-red-500">&#42;</span>
                                </label>
                                <input class="border-[1px] placeholder:text-white border-white  bg-[#2c323f] p-2 rounded-md"
                                    placeholder="Enter Your Name" re quired name="name" type="text" />
                            </div>

                            <!-- {/* email input  */} -->
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">
                                    Email <span class="text-red-500">&#42;</span>
                                </label>
                                <input class="border-[1px]  border-white placeholder:text-white  bg-[#2c323f] p-2 rounded-md"
                                    placeholder="Enter Your Email" r equired name="email" type="email" />
                            </div>

                            <!-- {/* phone number input  */} -->
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">
                                    Phone <span class="text-red-500">&#42;</span>
                                </label>
                                <input class="border-[1px]  border-white placeholder:text-white  bg-[#2c323f] p-2 rounded-md"
                                    placeholder="Enter Your Phone Nu mber" required name="phone" type="tel" />
                            </div>

                            <!-- {/* subject input  */} -->
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">
                                    Subject <span class="text-red-500">&#42;</span>
                                </label>
                                <input class="border-[1px]  border-white placeholder:text-white  bg-[#2c323f] p-2 rounded-md"
                                    placeholder="Enter Your Subject"  required name="subject" type="text" />
                            </div>

                            <!-- {/* message input  */} -->
                            <div class="flex flex-col gap-1 md:col-span-2">
                                <label class="font-semibold">
                                    Message <span class="text-red-500">&#42;</span>
                                </label>
                                <input class="border-[1px]  border-white placeholder:text-white  bg-[#2c323f] p-2 rounded-md"
                                    placeholder="Enter Your Message"  required name="message" type="text" />
                            </div>
                        </div>
                        <!-- {/* submit button div  */} -->
                        <div class="flex items-center justify-center md:justify-end py-4 px-8 ">
                            <!-- {/* submit button  */} -->
                            <button
                                class=" lg:py-1  px-2  md:px-6 bg-[#2c323f] rounded-md border-2 border-white flex items-center gap-2 hover:scale-95 transition-all">
                                <span class="text-xl">Submit</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-brand-telegram" width="30" height="30"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                                </svg>
                            </button>
                        </div>
                    </form>

                </div>

                <!-- {/* right div  */} -->
                <div class="py-6 px-4 h-[fit-content] md:h-full bg-slate-100 text-[#2c323f]  flex flex-col  gap-y-20 justify-center">
                    <div>
                        <!-- {/* heading tag  */} -->
                        <h2 class="text-xl lg:text-2xl text-center md:text-start font-semibold">Contact Information</h2>

                        <!-- {/* email and icon  */} -->
                        <div class="row-span-4 flex flex-col items-center ">
                            <i class="fa-solid fa-envelope-circle-check text-gray-500 cursor-pointer hover:text-gray-700 text-3xl mb-2"></i>
                            <span class="text-lg">contact@evenxt.com</span>
                        </div>
                    </div>

                    <div>
                        <!-- {/* social icons div  */} -->
                    
                        <h2 class="text-xl lg:text-2xl text-center md:text-start font-semibold">Follow us :</h2>
                        <div class="mt-2 text-center ">
                            <span class="inline-flex justify-center mt-2 sm:ml-auto sm:mt-0 sm:justify-start">
                                <a class="text-gray-500 cursor-pointer hover:text-gray-700 ">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                    </svg>
                                </a>
                                <a class="ml-3 text-gray-500 cursor-pointer hover:text-gray-700">
                                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        class="w-5 h-5" viewBox="0 0 24 24">
                                        <path
                                            d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                        </path>
                                    </svg>
                                </a>
                                <a class="ml-3 text-gray-500 cursor-pointer hover:text-gray-700">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                                    </svg>
                                </a>
                                <a class="ml-3 text-gray-500 cursor-pointer hover:text-gray-700">
                                    <svg fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path stroke="none"
                                            d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z">
                                        </path>
                                        <circle cx="4" cy="4" r="2" stroke="none"></circle>
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
