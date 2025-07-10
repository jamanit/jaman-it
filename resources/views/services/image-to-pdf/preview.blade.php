<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Images PDF</title>
    <style>
        @page {
            size: A4 {{ $orientation }};
            margin: {{ $useMargin ? '20mm' : '0' }};
        }

        body {
            margin: 0;
            padding: 0;
        }

        .image-page {
            page-break-after: always;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .image-page:last-child {
            page-break-after: avoid;
        }

        .portrait img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .landscape img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }
    </style>
</head>

<body>
    @foreach ($images as $img)
        <div class="image-page {{ $orientation }}">
            <img src="{{ $img }}" alt="Image">
        </div>
    @endforeach
</body>

</html>
