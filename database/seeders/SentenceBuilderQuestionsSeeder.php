<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class SentenceBuilderQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Memasukkan 100 soal "Arabic Sentence Builder" dengan harokat lengkap...');
        
        $sentences = [
            // ==========================================
            // JUMLAH ISMIYAH (Nominal Sentence) - 45 Soal
            // ==========================================
            [
                'category' => 'ismiyyah',
                'correct' => 'الْبَيْتُ كَبِيرٌ',
                'scrambled' => ['كَبِيرٌ', 'الْبَيْتُ'],
                'translation' => 'Rumah itu besar.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْوَلَدُ ذَكِيٌّ',
                'scrambled' => ['ذَكِيٌّ', 'الْوَلَدُ'],
                'translation' => 'Anak laki-laki itu pandai.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'السَّمَاءُ صَافِيَةٌ',
                'scrambled' => ['صَافِيَةٌ', 'السَّمَاءُ'],
                'translation' => 'Langit itu cerah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْكِتَابُ مَفْتُوحٌ',
                'scrambled' => ['مَفْتُوحٌ', 'الْكِتَابُ'],
                'translation' => 'Buku itu terbuka.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمَاءُ بَارِدٌ',
                'scrambled' => ['بَارِدٌ', 'الْمَاءُ'],
                'translation' => 'Air itu dingin.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمُعَلِّمُ حَاضِرٌ',
                'scrambled' => ['حَاضِرٌ', 'الْمُعَلِّمُ'],
                'translation' => 'Guru itu hadir.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الطَّالِبَةُ مُجْتَهِدَةٌ',
                'scrambled' => ['مُجْتَهِدَةٌ', 'الطَّالِبَةُ'],
                'translation' => 'Siswi itu rajin.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الِامْتِحَانُ صَعْبٌ',
                'scrambled' => ['صَعْبٌ', 'الِامْتِحَانُ'],
                'translation' => 'Ujian itu sulit.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الدَّرْسُ سَهْلٌ',
                'scrambled' => ['سَهْلٌ', 'الدَّرْسُ'],
                'translation' => 'Pelajaran itu mudah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمَكْتَبَةُ وَاسِعَةٌ',
                'scrambled' => ['وَاسِعَةٌ', 'الْمَكْتَبَةُ'],
                'translation' => 'Perpustakaan itu luas.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الطَّعَامُ لَذِيذٌ',
                'scrambled' => ['لَذِيذٌ', 'الطَّعَامُ'],
                'translation' => 'Makanan itu lezat.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الصَّدِيقُ وَفِيٌّ',
                'scrambled' => ['وَفِيٌّ', 'الصَّدِيقُ'],
                'translation' => 'Teman itu setia.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْجَوُّ حَارٌّ',
                'scrambled' => ['حَارٌّ', 'الْجَوُّ'],
                'translation' => 'Cuaca itu panas.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الشَّارِعُ نَظِيفٌ',
                'scrambled' => ['نَظِيفٌ', 'الشَّارِعُ'],
                'translation' => 'Jalan itu bersih.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْحَدِيقَةُ جَمِيلَةٌ',
                'scrambled' => ['جَمِيلَةٌ', 'الْحَدِيقَةُ'],
                'translation' => 'Taman itu indah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْقَلَمُ جَدِيدٌ',
                'scrambled' => ['جَدِيدٌ', 'الْقَلَمُ'],
                'translation' => 'Pulpen itu baru.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْغُرْفَةُ نَظِيفَةٌ',
                'scrambled' => ['نَظِيفَةٌ', 'الْغُرْفَةُ'],
                'translation' => 'Kamar itu bersih.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمَسْجِدُ قَرِيبٌ',
                'scrambled' => ['قَرِيبٌ', 'الْمَسْجِدُ'],
                'translation' => 'Masjid itu dekat.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْوَقْتُ ثَمِينٌ',
                'scrambled' => ['ثَمِينٌ', 'الْوَقْتُ'],
                'translation' => 'Waktu itu berharga.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'اللُّغَةُ الْعَرَبِيَّةُ مُهِمَّةٌ',
                'scrambled' => ['مُهِمَّةٌ', 'الْعَرَبِيَّةُ', 'اللُّغَةُ'],
                'translation' => 'Bahasa Arab itu penting.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْوَالِدُ طَبِيبٌ',
                'scrambled' => ['طَبِيبٌ', 'الْوَالِدُ'],
                'translation' => 'Ayah itu seorang dokter.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْأُمُّ مُمَرِّضَةٌ',
                'scrambled' => ['مُمَرِّضَةٌ', 'الْأُمُّ'],
                'translation' => 'Ibu itu seorang perawat.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'السَّيَّارَةُ سَرِيعَةٌ',
                'scrambled' => ['سَرِيعَةٌ', 'السَّيَّارَةُ'],
                'translation' => 'Mobil itu cepat.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الشَّمْسُ مُشْرِقَةٌ',
                'scrambled' => ['مُشْرِقَةٌ', 'الشَّمْسُ'],
                'translation' => 'Matahari bersinar terang.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْقَمَرُ مُضِيءٌ',
                'scrambled' => ['مُضِيءٌ', 'الْقَمَرُ'],
                'translation' => 'Bulan itu bersinar.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الشَّجَرَةُ عَالِيَةٌ',
                'scrambled' => ['عَالِيَةٌ', 'الشَّجَرَةُ'],
                'translation' => 'Pohon itu tinggi.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الزَّهْرَةُ حَمْرَاءُ',
                'scrambled' => ['حَمْرَاءُ', 'الزَّهْرَةُ'],
                'translation' => 'Bunga itu merah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْبَحْرُ أَزْرَقُ',
                'scrambled' => ['أَزْرَقُ', 'الْبَحْرُ'],
                'translation' => 'Laut itu biru.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْجَبَلُ شَاهِقٌ',
                'scrambled' => ['شَاهِقٌ', 'الْجَبَلُ'],
                'translation' => 'Gunung itu menjulang tinggi.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'النَّهْرُ صَغِيرٌ',
                'scrambled' => ['صَغِيرٌ', 'النَّهْرُ'],
                'translation' => 'Sungai itu kecil.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمَدِينَةُ كَبِيرَةٌ',
                'scrambled' => ['كَبِيرَةٌ', 'الْمَدِينَةُ'],
                'translation' => 'Kota itu besar.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْقَرْيَةُ هَادِئَةٌ',
                'scrambled' => ['هَادِئَةٌ', 'الْقَرْيَةُ'],
                'translation' => 'Desa itu tenang.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'السُّوقُ مُزْدَحِمٌ',
                'scrambled' => ['مُزْدَحِمٌ', 'السُّوقُ'],
                'translation' => 'Pasar itu ramai.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْفَاكِهَةُ طَازِجَةٌ',
                'scrambled' => ['طَازِجَةٌ', 'الْفَاكِهَةُ'],
                'translation' => 'Buah itu segar.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْخُضَرَاوَاتُ خَضْرَاءُ',
                'scrambled' => ['خَضْرَاءُ', 'الْخُضَرَاوَاتُ'],
                'translation' => 'Sayuran itu hijau.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْحَلِيبُ بَارِدٌ',
                'scrambled' => ['بَارِدٌ', 'الْحَلِيبُ'],
                'translation' => 'Susu itu dingin.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْقَهْوَةُ سَاخِنَةٌ',
                'scrambled' => ['سَاخِنَةٌ', 'الْقَهْوَةُ'],
                'translation' => 'Kopi itu panas.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْخُبْزُ طَازِجٌ',
                'scrambled' => ['طَازِجٌ', 'الْخُبْزُ'],
                'translation' => 'Roti itu segar.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمَلَابِسُ نَظِيفَةٌ',
                'scrambled' => ['نَظِيفَةٌ', 'الْمَلَابِسُ'],
                'translation' => 'Pakaian itu bersih.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْأَرْضُ خَضْرَاءُ',
                'scrambled' => ['خَضْرَاءُ', 'الْأَرْضُ'],
                'translation' => 'Tanah itu hijau.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'النُّورُ سَاطِعٌ',
                'scrambled' => ['سَاطِعٌ', 'النُّورُ'],
                'translation' => 'Cahaya itu terang.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الصَّبَاحُ جَمِيلٌ',
                'scrambled' => ['جَمِيلٌ', 'الصَّبَاحُ'],
                'translation' => 'Pagi itu indah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمَسَاءُ هَادِئٌ',
                'scrambled' => ['هَادِئٌ', 'الْمَسَاءُ'],
                'translation' => 'Sore itu tenang.',
            ],
            // 15 soal tambahan baru
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمِفْتَاحُ صَغِيرٌ',
                'scrambled' => ['صَغِيرٌ', 'الْمِفْتَاحُ'],
                'translation' => 'Kunci itu kecil.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْبَابُ مُغْلَقٌ',
                'scrambled' => ['مُغْلَقٌ', 'الْبَابُ'],
                'translation' => 'Pintu itu tertutup.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'النَّافِذَةُ مَفْتُوحَةٌ',
                'scrambled' => ['مَفْتُوحَةٌ', 'النَّافِذَةُ'],
                'translation' => 'Jendela itu terbuka.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْكَلْبُ وَلِيٌّ',
                'scrambled' => ['وَلِيٌّ', 'الْكَلْبُ'],
                'translation' => 'Anjing itu setia.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْقِطُّ نَظِيفٌ',
                'scrambled' => ['نَظِيفٌ', 'الْقِطُّ'],
                'translation' => 'Kucing itu bersih.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الطَّالِبُ مُتَفَوِّقٌ',
                'scrambled' => ['مُتَفَوِّقٌ', 'الطَّالِبُ'],
                'translation' => 'Siswa itu berprestasi.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمَطَرُ غَزِيرٌ',
                'scrambled' => ['غَزِيرٌ', 'الْمَطَرُ'],
                'translation' => 'Hujan lebat.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الرِّيحُ قَوِيَّةٌ',
                'scrambled' => ['قَوِيَّةٌ', 'الرِّيحُ'],
                'translation' => 'Angin kencang.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الطَّرِيقُ طَوِيلٌ',
                'scrambled' => ['طَوِيلٌ', 'الطَّرِيقُ'],
                'translation' => 'Jalan itu panjang.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْحَقِيبَةُ ثَقِيلَةٌ',
                'scrambled' => ['ثَقِيلَةٌ', 'الْحَقِيبَةُ'],
                'translation' => 'Tas itu berat.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْهَدِيَّةُ جَمِيلَةٌ',
                'scrambled' => ['جَمِيلَةٌ', 'الْهَدِيَّةُ'],
                'translation' => 'Hadiah itu indah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْوَجْهُ مَبْسُوطٌ',
                'scrambled' => ['مَبْسُوطٌ', 'الْوَجْهُ'],
                'translation' => 'Wajah itu berseri.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْقَلْبُ سَلِيمٌ',
                'scrambled' => ['سَلِيمٌ', 'الْقَلْبُ'],
                'translation' => 'Hati itu sehat/bersih.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْعَمَلُ شَرِيفٌ',
                'scrambled' => ['شَرِيفٌ', 'الْعَمَلُ'],
                'translation' => 'Pekerjaan itu mulia.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الْمَسْرُورُ سَعِيدٌ',
                'scrambled' => ['سَعِيدٌ', 'الْمَسْرُورُ'],
                'translation' => 'Orang yang gembira itu bahagia.',
            ],

            // ==========================================
            // JUMLAH FILIYYAH (Verbal Sentence) - 55 Soal
            // ==========================================
            [
                'category' => 'filiyyah',
                'correct' => 'ذَهَبَ الْوَلَدُ إِلَى الْمَدْرَسَةِ',
                'scrambled' => ['الْمَدْرَسَةِ', 'إِلَى', 'الْوَلَدُ', 'ذَهَبَ'],
                'translation' => 'Anak laki-laki pergi ke sekolah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'قَرَأَ الطَّالِبُ الْكِتَابَ',
                'scrambled' => ['الْكِتَابَ', 'الطَّالِبُ', 'قَرَأَ'],
                'translation' => 'Siswa itu membaca buku.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'شَرِبَ الرَّجُلُ الْمَاءَ',
                'scrambled' => ['الْمَاءَ', 'الرَّجُلُ', 'شَرِبَ'],
                'translation' => 'Pria itu meminum air.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَكَلَتِ الْبِنْتُ التُّفَّاحَةَ',
                'scrambled' => ['التُّفَّاحَةَ', 'الْبِنْتُ', 'أَكَلَتِ'],
                'translation' => 'Anak perempuan itu memakan apel.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'فَتَحَ الْأَبُ الْبَابَ',
                'scrambled' => ['الْبَابَ', 'الْأَبُ', 'فَتَحَ'],
                'translation' => 'Ayah itu membuka pintu.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'كَتَبَ الطَّالِبُ الْوَاجِبَ',
                'scrambled' => ['الْوَاجِبَ', 'الطَّالِبُ', 'كَتَبَ'],
                'translation' => 'Siswa itu menulis PR.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'دَرَسَ الْوَلَدُ الدَّرْسَ',
                'scrambled' => ['الدَّرْسَ', 'الْوَلَدُ', 'دَرَسَ'],
                'translation' => 'Anak laki-laki itu belajar pelajaran.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نَامَ الطِّفْلُ فِي السَّرِيرِ',
                'scrambled' => ['السَّرِيرِ', 'فِي', 'الطِّفْلُ', 'نَامَ'],
                'translation' => 'Anak itu tidur di tempat tidur.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'لَعِبَ الْأَوْلَادُ فِي الْمَلْعَبِ',
                'scrambled' => ['الْمَلْعَبِ', 'فِي', 'الْأَوْلَادُ', 'لَعِبَ'],
                'translation' => 'Anak-anak bermain di lapangan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'سَاعَدَ الطَّالِبُ صَدِيقَهُ',
                'scrambled' => ['صَدِيقَهُ', 'الطَّالِبُ', 'سَاعَدَ'],
                'translation' => 'Siswa itu menolong temannya.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'زَارَ الْأُسْتَاذُ الْمَرِيضَ',
                'scrambled' => ['الْمَرِيضَ', 'الْأُسْتَاذُ', 'زَارَ'],
                'translation' => 'Ustadz itu mengunjungi orang sakit.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'حَفِظَ الطَّالِبُ الْقُرْآنَ',
                'scrambled' => ['الْقُرْآنَ', 'الطَّالِبُ', 'حَفِظَ'],
                'translation' => 'Siswa itu menghafal Al-Quran.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'صَلَّى الْمُسْلِمُ فِي الْمَسْجِدِ',
                'scrambled' => ['الْمَسْجِدِ', 'فِي', 'الْمُسْلِمُ', 'صَلَّى'],
                'translation' => 'Muslim itu sholat di masjid.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'طَبَخَتِ الْأُمُّ الطَّعَامَ',
                'scrambled' => ['الطَّعَامَ', 'الْأُمُّ', 'طَبَخَتِ'],
                'translation' => 'Ibu itu memasak makanan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'غَسَلَتِ الْبِنْتُ الْمَلَابِسَ',
                'scrambled' => ['الْمَلَابِسَ', 'الْبِنْتُ', 'غَسَلَتِ'],
                'translation' => 'Anak perempuan itu mencuci pakaian.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'سَافَرَ الرَّجُلُ إِلَى مَكَّةَ',
                'scrambled' => ['مَكَّةَ', 'إِلَى', 'الرَّجُلُ', 'سَافَرَ'],
                'translation' => 'Pria itu bepergian ke Makkah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'جَلَسَ الطَّالِبُ عَلَى الْكُرْسِيِّ',
                'scrambled' => ['الْكُرْسِيِّ', 'عَلَى', 'الطَّالِبُ', 'جَلَسَ'],
                'translation' => 'Siswa itu duduk di kursi.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'رَكِبَ الْوَلَدُ الدَّرَّاجَةَ',
                'scrambled' => ['الدَّرَّاجَةَ', 'الْوَلَدُ', 'رَكِبَ'],
                'translation' => 'Anak laki-laki itu mengendarai sepeda.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'رَسَمَ الطَّالِبُ الصُّورَةَ',
                'scrambled' => ['الصُّورَةَ', 'الطَّالِبُ', 'رَسَمَ'],
                'translation' => 'Siswa itu menggambar lukisan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'حَمَلَ الرَّجُلُ الْحَقِيبَةَ',
                'scrambled' => ['الْحَقِيبَةَ', 'الرَّجُلُ', 'حَمَلَ'],
                'translation' => 'Pria itu membawa tas.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نَظَّفَتِ الْمَرْأَةُ الْبَيْتَ',
                'scrambled' => ['الْبَيْتَ', 'الْمَرْأَةُ', 'نَظَّفَتِ'],
                'translation' => 'Wanita itu membersihkan rumah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'اسْتَيْقَظَ الطَّالِبُ مُبَكِّرًا',
                'scrambled' => ['مُبَكِّرًا', 'الطَّالِبُ', 'اسْتَيْقَظَ'],
                'translation' => 'Siswa itu bangun pagi.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'اشْتَرَى الْأَبُ الْهَدِيَّةَ',
                'scrambled' => ['الْهَدِيَّةَ', 'الْأَبُ', 'اشْتَرَى'],
                'translation' => 'Ayah itu membeli hadiah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'سَمِعَ الطَّالِبُ الشَّرْحَ',
                'scrambled' => ['الشَّرْحَ', 'الطَّالِبُ', 'سَمِعَ'],
                'translation' => 'Siswa itu mendengar penjelasan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'فَهِمَ الْوَلَدُ السُّؤَالَ',
                'scrambled' => ['السُّؤَالَ', 'الْوَلَدُ', 'فَهِمَ'],
                'translation' => 'Anak laki-laki itu memahami pertanyaan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نَجَحَ الطَّالِبُ فِي الِامْتِحَانِ',
                'scrambled' => ['الِامْتِحَانِ', 'فِي', 'الطَّالِبُ', 'نَجَحَ'],
                'translation' => 'Siswa itu lulus dalam ujian.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَجَابَ الطَّالِبُ عَلَى السُّؤَالِ',
                'scrambled' => ['السُّؤَالِ', 'عَلَى', 'الطَّالِبُ', 'أَجَابَ'],
                'translation' => 'Siswa itu menjawab pertanyaan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'شَكَرَ الْوَلَدُ الْمُعَلِّمَ',
                'scrambled' => ['الْمُعَلِّمَ', 'الْوَلَدُ', 'شَكَرَ'],
                'translation' => 'Anak laki-laki itu berterima kasih kepada guru.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'رَجَعَ الطَّالِبُ إِلَى الْبَيْتِ',
                'scrambled' => ['الْبَيْتِ', 'إِلَى', 'الطَّالِبُ', 'رَجَعَ'],
                'translation' => 'Siswa itu kembali ke rumah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'قَابَلَ الطَّالِبُ صَدِيقَهُ',
                'scrambled' => ['صَدِيقَهُ', 'الطَّالِبُ', 'قَابَلَ'],
                'translation' => 'Siswa itu bertemu temannya.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'شَرَحَ الْمُعَلِّمُ الدَّرْسَ',
                'scrambled' => ['الدَّرْسَ', 'الْمُعَلِّمُ', 'شَرَحَ'],
                'translation' => 'Guru itu menjelaskan pelajaran.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'غَنَّى الطِّفْلُ أُغْنِيَةً',
                'scrambled' => ['أُغْنِيَةً', 'الطِّفْلُ', 'غَنَّى'],
                'translation' => 'Anak itu bernyanyi sebuah lagu.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'رَقَصَتِ الْبِنْتُ فِي الْحَفْلَةِ',
                'scrambled' => ['الْحَفْلَةِ', 'فِي', 'الْبِنْتُ', 'رَقَصَتِ'],
                'translation' => 'Anak perempuan itu menari di pesta.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'ضَحِكَ الْأَوْلَادُ بِصَوْتٍ عَالٍ',
                'scrambled' => ['عَالٍ', 'بِصَوْتٍ', 'الْأَوْلَادُ', 'ضَحِكَ'],
                'translation' => 'Anak-anak tertawa dengan suara yang keras.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'بَكَى الطِّفْلُ بِشِدَّةٍ',
                'scrambled' => ['بِشِدَّةٍ', 'الطِّفْلُ', 'بَكَى'],
                'translation' => 'Anak itu menangis dengan keras.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نَظَرَ الرَّجُلُ مِنَ النَّافِذَةِ',
                'scrambled' => ['النَّافِذَةِ', 'مِنَ', 'الرَّجُلُ', 'نَظَرَ'],
                'translation' => 'Pria itu melihat dari jendela.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'سَأَلَ الطَّالِبُ الْمُعَلِّمَ سُؤَالًا',
                'scrambled' => ['سُؤَالًا', 'الْمُعَلِّمَ', 'الطَّالِبُ', 'سَأَلَ'],
                'translation' => 'Siswa itu bertanya kepada guru sebuah pertanyaan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَعْطَى الْأَبُ الْوَلَدَ نُقُودًا',
                'scrambled' => ['نُقُودًا', 'الْوَلَدَ', 'الْأَبُ', 'أَعْطَى'],
                'translation' => 'Ayah itu memberikan anak laki-laki uang.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَخَذَ الطَّالِبُ الْكِتَابَ مِنَ الْمَكْتَبَةِ',
                'scrambled' => ['الْمَكْتَبَةِ', 'مِنَ', 'الْكِتَابَ', 'الطَّالِبُ', 'أَخَذَ'],
                'translation' => 'Siswa itu mengambil buku dari perpustakaan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'وَضَعَتِ الْأُمُّ الطَّعَامَ عَلَى الطَّاوِلَةِ',
                'scrambled' => ['الطَّاوِلَةِ', 'عَلَى', 'الطَّعَامَ', 'الْأُمُّ', 'وَضَعَتِ'],
                'translation' => 'Ibu itu meletakkan makanan di atas meja.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'صَافَحَ الرَّجُلُ صَدِيقَهُ',
                'scrambled' => ['صَدِيقَهُ', 'الرَّجُلُ', 'صَافَحَ'],
                'translation' => 'Pria itu berjabat tangan dengan temannya.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'وَدَّعَ الطَّالِبُ أَصْدِقَاءَهُ',
                'scrambled' => ['أَصْدِقَاءَهُ', 'الطَّالِبُ', 'وَدَّعَ'],
                'translation' => 'Siswa itu berpamitan dengan teman-temannya.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'اسْتَقْبَلَ الرَّجُلُ ضَيْفَهُ',
                'scrambled' => ['ضَيْفَهُ', 'الرَّجُلُ', 'اسْتَقْبَلَ'],
                'translation' => 'Pria itu menyambut tamunya.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَعَدَّتِ الْأُمُّ الْحُلْوَى',
                'scrambled' => ['الْحُلْوَى', 'الْأُمُّ', 'أَعَدَّتِ'],
                'translation' => 'Ibu itu menyiapkan kue.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'كَسَرَ الْوَلَدُ الزُّجَاجَ',
                'scrambled' => ['الزُّجَاجَ', 'الْوَلَدُ', 'كَسَرَ'],
                'translation' => 'Anak laki-laki itu memecahkan kaca.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'صَلَحَ الرَّجُلُ السَّيَّارَةَ',
                'scrambled' => ['السَّيَّارَةَ', 'الرَّجُلُ', 'صَلَحَ'],
                'translation' => 'Pria itu memperbaiki mobil.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نَسَجَتِ الْمَرْأَةُ الثَّوْبَ',
                'scrambled' => ['الثَّوْبَ', 'الْمَرْأَةُ', 'نَسَجَتِ'],
                'translation' => 'Wanita itu menenun pakaian.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'خَاطَتِ الْأُمُّ الثَّوْبَ',
                'scrambled' => ['الثَّوْبَ', 'الْأُمُّ', 'خَاطَتِ'],
                'translation' => 'Ibu itu menjahit pakaian.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'زَرَعَ الْفَلَّاحُ الشَّجَرَ',
                'scrambled' => ['الشَّجَرَ', 'الْفَلَّاحُ', 'زَرَعَ'],
                'translation' => 'Petani itu menanam pohon.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'قَطَفَ الطِّفْلُ الزَّهْرَةَ',
                'scrambled' => ['الزَّهْرَةَ', 'الطِّفْلُ', 'قَطَفَ'],
                'translation' => 'Anak itu memetik bunga.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'صَادَ الصَّيَّادُ السَّمَكَ',
                'scrambled' => ['السَّمَكَ', 'الصَّيَّادُ', 'صَادَ'],
                'translation' => 'Nelayan itu menangkap ikan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'طَهَا الطَّاهِي الطَّعَامَ',
                'scrambled' => ['الطَّعَامَ', 'الطَّاهِي', 'طَهَا'],
                'translation' => 'Koki itu memasak makanan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'بَنَى الْعَامِلُ الْبَيْتَ',
                'scrambled' => ['الْبَيْتَ', 'الْعَامِلُ', 'بَنَى'],
                'translation' => 'Pekerja itu membangun rumah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'حَفَرَ الرَّجُلُ الْبِئْرَ',
                'scrambled' => ['الْبِئْرَ', 'الرَّجُلُ', 'حَفَرَ'],
                'translation' => 'Pria itu menggali sumur.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نَسَخَ الطَّالِبُ الدَّرْسَ',
                'scrambled' => ['الدَّرْسَ', 'الطَّالِبُ', 'نَسَخَ'],
                'translation' => 'Siswa itu menyalin pelajaran.',
            ],
            // 15 soal tambahan baru
            [
                'category' => 'filiyyah',
                'correct' => 'كَتَبَ الْمُدَرِّسُ الْحُرُوفَ عَلَى السَّبُّورَةِ',
                'scrambled' => ['السَّبُّورَةِ', 'عَلَى', 'الْحُرُوفَ', 'الْمُدَرِّسُ', 'كَتَبَ'],
                'translation' => 'Guru menulis huruf di papan tulis.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'رَأَى الطِّفْلُ الْقَمَرَ فِي السَّمَاءِ',
                'scrambled' => ['السَّمَاءِ', 'فِي', 'الْقَمَرَ', 'الطِّفْلُ', 'رَأَى'],
                'translation' => 'Anak melihat bulan di langit.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'شَاهَدَ الرِّجَالُ الْمُبَارَاةَ فِي التِّلِفَازِ',
                'scrambled' => ['التِّلِفَازِ', 'فِي', 'الْمُبَارَاةَ', 'الرِّجَالُ', 'شَاهَدَ'],
                'translation' => 'Para pria menonton pertandingan di TV.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'ذَاقَ الرَّجُلُ الْحُلْوَى',
                'scrambled' => ['الْحُلْوَى', 'الرَّجُلُ', 'ذَاقَ'],
                'translation' => 'Pria itu mencicipi kue.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'وَقَفَ الطَّالِبُ أَمَامَ الْبَابِ',
                'scrambled' => ['الْبَابِ', 'أَمَامَ', 'الطَّالِبُ', 'وَقَفَ'],
                'translation' => 'Siswa itu berdiri di depan pintu.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'جَمَعَ الْوَلَدُ الْأَلْعَابَ',
                'scrambled' => ['الْأَلْعَابَ', 'الْوَلَدُ', 'جَمَعَ'],
                'translation' => 'Anak laki-laki itu mengumpulkan mainan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'فَتَحَ الْمُسَافِرُ الْحَقِيبَةَ',
                'scrambled' => ['الْحَقِيبَةَ', 'الْمُسَافِرُ', 'فَتَحَ'],
                'translation' => 'Penumpang itu membuka tasnya.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَطْلَقَ الرَّجُلُ الطَّائِرَ',
                'scrambled' => ['الطَّائِرَ', 'الرَّجُلُ', 'أَطْلَقَ'],
                'translation' => 'Pria itu melepaskan burung.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'قَفَزَ الْقِطُّ عَلَى الْكُرْسِيِّ',
                'scrambled' => ['الْكُرْسِيِّ', 'عَلَى', 'الْقِطُّ', 'قَفَزَ'],
                'translation' => 'Kucing itu melompat ke kursi.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَكْمَلَ الطَّالِبُ الْقِصَّةَ',
                'scrambled' => ['الْقِصَّةَ', 'الطَّالِبُ', 'أَكْمَلَ'],
                'translation' => 'Siswa itu menyelesaikan cerita.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَطْعَمَ الْوَلَدُ الْقِطَّ',
                'scrambled' => ['الْقِطَّ', 'الْوَلَدُ', 'أَطْعَمَ'],
                'translation' => 'Anak laki-laki itu memberi makan kucing.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'شَغَّلَ الرَّجُلُ الْجَوَّالَ',
                'scrambled' => ['الْجَوَّالَ', 'الرَّجُلُ', 'شَغَّلَ'],
                'translation' => 'Pria itu menghidupkan ponsel.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أَخْمَدَ الرَّجُلُ النَّارَ',
                'scrambled' => ['النَّارَ', 'الرَّجُلُ', 'أَخْمَدَ'],
                'translation' => 'Pria itu memadamkan api.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'غَسَلَ الْوَلَدُ يَدَيْهِ',
                'scrambled' => ['يَدَيْهِ', 'الْوَلَدُ', 'غَسَلَ'],
                'translation' => 'Anak laki-laki itu mencuci tangannya.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'لَبِسَ الطِّفْلُ الْقُمْصَانَ',
                'scrambled' => ['الْقُمْصَانَ', 'الطِّفْلُ', 'لَبِسَ'],
                'translation' => 'Anak itu memakai baju.',
            ],
        ];

        foreach ($sentences as $s) {
            Question::firstOrCreate(
                // Kriteria untuk mencari soal yang sudah ada
                [
                    'category' => 'sentence_builder',
                    'question_text' => $s['correct'],
                ],
                // Data yang akan disimpan jika tidak ditemukan
                [
                    'game_id' => null,
                    'correct_answer' => $s['translation'], // Simpan terjemahan sebagai jawaban benar untuk hint
                    'options' => json_encode($s['scrambled']),
                    'location_name' => null,
                ]
            );
        }

        $this->command->info('✅ Seeder "Arabic Sentence Builder" selesai.');
        $this->command->info('📊 Total: ' . count($sentences) . ' kalimat dengan harokat lengkap telah ditambahkan.');
    }
}