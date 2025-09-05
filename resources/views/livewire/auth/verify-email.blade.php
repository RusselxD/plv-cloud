<div>
    <form wire:submit.prevent="submit">

        <p>Verify your PLV Email</p>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" wire:model="email"/>
        </div>

        <button type="submit">Send Verification Link</button>
    </form>
    @error('email')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>