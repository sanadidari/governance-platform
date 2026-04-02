<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        @page { margin: 0px; }
        body { 
            font-family: 'Cairo', sans-serif; 
            direction: rtl; 
            text-align: right; 
            padding: 40px; 
            margin: 0;
            color: #1f2937; 
            background-color: #ffffff; 
            line-height: 1.6;
        }
        .header { 
            text-align: center; 
            margin: -40px -40px 40px -40px; 
            padding: 60px 40px 40px 40px; 
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); 
            color: white; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header h1 { margin: 0; font-size: 32px; font-weight: bold; }
        .header h2 { margin: 15px 0 0; font-size: 20px; font-weight: normal; opacity: 0.9; }
        .section { 
            margin-bottom: 30px; 
            background: #f8fafc;
            padding: 25px;
            border-radius: 8px;
            border-right: 6px solid #1e3a8a;
        }
        .section h3 { 
            color: #1e3a8a; 
            margin-top: 0; 
            font-size: 18px; 
            border-bottom: 2px solid #e5e7eb; 
            padding-bottom: 12px; 
            margin-bottom: 15px;
        }
        ul { list-style-type: none; padding: 0; margin: 0; }
        li { 
            margin-bottom: 12px; 
            padding-right: 25px; 
            position: relative; 
            font-size: 14px;
        }
        li:before { 
            content: "✦"; 
            color: #3b82f6; 
            font-weight: bold; 
            position: absolute; 
            right: 0; 
            top: 2px;
        }
        .highlight {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 15px;
            border-radius: 6px;
            font-size: 13px;
            margin-top: 20px;
            border: 1px solid #bfdbfe;
        }
        .footer { 
            text-align: center; 
            margin-top: 60px; 
            padding-top: 20px; 
            border-top: 1px solid #e5e7eb; 
            font-size: 10px; 
            color: #6b7280; 
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
        th, td { border: 1px solid #e5e7eb; padding: 10px; text-align: right; font-size: 12px; }
        th { background-color: #f1f5f9; color: #374151; }
    </style>
</head>
<body>
    <div class="header">
        <h1>المنصة الوطنية للمفوضين القضائيين</h1>
        <h2>دليل الاستخدام: المسؤول الوطني (Super Admin)</h2>
    </div>

    <div class="section">
        <h3>1. مقدمة ونظرة عامة</h3>
        <p>مرحباً بكم في المنصة الوطنية، النظام الرقمي الموحد لرقمنة مهنة المفوضين القضائيين بالمملكة. بصفتكم "المسؤول الوطني"، فإنكم تمتلكون أعلى مستوى من الصلاحيات للإشراف على البنية التحتية الرقمية للنظام بأكمله.</p>
    </div>

    <div class="section">
        <h3>2. إدارة الخريطة القضائية</h3>
        <p>تعتبر الخريطة القضائية العمود الفقري للنظام. مسؤوليكم تشمل:</p>
        <ul>
            <li><strong>الجهات القضائية (Regions):</strong> إضافة وتعديل الدوائر الاستئنافية في المملكة.</li>
            <li><strong>المحاكم (Tribunaux):</strong> ربط كل محكمة ابتدائية بالدائرة الاستئنافية التابعة لها.</li>
            <li><strong>التوزيع الجغرافي:</strong> ضمان تغطية كافة التراب الوطني لخدمات المفوضين.</li>
        </ul>
    </div>

    <div class="section">
        <h3>3. السجل الوطني للمفوضين</h3>
        <p>أنتم المسؤولون عن قاعدة البيانات المركزية لجميع المفوضين القضائيين:</p>
        <table>
            <thead>
                <tr>
                    <th>العملية</th>
                    <th>الوصف</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>الاعتماد</td>
                    <td>تفعيل حسابات المفوضين الجدد بعد التأكد من وضعيتهم القانونية.</td>
                </tr>
                <tr>
                    <td>التوقيف</td>
                    <td>تعليق حساب مفوض مؤقتاً أو نهائياً في حالات التأديب أو التقاعد.</td>
                </tr>
                <tr>
                    <td>نقل</td>
                    <td>تحيين دائرة اختصاص المفوض في حال انتقاله لمحكمة أخرى.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>4. إدارة الصلاحيات والأمان</h3>
        <ul>
            <li>إنشاء حسابات "المسؤولين الجهويين" وتفويضهم لإدارة دوائرهم.</li>
            <li>مراقبة سجلات الدخول (Logs) للكشف عن أي نشاط مشبوه.</li>
            <li>إعادة تعيين كلمات المرور في الحالات الطارئة.</li>
        </ul>
    </div>

    <div class="highlight">
        <strong>تنبيه هام:</strong> بصفتكم المسؤول الوطني، لديكم حق الوصول الشامل. يرجى توخي الحذر الشديد عند تعديل البيانات الهيكلية (مثل حذف محكمة)، حيث أن ذلك قد يؤثر على آلاف الملفات المرتبطة بها.
    </div>

    <div class="footer">
        وثيقة رسمية - الغرفة الوطنية للمفوضين القضائيين - جميع الحقوق محفوظة © 2026<br>
        تم إنشاء هذا الدليل آلياً من المنصة
    </div>
</body>
</html>
