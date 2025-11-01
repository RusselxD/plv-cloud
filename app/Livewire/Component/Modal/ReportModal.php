<?php

namespace App\Livewire\Component\Modal;

use App\Models\File;
use App\Models\Folder;
use App\Models\Notification;
use App\Models\Report;
use App\Models\UserActivity;
use Livewire\Component;

class ReportModal extends Component
{

    public $options = [
        [
            "id" => "malware",
            "icon" => "⚠️"
        ],
        [
            "id"=> "nsfw",
            "icon" => "🔞"
        ],
        [
            "id"=> "hate",
            "icon" => "⛔"
        ],
        [
            "id"=> "copyright",
            "icon" => "©️"
        ],
        [
            "id"=> "illegal",
            "icon" => "🚫"
        ],
        [
            "id"=> "notbelongs",
            "icon" => "📁"
        ],
        [
            "id"=> "spam",
            "icon" => "📧"
        ],
        [
            "id"=> "lowquality",
            "icon" => "❌"
        ],
        [
            "id"=> "other",
            "icon" => "📝"
        ],
    ];

    public $labels = [
        "malware" => "Malware / Virus",
        "nsfw" => "Pornography / NSFW Content",
        "hate" => "Hate Speech / Violence",
        "copyright"=> "Copyright Violation",
        "illegal"=> "Illegal Content",
        "notbelongs"=> "Doesn't belong in this directory",
        "spam"=> "Spam / Irrelevant Content",
        "lowquality"=> "Low Quality / Broken File",
        "other"=> "Others (Please Specify)",
    ];


    public $reason = "";

    public $otherDetails = "";

    public $reportedItemId;

    public $isAFolder;

    public function closeModal()
    {
        $this->dispatch('close-report-modal'); // to FolderCard or FileCard
    }

    public function notifyFolderParentOwner($reportedName, $parentFolder){        

        Notification::create([
            'user_id' => $parentFolder->user_id,
            'title' => "Folder Reported",
            'message' => auth()->user()->username . ' has reported "' . $reportedName . '" on your folder "' . $parentFolder->name . '"',
            'type' => 'report',
            'url' => route('folder', ['uuid' => $parentFolder->uuid]),
        ]);
    }

    public function submitReport()
    {   
        if($this->reason == "other" && empty($this->otherDetails)){
            $this->addError('otherDetails', 'Please provide details for "Other" reason.');
            return;
        }

        if($this->reason == "other" && strlen($this->otherDetails) > 100){
            $this->addError('otherDetails', 'Details must not exceed 100 characters.');
            return;
        }

        Report::create([
            'user_id' => auth()->id(),
            'reason' => $this->reason == 'other' ? $this->otherDetails : $this->labels[$this->reason],
            'reported_file_id' => $this->isAFolder ? null : $this->reportedItemId,
            'reported_folder_id' => $this->isAFolder ? $this->reportedItemId : null,
        ]);

        $reportedItem = $this->isAFolder ? Folder::with('folder')->find($this->reportedItemId) : File::with('folder')->find($this->reportedItemId);

        if($reportedItem->folder != null){
            $this->notifyFolderParentOwner($reportedItem->name, $reportedItem->folder);            
        }   
        
        UserActivity::create([
            'user_id' => auth()->id(),
            'details' => "Reported " . ($this->isAFolder ? "folder" : "file") . ": " . $reportedItem->name
        ]);

        $this->dispatch('success_flash', message: 'Report submitted successfully.');
        $this->dispatch('close-report-modal'); // caught by FolderCard or FileCard
    }

    public function mount($reportedItemId, $isAFolder){
        $this->reportedItemId = $reportedItemId;
        $this->isAFolder = $isAFolder;
    }

    public function render()
    {        
        return view('livewire.component.modal.report-modal');
    }
}