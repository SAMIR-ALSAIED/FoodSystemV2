<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #f8f9fa; padding: 10px; text-align: center; border-bottom: 2px solid #007bff; }
        .details { margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>إشعار حجز طاولة جديد</h2>
        </div>
        
        <div class="details">
            <p><strong>اسم العميل:</strong> {{ $reservation->customer_name }}</p>
            <p><strong>رقم الهاتف:</strong> {{ $reservation->phone }}</p>
            <p><strong>التاريخ والوقت:</strong> {{ $reservation->datetime }}</p>
            <p><strong>عدد الأفراد:</strong> {{ $reservation->guest_count }}</p>
            <p><strong>حالة الحجز:</strong> {{ $reservation->status }}</p>
        </div>

        <div class="footer">
            <p>هذا البريد مرسل  من  الحجوزات. للموقع</p>
        </div>
    </div>
</body>
</html>