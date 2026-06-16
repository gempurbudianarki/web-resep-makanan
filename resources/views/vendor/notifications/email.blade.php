<!DOCTYPE html>
<html lang="id" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body style="margin:0;padding:0;background-color:#F8F4EE;font-family:'DM Sans',system-ui,-apple-system,sans-serif;">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color:#F8F4EE;padding:40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="480" style="max-width:480px;width:100%;background-color:#FFFFFF;border-radius:24px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06);">
                    
                    <tr>
                        <td style="background:linear-gradient(135deg,#61472E,#7A5A3A);padding:40px 32px;text-align:center;">
                            <h1 style="margin:0;color:#D9A441;font-family:'Playfair Display',Georgia,serif;font-size:28px;font-weight:700;">BagiResep</h1>
                            <p style="margin:6px 0 0;color:rgba(248,244,238,0.7);font-size:13px;font-weight:400;">Platform Berbagi Resep Indonesia</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">
                            
                            @if(!empty($greeting))
                            <p style="margin:0 0 20px;color:#2E2E2E;font-size:18px;font-weight:700;line-height:1.5;">{{ $greeting }}</p>
                            @endif

                            @foreach($introLines as $line)
                            <p style="margin:0 0 16px;color:#2E2E2E;font-size:15px;line-height:1.7;">{{ $line }}</p>
                            @endforeach

                            @if(isset($actionText) && isset($actionUrl))
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td align="center" style="padding:28px 0 20px;">
                                        <a href="{{ $actionUrl }}" target="_blank" style="display:inline-block;background-color:#D9A441;color:#2E2E2E;font-weight:700;font-size:15px;padding:14px 36px;border-radius:14px;text-decoration:none;text-align:center;line-height:1.5;">
                                            {{ $actionText }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="padding:0 0 8px;">
                                        <p style="margin:0;color:#757575;font-size:13px;line-height:1.6;word-break:break-all;">
                                            Jika tombol tidak berfungsi, salin dan tempel URL ini di browser:
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ $actionUrl }}" style="color:#7A5A3A;font-size:13px;word-break:break-all;text-decoration:underline;">{{ $actionUrl }}</a>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            @foreach($outroLines as $line)
                            <p style="margin:0 0 12px;color:#757575;font-size:13px;line-height:1.6;">{{ $line }}</p>
                            @endforeach

                        </td>
                    </tr>

                    <tr>
                        <td style="border-top:1px solid #E5E9DB;padding:24px 32px;text-align:center;">
                            <p style="margin:0 0 4px;color:#9E9E9E;font-size:12px;line-height:1.6;">
                                &copy; {{ date('Y') }} <strong style="color:#7A5A3A;">BagiResep</strong> - Seluruh hak cipta dilindungi.
                            </p>
                            <p style="margin:0;color:#9E9E9E;font-size:12px;line-height:1.6;">
                                Email ini dikirim otomatis. Mohon tidak membalas.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
