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

    public $confirmDeleteAllModalIsOpen = false;

    public function submitSearch()
    {
        $this->render();
    }

    public function clearSearch()
    {
        $this->search = '';
    }

    public function sendDispatchForNotifUpdate()
    {
        $this->dispatch('update-notifs'); // caught by Sidebar and ProfileWithNotif
    }

    public function toggleShowAll()
    {
        if (!$this->showAll) {
            $this->showAll = true;
        }
    }

    public function showUnread()
    {
        if ($this->showAll) {
            $this->showAll = false;
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())->where('is_read', false)->update(['is_read' => true]);
        $this->sendDispatchForNotifUpdate();
    }

    public function openConfirmDeleteAllNotificationsModal()
    {
        $this->confirmDeleteAllModalIsOpen = true;
    }

    public function closeConfirmDeleteAllNotificationsModal()
    {
        $this->confirmDeleteAllModalIsOpen = false;
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->is_read = true;
            $notification->save();
            $this->sendDispatchForNotifUpdate();
        }
    }

    public function goToNotificationURL($notificationId, $url)
    {
        Notification::find($notificationId)->update(['is_read' => true]);
        return redirect($url);
    }


    public function deleteNotification($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->delete();
            $this->dispatch('success_flash', message: 'Notification deleted successfully');
            $this->sendDispatchForNotifUpdate();
        }
    }

    public function deleteAllNotifications()
    {
        Notification::where('user_id', auth()->id())->delete();
        $this->dispatch('success_flash', message: 'All notifications deleted successfully');
        $this->sendDispatchForNotifUpdate();
        $this->confirmDeleteAllModalIsOpen = false;
    }

    public function render()
    {
        $this->allNotifsCount = Notification::where('user_id', auth()->id())->count();
        $this->unreadNotifsCount = Notification::where('user_id', auth()->id())->where('is_read', false)->count();

        $query = Notification::where('user_id', auth()->id());

        // Apply search filter if search has content
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('message', 'LIKE', '%' . $this->search . '%');
            });
            $this->showAll = true;
        }

        // Apply read/unread filter
        if (!$this->showAll) {
            $query->where('is_read', false);
        }

        $notifications = $query->orderBy('created_at', 'desc')->get();

        return view('livewire.page.notifications', compact('notifications'));
    }
}