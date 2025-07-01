<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kẻ Huỷ Diệt Nỗi Buồn</title>
    <link rel="stylesheet" href="{{ asset('/css/meme_donate.css') }}">
</head>

<body>
    <h1>🖼️ Hiến Tặng Meme Template</h1>
    <p>"Nơi bạn giúp tôi giúp bạn có thêm meme."</p>
    <a href="/lmao">
        <button class="back-button">🔙 Quay lại</button>
    </a>
    <form id="meme-form" method="POST" action="/meme_donate" enctype="multipart/form-data">
        @csrf
        <label for="file">Ảnh Template</label>
        <div class="drop-zone" id="drop-zone">
            <p id="drop-text">Kéo & thả hoặc click để chọn ảnh (JPG, PNG, GIF, max 5MB)</p>
            <input type="file" name="file" id="file" accept="image/jpeg,image/png,image/gif" required>
            <div class="preview-container" id="preview" style="display: none;">
                <img id="preview-image" src="" alt="Image Preview">
            </div>
        </div>
        <div id="message"></div>
        <button type="submit" id="submit-btn">🚀 Upload</button>
    </form>

    <script src="{{ asset('/js/meme_donate.js') }}"></script>
</body>

</html>