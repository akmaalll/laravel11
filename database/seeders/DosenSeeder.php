<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dosens = [
            ['nidn' => '0003117501', 'nama' => 'Faizal, S.Kom., M.Si.', 'email' => 'faizal.s.kom.m.si@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0010087201', 'nama' => 'Nurdin, S.Kom., M.T.', 'email' => 'nurdin.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0025027801', 'nama' => 'Salman, S.Kom., M.T.', 'email' => 'salman.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0025067501', 'nama' => 'Abdul Kadir Jailani, S.Kom., M.T.', 'email' => 'abdul.kadir.jailani.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0027077601', 'nama' => 'Angdy Erna, S.Kom., M.Si.', 'email' => 'angdy.erna.s.kom.m.si@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0028017401', 'nama' => 'Marcellus O. Kadang, S.Kom., M.T.', 'email' => 'marcellus.o.kadang.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '007024901', 'nama' => 'Drs. Suarga, M.Sc., M.Math., Ph.D.', 'email' => 'drs.suarga.m.sc.m.math.ph.d@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '05221009', 'nama' => 'Yuliana Saleda', 'email' => 'yuliana.saleda@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0901019301', 'nama' => 'Heriadi, S.Pd.I., M.Pd.', 'email' => 'heriadi.s.pd.i.m.pd@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0901118402', 'nama' => 'Komang Aryasa, S.Kom., M.T.', 'email' => 'komang.aryasa.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0902026402', 'nama' => 'Drs. Mudarsep, M.Hum.', 'email' => 'drs.mudarsep.m.hum@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0902047701', 'nama' => 'Indra Samsie, S.Kom., M.Kom.', 'email' => 'indra.samsie.s.kom.m.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0902048601', 'nama' => 'Ardimansyah, S.Kom., M.T.', 'email' => 'ardimansyah.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0902057805', 'nama' => 'Salmiati, S.Kom., M.T.', 'email' => 'salmiati.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0902087302', 'nama' => 'Usman, S.E., M.Kom.', 'email' => 'usman.s.e.m.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0903049801', 'nama' => 'Ina Yuliana Dewi,SE.,MM.', 'email' => 'ina.yuliana.dewi.se.mm@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0903069501', 'nama' => 'Andi Asvin Mahersatillah Suradi, S.Kom.,M.T', 'email' => 'andi.asvin.mahersatillah.suradi.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0903118301', 'nama' => 'Novita Sambo, S.Si., M.Si.', 'email' => 'novita.sambo.s.si.m.si@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0904018701', 'nama' => 'Suryani, S.Kom., M.T.', 'email' => 'suryani.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0904066801', 'nama' => 'Hardi, S.E., M.M.', 'email' => 'hardi.s.e.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0904098604', 'nama' => 'Asmah Akhriana, S.T., M.T.', 'email' => 'asmah.akhriana.s.t.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0905038601', 'nama' => 'Dr. Aprizal, S.Kom., M.M.', 'email' => 'dr.aprizal.s.kom.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0905058904', 'nama' => 'Arham Arifin, S.Kom., M.T', 'email' => 'arham.arifin.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0905088201', 'nama' => 'Thabrani R., S.Kom., M.T.', 'email' => 'thabrani.r.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0906098001', 'nama' => 'Akbar Bahtiar, S.E.,M.M', 'email' => 'akbar.bahtiar.s.e.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0906128601', 'nama' => 'Nurul Aini, S.Kom., M.T.', 'email' => 'nurul.aini.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0907057204', 'nama' => 'Khadafi, SE., MM', 'email' => 'khadafi.se.mm@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0907087202', 'nama' => 'Dr. Eng. Wilem Musu, S.Kom., M.T.', 'email' => 'dr.eng.wilem.musu.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0907087903', 'nama' => 'Annah, S.Kom., M.T.', 'email' => 'annah.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0907107101', 'nama' => 'Muhammad Syukri Mustafa, S.Si., M.MSI.', 'email' => 'muhammad.syukri.mustafa.s.si.m.msi@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0907117303', 'nama' => 'Dr. Husain, S.T., M.T.', 'email' => 'dr.husain.s.t.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0908048701', 'nama' => 'Erfan Hasmin, S.Kom., M.T.', 'email' => 'erfan.hasmin.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0908048702', 'nama' => 'Ir. Rismayani, S.Kom., M.T.', 'email' => 'ir.rismayani.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0908097601', 'nama' => 'Imran Djafar, S.Kom., M.T.', 'email' => 'imran.djafar.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0909058802', 'nama' => 'Suci Ramadhani Arifin, S.T., M.Eng.', 'email' => 'suci.ramadhani.arifin.s.t.m.eng@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0909118301', 'nama' => 'Muh. Syahlan Natsir, S.Kom., M.T.', 'email' => 'muh.syahlan.natsir.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0910027401', 'nama' => 'St. Aminah Dinayati, S.Sos., M.Kom.', 'email' => 'st.aminah.dinayati.s.sos.m.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0911036101', 'nama' => 'Dr. Drs. Baharuddin Rahman, M.Hum.', 'email' => 'dr.drs.baharuddin.rahman.m.hum@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0911067502', 'nama' => 'Herlinda, S.T., M.T.', 'email' => 'herlinda.s.t.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0911075701', 'nama' => 'Ir. Irsal, M.T.', 'email' => 'ir.irsal.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0911089401', 'nama' => 'Mushaf, S.Kom.,M.Kom', 'email' => 'mushaf.s.kom.m.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0912048901', 'nama' => 'Suci Rahma Dani R., S.Kom., M.T.', 'email' => 'suci.rahma.dani.r.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0912109201', 'nama' => 'Fadel Muslaini, S.Pd.,M.Pd.', 'email' => 'fadel.muslaini.s.pd.m.pd@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0912127001', 'nama' => 'Jufri, S.Kom., M.T.', 'email' => 'jufri.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0913068502', 'nama' => 'Muhardi, S.Kom., M.T.', 'email' => 'muhardi.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0914018301', 'nama' => 'Asran, S.T., M.T.', 'email' => 'asran.s.t.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0914037501', 'nama' => 'Erni Marlina, S.Kom., M.I.Kom.', 'email' => 'erni.marlina.s.kom.m.i.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0914099202', 'nama' => 'Herenal Daeng Toto,SE.,MM.', 'email' => 'herenal.daeng.toto.se.mm@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0914117202', 'nama' => 'Risnayanti A. Djamro, S.E., M.M.', 'email' => 'risnayanti.a.djamro.s.e.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0914117504', 'nama' => 'Rudi Donny, S.E., M.Kom.', 'email' => 'rudi.donny.s.e.m.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0914118501', 'nama' => 'Ahyuna, S.Kom., M.I.Kom.', 'email' => 'ahyuna.s.kom.m.i.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0915046902', 'nama' => 'Dr. Asri Kunda, S.E., M.M.', 'email' => 'dr.asri.kunda.s.e.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0915108101', 'nama' => 'Michael Oktavianus, S.Kom., M.M.', 'email' => 'michael.oktavianus.s.kom.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0916068301', 'nama' => 'Hasyrif Sy, S.Kom., M.T.', 'email' => 'hasyrif.sy.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0917067501', 'nama' => 'Dr. Fatmasari, S.E., M.M., M.Si.', 'email' => 'dr.fatmasari.s.e.m.m.m.si@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0918098501', 'nama' => 'Andi Irmayana, S.Kom., M.T.', 'email' => 'andi.irmayana.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0919029204', 'nama' => 'Nurdiansyah,SM.,MM.', 'email' => 'nurdiansyah.sm.mm@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0920027603', 'nama' => 'Dr. Syafruddin Muhtamar, S.H., M.H.', 'email' => 'dr.syafruddin.muhtamar.s.h.m.h@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0920037103', 'nama' => 'Joseph Tumiwa, SS., M.Pd.', 'email' => 'joseph.tumiwa.ss.m.pd@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0920038502', 'nama' => 'Nurlindasari Tamsir, S.Kom., M.T.', 'email' => 'nurlindasari.tamsir.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0920057302', 'nama' => 'Kasmawaru, S.Sos., M.Kom.', 'email' => 'kasmawaru.s.sos.m.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0920068803', 'nama' => 'Nirwana, S.Si., M.T.', 'email' => 'nirwana.s.si.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0920127901', 'nama' => 'Amirah, S.T., M.T.', 'email' => 'amirah.s.t.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0921037502', 'nama' => 'Nurdiana, SE.,MM.', 'email' => 'nurdiana.se.mm@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0921038602', 'nama' => 'Dr. Nurdiansah, S.Kom., M.Pd.', 'email' => 'dr.nurdiansah.s.kom.m.pd@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0922068907', 'nama' => 'Sriwahyuningsih Piu, S.Si., M.T.', 'email' => 'sriwahyuningsih.piu.s.si.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0923037002', 'nama' => 'Abdul Ibrahim, S.Kom., M.MSI.', 'email' => 'abdul.ibrahim.s.kom.m.msi@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0923118301', 'nama' => 'Magfirah, S.Si., M.M.', 'email' => 'magfirah.s.si.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0924047803', 'nama' => 'Irmawati, S.Kom.,M.M', 'email' => 'irmawati.s.kom.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0924049301', 'nama' => 'Fachriyahtul Jannah, SM.,MM.', 'email' => 'fachriyahtul.jannah.sm.mm@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0924056701', 'nama' => 'Dr. Nasaruddin, S.E., M.M.', 'email' => 'dr.nasaruddin.s.e.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0924056702', 'nama' => 'Dr. Y. Johny  W. Soetikno, S.E., M.M.', 'email' => 'dr.y.johny.w.soetikno.s.e.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0924069201', 'nama' => 'Husnul Muamilah, SE.,M.M', 'email' => 'husnul.muamilah.se.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0924097202', 'nama' => 'Dr. Abdul Rauf, S.H., M.H.', 'email' => 'dr.abdul.rauf.s.h.m.h@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0925016603', 'nama' => 'Dr. Ir. Mirfan, M.M.', 'email' => 'dr.ir.mirfan.m.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0926089201', 'nama' => 'Muhammad Rizal, S.Kom., M.T.', 'email' => 'muhammad.rizal.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0926117401', 'nama' => 'Yesaya Tommy Paulus, S.Kom., M.T., Ph.D.', 'email' => 'yesaya.tommy.paulus.s.kom.m.t.ph.d@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0927037502', 'nama' => 'Sitti Harlina, S.E., M.Kom.', 'email' => 'sitti.harlina.s.e.m.kom@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0927038801', 'nama' => 'Sadly Syamsuddin, S.Kom., M.T.', 'email' => 'sadly.syamsuddin.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0927088601', 'nama' => 'Marsha, SE., MM', 'email' => 'marsha.se.mm@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0927117301', 'nama' => 'Dr. Cucut Susanto, S.Kom., M.Si.', 'email' => 'dr.cucut.susanto.s.kom.m.si@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0928079104', 'nama' => 'Muhammad Furqan Rasyid, S.Kom., M.T.', 'email' => 'muhammad.furqan.rasyid.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0928087503', 'nama' => 'Andrew Ridow Johanis M', 'email' => 'andrew.ridow.johanis.m@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0928107901', 'nama' => 'Madiana Patasik, S.Kom., M.T.', 'email' => 'madiana.patasik.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0928108705', 'nama' => 'Sitti Aisa, S.Kom., M.T.', 'email' => 'sitti.aisa.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0929027601', 'nama' => 'Nurlina, S.Kom., M.T.', 'email' => 'nurlina.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0929058602', 'nama' => 'Samsu Alam, S.Si., M.Si.', 'email' => 'samsu.alam.s.si.m.si@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0929127802', 'nama' => 'Indo Intan, S.T., M.T.', 'email' => 'indo.intan.s.t.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0930077801', 'nama' => 'Nur Salman, S.Kom., M.T.', 'email' => 'nur.salman.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0930128405', 'nama' => 'Asrul Syam, S.Si.,M.Si.', 'email' => 'asrul.syam.s.si.m.si@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0931039002', 'nama' => 'Sri Wahyuni, S.Kom., M.T.', 'email' => 'sri.wahyuni.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0931108803', 'nama' => 'Sunardi, S.Kom., M.T.', 'email' => 'sunardi.s.kom.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0931127016', 'nama' => 'Dr. Ahmad, S.T., M.T.', 'email' => 'dr.ahmad.s.t.m.t@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '0931127701', 'nama' => 'Hasriani, S.E., M.Si.', 'email' => 'hasriani.s.e.m.si@undipa.ac.id', 'id_keahlian' => 1],
            ['nidn' => '5214012', 'nama' => 'Mika Tandililing S.Th.', 'email' => 'mika.tandililing.s.th@undipa.ac.id', 'id_keahlian' => 1],
        ];

        foreach ($dosens as $dosen) {
            DB::table('mst_dosens')->insert([
                'nidn' => $dosen['nidn'],
                'nama' => $dosen['nama'],
                'email' => $dosen['email'],
                'created_at' => now(),
                'updated_at' => now(),
                'id_keahlian' => $dosen['id_keahlian']
            ]);
        }
    }
}
