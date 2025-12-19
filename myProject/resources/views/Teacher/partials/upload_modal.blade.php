<div id="uploadModal" class="modal hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-upload"></i> Upload Learning Material</h3>
            <button class="close-btn" onclick="closeUploadModal()">&times;</button>
        </div>
        <form action="{{ route('teacher.modules.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="type">Type <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-control" required onchange="toggleFileUrl(this.value)">
                        <option value="Module">Module</option>
                        <option value="Presentation">Presentation</option>
                        <option value="Video">Video</option>
                        <option value="Image">Image</option>
                        <option value="Website/Link">Website/Link</option>
                    </select>
                </div>

                <div class="form-group" id="fileInputGroup">
                    <label for="file">File</label>
                    <input type="file" name="file" id="file" class="form-control">
                </div>

                <div class="form-group hidden" id="urlInputGroup">
                    <label for="url">Website/Link URL</label>
                    <input type="url" name="url" id="url" class="form-control">
                </div>

                <div class="form-group">
                    <label for="quarter">Quarter <span class="text-danger">*</span></label>
                    <select name="quarter" id="quarter" class="form-control" required>
                        @foreach(['1st','2nd','3rd','4th'] as $q)
                            <option value="{{ $q }}">{{ $q }} Quarter</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="week">Week <span class="text-danger">*</span></label>
                    <select name="week" id="week" class="form-control" required>
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}">Week {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</button>
                <button type="button" class="btn btn-secondary" onclick="closeUploadModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleFileUrl(type){
    const fileGroup = document.getElementById('fileInputGroup');
    const urlGroup = document.getElementById('urlInputGroup');
    if(type === 'Website/Link'){
        fileGroup.classList.add('hidden');
        urlGroup.classList.remove('hidden');
    } else {
        fileGroup.classList.remove('hidden');
        urlGroup.classList.add('hidden');
    }
}

function openUploadModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
}
</script>
