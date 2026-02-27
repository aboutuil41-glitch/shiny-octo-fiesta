<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;background:#0a0a0a;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#0a0a0a;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:520px;width:100%;">

                    {{-- ── Top accent bar ── --}}
                    <tr>
                        <td style="height:3px;background:#ff2d2d;border-radius:2px 2px 0 0;"></td>
                    </tr>

                    {{-- ── Card body ── --}}
                    <tr>
                        <td style="background:#111111;border:1px solid #1f1f1f;border-top:none;border-radius:0 0 12px 12px;padding:48px 44px 40px;">

                            {{-- ── Invitation tag ── --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                                <tr>
                                    <td align="center">
                                        <span style="display:inline-block;border:1px solid #ff2d2d;color:#ff2d2d;font-family:'Courier New',Courier,monospace;font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:4px 12px;border-radius:2px;">
                                            INVITATION
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            {{-- ── Big headline ── --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:6px;">
                                <tr>
                                    <td align="center">
                                        <p style="margin:0;font-family:'Arial Black','Helvetica Neue',Arial,sans-serif;font-size:48px;font-weight:900;letter-spacing:-1px;line-height:1;color:#ffffff;text-transform:uppercase;">
                                            YOU'RE IN,
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <p style="margin:0;font-family:'Arial Black','Helvetica Neue',Arial,sans-serif;font-size:48px;font-weight:900;letter-spacing:-1px;line-height:1;color:#ff2d2d;text-transform:uppercase;">
                                            {{ $name }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- ── Red divider ── --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                                <tr>
                                    <td align="center">
                                        <div style="width:40px;height:2px;background:#ff2d2d;margin:0 auto;"></div>
                                    </td>
                                </tr>
                            </table>

                            {{-- ── Body text ── --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                                <tr>
                                    <td align="center">
                                        <p style="margin:0;font-family:'Courier New',Courier,monospace;font-size:12px;font-weight:400;letter-spacing:.15em;line-height:1.8;color:#555555;text-transform:uppercase;max-width:340px;">
                                            Someone added you to their accommodation. Accept to start tracking shared expenses together.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- ── CTA button ── --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:36px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}"
                                           style="display:inline-block;font-family:'Courier New',Courier,monospace;font-size:11px;font-weight:700;letter-spacing:.25em;text-transform:uppercase;color:#f0f0f0;text-decoration:none;border:1px solid #333333;padding:13px 32px;border-radius:2px;background:#111111;">
                                            &#8592; VIEW INVITATION
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            {{-- ── Expiry notice ── --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                                <tr>
                                    <td align="center" style="background:#0e0e0e;border:1px solid #1a1a1a;border-radius:6px;padding:12px 20px;">
                                        <p style="margin:0;font-family:'Courier New',Courier,monospace;font-size:10px;font-weight:400;letter-spacing:.12em;color:#3a3a3a;text-transform:uppercase;">
                                            This invitation expires in&nbsp;<span style="color:#ff2d2d;font-weight:700;">7 DAYS</span>.&nbsp;After that, request a new one.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- ── Hairline divider ── --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px;">
                                <tr>
                                    <td style="border-top:1px solid #1a1a1a;height:1px;font-size:0;line-height:0;">&nbsp;</td>
                                </tr>
                            </table>

                            {{-- ── Footer note ── --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <p style="margin:0;font-family:'Courier New',Courier,monospace;font-size:9px;font-weight:400;letter-spacing:.1em;color:#2a2a2a;text-transform:uppercase;line-height:1.8;">
                                            If you weren't expecting this, ignore this email.<br>
                                            You won't be added to anything unless you click above.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>