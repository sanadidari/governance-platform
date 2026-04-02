<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Tribunal;

class RegionTribunalSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK checks to allow truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Tribunal::truncate();
        Region::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 12 Regions of Morocco in Arabic
        $regions = [
            'طنجة - تطوان - الحسيمة' => ['طنجة', 'تطوان', 'الحسيمة', 'العرائش', 'شفشاون', 'وزان'],
            'الشرق' => ['وجدة', 'الناظور', 'بركان', 'تاوريرت', 'جرادة', 'جرسيف', 'فجيج', 'الدريوش'],
            'فاس - مكناس' => ['فاس', 'مكناس', 'تازة', 'إفران', 'صفرو', 'بولمان', 'تاونات', 'الحاجب', 'مولاي يعقوب'],
            'الرباط - سلا - القنيطرة' => ['الرباط', 'سلا', 'القنيطرة', 'سيدي قاسم', 'تمارة', 'الخميسات', 'سيدي سليمان'],
            'بني ملال - خنيفرة' => ['بني ملال', 'خنيفرة', 'خريبكة', 'أزيلال', 'الفقيه بن صالح'],
            'الدار البيضاء - سطات' => ['الدار البيضاء', 'سطات', 'الجديدة', 'المحمدية', 'برشيد', 'بن سليمان', 'سيدي بنور', 'مديونة', 'النواصر'],
            'مراكش - آسفي' => ['مراكش', 'آسفي', 'الصويرة', 'شيشاوة', 'الحوز', 'قلعة السراغنة', 'الرحامنة', 'اليوسفية'],
            'درعة - تافيلالت' => ['الرشيدية', 'ورزازات', 'زاكورة', 'ميدلت', 'تنغير'],
            'سوس - ماسة' => ['أكادير', 'إنزكان', 'تارودانت', 'تيزنيت', 'شتوكة آيت باها', 'طاطا'],
            'كلميم - واد نون' => ['كلميم', 'طانطان', 'سيدي إفني', 'آسا الزاك'],
            'العيون - الساقية الحمراء' => ['العيون', 'بوجدور', 'طرفاية', 'السمارة'],
            'الداخلة - وادي الذهب' => ['الداخلة', 'أوسرد'],
        ];

        foreach ($regions as $regionName => $tribunals) {
            $region = Region::create(['name' => $regionName]);
            
            foreach ($tribunals as $tribunalName) {
                Tribunal::create([
                    'name' => "المحكمة الابتدائية - $tribunalName",
                    'region_id' => $region->id,
                    'type' => 'TPI',
                ]);
            }
        }
    }
}
