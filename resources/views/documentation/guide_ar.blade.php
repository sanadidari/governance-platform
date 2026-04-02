<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 0px; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 40px;
            direction: rtl;
            text-align: right;
            color: #333;
            line-height: 1.6;
        }
        .cover {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 20px;
            margin: -40px -40px 40px -40px;
        }
        .cover h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .cover h2 {
            font-size: 24px;
            font-weight: normal;
            opacity: 0.9;
        }
        .section-title {
            background-color: #1e3a8a;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .role-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #f9fafb;
        }
        .role-title {
            color: #1e3a8a;
            font-size: 22px;
            font-weight: bold;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .feature-list {
            list-style-type: none;
            padding: 0;
        }
        .feature-item {
            margin-bottom: 10px;
            padding-right: 20px;
            position: relative;
        }
        .feature-item:before {
            content: "✔";
            color: #10b981;
            position: absolute;
            right: 0;
            font-weight: bold;
        }
        .toc {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 40px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- COVER PAGE -->
    <div class="cover">
        <h1>المنصة الوطنية للمفوضين القضائيين</h1>
        <h2>دليل الاستخدام الشامل</h2>
        <p>الإصدار 1.0 - فبراير 2026</p>
    </div>

    <!-- TABLE OF CONTENTS -->
    <div class="toc">
        <h3 style="margin-top:0; color:#b45309;">فهرس المحتويات</h3>
        <ol>
            <li>التعريف بالمنصة</li>
            <li>دليل المسؤول الوطني (Super Admin)</li>
            <li>دليل المسؤول الجهوي (Regional Admin)</li>
            <li>دليل المفوض القضائي (Huissier)</li>
            <li>تطبيق الهاتف المحمول</li>
        </ol>
    </div>

    <!-- INTRO -->
    <div class="role-card">
        <div class="role-title">1. التعريف بالمنصة (نبذة عامة)</div>
        <p>
            هذه المنصة هي النظام الرقمي الموحد لتدبير مهنة المفوضين القضائيين بالمملكة.
            وتهدف إلى رقمنة الإجراءات (تبليغ، تنفيذ، معاينة)، ضبط الخريطة القضائية، وتوفير إحصائيات دقيقة لصناع القرار.
        </p>
    </div>

    <div class="page-break"></div>

    <!-- ADMIN -->
    <div class="section-title">المستوى الأول: الإدارة المركزية</div>
    <div class="role-card">
        <div class="role-title">2. دليل المسؤول الوطني (Super Admin)</div>
        <p>بصفتك المسؤول الوطني، أنت تمتلك الصلاحيات الكاملة لإدارة النظام.</p>
        
        <h3>المهام الرئيسية:</h3>
        <ul class="feature-list">
            <li class="feature-item">
                <strong>إدارة الخريطة القضائية:</strong> إضافة وتعديل الجهات والمحاكم (ابتدائية، استئناف).
            </li>
            <li class="feature-item">
                <strong>السجل الوطني للمفوضين:</strong> الإشراف sur l'ensemble des huissiers (Actif, Suspendu).
            </li>
            <li class="feature-item">
                <strong>لوحة القيادة الاستراتيجية:</strong> تتبع النشاط الوطني (عدد الملفات، التوزيع الجغرافي).
            </li>
            <li class="feature-item">
                <strong>إدارة المستخدمين:</strong> منح صلاحيات المسؤولين الجهويين.
            </li>
        </ul>
        <p style="background:#fee2e2; padding:10px; border-radius:5px; color:#991b1b;">
            ⚠️ تنبيه: حسابك يمتلك صلاحية الحذف النهائي للبيانات. يرجى توخي الحذر.
        </p>
    </div>

    <!-- REGIONAL -->
    <div class="section-title">المستوى الثاني: الإدارة الجهوية</div>
    <div class="role-card">
        <div class="role-title">3. دليل المسؤول الجهوي (Regional Admin)</div>
        <p>أنت المسؤول عن تتبع النشاط القضائي داخل الدائرة الاستئنافية الخاصة بجهتك.</p>

        <h3>المهام الرئيسية:</h3>
        <ul class="feature-list">
            <li class="feature-item">
                <strong>التتبع المحلي:</strong> مراقبة عمل المفوضين التابعين لمحاكم جهتكم فقط.
            </li>
            <li class="feature-item">
                <strong>الاحصائيات الجهوية:</strong> التوصل بتقارير دقيقة حول نسب التنفيذ في جهتكم.
            </li>
            <li class="feature-item">
                <strong>مراقبة الالتزام:</strong> التأكد من تحيين الملفات من طرف المفوضين.
            </li>
        </ul>
    </div>

    <div class="page-break"></div>

    <!-- HUISSIER -->
    <div class="section-title">المستوى الثالث: المهنيون</div>
    <div class="role-card">
        <div class="role-title">4. دليل المفوض القضائي</div>
        <p>هذا الفضاء هو مكتبك الرقمي لتنظيم وتتبع الملفات اليومية.</p>

        <h3>الوظائف المتاحة:</h3>
        <ul class="feature-list">
            <li class="feature-item">
                <strong>فتح الملفات (Actes):</strong> تسجيل ملفات التبليغ، التنفيذ، والمعاينة برقم مرجعي فريد.
            </li>
            <li class="feature-item">
                <strong>تحيين الوضعية:</strong> تغيير حالة الملف من "في الانتظار" إلى "منجز" أو "في طور الإنجاز".
            </li>
            <li class="feature-item">
                <strong>استخراج الوثائق:</strong> طباعة "شهادة تتبع الإجراء" (PDF) بنقرة زر واحدة.
            </li>
            <li class="feature-item">
                <strong>البحث والأرشيف:</strong> العثور على أي ملف قديم بسهولة تامة.
            </li>
        </ul>
    </div>

    <!-- MOBILE APP -->
    <div class="role-card">
        <div class="role-title">5. تطبيق الهاتف المحمول</div>
        <p>
            يمكن للمفوضين ومساعديهم استخدام التطبيق الرسمي <strong>المنصة الوطنية</strong>:
        </p>
        <ul class="feature-list">
            <li class="feature-item"><strong>الدخول:</strong> بنفس البريد الإلكتروني وكلمة المرور للموقع.</li>
            <li class="feature-item"><strong>الجيولوكاليزاسيون:</strong> تحديد موقع إجراء المعاينة أو التبليغ تلقائياً.</li>
            <li class="feature-item"><strong>رفع الصور:</strong> إرفاق صور المحاضر مباشرة من الهاتف.</li>
        </ul>
    </div>

    <div class="footer">
        تم إنشاء هذا الدليل آلياً عبر نظام التوثيق الذكي - جميع الحقوق محفوظة للغرفة الوطنية للمفوضين القضائيين
    </div>
</body>
</html>
