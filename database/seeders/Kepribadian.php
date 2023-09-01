<?php

namespace Database\Seeders;

use App\Models\kepribadian as Modelskepribadian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class kepribadian extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //name
        //reason
        //solution
        //image

        Modelskepribadian::create([
            'name' => 'Plegmatis',
            'reason' => 'Cenderung tenang, stabil, dan santai., Menghindari konflik dan cenderung pasif., Kurang emosional dan menghindari risiko., Mudah beradaptasi dan tidak mudah marah.',
            'solution' => '1.   Dorong untuk lebih terbuka dan berkomunikasi, terutama dalam hal mengungkapkan perasaan dan kebutuhan mereka.
            2.	Bantu mereka untuk menetapkan tujuan dan ambisi yang lebih jelas sehingga mereka tidak menjadi terlalu pasif dalam menghadapi tantangan.
            3.	Ajarkan teknik manajemen stres agar mereka tidak menekan emosi dan kekhawatiran mereka.',
        ]);

        Modelskepribadian::create([
            'name' => 'Koleris',
            'reason' => 'Cenderung kuat, percaya diri, dan penuh energi., Cepat marah dan tegas dalam mengambil keputusan., Suka mengendalikan situasi dan orang lain., Cenderung menjadi pemimpin.',
            'solution' => '1.   Ajarkan keterampilan pengelolaan emosi dan teknik komunikasi yang lebih lembut agar mereka tidak terlalu mendominasi dalam hubungan sosial.
            2.  Dorong mereka untuk lebih sabar dan menghargai perspektif orang lain.
            3.  Bantu mereka mengenali pentingnya mendengarkan dan memberikan kesempatan bagi orang lain untuk berpartisipasi.',
        ]);

        Modelskepribadian::create([
            'name' => 'Melankolis',
            'reason' => 'Cenderung introvert, sensitif, dan perfeksionis., Mudah cemas dan khawatir., Cenderung menyimpan perasaan mereka sendiri., Suka merenung dan memiliki imajinasi yang kaya., Suka merenung dan memiliki imajinasi yang kaya.',
            'solution' => '1.   Bantu mereka mengatasi ketakutan dan kecemasan mereka dengan teknik relaksasi dan kognitif.
            2.	Dorong mereka untuk berbicara tentang perasaan mereka dan mencari dukungan dari orang lain.
            3.	Ajarkan mereka untuk tidak terlalu keras pada diri sendiri dan menerima kekurangan sebagai bagian dari manusiawi.',
        ]);

        Modelskepribadian::create([
            'name' => 'Saguinis',
            'reason' => 'Cenderung ekstrovert, ceria, dan penuh semangat., Mudah beradaptasi dan berkomunikasi dengan orang lain., Cepat bosan dan sulit berkonsentrasi pada satu hal., Suka menjadi pusat perhatian.',
            'solution' => '1.   Dorong mereka untuk menemukan keseimbangan dan fokus dalam hidup mereka.
            2.  Ajarkan mereka untuk bertanggung jawab terhadap tugas dan komitmen yang mereka miliki.
            3.	Bantu mereka mengatasi impulsivitas dan mencari cara untuk bertahan dalam situasi yang memerlukan ketekunan.',
        ]);
    }
}
