<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedicalChildrenCategory;

class MedicalChildrenCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['parent_id' => 1, 'title' => '虫歯', 'display_order' => 1],
            ['parent_id' => 4, 'title' => 'ホワイトニング', 'display_order' => 2],
            ['parent_id' => 1, 'title' => 'インプラント', 'display_order' => 3],
            ['parent_id' => 1, 'title' => '歯周病', 'display_order' => 4],
            ['parent_id' => 1, 'title' => '親知らず', 'display_order' => 5],
            ['parent_id' => 1, 'title' => '小児歯科', 'display_order' => 6],
            ['parent_id' => 1, 'title' => 'ブリッジ', 'display_order' => 7],
            ['parent_id' => 1, 'title' => '差し歯', 'display_order' => 8],
            ['parent_id' => 1, 'title' => '顎関節症', 'display_order' => 9],
            ['parent_id' => 1, 'title' => '知覚過敏', 'display_order' => 10],
            ['parent_id' => 1, 'title' => '口臭', 'display_order' => 11],
            ['parent_id' => 1, 'title' => '詰め物・かぶせ物', 'display_order' => 12],
            ['parent_id' => 1, 'title' => 'ドライマウス(口腔乾燥症)', 'display_order' => 13],
            ['parent_id' => 1, 'title' => '障がい者治療', 'display_order' => 14],
            ['parent_id' => 1, 'title' => '根管治療', 'display_order' => 15],
            ['parent_id' => 1, 'title' => 'レーザー治療', 'display_order' => 16],
            ['parent_id' => 1, 'title' => '訪問歯科治療', 'display_order' => 17],
            ['parent_id' => 2, 'title' => '矯正歯科', 'display_order' => 18],
            ['parent_id' => 2, 'title' => '小児矯正', 'display_order' => 19],
            ['parent_id' => 2, 'title' => '噛み合わせ', 'display_order' => 20],
            ['parent_id' => 3, 'title' => '予防歯科', 'display_order' => 21],
            ['parent_id' => 3, 'title' => '検診歯科', 'display_order' => 22],
            ['parent_id' => 4, 'title' => '審美歯科', 'display_order' => 23],
            ['parent_id' => 4, 'title' => '歯科口腔外科', 'display_order' => 24],
            ['parent_id' => 4, 'title' => 'マタニティ歯科', 'display_order' => 25],
            ['parent_id' => 4, 'title' => 'クリーニング', 'display_order' => 26],
            ['parent_id' => 4, 'title' => '歯石取り', 'display_order' => 27],
            ['parent_id' => 4, 'title' => '美容治療', 'display_order' => 28],
        ];
        foreach ($data as $d) {
            MedicalChildrenCategory::create([
                'parent_id' => $d['parent_id'],
                'title' => $d['title'],
                'display_order' => $d['display_order']
            ]);
        }
    }
}
