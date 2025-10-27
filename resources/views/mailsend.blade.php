<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555555;
            margin-bottom: 15px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888888;
        }
        .footer a {
            color: #555555;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Cảm ơn Quý khách đã đặt hàng tại QuangQuocBook</h1>
        <p>Kính gửi {{$nameifor}},</p>
        <p>Cảm ơn Quý khách đã tin tưởng và đặt hàng tại <strong>QuangQuocBook</strong>. Chúng tôi đã nhận được đơn hàng của Quý khách và đang tiến hành xử lý.</p>
        <p>Thông tin đơn hàng sẽ được xác nhận và gửi tới Quý khách trong thời gian sớm nhất. Trong quá trình xử lý nếu cần thêm thông tin, chúng tôi sẽ chủ động liên hệ.</p>
        <p>Rất mong Quý khách hài lòng với sản phẩm/dịch vụ của chúng tôi. Việc lựa chọn của Quý khách là niềm vinh hạnh và động lực để chúng tôi nỗ lực phục vụ tốt hơn mỗi ngày.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/order/confirm/' . $token) }}" style="display: inline-block; padding: 15px 40px; background-color: #27ae60; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;">
                XÁC NHẬN ĐƠN HÀNG
            </a>
        </div>
        
        <p>Trân trọng,<br>
        <strong>QuangQuocBook</strong><br>
        1900 6278 / <a href="mailto:quangquocbook@gmail.com">quangquocbook@gmail.com</a></p>
        <div class="footer">
            &copy; {{ date('Y') }} QuangQuocBook. All rights reserved.
        </div>
    </div>
</body>
</html>
