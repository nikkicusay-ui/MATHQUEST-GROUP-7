<div id="editModal" class="modal hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Edit Learning Material</h3>
            <button class="close-btn" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_title">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="edit_title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea name="description" id="edit_description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="edit_type">Type <span class="text-danger">*</span></label>
                    <select name="type" id="edit_type" class="form-control" required onchange="toggleEditFileUrl(this.value)">
                        <option value="Module">Module</option>
                        <option value="Presentation">Presentation</option>
                        <option value="Video">Video</option>
                        <option value="Image">Image</option>
                        <option value="Website/Link">Website/Link</option>
                    </select>
                </div>

                <div class="form-group" id="editFileInputGroup">
                    <label for="edit_file">File</label>
                    <input type="file" name="file" id="edit_file" class="form-control">
                </div>

                <div class="form-group hidden" id="editUrlInputGroup">
                    <label for="edit_url">Website/Link URL</label>
                    <input type="url" name="url" id="edit_url" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edit_quarter">Quarter <span class="text-danger">*</span></label>
                    <select name="quarter" id="edit_quarter" class="form-control" required>
                        @foreach(['1st','2nd','3rd','4th'] as $q)
                            <option value="{{ $q }}">{{ $q }} Quarter</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_week">Week <span class="text-danger">*</span></label>
                    <select name="week" id="edit_week" class="form-control" required>
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}">Week {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleEditFileUrl(type){
    const fileGroup = document.getElementById('editFileInputGroup');
    const urlGroup = document.getElementById('editUrlInputGroup');
    if(type === 'Website/Link'){
        fileGroup.classList.add('hidden');
        urlGroup.classList.remove('hidden');
    } else {
        fileGroup.classList.remove('hidden');
        urlGroup.classList.add('hidden');
    }
}

function openEditModal(id){
    // Fetch material data from JS (or you can pass via data attributes)
    const material = @json($materials->keyBy('id'));
    const mat = material[id];

    document.getElementById('edit_title').value = mat.title;
    document.getElementById('edit_description').value = mat.description || '';
    document.getElementById('edit_type').value = mat.type;
    toggleEditFileUrl(mat.type);
    document.getElementById('edit_quarter').value = mat.quarter;
    document.getElementById('edit_week').value = mat.week;

    document.getElementById('editForm').action = '/teacher/modules/' + id;

    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
