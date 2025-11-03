<?php

namespace App\Livewire\Page;

use App\Models\Course;
use App\Models\File;
use App\Models\Folder;
use App\Models\Report;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $currentView = 'dashboard'; // 'dashboard' or 'reports'

    // Reports data
    public $reports;
    public $totalReports;
    public $pendingReports;
    public $acknowledgedReports;

    // Dashboard statistics
    public $totalUsers;
    public $totalCourses;
    public $totalFolders;
    public $totalFiles;
    public $recentUsers;
    public $storageUsed;

    public function mount($view = 'dashboard')
    {
        // Check if admin is authenticated
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login');
        }

        $this->currentView = $view;
        $this->loadData();
    }

    public function loadData()
    {
        // Load reports data
        $this->reports = Report::with([
            'user' => function ($query) {
                $query->select('id', 'username', 'email');
            },
            'reportedFile.folder',
            'reportedFile.course',
            'reportedFolder.folder',
            'reportedFolder.course'
        ])->orderBy('created_at', 'desc')->get();

        $this->totalReports = $this->reports->count();
        $this->pendingReports = $this->reports->where('is_acknowledged', false)->count();
        $this->acknowledgedReports = $this->reports->where('is_acknowledged', true)->count();

        // Load dashboard statistics
        $this->totalUsers = User::count();
        $this->totalCourses = Course::count();
        $this->totalFolders = Folder::count();
        $this->totalFiles = File::count();

        // Get recent users (last 5)
        $this->recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Calculate storage used (sum of file sizes)
        $files = File::all();
        $totalBytes = 0;
        foreach ($files as $file) {
            // Parse file size string (e.g., "1.5 MB", "500 KB")
            $size = $file->file_size;
            if (preg_match('/^([\d.]+)\s*(B|KB|MB|GB)$/', $size, $matches)) {
                $value = floatval($matches[1]);
                $unit = $matches[2];

                $multipliers = [
                    'B' => 1,
                    'KB' => 1024,
                    'MB' => 1024 * 1024,
                    'GB' => 1024 * 1024 * 1024,
                ];

                $totalBytes += $value * ($multipliers[$unit] ?? 1);
            }
        }

        $this->storageUsed = $totalBytes;
    }

    public function formatBytes($bytes, $decimals = 2)
    {
        if ($bytes === 0)
            return '0 B';

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor(log($bytes, 1024));
        $value = $bytes / pow(1024, $factor);

        if ($value >= 100) {
            $decimals = 0;
        } elseif ($value >= 10) {
            $decimals = 1;
        }

        return number_format($value, $decimals) . ' ' . $units[$factor];
    }

    public function switchView($view)
    {
        $this->currentView = $view;
    }

    public function toggleAcknowledgment($reportId)
    {
        $report = Report::find($reportId);
        if ($report) {
            $report->is_acknowledged = !$report->is_acknowledged;
            $report->save();

            // Reload data
            $this->loadData();

            $this->dispatch('success_flash', message: 'Report status updated.');
        }
    }

    public function logout()
    {
        session()->forget('admin_authenticated');
        session()->flash('success', 'Logged out successfully.');
        return redirect()->route('admin.login');
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.page.admin-dashboard');
    }
}
