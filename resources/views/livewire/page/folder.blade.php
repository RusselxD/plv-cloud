<div>
    <x-ui.general.breadcrumb :breadcrumbs="[
        ['Home', '/'],
        [$course->abbreviation, route('course', ['courseSlug' => $course->slug])],
        [$folder->name, route('folder', ['courseSlug' => $course->slug, 'folderSlug' => $folder->slug])],
    ]"/>
</div>
