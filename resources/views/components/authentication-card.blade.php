<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black-100">
    <div>
        <a href="/" class="flex flex-col items-center">
            <img src="{{ asset('assets/img/logo.png') }}"
            alt="Lands and People Coffee"
            class="mx-auto mb-2" 
            style="width:160px;">

         
        <span class="text-lg font-bold tracking-wide">
            Lands & People Coffee
        </span>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
