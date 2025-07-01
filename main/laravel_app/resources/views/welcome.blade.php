<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kẻ Huỷ Diệt Nỗi Buồn</title>
    <link rel="stylesheet" href="{{ asset('css/wellcum.css') }}">
</head>
<body>
    <h1>🧠 Meme Template Gallery</h1>
    <div class="quote">"Thứ ma tuý duy nhất tôi chơi là meme:))))"</div>
    <center>
        <a href="/meme_donate">Giúp tôi giúp bạn có thêm meme </a>
        <br><br><br>
    </center>
    <div class="masonry">
        @foreach ($memes as $meme)
            <div class="meme-card">
                <img src="{{ $meme->template_url }}" alt="{{ $meme->template_name }}">
                <div class="meme-content">
                    <div class="meme-title">{{ $meme->template_name }}</div>
                    <a class="meme-link" href="{{ $meme->template_url }}" target="_blank">🔗 Xem</a>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
