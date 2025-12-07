<?php

namespace App\Livewire\Page;

use App\Models\Course;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User as UserModel;
use Livewire\WithFileUploads;

class User extends Component
{
    use WithFileUploads;

    public $user;

    public $courses;

    public $isEditing = false;

    public $changePasswordIsShown = false;

    public $deleteAccountModalIsOpen = false;

    public $removeProfilePicture = false;

    public $newFirstName;
    public $newLastName;
    public $newUsername;
    public $newCourseId;
    public $newProfilePicture;

    public $currentPasswordInput;
    public $newPassword;
    public $confirmNewPassword;

    public $updateProfileToPublic;

    public function hydrate()
    {
        // Reload the user with counts after every request to prevent losing withCount data
        $this->user->loadCount('files', 'folders');
    }

    public function openEditing()
    {
        $this->isEditing = true;
    }

    public function closeEditing()
    {
        $this->isEditing = false;
    }

    public function toggleChangePassword()
    {
        $this->changePasswordIsShown = !$this->changePasswordIsShown;
    }

    public function setProfileToPublic()
    {
        $this->updateProfileToPublic = true;
    }

    public function setProfileToPrivate()
    {
        $this->updateProfileToPublic = false;
    }

    public function openDeleteAccountModal()
    {
        $this->deleteAccountModalIsOpen = true;
    }

    public function removePhoto()
    {
        $this->removeProfilePicture = true;
        $this->newProfilePicture = null;
    }

    #[On('close-delete-account-modal')]
    public function closeDeleteAccountModal()
    {
        $this->deleteAccountModalIsOpen = false;
    }

    public function noChanges()
    {
        // Check if a new profile picture was uploaded (file object)
        $profilePictureChanged = is_object($this->newProfilePicture);

        return $this->newFirstName === $this->user->first_name &&
            $this->newLastName === $this->user->last_name &&
            $this->newUsername === $this->user->username &&
            $this->newCourseId === $this->user->course_id &&
            $this->updateProfileToPublic === $this->user->is_public &&
            !$profilePictureChanged &&
            !$this->removeProfilePicture;
    }

    public function saveChanges()
    {
        if ($this->noChanges()) {
            $this->isEditing = false;
            return;
        }

        // Validate basic profile fields
        $validationRules = [
            'newFirstName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'newLastName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'newUsername' => ['required', 'string', 'min:3', 'max:20', 'regex:/^[a-zA-Z0-9._-]+$/', 'unique:users,username,' . $this->user->id],
            'newCourseId' => 'required|exists:courses,id',
        ];

        // Only validate profile picture if it's a newly uploaded file (object)
        if (is_object($this->newProfilePicture)) {
            $validationRules['newProfilePicture'] = 'nullable|image|max:2048';
        }

        $this->validate($validationRules, [
            'newFirstName.required' => 'First name is required.',
            'newFirstName.regex' => 'First name may only contain letters, spaces, hyphens, and apostrophes.',
            'newLastName.required' => 'Last name is required.',
            'newLastName.regex' => 'Last name may only contain letters, spaces, hyphens, and apostrophes.',
            'newUsername.required' => 'Username is required.',
            'newUsername.min' => 'Username must be at least 3 characters.',
            'newUsername.max' => 'Username cannot exceed 20 characters.',
            'newUsername.regex' => 'Username may only contain letters, numbers, dots, underscores, and hyphens.',
            'newUsername.unique' => 'This username is already taken.',
            'newCourseId.required' => 'Please select a course.',
            'newCourseId.exists' => 'Invalid course selected.',
            'newProfilePicture.image' => 'Profile picture must be an image.',
            'newProfilePicture.max' => 'Profile picture must not exceed 2MB.',
        ]);

        // Validate password fields if Change Password section is shown and any field is filled
        if ($this->changePasswordIsShown && ($this->currentPasswordInput || $this->newPassword || $this->confirmNewPassword)) {
            $this->validate([
                'currentPasswordInput' => 'required',
                'newPassword' => 'required|min:8',
                'confirmNewPassword' => 'required|same:newPassword',
            ], [
                'currentPasswordInput.required' => 'Current password is required.',
                'newPassword.required' => 'New password is required.',
                'newPassword.min' => 'New password must be at least 8 characters.',
                'confirmNewPassword.required' => 'Please confirm your new password.',
                'confirmNewPassword.same' => 'Password confirmation does not match.',
            ]);

            // Verify current password
            if (!\Hash::check($this->currentPasswordInput, $this->user->password)) {
                $this->addError('currentPasswordInput', 'Current password is incorrect.');
                return;
            }

            // Update password
            $this->user->password = \Hash::make($this->newPassword);
        }

        // Handle profile picture removal
        if ($this->removeProfilePicture) {
            // Delete old profile picture if exists
            if ($this->user->profile_picture && \Storage::disk('public')->exists($this->user->profile_picture)) {
                \Storage::disk('public')->delete($this->user->profile_picture);
            }
            $this->user->profile_picture = null;
            $this->removeProfilePicture = false;
        }
        // Update profile picture if uploaded
        elseif (is_object($this->newProfilePicture)) {
            // Delete old profile picture if exists
            if ($this->user->profile_picture && \Storage::disk('public')->exists($this->user->profile_picture)) {
                \Storage::disk('public')->delete($this->user->profile_picture);
            }

            // Store new profile picture
            $path = $this->newProfilePicture->store('profile_pictures', 'public');
            $this->user->profile_picture = $path;
        }

        // Check if username changed
        $usernameChanged = $this->user->username !== $this->newUsername;

        // Update user details
        $this->user->first_name = $this->newFirstName;
        $this->user->last_name = $this->newLastName;
        $this->user->username = $this->newUsername;
        $this->user->course_id = $this->newCourseId;
        $this->user->is_public = $this->updateProfileToPublic;

        $this->user->save();

        // Reset password fields
        $this->currentPasswordInput = '';
        $this->newPassword = '';
        $this->confirmNewPassword = '';

        // Update local state
        $this->newProfilePicture = $this->user->profile_picture;

        $this->user->loadCount('files', 'folders');

        // Redirect to new username URL if username changed
        if ($usernameChanged) {
            session()->flash('success', 'Profile updated successfully.');
            return redirect()->route('user', ['username' => $this->newUsername]);
        }

        $this->dispatch('success_flash', message: 'Profile updated successfully.');
        $this->isEditing = false;
    }

    public function mount($username)
    {
        $this->user = UserModel::with('course', 'files', 'folders', 'userActivities')->withCount('files', 'folders')->where("username", $username)->firstOrFail();
        if (auth()->id() == $this->user->id) {
            $this->courses = Course::get();

            $this->newProfilePicture = $this->user->profile_picture;

            $this->newFirstName = $this->user->first_name;
            $this->newLastName = $this->user->last_name;
            $this->newUsername = $this->user->username;
            $this->newCourseId = $this->user->course_id;
            $this->updateProfileToPublic = $this->user->is_public;
        }

    }

    public function render()
    {
        return view('livewire.page.user');
    }
}