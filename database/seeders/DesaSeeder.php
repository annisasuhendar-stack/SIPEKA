<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'ANGSANA' => ['Angsana', 'Cikayas', 'Cipinang', 'Kadubadak', 'Karangsari', 'Kramatmanik', 'Padaherang', 'Padamulya', 'Sumurlaban'],
            'BANJAR' => ['Bandung', 'Banjar', 'Cibeureum', 'Cibodas', 'Citalahab', 'Gunungputri', 'Kadubale', 'Kadulimus', 'Kadumaneuh', 'Mogana', 'Pasirawi'],
            'BOJONG' => ['Banyumas', 'Bojong', 'Cahaya Mekar', 'Cijakan', 'Citumengung', 'Geredug', 'Manggung Jaya', 'Mekarsari'],
            'CADASARI' => ['Cadasari', 'Ciinjuk', 'Cikentrung', 'Kaduela', 'Kaduengang', 'Kaungcaang', 'Koranji', 'Kurungdahu', 'Pasirpeuteuy', 'Tanagara', 'Tapos'],
            'CARITA' => ['Banjarmasin', 'Carita', 'Cinoyong', 'Kawoyang', 'Pejamben', 'Sindanglaut', 'Sukajadi', 'Sukanagara', 'Sukarame', 'Tembong'],
            'CIBALIUNG' => ['Cibaliung', 'Cibingbin', 'Cihanjuang', 'Curug', 'Mahendra', 'Mendung', 'Sorongan', 'Sudimanik', 'Sukajadi'],
            'CIBITUNG' => ['Cikadu', 'Cikalong', 'Cikiruh', 'Citeluk', 'Kiarajangkung', 'Kiarapayung', 'Kutakarang', 'Malangnengah', 'Manglid', 'Sindangkerta'],
            'CIGEULIS' => ['Banyuasih', 'Cigeulis', 'Ciseureuheun', 'Karangbolong', 'Karyabuana', 'Katumbiri', 'Sinarjaya', 'Tarumanagara', 'Waringinjaya'],
            'CIKEDAL' => ['Babakanlor', 'Bangkuyung', 'Cening', 'Cipicung', 'Dahu', 'Karyasari', 'Karyautama', 'Mekarjaya', 'Padahayuk', 'Tegal'],
            'CIKEUSIK' => ['Cikadondong', 'Cikeusik', 'Cikiruhwetan', 'Curugciung', 'Leuwibalang', 'Nanggala', 'Parungkokosan', 'Rancaseneng', 'Sukamulya', 'Sukaseneng', 'Sukawaris', 'Sumurbatu', 'Tanjungan', 'Umbulan'],
            'CIMANGGU' => ['Batuhideung', 'Cibadak', 'Ciburial', 'Cijaralang', 'Cimanggu', 'Kramatjaya', 'Mangkualam', 'Padasuka', 'Rancapinang', 'Tangkilsari', 'Tugu', 'Waringinkurung'],
            'CIMANUK' => ['Batubantar', 'Cimanuk', 'Dalembalar', 'Gunungcupu', 'Gunungdatar', 'Kadubungbang', 'Kadudodol', 'Kadumadang', 'Kupahandap', 'Rocek', 'Sekong'],
            'CIPEUCANG' => ['Baturanjang', 'Cikadueun', 'Curugbarang', 'Kadugadung', 'Kalanggunung', 'Koncang', 'Palanyar', 'Parumasan', 'Pasireurih', 'Pasirmae'],
            'CISATA' => ['Cibarani', 'Ciherang', 'Cisereh', 'Kadu Ronyok', 'Kondang Jaya', 'Kubang Kondang', 'Palembang', 'Pasir Eurih', 'Rawasari'],
            'JIPUT' => ['Babadsari', 'Banyuresmi', 'Citaman', 'Janaka', 'Jayamekar', 'Jiput', 'Pamarayan', 'Salapraya', 'Sampang Bitung', 'Sikulan', 'Sukacai', 'Sukamanah', 'Tenjolahang'],
            'KADUHEJO' => ['Banjarsari', 'Bayumundu', 'Campaka', 'Ciputri', 'Kadugemblo', 'Mandalasari', 'Palurahan', 'Saninten', 'Sukamanah', 'Sukasari'],
            'KORONCONG' => ['Awilega', 'Bangkonol', 'Gerendong', 'Karangsetra', 'Koroncong', 'Pakuluran', 'Paniis', 'Pasirjaksa', 'Pasirkarang', 'Setrajaya', 'Sukajaya', 'Tegalongok'],
            'LABUAN' => ['Banyubiru', 'Banyumekar', 'Caringin', 'Cigondang', 'Kalanganyar', 'Labuan', 'Rancateureup', 'Sukamaju', 'Teluk'],
            'MANDALAWANGI' => ['Cikoneng', 'Cikumbueun', 'Curuglemo', 'Giripawana', 'Gunungsari', 'Kurungkambing', 'Mandalasari', 'Mandalawangi', 'Nembol', 'Pandat', 'Panjangjaya', 'Pari', 'Ramea', 'Sinarjaya', 'Sirnagalih'],
            'MEKARJAYA' => ['Kadubelang', 'Kadujangkung', 'Medong', 'Mekarjaya', 'Pareang', 'Rancabugel', 'Sukamulya', 'Wirasinga'],
            'MENES' => ['Alaswangi', 'Cigandeng', 'Cilabanbulan', 'Kadupayung', 'Kananga', 'Menes', 'Muruy', 'Purwaraja', 'Ramaya', 'Sindangkarya', 'Sukamanah', 'Tegalwangi'],
            'MUNJUL' => ['Cibitung', 'Curuglanglang', 'Gunungbatu', 'Kotadukuh', 'Lebak', 'Munjul', 'Panacaran', 'Pasanggrahan', 'Sukasaba'],
            'PAGELARAN' => ['Bama', 'Bulagor', 'Harapankarya', 'Kertasana', 'Margagiri', 'Margasana', 'Montor', 'Pagelaran', 'Senangsari', 'Sindanglaya', 'Sukadame', 'Surakarta', 'Tegalpapak'],
            'PANIMBANG' => ['Citeureup', 'Gombong', 'Mekarjaya', 'Mekarsari', 'Panimbang Jaya', 'Tanjungjaya'],
            'PATIA' => ['Babakankeusik', 'Ciawi', 'Cimoyan', 'Idaman', 'Pasirgadung', 'Patia', 'Rahayu', 'Simpangtiga', 'Surianeun', 'Turus'],
            'PICUNG' => ['Bungurcopong', 'Ciherang', 'Cililitan', 'Ganggaeng', 'Kadubera', 'Kadupandak', 'Kolelet', 'Pasirpanjang', 'Pasirsedang'],
            'PULOSARI' => ['Banjarnegara', 'Banjarwangi', 'Cilentung', 'Kaduhejo', 'Karyawangi', 'Koranji', 'Sanghiangdengdek', 'Sukaraja', 'Sukasari'],
            'SAKETI' => ['Ciandur', 'Girijaya', 'Kadudampit', 'Langensari', 'Majau', 'Medalsari', 'Mekarwangi', 'Parigi', 'Saketi', 'Sindanghayu', 'Sodong', 'Sukalangu', 'Talagasari', 'Wanagiri'],
            'SINDANGRESMI' => ['Bojongmanik', 'Campakawarna', 'Ciodeng', 'Kadumalati', 'Pasirdurung', 'Pasirlancar', 'Pasirloa', 'Pasirtenjo', 'Sindangresmi'],
            'SOBANG' => ['Bojen', 'Bojenwetan', 'Cimanis', 'Kertaraharja', 'Kutamekar', 'Pangkalan', 'Sobang', 'Teluk Lada'],
            'SUKARESMI' => ['Cibungur', 'Cikuya', 'Karyasari', 'Kubangkampil', 'Pasirkadu', 'Perdana', 'Seuseupan', 'Sidamukti', 'Sukaresmi', 'Weru'],
            'SUMUR' => ['Cigorondong', 'Kertajaya', 'Kertamukti', 'Sumberjaya', 'Tamanjaya', 'Tunggaljaya', 'Ujungjaya'],
        ];

        foreach ($data as $namaKecamatan => $desas) {
            $kecamatan = Kecamatan::where('nama_kecamatan', 'LIKE', $namaKecamatan)->first();

            if ($kecamatan) {
                foreach ($desas as $namaDesa) {
                    Desa::create([
                        'kecamatan_id' => $kecamatan->id,
                        'nama_desa'    => $namaDesa,
                    ]);
                }
            }
        }
    }
}