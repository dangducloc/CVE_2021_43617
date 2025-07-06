const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file');
const preview = document.getElementById('preview');
const previewImage = document.getElementById('preview-image');
const dropText = document.getElementById('drop-text');
const submitBtn = document.getElementById('submit-btn');
const message = document.getElementById('message');
const form = document.getElementById('meme-form');

// File validation
const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

function showMessage(text, type) {
    message.className = type;
    message.textContent = text;
    setTimeout(() => {
        message.textContent = '';
        message.className = '';
    }, 5000);
}

function updatePreview(file) {
    if (file && ALLOWED_TYPES.includes(file.type) && file.size <= MAX_FILE_SIZE) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            preview.style.display = 'block';
            dropText.textContent = `Đã chọn: ${file.name}`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        dropText.textContent = 'Kéo & thả hoặc click để chọn ảnh (JPG, PNG, GIF, max 5MB)';
    }
}

dropZone.addEventListener('click', () => fileInput.click());

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
        fileInput.files = e.dataTransfer.files;
        updatePreview(file);
    }
});

fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (file) {
        if (!ALLOWED_TYPES.includes(file.type)) {
            showMessage('Vui lòng chọn file JPG, PNG hoặc GIF!', 'error');
            fileInput.value = '';
            return;
        }
        if (file.size > MAX_FILE_SIZE) {
            showMessage('File quá lớn! Vui lòng chọn file dưới 5MB.', 'error');
            fileInput.value = '';
            return;
        }
        updatePreview(file);
    }
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!fileInput.files[0]) {
        showMessage('Vui lòng chọn một ảnh trước khi upload!', 'error');
        return;
    }

    submitBtn.disabled = true;
    submitBtn.classList.add('loading');
    submitBtn.textContent = 'Đang upload...';

    try {
        const formData = new FormData(form);
        const response = await fetch('/meme_donate', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            showMessage('Upload thành công! Cảm ơn bạn đã hiến tặng meme!', 'success');
            form.reset();
            preview.style.display = 'none';
            dropText.textContent = 'Kéo & thả hoặc click để chọn ảnh (JPG, PNG, GIF, max 5MB)';
        } else {
            showMessage('Upload thất bại! Vui lòng thử lại.', 'error');
            const errorText = await response;
            console.error('Error response:', errorText);

        }
    } catch (error) {
        showMessage('Đã có lỗi xảy ra! Vui lòng thử lại sau.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.classList.remove('loading');
        submitBtn.textContent = '🚀 Upload';
    }
});