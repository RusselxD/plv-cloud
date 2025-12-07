<div class="h-full flex flex-col items-center justify-start py-8 min-h-full">

    <x-ui.general.auth-logo />

    <form wire:submit.prevent="register"
        class="relative overflow-hidden bg-white w-[95%] sm:w-[70%] md:w-[60%] lg:w-[80%] shadow-[0_0_10px_rgba(0,0,0,0.25)] flex flex-col justify-center items-center p-8 rounded-lg flex-shrink-0 mt-4">

        <h1 class="text-2xl text-primary font-bold border-b-2 border-primary pb-3 w-full text-center">
            Complete Registration
        </h1>

        <div class="w-full flex flex-col items-stretch mt-5">
            <p class="mb-1 text-sm text-primary">Email</p>
            <p class="px-3 py-2 text-sm rounded-lg text-primary border-2 border-primary bg-primary/10">
                {{ $email }}
            </p>
        </div>

        <div class="w-full flex flex-col items-stretch mt-3">
            <label for="username" class="mb-1 text-sm text-primary">Username</label>
            <input id="username" type="text" wire:model="username"
                oninput="this.value = this.value.replace(/[^a-zA-Z0-9._-]/g, '')"
                class="px-3 py-2 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none" />
            @error('username') <p
                class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                {{ $message }}
            </p> @enderror
        </div>

        <div class="w-full flex flex-col items-stretch mt-3">
            <label for="password" class="mb-1 text-sm text-primary">Password</label>
            <div x-data="{ 
                show: false,
                password: '',
                getStrength() {
                    const pass = this.password;
                    if (!pass) return 0;
                    let score = 0;
                    if (pass.length >= 8) score++;
                    if (/[A-Z]/.test(pass)) score++;
                    if (/[a-z]/.test(pass)) score++;
                    if (/[0-9]/.test(pass)) score++;
                    if (/[^A-Za-z0-9]/.test(pass)) score++;
                    return score;
                },
                getStrengthText() {
                    const strength = this.getStrength();
                    if (strength === 0) return '';
                    if (strength <= 2) return 'Weak';
                    if (strength <= 3) return 'Good';
                    return 'Strong';
                },
                getStrengthColor() {
                    const strength = this.getStrength();
                    if (strength <= 2) return 'bg-red-500';
                    if (strength <= 3) return 'bg-yellow-500';
                    return 'bg-green-500';
                }
            }">
                <div class="relative">
                    <input id="password" :type="show ? 'text' : 'password'" wire:model="password" x-model="password"
                        class="px-3 py-2 pr-10 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none w-full" />
                    <div @click="show = !show"
                        class="absolute cursor-pointer inset-y-0 right-0 flex items-center pr-3 text-primary hover:text-primary/70">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Password Strength Indicator -->
                <div x-show="password.length > 0" class="mt-2">
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-300" :class="getStrengthColor()"
                                :style="'width: ' + (getStrength() * 20) + '%'"></div>
                        </div>
                        <span class="text-xs font-medium"
                            :class="getStrength() <= 2 ? 'text-red-500' : (getStrength() <= 3 ? 'text-yellow-600' : 'text-green-600')"
                            x-text="getStrengthText()"></span>
                    </div>
                    <div class="mt-1 text-xs text-gray-600">
                        <div class="grid grid-cols-2 gap-1">
                            <span :class="password.length >= 8 ? 'text-green-600' : 'text-gray-400'">✓ 8+
                                characters</span>
                            <span :class="/[A-Z]/.test(password) ? 'text-green-600' : 'text-gray-400'">✓
                                Uppercase</span>
                            <span :class="/[a-z]/.test(password) ? 'text-green-600' : 'text-gray-400'">✓
                                Lowercase</span>
                            <span :class="/[0-9]/.test(password) ? 'text-green-600' : 'text-gray-400'">✓ Number</span>
                            <span :class="/[^A-Za-z0-9]/.test(password) ? 'text-green-600' : 'text-gray-400'"
                                class="col-span-2">✓ Special character</span>
                        </div>
                    </div>
                </div>
            </div>
            @error('password') <p
                class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                {{ $message }}
            </p> @enderror
        </div>

        <div class="w-full flex flex-col items-stretch mt-3">
            <label for="password_confirmation" class="mb-1 text-sm text-primary">Confirm Password</label>
            <div class="relative" x-data="{ show_confirm: false }">
                <input id="password_confirmation" :type="show_confirm ? 'text' : 'password'"
                    wire:model="password_confirmation"
                    class="px-3 py-2 pr-10 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none w-full" />
                <div @click="show_confirm = !show_confirm"
                    class="absolute cursor-pointer inset-y-0 right-0 flex items-center pr-3 text-primary hover:text-primary/70">
                    <svg x-show="!show_confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <svg x-show="show_confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                        </path>
                    </svg>
                </div>
            </div>
            @error('password_confirmation') <p
                class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                {{ $message }}
            </p> @enderror
        </div>

        <div class="mt-4 flex justify-between items-center w-full gap-3">
            <div class="w-full">
                <label for="first_name" class="mb-1 text-sm text-primary">First Name</label>
                <input id="first_name" type="text" wire:model="firstName"
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s'-]/g, '')"
                    class="w-full px-3 py-2 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none" />
                @error('firstName') <p
                    class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                    {{ $message }}
                </p> @enderror
            </div>

            <div class="w-full">
                <label for="last_name" class="mb-1 text-sm text-primary">Last Name</label>
                <input id="last_name" type="text" wire:model="lastName"
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s'-]/g, '')"
                    class="w-full px-3 py-2 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none" />
                @error('lastName') <p
                    class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                    {{ $message }}
                </p> @enderror
            </div>
        </div>

        <div class="mt-4 flex justify-between items-start w-full gap-3">
            <div class="w-full">
                <label for="courseId" class="mb-1 text-sm text-primary">Course</label>
                <select wire:model="courseId"
                    class="w-full px-3 py-2 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none">
                    <option value="" selected>Select Course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->abbreviation }}</option>
                    @endforeach
                </select>
                @error('courseId')
                    <p
                        class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <button type="submit"
            class="mt-8 px-16 py-3 rounded-full font-medium border-2 border-primary text-primary bg-white hover:bg-primary hover:text-white cursor-pointer active:bg-primary active:text-white transition-colors duration-200">Sign
            Up</button>

        <div class="absolute inset-0 bg-black/20" wire:loading wire:target="register">
            <x-ui.general.spinner />
        </div>
    </form>

    <div class="mt-10 pb-5">
        <x-ui.general.copyright-footer />
    </div>
</div>