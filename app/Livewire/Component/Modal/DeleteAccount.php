<?php

namespace App\Livewire\Component\Modal;

use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DeleteAccount extends Component
{
    public $passwordConfirmation;

    public function closeModal()
    {
        $this->dispatch('close-delete-account-modal');
    }

    public function deleteAccount()
    {
        // Validate password confirmation
        $this->validate([
            'passwordConfirmation' => 'required',
        ], [
            'passwordConfirmation.required' => 'Password is required to confirm deletion.',
        ]);

        $user = Auth::user();

        // Verify the password
        if (!Hash::check($this->passwordConfirmation, $user->password)) {
            $this->addError('passwordConfirmation', 'Incorrect password.');
            return;
        }

        // Delete all user's files from storage
        $files = File::where('user_id', $user->id)->get();
        foreach ($files as $file) {
            if ($file->path && Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
        }

        // Delete all user's folders (cascade will handle related records)
        Folder::where('user_id', $user->id)->delete();

        // Delete all user's files (cascade will handle related records)
        File::where('user_id', $user->id)->delete();

        // Delete profile picture if exists
        if (!empty($user->profile_picture) && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Logout the user
        Auth::logout();

        // Delete the user account
        $user->delete();

        // Invalidate the session
        session()->invalidate();
        session()->regenerateToken();

        // Redirect to home page
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }

    public function render()
    {
        return view('livewire.component.modal.delete-account');
    }
}
