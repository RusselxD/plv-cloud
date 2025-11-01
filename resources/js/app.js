import "./bootstrap";

// Handle file downloads with success message
document.addEventListener('livewire:init', () => {
    Livewire.on('trigger-download', (event) => {
        const { url, filename } = event[0];
        
        // Create a hidden link and trigger download
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Show success message after triggering download
        setTimeout(() => {
            Livewire.dispatch('success_flash', { message: 'File is downloading.' });
        }, 100);
    });

    // Handle folder downloads with success message
    Livewire.on('trigger-folder-download', (event) => {
        const { url, foldername } = event[0];
        
        // Create a hidden link and trigger download
        const link = document.createElement('a');
        link.href = url;
        link.download = foldername + '.zip';
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Show success message after triggering download
        setTimeout(() => {
            Livewire.dispatch('success_flash', { message: 'Folder is being prepared for download.' });
        }, 100);
    });
});
