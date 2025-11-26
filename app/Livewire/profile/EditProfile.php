<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.app')]
    #[Title('Edit Profile')]

    public $name;
    public $profession;
    public $bio;
    public $photo_profile;
    public $new_photo;

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->profession = $user->profession;
        $this->bio = $user->bio;
        $this->photo_profile = $user->photo_profile;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'new_photo' => 'nullable|image|max:2048',
        ]);

        if ($this->new_photo) {
            $path = $this->new_photo->store('profiles', 'public');
            $user->photo_profile = $path;
        }

        $user->update([
            'name' => $this->name,
            'profession' => $this->profession,
            'bio' => $this->bio,
            'photo_profile' => $user->photo_profile,
        ]);
        session()->flash('profile_updated', true);
        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.profile.edit-profile');
    }
}

