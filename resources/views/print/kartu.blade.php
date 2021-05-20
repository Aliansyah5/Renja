<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <div style="position: relative;background-image: url('{{ $background }}');height: 10.75cm;width: 6.7cm;background-repeat: no-repeat;background-position: center;background-size: 100% 100%;margin-left: -0.2cm;">

        @if ($side == 'depan')

        @if($template->IsFoto)
        <div style="position: absolute;width: 100%;margin-left: 1.6cm;margin-right: auto;top: 3cm;">
            <div style="background-color: white;border-radius: 5%;height: 4.5cm;width: 3.5cm;">
                <!-- <div style="background-image: url('{{ $foto }}');background-repeat: no-repeat;background-position: center;background-size: cover;border-radius: 5%;height: 4.5cm;width: 3.5cm;"></div> -->
                <img src="{{ $foto }}" style="height: 4.5cm;width: 3.5cm;border-radius: 5%;" />
            </div>
        </div>
        @endif

        @if($template->IsNama)
        <div style="position: absolute;width: 100%;text-align: center;top: 7.3cm;">
            <p style="font-family: 'Arial';font-weight: bold;color: {{ $template->FontColor }};">{{ $nama }}</p>
        </div>
        @endif

        @if($template->IsNIK)
        <div style="position: absolute;width: 100%;text-align: center;top: 7.8cm;">
            <p style="font-family: 'Arial';font-size: 0.9rem;color: {{ $template->FontColor }};">NIK: {{ $nik }}</p>
        </div>
        @endif

        @if($template->IsRFID)
        <div style="position: absolute;width: 100%;text-align: center;top: 9.8cm;">
            <p style="font-family: monospace;font-size: 0.9rem;color: {{ $template->FontColor }};">No: {{ $rfid }}</p>
        </div>
        @endif

        @endif

    </div>
</body>
</html>