// ── Character counter ──
function onContentInput(textarea) {
    const len     = textarea.value.length;
    const counter = document.getElementById('charCount');
    counter.textContent = `${len} / 280`;
    counter.classList.remove('warn', 'limit');
    if (len >= 280)      counter.classList.add('limit');
    else if (len >= 220) counter.classList.add('warn');
    validateForm();
}

// ── Enable Post button only when content is filled ──
function validateForm() {
    const content = document.getElementById('postContent').value.trim();
    document.getElementById('submitBtn').disabled = content.length === 0;
}

// ── Image upload via file input ──
function onFileChange(event) {
    const file = event.target.files[0];
    if (file) loadImageFile(file);
}

// ── Drag & drop ──
function onDragOver(event) {
    event.preventDefault();
    document.getElementById('uploadZone').classList.add('dragover');
}
function onDragLeave(event) {
    document.getElementById('uploadZone').classList.remove('dragover');
}
function onDrop(event) {
    event.preventDefault();
    document.getElementById('uploadZone').classList.remove('dragover');
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) loadImageFile(file);
}

// ── Show image preview ──
function loadImageFile(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewWrap').classList.remove('hidden');
        document.getElementById('uploadZone').classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

// ── Remove chosen image ──
function removeImage() {
    document.getElementById('previewImg').src = '';
    document.getElementById('previewWrap').classList.add('hidden');
    document.getElementById('uploadZone').classList.remove('hidden');
    document.getElementById('fileInput').value = '';
}

// ── Tags ──
const tags = [];

function onTagKey(event) {
    if (event.key === 'Enter') { event.preventDefault(); addTag(); }
}
function addTag() {
    const input = document.getElementById('tagInput');
    const raw   = input.value.trim().replace(/\s+/g, '').toLowerCase();
    if (!raw || tags.includes(raw) || tags.length >= 5) return;
    tags.push(raw);
    renderTags();
    input.value = '';
}
function removeTag(tag) {
    const idx = tags.indexOf(tag);
    if (idx > -1) tags.splice(idx, 1);
    renderTags();
}
function renderTags() {
    const list = document.getElementById('tagList');
    list.innerHTML = tags.map(t => `
        <span class="tag-chip">
            #${t}
            <button onclick="removeTag('${t}')" title="Remove">×</button>
        </span>
    `).join('');
}

// ── Text formatting ──
function insertFormat(before, after) {
    const ta    = document.getElementById('postContent');
    const start = ta.selectionStart;
    const end   = ta.selectionEnd;
    const sel   = ta.value.substring(start, end);
    ta.value    = ta.value.substring(0, start) + before + sel + after + ta.value.substring(end);
    ta.selectionStart = start + before.length;
    ta.selectionEnd   = start + before.length + sel.length;
    ta.focus();
    onContentInput(ta);
}

// ── Emoji picker ──
function toggleEmojiPicker() {
    document.getElementById('emojiPicker').classList.toggle('hidden');
}
function insertEmoji(emoji) {
    const ta  = document.getElementById('postContent');
    const pos = ta.selectionStart;
    ta.value  = ta.value.substring(0, pos) + emoji + ta.value.substring(pos);
    ta.selectionStart = ta.selectionEnd = pos + emoji.length;
    ta.focus();
    document.getElementById('emojiPicker').classList.add('hidden');
    onContentInput(ta);
}
document.addEventListener('click', (e) => {
    const picker   = document.getElementById('emojiPicker');
    const emojiBtn = document.querySelector('[title="Emoji"]');
    if (!picker.contains(e.target) && e.target !== emojiBtn) {
        picker.classList.add('hidden');
    }
});

// ── Submit post → POST /posts → saves to DB + uploads image ──
async function submitPost() {
    const content = document.getElementById('postContent').value.trim();
    if (!content) return;

    const btn = document.getElementById('submitBtn');
    btn.disabled    = true;
    btn.textContent = 'Posting...';

    // Build FormData so the image file is included
    const formData = new FormData();
    formData.append('user_id', 1); // TODO: replace with real session user_id
    formData.append('content', content);

    const fileInput = document.getElementById('fileInput');
    if (fileInput.files[0]) {
        formData.append('image', fileInput.files[0]);
    }

    try {
        const res  = await fetch('/posts', {
            method: 'POST',
            body:   formData   // Do NOT set Content-Type header — browser sets it with boundary
        });
        const json = await res.json();

        if (json.success) {
            showToast('✓ Post berhasil dibuat!');
            // Redirect to profile after short delay
            setTimeout(() => { window.location.href = '/profile'; }, 1000);
        } else {
            alert(json.error || 'Failed to post. Please try again.');
            btn.disabled    = false;
            btn.textContent = 'Post';
        }
    } catch {
        alert('Network error. Please try again.');
        btn.disabled    = false;
        btn.textContent = 'Post';
    }
}

// ── Toast ──
function showToast(msg) {
    const toast = document.getElementById('toast');
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}

// ── Back button ──
function goBack() {
    if (document.getElementById('postContent').value.trim().length > 0) {
        if (!confirm('Discard this post?')) return;
    }
    window.history.back();
}