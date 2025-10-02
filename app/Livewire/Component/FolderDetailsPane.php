<?php

namespace App\Livewire\Component;

use App\Models\Folder;
use App\Models\FolderContributors;
use App\Models\FolderLog;
use App\Models\FolderRequests;
use App\Models\Notification;
use App\Models\Report;
use App\Models\UserActivity;
use Livewire\Attributes\On;
use Livewire\Component;

class FolderDetailsPane extends Component
{
    public $folder;
    public $reports = [];
    public $logs = [];
    public $contributors = [];
    public $activeReportsCount = 0;
    public $childrenFolderCount = 0;
    public $filesCount = 0;
    public $userIsTheOwner = false;
    public $userIsAContributor = false;

    #[On('folder-created')] // from CreateFolder
    #[On('file-created')] // from AddNewButton
    #[On('deleted')] // from ConfirmDeleteModal
    #[On('close-rename-modal')] // from RenameModal
    public function refresh()
    {
        $this->folder->loadCount(['files', 'children']);
        $this->storeCounts();

        $this->folder->load([
            'folderLogs.user:id,username,profile_picture',
        ]);
        $this->storeLogs();
    }

    public function toggleFolderPublicity()
    {
        $this->folder->is_public = !$this->folder->is_public;
        $this->folder->save();

        FolderLog::create([
            'folder_id' => $this->folder->id,
            'user_id' => auth()->id(),
            'details' => 'changed folder privacy to ' . ($this->folder->is_public ? 'public' : 'private'),
            // changed folder privacy to (public/private)            
        ]);

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Changed folder "' . $this->folder->name . '" privacy to ' . ($this->folder->is_public ? 'public' : 'private'),
            // Changed folder "Name" privacy to (public/private)            
        ]);

        $this->folder->load([
            'folderLogs.user:id,username,profile_picture',
        ]);
        $this->storeLogs();

        $this->dispatch('success_flash', message: 'Folder privacy updated successfully');
    }

    public function toggleReportedContents()
    {
        $this->reportedContentsAreShown = !$this->reportedContentsAreShown;
    }

    public function sendRequest()
    {
        FolderRequests::create([
            'folder_id' => $this->folder->id,
            'user_id' => auth()->id(),
        ]);

        Notification::create([
            'user_id' => $this->folder->user_id,
            'sender_id' => auth()->id(),
            'message' => auth()->user()->username . ' has requested to be a contributor in your folder "' . $this->folder->name . '"',
            'url' => route('folder', ['uuid' => $this->folder->uuid])
        ]);

        FolderLog::create([
            'folder_id' => $this->folder->id,
            'user_id' => auth()->id(),
            'details' => 'sent a request to be a contributor',
        ]);

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Sent a request to be a contributor in "' . $this->folder->name . '"',
        ]);

        $this->dispatch('success_flash', message: 'Request sent successfully');
    }

    public function approveOrDeclineRequest($approved, $requestId)
    {
        $request = $this->folder->folderRequests()->where('id', $requestId)->first();

        if ($approved) {
            FolderContributors::create([
                'folder_id' => $this->folder->id,
                'user_id' => $request->user_id
            ]);
        }

        Notification::create([
            'user_id' => $request->user_id,
            'sender_id' => auth()->id(),
            'message' => $this->folder->user->username . ' has ' . ($approved ? 'approved' : 'declined') . ' your request to be a contributor in "' . $this->folder->name . '"',
            'url' => route('folder', ['uuid' => $this->folder->uuid])
        ]);

        FolderLog::create([
            'folder_id' => $this->folder->id,
            'user_id' => auth()->id(),
            'details' => ($approved ? 'approved' : 'declined') . ' the request of ' . $request->user->username . ' to be a contributor',
            // approved/declined the request of username to be a contributor
        ]);

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => ($approved ? 'Approved' : 'Declined') . ' the request of ' . $request->user->username . ' to be a contributor in "' . $this->folder->name . '"',
            // Approved/Declined the request of username to be a contributor in "Name"
        ]);

        $request->delete();
        $this->folder->load([
            'folderContributors.user:id,username,profile_picture',
        ]);
        $this->storeContributors();
        
        $this->dispatch('success_flash', message: 'Request ' . ($approved ? 'approved' : 'declined') . ' successfully');
    }

    public function acknowledgeReport($reportId)
    {
        $report = $this->reports->where('id', $reportId)->first();
        if ($report['is_acknowledged']) {
            return;
        }

        Report::where('id', $reportId)->firstOrFail()->update(['is_acknowledged' => true]);

        FolderLog::create([
            'folder_id' => $this->folder->id,
            'user_id' => auth()->id(),
            'details' => 'acknowledged the report by ' . $report['username'] . ' of "' . $report['reported_item_name'] . '"',
            // acknowledged the report by username of "reported_item_name"
        ]);

        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => 'Acknowledged the report by ' . $report['username'] . ' of "' . $report['reported_item_name'] . '" in folder "' . $this->folder->name . '"',
            // Acknowledged the report by username of "reported_item_name"
        ]);


        $this->folder->load([
            'folderLogs.user:id,username,profile_picture',
        ]);
        $this->storeLogs();

        $this->folder->load([
            'files.reports.user:id,username',
            'children.reports.user:id,username',
        ]);
        $this->collectReports();
    }

    private function insertReports($reports, $name)
    {
        foreach ($reports as $report) {
            $this->reports[] = [
                'id' => $report->id,
                'reported_item_name' => $name,
                'username' => $report->user->username,
                'reason' => $report->reason,
                'reported_date' => $report->created_at->format('M d, Y'),
                'is_acknowledged' => $report->is_acknowledged
            ];
        }
    }

    private function collectReports()
    {
        $this->reports = collect();
        foreach ($this->folder->children as $child) {
            if ($child->reports) {
                $this->insertReports($child->reports, $child->name);
            }
        }

        $this->folder->unsetRelation('children');

        foreach ($this->folder->files as $file) {
            if ($file->reports) {
                $this->insertReports($file->reports, $file->name);
            }
        }

        $this->folder->unsetRelation('files');

        $this->activeReportsCount = $this->reports->where('is_acknowledged', false)->count();
    }

    private function storeLogs()
    {
        foreach ($this->folder->folderLogs as $log) {
            array_unshift($this->logs, [
                'username' => $log->user->username,
                'profile_picture' => $log->user->profile_picture,
                'details' => $log->details,
                'date' => $log->created_at->format('M d, Y'),
            ]);
        }

        $this->folder->unsetRelation('folderLogs');
    }

    private function storeContributors()
    {
        foreach ($this->folder->folderContributors as $contributor) {
            $this->contributors[] = [
                'id' => $contributor->user->id,
                'username' => $contributor->user->username,
                'profile_picture' => $contributor->user->profile_picture,
            ];
        }

        $this->folder->unsetRelation('folderContributors');
    }

    private function storeCounts()
    {
        $this->childrenFolderCount = $this->folder->children_count;
        $this->filesCount = $this->folder->files_count;

        unset($this->folder->files_count, $this->folder->children_count);
    }

    public function mount($uuid)
    {
        // First, get the folder with minimal data to determine access level
        $this->folder = Folder::where('uuid', $uuid)
            ->with(['user:id,username,profile_picture'])
            ->withCount(['files', 'children'])
            ->firstOrFail();

        $this->userIsTheOwner = $this->folder->user_id === auth()->id();

        // Check if user is a contributor (need to load this relationship first)
        $this->folder->load(['folderContributors:id,folder_id,user_id']);
        $this->userIsAContributor =
            $this->userIsTheOwner ||
            $this->folder->folderContributors->contains('user_id', auth()->id());

        // Now load relationships based on access level
        if ($this->userIsTheOwner) {
            // Owner gets everything
            $this->folder->load([
                'files.reports.user:id,username',
                'children.reports.user:id,username',
                'folderContributors.user:id,username,profile_picture',
                'folderRequests.user:id,username,profile_picture',
                'folderLogs.user:id,username,profile_picture',
            ]);

            $this->collectReports();
            $this->storeLogs();
            $this->storeContributors();

        } elseif ($this->userIsAContributor) {
            // Contributor gets: user (already loaded), contributors, and logs
            $this->folder->load([
                'folderContributors.user:id,username,profile_picture',
                'folderLogs.user:id,username,profile_picture',
            ]);

            $this->storeLogs();
            $this->storeContributors();

        } else {
            // Viewer gets: user (already loaded) and contributors
            $this->folder->load([
                'folderContributors.user:id,username,profile_picture',
            ]);

            $this->storeContributors();
        }

        $this->storeCounts();
    }

    public function render()
    {
        return view('livewire.component.folder-details-pane', ['folder' => $this->folder]);
    }
}