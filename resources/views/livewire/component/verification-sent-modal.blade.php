<div class="absolute inset-0 bg-primary/20 flex items-center justify-center" x-data="{ open: true }" x-show="open"
    x-transition @click.self="open = false">
    <div
        class="lg:w-[40rem] bg-white border-2 border-primary p-5 flex flex-col items-center text-center justify-center text-primary gap-5 rounded-3xl">

        <img src="{{ asset('/assets/mail-sent.svg') }}" class="w-16 h-16    " />
        <h1 class="font-bold text-3xl">Verification Link Sent!</h1>
        <p>A verification link has been sent to <strong>{{ $email }}</strong></p>

        <p class="text-sm">Check your inbox to complete registration. If not found, look in Spam/Junk folder.</p>

        <a href="https://outlook.office.com/mail/" target="_blank" class="flex items-center justify-center border-2 border-primary text-primary rounded-full px-8 py-2 gap-3 font-medium cursor-pointer 
          transition-colors duration-200 hover:bg-primary hover:text-white">
            <img src="{{ asset('/assets/outlook.svg') }}" class="w-7 h-7" />
            Check Your Email
        </a>

        <span class="text-sm" wire:click="resend">
            Didn't get it?
            <span class="font-bold cursor-pointer">Click here to resend</span>
        </span>
    </div>
</div>