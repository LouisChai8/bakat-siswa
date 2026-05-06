// ── Character counter ──
function onContentInput(textarea) {
    const len = textarea.value.length;
    const counter = document.getElementById('charCount');
    counter.textContent = `${len} / 280`;
    counter.classList.remove('warn', 'limit');
    if (len >= 280)      counter.classList.add('limit');
    else if (len >= 220) counter.classList.add('warn');
    validateForm();
}

// ── Validate: enable submit only when content is not empty ──
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

// ── Load image into preview ──
function loadImageFile(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewWrap').classList.remove('hidden');
        document.getElementById('uploadZone').classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

// ── Remove image ──
function removeImage() {
    document.getElementById('previewImg').src = '';
    document.getElementById('previewWrap').classList.add('hidden');
    document.getElementById('uploadZone').classList.remove('hidden');
    document.getElementById('fileInput').value = '';
}

// ── Tags ──
const tags = [];

function onTagKey(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        addTag();
    }
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

// ── Text formatting (insert around selection) ──
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
    const picker = document.getElementById('emojiPicker');
    picker.classList.toggle('hidden');
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

// close emoji picker on outside click
document.addEventListener('click', (e) => {
    const picker  = document.getElementById('emojiPicker');
    const emojiBtn = document.querySelector('[title="Emoji"]');
    if (!picker.contains(e.target) && e.target !== emojiBtn) {
        picker.classList.add('hidden');
    }
});

// ── Submit post ──
function submitPost() {
    const content = document.getElementById('postContent').value.trim();
    if (!content) return;

    // Disable button & show loading state
    const btn = document.getElementById('submitBtn');
    btn.disabled    = true;
    btn.textContent = 'Posting...';

    // Simulate async submit (replace with real fetch/form submit)
    setTimeout(() => {
        showToast('✓ Post berhasil dibuat!');
        // Reset form
        document.getElementById('postContent').value = '';
        document.getElementById('charCount').textContent = '0 / 280';
        document.getElementById('charCount').classList.remove('warn', 'limit');
        removeImage();
        tags.length = 0;
        renderTags();
        btn.textContent = 'Post';
        // Redirect to home after short delay
        setTimeout(() => { window.location.href = '/home'; }, 1200);
    }, 800);
}

// ── Toast notification ──
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

// ── Wire up home page "Add Post" button ──
// If this script is also included in home.php, uncomment below:
// document.querySelx`ector('.btn-addpost')?.addEventListener('click', () => {
//     window.location.href = '/addpost';
// });