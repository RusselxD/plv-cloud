<!DOCTYPE html>
<html>

<head>
     <meta charset="utf-8">
     <title>Verify Your Email - PLV Cloud</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body
     style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px 0;">

     <div
          style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.08);">

          <!-- Header -->
          <div style="background: #4f46e5; padding: 30px; text-align: center;">               
               <h1 style="color: #ffffff; font-size: 30px; font-weight: 600; margin: 0 0 8px;">
                    Welcome to PLV Cloud!
               </h1>
          </div>

          <!-- Content -->
          <div style="padding: 30px;">

               <div style="text-align: center; margin-bottom: 30px;">
                    <div style="font-size: 30px; margin-bottom: 15px;">👋</div>
                    <p style="font-size: 18px; color: #374151; line-height: 1.5; margin: 0;">
                         Thank you for signing up! Please verify your email address to get started with
                         <strong style="color: #4f46e5;">PLV Cloud</strong>.
                    </p>
               </div>

               <!-- CTA Button -->
               <div style="text-align: center; margin: 35px 0;">
                    <a href="{{ $link }}"
                         style="display: inline-block; padding: 16px 32px; background: #4f46e5; color: #ffffff; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 8px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
                         Verify My Email
                    </a>
               </div>

               <!-- Features -->
               <div
                    style="background: #f8fafc; border-radius: 8px; padding: 25px; margin: 30px 0; border-left: 3px solid #4f46e5;">
                    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 0 0 15px;">
                         What you'll get access to:
                    </h3>
                    <ul style="margin: 0; padding-left: 20px; color: #6b7280; font-size: 14px; line-height: 1.6;">
                         <li style="margin-bottom: 8px;">📚 Shared study materials and notes</li>
                         <li style="margin-bottom: 8px;">📂 Organized academic resources</li>
                         <li style="margin-bottom: 0;">🎓 Exclusive content for PLV students only</li>
                    </ul>
               </div>

               <!-- Alternative link -->
               <div style="text-align: center; margin: 25px 0;">
                    <p style="font-size: 13px; color: #9ca3af; margin: 0 0 8px;">
                         Button not working? Copy and paste this link into your browser:
                    </p>
                    <p
                         style="font-size: 12px; color: #6b7280; word-break: break-all; background: #f3f4f6; padding: 8px; border-radius: 4px;">
                         {{ $link }}
                    </p>
               </div>

               <!-- Security note -->
               <div
                    style="background: #fef9e7; border: 1px solid #fbbf24; border-radius: 6px; padding: 15px; margin: 35px 0 10px 0;">
                    <p style="font-size: 13px; color: #92400e; margin: 0;">
                         If you didn't sign up for PLV Cloud, you can safely ignore this email.
                    </p>
               </div>
          </div>

          <!-- Footer -->
          <div style="background: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
               <p style="font-size: 13px; color: #374151; margin: 0;">
                    &copy; {{ date('Y') }} PLV Cloud. All rights reserved.
               </p>
          </div>
     </div>

     <!-- Mobile styles -->
     <style>
          @media screen and (max-width: 600px) {
               body {
                    padding: 10px !important;
               }

               div[style*="padding: 40px 30px"] {
                    padding: 30px 20px !important;
               }

               div[style*="padding: 20px 30px"] {
                    padding: 15px 20px !important;
               }
          }
     </style>
</body>

</html>