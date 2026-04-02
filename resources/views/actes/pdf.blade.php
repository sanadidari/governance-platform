<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif; /* DejaVu Sans supports Arabic */
            direction: rtl;
            text-align: right;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>المملكة المغربية</h2>
        <h3>المنصة الوطنية للمفوضين القضائيين</h3>
    </div>

    <div class="title">
        شهادة تتبع إجراء
        <br>
        <small>Dossier N°: {{ $acte->reference }}</small>
    </div>

    <div class="content">
        <p><strong>المفوض القضائي:</strong> الأستاذ(ة) {{ $acte->huissier?->nom }} {{ $acte->huissier?->prenom }}</p>
        <p><strong>المحكمة المختصة:</strong> {{ $acte->huissier?->tribunal?->name }}</p>
        
        <table>
            <tr>
                <th>المرجع</th>
                <td>{{ $acte->reference }}</td>
            </tr>
            <tr>
                <th>نوع الإجراء</th>
                <td>{{ match($acte->type) {
                    'notification' => 'تبليغ',
                    'execution' => 'تنفيذ',
                    'constat' => 'معاينة',
                    default => $acte->type
                } }}</td>
            </tr>
            <tr>
                <th>الحالة الحالية</th>
                <td>{{ match($acte->status) {
                    'pending' => 'في الانتظار',
                    'in_progress' => 'في طور الإنجاز',
                    'completed' => 'منجز',
                    'archived' => 'مؤرشف',
                    default => $acte->status
                } }}</td>
            </tr>
            <tr>
                <th>تاريخ الإيداع</th>
                <td>{{ $acte->date_depot->format('d/m/Y') }}</td>
            </tr>
            @if($acte->date_execution)
            <tr>
                <th>تاريخ الإنجاز</th>
                <td>{{ $acte->date_execution->format('d/m/Y') }}</td>
            </tr>
            @endif
        </table>

        <div style="margin-top: 20px;">
            <strong>موضوع الإجراء:</strong>
            <p style="border: 1px solid #eee; padding: 10px; background: #fafafa;">
                {{ $acte->objet }}
            </p>
        </div>

        @if($acte->notes)
        <div style="margin-top: 10px;">
            <strong>ملاحظات:</strong>
            <p>{{ $acte->notes }}</p>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>تم استخراج هذه الوثيقة إلكترونياً من المنصة الوطنية.</p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
