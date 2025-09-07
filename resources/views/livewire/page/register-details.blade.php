<div>
    <h1>Create your account</h1>
    <div>
        <p>Email</p>
        <p>{{ $email }}</p>
    </div>

    <form wire:submit.prevent="register">
        @csrf

        <div>
            <label for="username">Username</label>
            <input id="username" type="text" wire:model="username" />
            @error('username') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" wire:model="password" />
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" wire:model="password_confirmation" />
            @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="student_number">Student Number</label>
            <input id="student_number" type="text" wire:model="studentNumber" />
            @error('studentNumber') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="first_name">First Name</label>
            <input id="first_name" type="text" wire:model="firstName" />
            @error('firstName') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="last_name">Last Name</label>
            <input id="last_name" type="text" wire:model="lastName" />
            @error('lastName') <span class="error">{{ $message }}</span> @enderror
        </div>

        <select wire:model="courseId">
            <option value="" selected>Select Course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->abbreviation }}</option>
            @endforeach
        </select>

        <button type="submit">Register</button>
    </form>

</div>