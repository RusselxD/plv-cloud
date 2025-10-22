<?php

namespace App\Livewire\Page;

use App\Models\Notification;
use Livewire\Component;

class Notifications extends Component
{
    public $icons = [
        "request" => "/assets/notif-icons/user-plus.svg",
        "report" => "/assets/notif-icons/triangle-alert.svg",
        "approve" => "/assets/notif-icons/circle-check.svg",
        "decline" => "/assets/notif-icons/circle-x.svg",
        "delete" => "/assets/notif-icons/trash.svg"
    ];

    public $bgColors = [
        "request" => "bg-blue-200",
        "report" => "bg-red-100",
        "approve" => "bg-green-200",
        "decline" => "bg-red-100",
        "delete" => "bg-orange-100"
    ];

    public $search;

    public $showAll = true;    

    public $allNotifsCount = 0;
    public $unreadNotifsCount = 0;

    public function clickSearch(){}

    public function toggleShowAll(){
        if (!$this->showAll){            
            $this->showAll = true;            
        }
    }

    public function showUnread(){
        if ($this->showAll){
            $this->showAll = false;
        }
    }    

    public function markAllAsRead(){
        Notification::where('user_id', auth()->id())->where('is_read', false)->update(['is_read' => true]);
    }

    public function markAsRead($id){
        $notification = Notification::find($id);
        if ($notification) {
            $notification->is_read = true;
            $notification->save();
        }
    }

    public function deleteNotification($id){
        $notification = Notification::find($id);
        if ($notification) {
            $notification->delete();
            $this->dispatch('success_flash', message: 'Notification deleted successfully');
        }
    }

    public function render()
    {
        $this->allNotifsCount = Notification::where('user_id', auth()->id())->count();
        $this->unreadNotifsCount = Notification::where('user_id', auth()->id())->where('is_read', false)->count();
        
        $notifications = $this->showAll ? 
            Notification::where('user_id', auth()->id())->get() :
            Notification::where('user_id', auth()->id())->where('is_read', false)->get();

        return view('livewire.page.notifications', compact('notifications'));
    }
}