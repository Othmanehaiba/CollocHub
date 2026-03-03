<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à rejoindre {{ $colocation->name }}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; background-color: #f3f4f6; color: #1f2937; line-height: 1.6; margin: 0; padding: 0; -webkit-font-smoothing: antialiased;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0; padding: 0; width: 100%; background-color: #f3f4f6;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0; padding: 0; width: 100%; max-width: 600px;">
                    <!-- Header with Logo -->
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <a href="{{ config('app.url') }}" style="display: inline-block;">
                                <!-- Simple CSS-based Logo representation for emails to avoid external image deps if possible, or link to app's logo -->
                                <div style="font-size: 24px; font-weight: 800; color: #4f46e5; text-decoration: none; letter-spacing: -0.5px;">
                                    <span style="color: #4f46e5;">Colloc</span><span style="color: #111827;">Hub</span>
                                </div>
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Main Content Body -->
                    <tr>
                        <td style="background-color: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
                            
                            <!-- Banner -->
                            <div style="background-color: #4f46e5; height: 6px; border-top-left-radius: 8px; border-top-right-radius: 8px;"></div>
                            
                            <div style="padding: 40px;">
                                <h1 style="margin-top: 0; color: #111827; font-size: 20px; font-weight: 700; text-align: left;">
                                    Bonjour,
                                </h1>
                                
                                <p style="margin-top: 16px; margin-bottom: 24px; font-size: 16px; color: #4b5563;">
                                    Vous avez été invité(e) à rejoindre la colocation <strong>{{ $colocation->name }}</strong> sur CollocHub. 
                                </p>
                                
                                <p style="margin-top: 0; margin-bottom: 32px; font-size: 16px; color: #4b5563;">
                                    Rejoignez vos colocataires pour gérer facilement vos dépenses partagées, voir qui doit quoi à qui, et simplifier la vie en communauté.
                                </p>
                                
                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 32px;">
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('invitations.open', $token) }}" style="box-sizing: border-box; display: inline-block; padding: 12px 28px; background-color: #4f46e5; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px; text-align: center; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                                                            Ouvrir l'invitation
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                                <div style="border-top: 1px solid #e5e7eb; padding-top: 24px; margin-top: 32px;">
                                    <p style="margin: 0; font-size: 14px; color: #6b7280; text-align: center;">
                                        Ce lien d'invitation expirera dans <span style="font-weight: 600;">7 jours</span>.
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding-top: 32px;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af; text-align: center;">
                                &copy; {{ date('Y') }} CollocHub. Tous droits réservés.
                            </p>
                            <p style="margin-top: 8px; font-size: 12px; color: #9ca3af; text-align: center;">
                                Si vous n'attendiez pas cette invitation, vous pouvez ignorer cet e-mail.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>