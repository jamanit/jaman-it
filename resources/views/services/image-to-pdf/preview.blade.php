<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Images PDF</title>

    @php
        $vAlign = $vAlign ?? 'center'; // top, center, bottom
        $hAlign = $hAlign ?? 'center'; // left, center, right
    @endphp

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
            position: relative;
            width: 100%;
            height: 100%;
        }

        .image-page:last-child {
            page-break-after: avoid;
        }

        /* Base image styling */
        .image-page img {
            position: absolute;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Vertical alignment */
        .v-top img {
            top: 0;
        }

        .v-center img {
            top: 50%;
            transform: translateY(-50%);
        }

        .v-bottom img {
            bottom: 0;
        }

        /* Horizontal alignment */
        .h-left img {
            left: 0;
        }

        .h-center img {
            left: 50%;
            transform: translateX(-50%);
        }

        .h-right img {
            right: 0;
        }

        /* Combine transforms if both center */
        .v-center.h-center img {
            transform: translate(-50%, -50%);
        }

        .v-center.h-left img {
            transform: translateY(-50%);
        }

        .v-center.h-right img {
            transform: translateY(-50%);
        }

        .v-top.h-center img {
            transform: translateX(-50%);
        }

        .v-bottom.h-center img {
            transform: translateX(-50%);
        }
    </style>
</head>

<body>
    @foreach ($images as $img)
        <div class="image-page v-{{ $vAlign }} h-{{ $hAlign }}">
            <img src="{{ $img }}" alt="Image">
        </div>
    @endforeach
</body>

</html>
