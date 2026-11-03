<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AbsensiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password123');

        // =====================================================
        // SUPER ADMIN & ADMIN SEKOLAH (SMA Negeri 1 Siperflex)
        // =====================================================
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@siperflex.com',
            'password' => $password,
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $schoolSMA = School::create([
            'code' => 'SCH001',
            'npsn' => '12345678',
            'name' => 'SMA Negeri 1 Siperflex',
            'address' => 'Jl. Pendidikan No. 1',
            'phone' => '0211234567',
            'email' => 'info@sman1siperflex.sch.id',
            'is_active' => true,
            'status' => 'active',
        ]);

        $adminSekolah = User::create([
            'school_id' => $schoolSMA->id,
            'name' => 'Admin Sekolah',
            'email' => 'admin@sman1siperflex.sch.id',
            'nip' => '198001012010011001',
            'password' => $password,
            'role' => 'admin_sekolah',
            'is_active' => true,
        ]);

        // =====================================================
        // SMP NEGERI 40 MAKASSAR
        // =====================================================
        $school40 = School::create([
            'code' => 'SCH40',
            'npsn' => '40404040',
            'name' => 'SMP NEGERI 40 MAKASSAR',
            'address' => 'Jl. Pendidikan No. 40, Makassar',
            'phone' => '0411234567',
            'email' => 'info@smpn40makassar.sch.id',
            'is_active' => true,
            'status' => 'active',
        ]);

        $adminSMP40 = User::create([
            'school_id' => $school40->id,
            'name' => 'Admin SMP 40',
            'email' => 'admin@smpn40.sch.id',
            'nip' => '198001012010011001',
            'password' => $password,
            'role' => 'admin_sekolah',
            'is_active' => true,
        ]);

        $academicYear40 = AcademicYear::create([
            'school_id' => $school40->id,
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);

        // Wali Kelas SMP 40
        $waliKelas40 = [
            'IX Diligent' => ['name' => "Sa'adah Layly, M.Pd.", 'nip' => '197908222006042010'],
            'IX Expert' => ['name' => 'Saribulan, S.Pd.', 'nip' => '196802012014102001'],
            'IX Creative' => ['name' => 'Sry Zulastri, S.Pd.', 'nip' => '197910232010012017'],
            'IX Attractive' => ['name' => 'Musfirah Nurhaerah, S.Pd.', 'nip' => '199705032023212015'],
            'IX Generous' => ['name' => 'Kasmayanti, S.Pd.', 'nip' => '198504162024212008'],
            'IX Brave' => ['name' => 'Sukmawanty Rahman, S.Pd.', 'nip' => '198601062011012011'],
            'IX Honest' => ['name' => 'Hj. Andi Bataria Pasong, M.Pd.', 'nip' => '198208122009032006'],
            'IX Fantastic' => ['name' => 'Andi Harmawati, S.Pd.', 'nip' => '198109012010042001'],
        ];

        $teachers40 = [];
        foreach ($waliKelas40 as $className => $data) {
            $teachers40[$className] = User::create([
                'school_id' => $school40->id,
                'name' => $data['name'],
                'email' => strtolower(str_replace([' ', ',', '.'], '', $data['name'])) . '@smpn40.sch.id',
                'nip' => $data['nip'],
                'password' => $password,
                'role' => 'guru',
                'is_active' => true,
            ]);
        }

        // Data Siswa SMP 40 - Kelas IX Diligent
        $siswa40Diligent = [
            ['nis' => '183089', 'nisn' => '3122083274', 'name' => 'Adriansyah', 'gender' => 'L'],
            ['nis' => '183090', 'nisn' => '3112310141', 'name' => 'Afif Suhdi', 'gender' => 'L'],
            ['nis' => '183091', 'nisn' => '3127142758', 'name' => 'Ahmad Al Munzir Sulaiman', 'gender' => 'L'],
            ['nis' => '183092', 'nisn' => '0121334295', 'name' => 'Al Fariz Samudra Aprilio. S', 'gender' => 'L'],
            ['nis' => '183095', 'nisn' => '0111756645', 'name' => 'Andi Muh. Asyrif Hidayatullah', 'gender' => 'L'],
            ['nis' => '183096', 'nisn' => '0123475301', 'name' => 'Carlos Daniel', 'gender' => 'L'],
            ['nis' => '183097', 'nisn' => '0112180538', 'name' => 'Dwi Mahardika Padwa', 'gender' => 'L'],
            ['nis' => '183098', 'nisn' => '0122103410', 'name' => 'Fahmi Fatwa', 'gender' => 'L'],
            ['nis' => '183099', 'nisn' => '0114563232', 'name' => 'Hanifa Siti Fatimah', 'gender' => 'P'],
            ['nis' => '183100', 'nisn' => '0114813754', 'name' => 'Hirza Qirani Parsyam', 'gender' => 'P'],
            ['nis' => '183102', 'nisn' => '0128076533', 'name' => 'Keyvin Rizq Asy Syamsu', 'gender' => 'L'],
            ['nis' => '183103', 'nisn' => '0121976278', 'name' => 'M. Annizam Al Rasya', 'gender' => 'L'],
            ['nis' => '183104', 'nisn' => '0119979163', 'name' => 'M. Farzan Arka Argani J.', 'gender' => 'L'],
            ['nis' => '183105', 'nisn' => '0123085111', 'name' => 'Muh. Adli Usman', 'gender' => 'L'],
            ['nis' => '183106', 'nisn' => '3126566893', 'name' => 'Muh. Annabia Al Amin', 'gender' => 'L'],
            ['nis' => '183107', 'nisn' => '0126201987', 'name' => 'Muh. Rajab Junaedi Marwangsah', 'gender' => 'L'],
            ['nis' => '183784', 'nisn' => '0111067506', 'name' => 'Muhammad Anugrah Pratama', 'gender' => 'L'],
            ['nis' => '183108', 'nisn' => '0116063274', 'name' => 'Muhammad Farabi', 'gender' => 'L'],
            ['nis' => '183109', 'nisn' => '0125654812', 'name' => 'Muhammad Fauzan', 'gender' => 'L'],
            ['nis' => '183111', 'nisn' => '0126054804', 'name' => 'Muhammad Righan Al Ghiffari', 'gender' => 'L'],
            ['nis' => '183112', 'nisn' => '3125702643', 'name' => 'Namiah Anindita', 'gender' => 'P'],
            ['nis' => '183115', 'nisn' => '0119019311', 'name' => 'Pregio Nor Asfriyan', 'gender' => 'L'],
            ['nis' => '183113', 'nisn' => '0126017382', 'name' => 'Puan Batari Kayla', 'gender' => 'P'],
            ['nis' => '183114', 'nisn' => '0116482710', 'name' => 'Putri Aprilia Hairul', 'gender' => 'P'],
            ['nis' => '183255', 'nisn' => '0127153692', 'name' => 'Rahimaha Kullu Sakhsiyah', 'gender' => 'P'],
            ['nis' => '183116', 'nisn' => '0118608732', 'name' => 'Ratifa', 'gender' => 'P'],
            ['nis' => '183237', 'nisn' => '0122753504', 'name' => 'Siti Azzahra', 'gender' => 'P'],
            ['nis' => '183119', 'nisn' => '0115177157', 'name' => 'Siti Nurul Syalzabila Irwan', 'gender' => 'P'],
            ['nis' => '183120', 'nisn' => '0124203009', 'name' => 'Wiwi Ramdani', 'gender' => 'P'],
        ];

        // Data Siswa SMP 40 - Kelas IX Expert
        $siswa40Expert = [
            ['nis' => '183129', 'nisn' => '0112472265', 'name' => 'A. Muh. Ibrahim Ramadhan', 'gender' => 'L'],
            ['nis' => '183254', 'nisn' => '111446113', 'name' => 'Aditya Naufal Abiyyu', 'gender' => 'L'],
            ['nis' => '183122', 'nisn' => '0113312965', 'name' => 'Akhsan Siddiq Putra Manalu', 'gender' => 'L'],
            ['nis' => '183123', 'nisn' => '3124358083', 'name' => 'Ananda Ferisya Sabur Ada', 'gender' => 'P'],
            ['nis' => '183124', 'nisn' => '0119484075', 'name' => 'Andi Aurick Syawal Ardhani', 'gender' => 'L'],
            ['nis' => '183125', 'nisn' => '0116113819', 'name' => 'Andi Diva Rizqiyah Pratiwi Ady', 'gender' => 'L'],
            ['nis' => '183128', 'nisn' => '0124788302', 'name' => 'Andi Muh. Al-Ghifari Smid', 'gender' => 'L'],
            ['nis' => '183126', 'nisn' => '0117341144', 'name' => 'Andi Muh. Ikrar Fatahillah Risal', 'gender' => 'L'],
            ['nis' => '183127', 'nisn' => '0128568110', 'name' => 'Andi Muh. Raqha\'at Mattalatta', 'gender' => 'L'],
            ['nis' => '183130', 'nisn' => '0127762114', 'name' => 'Andi Raisya Alika Putri Ramadhan', 'gender' => 'P'],
            ['nis' => '183131', 'nisn' => '0114983790', 'name' => 'Dirgham Fawwas Ramadhana Putra', 'gender' => 'L'],
            ['nis' => '183132', 'nisn' => '0115967947', 'name' => 'Elira Nur Oktaviani Ilyas', 'gender' => 'P'],
            ['nis' => '183133', 'nisn' => '0128151434', 'name' => 'Fadiyah Nurul Dzihni', 'gender' => 'P'],
            ['nis' => '183134', 'nisn' => '3111308206', 'name' => 'Fitriyani', 'gender' => 'P'],
            ['nis' => '183135', 'nisn' => '3122143601', 'name' => 'Frits Fernando Tenker', 'gender' => 'L'],
            ['nis' => '183136', 'nisn' => '0121581924', 'name' => 'Gibran Saputra', 'gender' => 'L'],
            ['nis' => '183137', 'nisn' => '3125789115', 'name' => 'Haziqah Umaiza Juniardi', 'gender' => 'P'],
            ['nis' => '183138', 'nisn' => '3126999612', 'name' => 'M. Reyfan Al Caesar', 'gender' => 'L'],
            ['nis' => '183140', 'nisn' => '0117934943', 'name' => 'Muh. Fikri', 'gender' => 'L'],
            ['nis' => '183141', 'nisn' => '3119200798', 'name' => 'Muh. Furqan Magfir Abdillah', 'gender' => 'L'],
            ['nis' => '183142', 'nisn' => '0112484830', 'name' => 'Muh. Ibnu Habib Wahyudi. G', 'gender' => 'L'],
            ['nis' => '183144', 'nisn' => '0129516560', 'name' => 'Muh. Raffi Effendi', 'gender' => 'L'],
            ['nis' => '183145', 'nisn' => '0125341439', 'name' => 'Nur Fitriyani', 'gender' => 'P'],
            ['nis' => '183177', 'nisn' => '0116652855', 'name' => 'Nansiya Ayu Danitha', 'gender' => 'P'],
            ['nis' => '183178', 'nisn' => '0128931038', 'name' => 'Nur Faiqah Zanna', 'gender' => 'P'],
            ['nis' => '183179', 'nisn' => '0117581752', 'name' => 'Reski Ameiia', 'gender' => 'P'],
            ['nis' => '183180', 'nisn' => '0113858729', 'name' => 'Sakina Putri Khouw', 'gender' => 'P'],
            ['nis' => '182881', 'nisn' => '0112876269', 'name' => 'Salsa Melani', 'gender' => 'P'],
            ['nis' => '183183', 'nisn' => '0128714253', 'name' => 'Sofhya Annisa', 'gender' => 'P'],
            ['nis' => '183184', 'nisn' => '3117018889', 'name' => 'Tasya Rezky Ramadhani', 'gender' => 'P'],
            ['nis' => '183185', 'nisn' => '0119938655', 'name' => 'Vista Anjelita', 'gender' => 'P'],
        ];

        // Data Siswa SMP 40 - Kelas IX Creative
        $siswa40Creative = [
            ['nis' => '183055', 'nisn' => '0129258917', 'name' => 'Afdhil Mappatoba Ranggong', 'gender' => 'L'],
            ['nis' => '183056', 'nisn' => '0127005300', 'name' => 'Ainiya Faiha', 'gender' => 'P'],
            ['nis' => '183057', 'nisn' => '3125262854', 'name' => 'Alif Afrizal Syam', 'gender' => 'L'],
            ['nis' => '183058', 'nisn' => '0126530599', 'name' => 'Andi Nur Afikha Hafied', 'gender' => 'P'],
            ['nis' => '183059', 'nisn' => '0121989647', 'name' => 'Andi Nurul Aisyah S.', 'gender' => 'P'],
            ['nis' => '183061', 'nisn' => '0111904668', 'name' => 'Andi Zivara Quinnova', 'gender' => 'P'],
            ['nis' => '183062', 'nisn' => '0118382490', 'name' => 'Annisa Putri Maharani', 'gender' => 'P'],
            ['nis' => '183063', 'nisn' => '0122632867', 'name' => 'Aprilia', 'gender' => 'P'],
            ['nis' => '183064', 'nisn' => '0127751600', 'name' => 'Arisma Diputri', 'gender' => 'P'],
            ['nis' => '183065', 'nisn' => '0125698804', 'name' => 'Biyazid Bistamin Auliya', 'gender' => 'L'],
            ['nis' => '183066', 'nisn' => '0123146465', 'name' => 'Dian Angreyni Malik', 'gender' => 'P'],
            ['nis' => '183067', 'nisn' => '0124171656', 'name' => 'Febrian Saputra Chandra', 'gender' => 'L'],
            ['nis' => '183068', 'nisn' => '0125975829', 'name' => 'Fuad Al Muqit', 'gender' => 'L'],
            ['nis' => '183071', 'nisn' => '0128147636', 'name' => 'M. Akmal Ghani Putra. UM', 'gender' => 'L'],
            ['nis' => '183072', 'nisn' => '0114022092', 'name' => 'Mifdhal Asyraf Almughni', 'gender' => 'L'],
            ['nis' => '183035', 'nisn' => '0126646611', 'name' => 'Muh. Amar Putra Arya', 'gender' => 'L'],
            ['nis' => '183078', 'nisn' => '0121135308', 'name' => 'Muh. Arhab Ibnu Yasin', 'gender' => 'L'],
            ['nis' => '183079', 'nisn' => '0116472449', 'name' => 'Muh. Rezki Nur Kholik', 'gender' => 'L'],
            ['nis' => '183074', 'nisn' => '0121393259', 'name' => 'Muhammad Abdi Herman', 'gender' => 'L'],
            ['nis' => '183081', 'nisn' => '0121123601', 'name' => 'Muhammad Aditya Pamungkas', 'gender' => 'L'],
            ['nis' => '183077', 'nisn' => '0124651658', 'name' => 'Muhammad Aryya Putra', 'gender' => 'L'],
            ['nis' => '183080', 'nisn' => '0125659419', 'name' => 'Muhammad Suleman', 'gender' => 'L'],
            ['nis' => '183082', 'nisn' => '0118849825', 'name' => 'Nurul Zal Zabila', 'gender' => 'P'],
            ['nis' => '183084', 'nisn' => '0122741122', 'name' => 'Putri Ayu Aanisah', 'gender' => 'P'],
            ['nis' => '183085', 'nisn' => '0114689226', 'name' => 'Revan Hariri', 'gender' => 'L'],
            ['nis' => '183086', 'nisn' => '0125669155', 'name' => 'Sabrina Aulia Kaltzum', 'gender' => 'P'],
            ['nis' => '183070', 'nisn' => '0112516998', 'name' => 'Safira Irfan', 'gender' => 'P'],
            ['nis' => '183087', 'nisn' => '3129032721', 'name' => 'Schatzi Aurel Christine Ansar', 'gender' => 'P'],
            ['nis' => '183088', 'nisn' => '0115472250', 'name' => 'Timothy Imanuel Tengkano', 'gender' => 'P'],
        ];

        // Data Siswa SMP 40 - Kelas IX Attractive
        $siswa40Attractive = [
            ['nis' => '182992', 'nisn' => '0121514270', 'name' => 'Airha Zahwa Nurfadillah', 'gender' => 'P'],
            ['nis' => '182993', 'nisn' => '0117074877', 'name' => 'Alifia Nabila Azzahrah', 'gender' => 'P'],
            ['nis' => '182994', 'nisn' => '0126256167', 'name' => 'Alika Afifa Az-Zahra. S', 'gender' => 'P'],
            ['nis' => '182990', 'nisn' => '0129888026', 'name' => 'Andi Akhdan Qhasid. AM', 'gender' => 'L'],
            ['nis' => '182991', 'nisn' => '0116017358', 'name' => 'Andi Muhammad Nirzam Tenribali', 'gender' => 'L'],
            ['nis' => '182995', 'nisn' => '3126039570', 'name' => 'Anugrah Firdanizar Yani', 'gender' => 'L'],
            ['nis' => '182996', 'nisn' => '0111865483', 'name' => 'Aqila Khansa Hanifah', 'gender' => 'P'],
            ['nis' => '183246', 'nisn' => '0121714585', 'name' => 'Aufa Ayatul Ikhwan', 'gender' => 'P'],
            ['nis' => '182997', 'nisn' => '116845249', 'name' => 'Azalia Devina Mahadewi Arianto', 'gender' => 'P'],
            ['nis' => '182998', 'nisn' => '0129283376', 'name' => 'Azzahra Naysila Tjandra', 'gender' => 'P'],
            ['nis' => '182999', 'nisn' => '0129043237', 'name' => 'Danisha Syaura Putri Darfin', 'gender' => 'P'],
            ['nis' => '183000', 'nisn' => '0121064053', 'name' => 'Dheya Fadriyani', 'gender' => 'P'],
            ['nis' => '183257', 'nisn' => '0125786247', 'name' => 'Farah Fadeluna Fatayah', 'gender' => 'P'],
            ['nis' => '183001', 'nisn' => '0121217896', 'name' => 'Fatih Ramdhan Faharuddin', 'gender' => 'P'],
            ['nis' => '183002', 'nisn' => '0126926423', 'name' => 'Finsya Kirana Putri', 'gender' => 'P'],
            ['nis' => '183003', 'nisn' => '0127345226', 'name' => 'Fira Kirani Putri', 'gender' => 'P'],
            ['nis' => '183004', 'nisn' => '0122734173', 'name' => 'Gladise Yonathan', 'gender' => 'P'],
            ['nis' => '183006', 'nisn' => '0121400944', 'name' => 'Haura Farah Ramadhani', 'gender' => 'P'],
            ['nis' => '183265', 'nisn' => '012675463', 'name' => 'Kanaya Naura Queen', 'gender' => 'P'],
            ['nis' => '183008', 'nisn' => '0115610739', 'name' => 'Khaisil Khaeril', 'gender' => 'L'],
            ['nis' => '183009', 'nisn' => '0116530271', 'name' => 'Khayla Sabrina Fitri', 'gender' => 'P'],
            ['nis' => '183011', 'nisn' => '119399348', 'name' => 'M. Yusuf', 'gender' => 'L'],
            ['nis' => '183014', 'nisn' => '0112015305', 'name' => 'Muh. Rizky Nugraha', 'gender' => 'L'],
            ['nis' => '183010', 'nisn' => '0112544200', 'name' => 'Muhammad Gibran Khalil', 'gender' => 'L'],
            ['nis' => '183007', 'nisn' => '0118861800', 'name' => 'Muhammad Ibnu Ulama Mursuta R.', 'gender' => 'L'],
            ['nis' => '183018', 'nisn' => '3120143951', 'name' => 'Putri Youme Angrelia', 'gender' => 'P'],
            ['nis' => '183019', 'nisn' => '0119751878', 'name' => 'Salsabila Alika', 'gender' => 'P'],
            ['nis' => '183020', 'nisn' => '0114374308', 'name' => 'Sri Muliani', 'gender' => 'P'],
            ['nis' => '183021', 'nisn' => '0121875234', 'name' => 'Ufairah Afifah', 'gender' => 'P'],
            ['nis' => '183022', 'nisn' => '0128875113', 'name' => 'Zhalva Sabilah Arli', 'gender' => 'P'],
        ];

        // Data Siswa SMP 40 - Kelas IX Generous
        $siswa40Generous = [
            ['nis' => '183186', 'nisn' => '0123960727', 'name' => 'Ahmad Zulkifli', 'gender' => 'L'],
            ['nis' => '183187', 'nisn' => '0127089237', 'name' => 'Alifya Mysha A', 'gender' => 'P'],
            ['nis' => '183188', 'nisn' => '0127417281', 'name' => 'Andi Sitti Atiyah A. Nusu', 'gender' => 'P'],
            ['nis' => '183189', 'nisn' => '0127008732', 'name' => 'Aqilah Yava Putri', 'gender' => 'P'],
            ['nis' => '183190', 'nisn' => '0115056072', 'name' => 'Aretha Zizi Sandrica', 'gender' => 'P'],
            ['nis' => '183192', 'nisn' => '0121627761', 'name' => 'Az Zahrah Aulia Risal', 'gender' => 'P'],
            ['nis' => '183191', 'nisn' => '0124486730', 'name' => 'Azahra Qirania Putri Asraf', 'gender' => 'P'],
            ['nis' => '183193', 'nisn' => '0127378740', 'name' => 'Calista', 'gender' => 'P'],
            ['nis' => '183194', 'nisn' => '0127798816', 'name' => 'Filzah Adzani Zulkarnain', 'gender' => 'P'],
            ['nis' => '183195', 'nisn' => '0118011504', 'name' => 'Janson Hendrikus Parinussa', 'gender' => 'L'],
            ['nis' => '183196', 'nisn' => '0121211245', 'name' => 'Khanza Febyan Alessya Suhaeb', 'gender' => 'P'],
            ['nis' => '183197', 'nisn' => '0127587125', 'name' => 'M. Fatih Arief Arafah', 'gender' => 'L'],
            ['nis' => '183200', 'nisn' => '0117925499', 'name' => 'Muh. Anugerah Alfarisal', 'gender' => 'L'],
            ['nis' => '183530', 'nisn' => '0217056559', 'name' => 'Muh. Arkananta Ash Siddiq', 'gender' => 'L'],
            ['nis' => '183203', 'nisn' => '0121175305', 'name' => 'Muh. Faiz Fardian', 'gender' => 'L'],
            ['nis' => '183204', 'nisn' => '0117206492', 'name' => 'Muhammad Gibraltar', 'gender' => 'L'],
            ['nis' => '183264', 'nisn' => '0126754763', 'name' => 'Nayaka Hazza Hermawan', 'gender' => 'L'],
            ['nis' => '183206', 'nisn' => '0128830885', 'name' => 'Nayla Akbar', 'gender' => 'P'],
            ['nis' => '183208', 'nisn' => '0113146853', 'name' => 'Nur Qaifah Rahmadhani', 'gender' => 'P'],
            ['nis' => '183207', 'nisn' => '0117684423', 'name' => 'Nur Qayla Rezky Supriadi', 'gender' => 'P'],
            ['nis' => '183209', 'nisn' => '0112931545', 'name' => 'Putra Aditya', 'gender' => 'L'],
            ['nis' => '183537', 'nisn' => '0129331099', 'name' => 'Rabiyatul Ahdawiah Arif', 'gender' => 'P'],
            ['nis' => '183210', 'nisn' => '3123696074', 'name' => 'Refan Alfrendi Karaeng', 'gender' => 'L'],
            ['nis' => '183211', 'nisn' => '0123044221', 'name' => 'Ridha Rabbani Ilyas', 'gender' => 'P'],
            ['nis' => '183212', 'nisn' => '0129778014', 'name' => 'Shabira Putri Pertiwi', 'gender' => 'P'],
            ['nis' => '183213', 'nisn' => '0119276870', 'name' => 'St. Syara Alzena Syam', 'gender' => 'P'],
        ];

        // Data Siswa SMP 40 - Kelas IX Brave
        $siswa40Brave = [
            ['nis' => '183024', 'nisn' => '0117471198', 'name' => 'Al Mukarramah', 'gender' => 'P'],
            ['nis' => '183025', 'nisn' => '0124816957', 'name' => 'Aleyza Naila Ramadhani', 'gender' => 'P'],
            ['nis' => '183026', 'nisn' => '0118653227', 'name' => 'Andi Akhdan Arif Athaya', 'gender' => 'P'],
            ['nis' => '183027', 'nisn' => '0124547754', 'name' => 'Andi Al Yusuf Adnan AB', 'gender' => 'L'],
            ['nis' => '183028', 'nisn' => '0124478173', 'name' => 'Andi Khavindra Wahyuddin', 'gender' => 'L'],
            ['nis' => '183262', 'nisn' => '0128716515', 'name' => 'Andi Syaza Salsabila', 'gender' => 'P'],
            ['nis' => '183029', 'nisn' => '0112975725', 'name' => 'Anggara Okto Ariano', 'gender' => 'L'],
            ['nis' => '183030', 'nisn' => '0116926039', 'name' => 'Atiqul Rahman', 'gender' => 'L'],
            ['nis' => '183031', 'nisn' => '0047772243', 'name' => 'Ayu Tinting', 'gender' => 'P'],
            ['nis' => '183032', 'nisn' => '0126834894', 'name' => 'Dwi Aulia Anwar Suryatmana', 'gender' => 'P'],
            ['nis' => '183222', 'nisn' => '0126698495', 'name' => 'Farah Dwi Nazhihah Fajar', 'gender' => 'P'],
            ['nis' => '183033', 'nisn' => '0115916713', 'name' => 'Fritzaldy Novian Faidzal', 'gender' => 'L'],
            ['nis' => '183034', 'nisn' => '0127060282', 'name' => 'Inaya Anindita', 'gender' => 'P'],
            ['nis' => '183036', 'nisn' => '0122119798', 'name' => 'M. Dwi Rizad', 'gender' => 'L'],
            ['nis' => '183037', 'nisn' => '0117461240', 'name' => 'M. Rihat Al Azhar. R', 'gender' => 'L'],
            ['nis' => '183042', 'nisn' => '0119771420', 'name' => 'Muh Ardiansya Halim', 'gender' => 'L'],
            ['nis' => '183038', 'nisn' => '0118089107', 'name' => 'Muh. Aslam Ibnu Nasruddin', 'gender' => 'L'],
            ['nis' => '183041', 'nisn' => '0116278447', 'name' => 'Muh. Syadhitra Fabian Alfaro. S', 'gender' => 'L'],
            ['nis' => '183043', 'nisn' => '0127316704', 'name' => 'Muhammad Ardan Priatna', 'gender' => 'L'],
            ['nis' => '183039', 'nisn' => '0122260033', 'name' => 'Muhammad Fadil', 'gender' => 'L'],
            ['nis' => '183044', 'nisn' => '3125722736', 'name' => 'Muhammad Nabil', 'gender' => 'L'],
            ['nis' => '183040', 'nisn' => '0111748031', 'name' => 'Muhammad Nur Ali Zainal', 'gender' => 'L'],
            ['nis' => '183045', 'nisn' => '0115169159', 'name' => 'Myiesha Nafeza', 'gender' => 'P'],
            ['nis' => '183047', 'nisn' => '0128635292', 'name' => 'Nur Asyiah Kamilah Syarif', 'gender' => 'P'],
            ['nis' => '183267', 'nisn' => '0112113474', 'name' => 'Nur Azizah Usman', 'gender' => 'P'],
            ['nis' => '183048', 'nisn' => '0121003645', 'name' => 'Nurul Cahaya Najwa', 'gender' => 'P'],
            ['nis' => '183049', 'nisn' => '0123409018', 'name' => 'Pandu Suna', 'gender' => 'L'],
            ['nis' => '183050', 'nisn' => '0118684279', 'name' => 'Queennita Novaliyah Sanas', 'gender' => 'P'],
            ['nis' => '183051', 'nisn' => '3121830001', 'name' => 'Safira Aisyah Putri', 'gender' => 'P'],
            ['nis' => '183052', 'nisn' => '0121153520', 'name' => 'Siti Fadhilah Azzikra', 'gender' => 'P'],
            ['nis' => '183054', 'nisn' => '0122884933', 'name' => 'Wahyu Ramadhan', 'gender' => 'L'],
        ];

        // Data Siswa SMP 40 - Kelas IX Honest
        $siswa40Honest = [
            ['nis' => '183218', 'nisn' => '0116972778', 'name' => 'Abdul Aji Endro Syah Reza', 'gender' => 'L'],
            ['nis' => '183219', 'nisn' => '0128216426', 'name' => 'Aisyah Afifa', 'gender' => 'P'],
            ['nis' => '183220', 'nisn' => '0128802495', 'name' => 'Andi Eva', 'gender' => 'P'],
            ['nis' => '183252', 'nisn' => '0128786870', 'name' => 'Andi Khalila Azzahra', 'gender' => 'P'],
            ['nis' => '183221', 'nisn' => '0126333837', 'name' => 'Anjas Setiawan', 'gender' => 'L'],
            ['nis' => '183223', 'nisn' => '0118369873', 'name' => 'Isdar', 'gender' => 'L'],
            ['nis' => '183224', 'nisn' => '3120016255', 'name' => 'Muh Mirza Lalong Langi RR', 'gender' => 'L'],
            ['nis' => '183299', 'nisn' => '0122639562', 'name' => 'Muh. Alif Nasry', 'gender' => 'L'],
            ['nis' => '183225', 'nisn' => '0122041751', 'name' => 'Muh. Anwar', 'gender' => 'L'],
            ['nis' => '183227', 'nisn' => '0125147479', 'name' => 'Muh. Fathir Kaimal', 'gender' => 'L'],
            ['nis' => '183228', 'nisn' => '0121099262', 'name' => 'Muh. Rezky Raditya Putra Ratno', 'gender' => 'L'],
            ['nis' => '183229', 'nisn' => '0117701666', 'name' => 'Mutmainnah Yasmina Paiha', 'gender' => 'P'],
            ['nis' => '183230', 'nisn' => '119930869', 'name' => 'Nadya Mahrani', 'gender' => 'P'],
            ['nis' => '183231', 'nisn' => '0128282887', 'name' => 'Nur Ghanya Putri Ansar', 'gender' => 'P'],
            ['nis' => '183232', 'nisn' => '3122789053', 'name' => 'Putri Maulidya Azzahra Samad', 'gender' => 'P'],
            ['nis' => '183234', 'nisn' => '0114123220', 'name' => 'Safa Aulia Zhafira', 'gender' => 'P'],
            ['nis' => '183235', 'nisn' => '0113449294', 'name' => 'Sakti Ariansyah', 'gender' => 'L'],
            ['nis' => '183236', 'nisn' => '0119644037', 'name' => 'Cifa Siti Nurzulaidha', 'gender' => 'P'],
            ['nis' => '183240', 'nisn' => '0122871666', 'name' => 'Siti Syahla Afifah', 'gender' => 'P'],
            ['nis' => '183238', 'nisn' => '0127506029', 'name' => 'Sitti Safira Misran', 'gender' => 'P'],
            ['nis' => '183053', 'nisn' => '0107502975', 'name' => 'Surya Saputra Syam', 'gender' => 'L'],
            ['nis' => '183239', 'nisn' => '0128895684', 'name' => 'Zachwan Rachmansyah Putra', 'gender' => 'L'],
            ['nis' => '183121', 'nisn' => '0117348262', 'name' => 'Zayanah Ghaliyah Amiaty', 'gender' => 'P'],
            ['nis' => '183774', 'nisn' => '0108563177', 'name' => 'Muhammad Noval Adji Restu', 'gender' => 'L'],
        ];

        // Data Siswa SMP 40 - Kelas IX Fantastic
        $siswa40Fantastic = [
            ['nis' => '183155', 'nisn' => '0122830504', 'name' => 'Abdul Hafidz Al Haq', 'gender' => 'P'],
            ['nis' => '183156', 'nisn' => '0113293500', 'name' => 'Adjie Sastra Saputra', 'gender' => 'L'],
            ['nis' => '183157', 'nisn' => '0127457196', 'name' => 'Aini Rukniah Quraisy', 'gender' => 'L'],
            ['nis' => '183158', 'nisn' => '0121993707', 'name' => 'Alam Syah Ramadan', 'gender' => 'P'],
            ['nis' => '183159', 'nisn' => '0118044474', 'name' => 'Andi Muhammad Farel Sultan', 'gender' => 'L'],
            ['nis' => '183160', 'nisn' => '0111351699', 'name' => 'Aqhyla Alwin Nouren Aswin', 'gender' => 'L'],
            ['nis' => '183161', 'nisn' => '0116087315', 'name' => 'Ardiansyah', 'gender' => 'P'],
            ['nis' => '183154', 'nisn' => '0123525121', 'name' => 'Asani Nursyifa Rahman', 'gender' => 'L'],
            ['nis' => '183162', 'nisn' => '0125501653', 'name' => 'Asyila Fahriza Nouren Aswin', 'gender' => 'P'],
            ['nis' => '183163', 'nisn' => '0126524715', 'name' => 'Azzam Khairul Fahmi', 'gender' => 'L'],
            ['nis' => '183164', 'nisn' => '0119580699', 'name' => 'Fira Maulida', 'gender' => 'P'],
            ['nis' => '183165', 'nisn' => '0119408723', 'name' => 'Fitra Ramadani', 'gender' => 'P'],
            ['nis' => '183166', 'nisn' => '0112803235', 'name' => 'Inas Afiyah Aras', 'gender' => 'P'],
            ['nis' => '183167', 'nisn' => '0123568488', 'name' => 'Ince Nizam Adzhani Amin', 'gender' => 'L'],
            ['nis' => '183168', 'nisn' => '0118632889', 'name' => 'Irfan', 'gender' => 'L'],
            ['nis' => '183169', 'nisn' => '0125468803', 'name' => 'Jefri Kurnia Putra Agung', 'gender' => 'L'],
            ['nis' => '183170', 'nisn' => '0126517882', 'name' => 'Khairunnisah Salsabilah Asyikin', 'gender' => 'P'],
            ['nis' => '183171', 'nisn' => '0118145542', 'name' => 'M. Dirgayuza Al Fiqram', 'gender' => 'L'],
            ['nis' => '183172', 'nisn' => '0126382275', 'name' => 'Mitha Ayunda', 'gender' => 'P'],
            ['nis' => '183176', 'nisn' => '0119426013', 'name' => 'Muh. Ilham', 'gender' => 'L'],
            ['nis' => '183173', 'nisn' => '0114303179', 'name' => 'Muh. Irfandy Ayyub Affandy', 'gender' => 'L'],
            ['nis' => '183174', 'nisn' => '0127731364', 'name' => 'Muh. Rhifqy Ogiestira', 'gender' => 'L'],
            ['nis' => '183175', 'nisn' => '0126105990', 'name' => 'Muhammad Fauzi Bukhari', 'gender' => 'L'],
            ['nis' => '183146', 'nisn' => '0113018566', 'name' => 'Nur Hikma', 'gender' => 'P'],
            ['nis' => '183147', 'nisn' => '0126724769', 'name' => 'Nur Rezky Latifah', 'gender' => 'P'],
            ['nis' => '183148', 'nisn' => '0125185659', 'name' => 'Siti Nurfitia Ramadhani', 'gender' => 'P'],
            ['nis' => '183149', 'nisn' => '0127301945', 'name' => 'St. Aisyah Humairah', 'gender' => 'P'],
            ['nis' => '183151', 'nisn' => '0113744844', 'name' => 'Syawal Putra Ramadhan', 'gender' => 'L'],
            ['nis' => '183150', 'nisn' => '0129258415', 'name' => 'Syari Alif', 'gender' => 'L'],
            ['nis' => '183153', 'nisn' => '0112774530', 'name' => 'Zahra Sahrani Aulia', 'gender' => 'P'],
            ['nis' => '183529', 'nisn' => '0112084811', 'name' => 'Rheinola', 'gender' => 'P'],
            ['nis' => '183779', 'nisn' => '0115073910', 'name' => 'Salman Al Farisi', 'gender' => 'L'],
        ];

        // Create Class Rooms and Students for SMP 40
        $allSiswa40 = [
            'IX Diligent' => $siswa40Diligent,
            'IX Expert' => $siswa40Expert,
            'IX Creative' => $siswa40Creative,
            'IX Attractive' => $siswa40Attractive,
            'IX Generous' => $siswa40Generous,
            'IX Brave' => $siswa40Brave,
            'IX Honest' => $siswa40Honest,
            'IX Fantastic' => $siswa40Fantastic,
        ];

        foreach ($allSiswa40 as $className => $students) {
            $classRoom = ClassRoom::create([
                'school_id' => $school40->id,
                'academic_year_id' => $academicYear40->id,
                'class_name' => $className,
                'grade_level' => '9',
                'major' => null,
                'homeroom_teacher_id' => $teachers40[$className]->id,
                'is_active' => true,
            ]);

            // Assign homeroom teacher to class_teacher
            DB::table('class_teacher')->insert([
                'school_id' => $school40->id,
                'class_id' => $classRoom->id,
                'teacher_id' => $teachers40[$className]->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($students as $student) {
                $user = User::create([
                    'school_id' => $school40->id,
                    'name' => $student['name'],
                    'email' => strtolower(str_replace([' ', ',', '.', "'"], '', $student['name'])) . $student['nis'] . '@student.smpn40.sch.id',
                    'nis' => $student['nis'],
                    'nisn' => $student['nisn'],
                    'gender' => $student['gender'],
                    'password' => $password,
                    'role' => 'siswa',
                    'is_active' => true,
                ]);

                DB::table('class_student')->insert([
                    'school_id' => $school40->id,
                    'class_id' => $classRoom->id,
                    'student_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

    }
}
