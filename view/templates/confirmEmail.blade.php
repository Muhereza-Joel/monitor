@include('partials/header')

<section class="section dashboard" style="background-color: #f9f9f9; padding: 20px;">
    <table style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <img src="https://opendata-analytics.org/cleaned-datasets/2021/01/Capture.png" style="max-width: 150px; height: auto;" alt="logo">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h1 style="font-size: 24px; margin-top: 20px; margin-bottom: 10px;">Open Data Analytics Monitor</h1>
            </td>
        </tr>
        
        <tr>
            <td style="text-align: center;">
                <div style="font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px;">
                    Your OTP: <span style="color: #d9534f;">{{$otp}}</span>
                </div>
                <div style="font-size: 18px; color: #333; margin-bottom: 20px;">
                    Please use this code to confirm your email address.
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <hr>
                <p style="font-size: 16px; color: #666; margin-bottom: 20px; text-align: center;">Thank you for choosing M & E Monitor. We are dedicated to delivering an exceptional user experience and supporting you in achieving your mission. If you have any questions or need assistance, please don't hesitate to contact our support team at moels.inc@gmail.com and alinaresearchinnovation@gmail.com </p>
                <p style="font-size: 16px; color: #444; margin-bottom: 20px; text-align: center;">&copy; <?php echo date('Y'); ?> M & E Monitor</p>
            </td>
        </tr>
    </table>
</section>

@include('partials/footer')
