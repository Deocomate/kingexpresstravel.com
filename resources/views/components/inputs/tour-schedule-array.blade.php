@pushonce("scripts")
    <script src="{{asset('/js/ckeditor/ckeditor.js')}}"></script>
@endpushonce

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $label }}</h3>
    </div>
    <div class="card-body">
        <div id="schedule-container-{{ $name }}">
            @if (is_array($value) && count($value) > 0)
                @foreach ($value as $index => $item)
                    <div class="schedule-item card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Ngày {{ $index + 1 }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool text-danger btn-remove-schedule"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="text" class="form-control mb-2" name="{{ $name }}[{{ $index }}][title]" placeholder="Tiêu đề (VD: Ngày 1: Hà Nội - Hạ Long)" value="{{ $item['title'] ?? '' }}">
                            <textarea name="{{ $name }}[{{ $index }}][content]" id="schedule-editor-{{ $name }}-{{ $index }}" class="form-control ckeditor-textarea">{!! $item['content'] ?? '' !!}</textarea>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="text-center mt-2">
            <button type="button" class="btn btn-primary btn-add-schedule-{{ $name }}">
                <i class="fas fa-plus"></i> Thêm Lịch trình
            </button>
        </div>
    </div>
</div>

<template id="schedule-template-{{ $name }}">
    <div class="schedule-item card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title">Ngày __INDEX_PLUS_1__</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool text-danger btn-remove-schedule"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <input type="text" class="form-control mb-2" name="{{ $name }}[__INDEX__][title]" placeholder="Tiêu đề (VD: Ngày __INDEX_PLUS_1__: ...)">
            <textarea name="{{ $name }}[__INDEX__][content]" id="schedule-editor-{{ $name }}-__INDEX__" class="form-control ckeditor-textarea"></textarea>
        </div>
    </div>
</template>

@pushonce("scripts")
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const allScheduleContainers = document.querySelectorAll('[id^="schedule-container-"]');

            allScheduleContainers.forEach(container => {
                const name = container.id.replace('schedule-container-', '');
                const addButton = document.querySelector(`.btn-add-schedule-${name}`);
                const template = document.getElementById(`schedule-template-${name}`);
                let scheduleCount = container.querySelectorAll('.schedule-item').length;
                let ckeditorInstances = {};

                const initCkEditor = (editorId) => {
                    if (!document.getElementById(editorId) || ckeditorInstances[editorId]) {
                        return;
                    }
                    CKEDITOR.ClassicEditor.create(document.getElementById(editorId), {
                        toolbar: {
                            items: [
                                'findAndReplace', 'selectAll', '|',
                                'heading', '|',
                                'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', 'bulletedList', 'numberedList', 'todoList', '|',
                                'outdent', 'indent', '|',
                                'undo', 'redo', '-',
                                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                                'alignment', '|',
                                'link', 'insertImage', "CKFinder", 'blockQuote', 'insertTable', 'mediaEmbed', 'htmlEmbed', '|',
                                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                                'sourceEditing'
                            ],
                            shouldNotGroupWhenFull: true
                        },
                        list: {
                            properties: {
                                styles: true,
                                startIndex: true,
                                reversed: true
                            }
                        },
                        ckfinder: {
                            openerMethod: 'popup',
                            options: {
                                resourceType: 'Images'
                            }
                        },
                        heading: {
                            options: [
                                { model: 'paragraph', view: 'p', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                            ]
                        },
                        placeholder: 'Content...',
                        fontFamily: {
                            options: [ 'default', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace', 'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif', 'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif', 'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif' ],
                            supportAllValues: true
                        },
                        fontSize: {
                            options: [10, 12, 14, 'default', 18, 20, 22],
                            supportAllValues: true
                        },
                        htmlSupport: {
                            allow: [{ name: /.*/, attributes: true, classes: true, styles: true }]
                        },
                        htmlEmbed: { showPreviews: true },
                        link: {
                            decorators: {
                                addTargetToExternalLinks: true,
                                defaultProtocol: 'https://',
                                toggleDownloadable: { mode: 'manual', label: 'Downloadable', attributes: { download: 'file' } }
                            }
                        },
                        removePlugins: [
                            'EasyImage', 'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges', 'RealTimeCollaborativeRevisionHistory',
                            'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination', 'WProofreader', 'MathType'
                        ]
                    }).then(editor => {
                        ckeditorInstances[editorId] = editor;
                    }).catch(error => console.error(`Error initializing CKEditor for ${editorId}:`, error));
                };

                const addRemoveEvent = (removeButton) => {
                    removeButton.addEventListener('click', function () {
                        const item = this.closest('.schedule-item');
                        const textarea = item.querySelector('.ckeditor-textarea');
                        const editorId = textarea.id;

                        if (ckeditorInstances[editorId]) {
                            ckeditorInstances[editorId].destroy().catch(error => console.error(error));
                            delete ckeditorInstances[editorId];
                        }
                        item.remove();
                        updateScheduleIndexes(name);
                    });
                };

                const updateScheduleIndexes = (name) => {
                    const scheduleContainer = document.getElementById(`schedule-container-${name}`);
                    const items = scheduleContainer.querySelectorAll('.schedule-item');
                    scheduleCount = items.length;
                    items.forEach((item, index) => {
                        item.querySelector('.card-title').textContent = `Ngày ${index + 1}`;
                        item.querySelectorAll('input, textarea').forEach(input => {
                            const oldName = input.getAttribute('name');
                            const newName = oldName.replace(/\[\d+\]/, `[${index}]`);
                            input.setAttribute('name', newName);
                        });
                    });
                };

                if (addButton) {
                    addButton.addEventListener('click', () => {
                        const newScheduleHTML = template.innerHTML.replace(/__INDEX__/g, scheduleCount).replace(/__INDEX_PLUS_1__/g, scheduleCount + 1);
                        const newScheduleDiv = document.createElement('div');
                        newScheduleDiv.innerHTML = newScheduleHTML;
                        const newItem = newScheduleDiv.firstElementChild;
                        container.appendChild(newItem);

                        const newEditorId = `schedule-editor-${name}-${scheduleCount}`;
                        initCkEditor(newEditorId);
                        addRemoveEvent(newItem.querySelector('.btn-remove-schedule'));
                        scheduleCount++;
                    });
                }

                container.querySelectorAll('.schedule-item').forEach(item => {
                    const textarea = item.querySelector('.ckeditor-textarea');
                    if (textarea) initCkEditor(textarea.id);
                    addRemoveEvent(item.querySelector('.btn-remove-schedule'));
                });
            });
        });
    </script>
@endpushonce
