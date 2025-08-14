<!-- component -->
<html>



<body class="border-2  bg-slate-400">
    <div class="container flex flex-col mx-auto ">
        <div class="w-full draggable">
            <div class="container flex flex-col items-center gap-16 mx-auto mt-10">
                <div class="grid w-full grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-y-8">
                    <div class="flex flex-col items-center">
                        <h3 class="text-5xl font-extrabold leading-tight text-center text-dark-grey-900"><span
                                id="countto1" countTo="250"></span>+</h3>
                        <p class="text-base font-medium leading-7 text-center text-dark-grey-600">Events Sold Out Monthly!
                        </p>
                    </div>
                    <div class="flex flex-col items-center">
                        <h3 class="text-5xl font-extrabold leading-tight text-center text-dark-grey-900">$<span
                                id="countto2" countTo="12"></span>m</h3>
                        <p class="text-base font-medium leading-7 text-center text-dark-grey-600">Annual Revenue Growth
                        </p>
                    </div>
                    <div class="flex flex-col items-center">
                        <h3 class="text-5xl font-extrabold leading-tight text-center text-dark-grey-900"><span
                                id="countto3" countTo="400" ></span>+</h3>
                        <p class="text-base font-medium leading-7 text-center text-dark-grey-600">Global Partners</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <h3 class="text-5xl font-extrabold leading-tight text-center text-dark-grey-900"><span
                                id="countto4" countTo="18000"></span>+</h3>
                        <p class="text-base font-medium leading-7 text-center text-dark-grey-600">Daily Website Visitors
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script
        src="https://cdn.jsdelivr.net/gh/Loopple/loopple-public-assets@main/motion-tailwind/scripts/plugins/countup.min.js">
    </script>
    <script>
        let numbers = document.querySelectorAll("[countTo]");

        numbers.forEach((number) => {
            let ID = number.getAttribute("id");
            let value = number.getAttribute("countTo");
            let countUp = new CountUp(ID, value);

            if (number.hasAttribute("data-decimal")) {
                const options = {
                    decimalPlaces: 1,
                };
                countUp = new CountUp(ID, 2.8, options);
            } else {
                countUp = new CountUp(ID, value);
            }

            if (!countUp.error) {
                countUp.start();
            } else {
                console.error(countUp.error);
                number.innerHTML = value;
            }
        });
    </script>
</body>

</html>
