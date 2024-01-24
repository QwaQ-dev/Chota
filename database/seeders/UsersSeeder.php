<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $jayParsedAry = [
            "adilet kulbayev" => "adilet@apk-edu.kz",
            "Alibi Kaman" => "ninjakem009@apk-edu.kz",
            "dima zabirov" => "dima_zabirov@apk-edu.kz",
            "Gulzada Bazekenova" => "gulzada@apk-edu.kz",
            "Khairullayev Rinat" => "khairullayev@apk-edu.kz",
            "merkasheva ainur" => "merkasheva@apk-edu.kz",
            "Miras Amanbai" => "miras@apk-edu.kz",
            "nazeka adelina" => "nazeka@apk-edu.kz",
            "Nazym Seitimova" => "upr@apk-edu.kz",
            "Абдулсабыр Мугалим" => "isoolus@apk-edu.kz",
            "Абзал Мухтаров" => "mukhtarov@apk-edu.kz",
            "Аида Мырзабаева" => "myrzabaeva@apk-edu.kz",
            "Айдар Смагулов" => "saj@apk-edu.kz",
            "Айжан Бижанова" => "aizhan.bizhanova@apk-edu.kz",
            "Айзада Қосдаулет" => "kosdauletaizada@apk-edu.kz",
            "Айнур Таханова" => "takhanova.ainur@apk-edu.kz",
            "Айтолқын Шортанбаева" => "shortanbaevaaitolkyn@apk-edu.kz",
            "Айымгул Тоймагамбетова" => "aimgul@apk-edu.kz",
            "Актентек Сутеева" => "aktentek_suteeva@apk-edu.kz",
            "Актылек Сагиева" => "aktlekmaksatovna@apk-edu.kz",
            "Алиби Каман" => "youninjakame@apk-edu.kz",
            "Алишер Дилмагамбетов" => "dilmagambetov.a@apk-edu.kz",
            "Алтынгул Сарсенбаева" => "sarsenbaeva.a@apk-edu.kz",
            "Амадей Уразбаев" => "amadey.urazbaev@apk-edu.kz",
            "Амина Хусаинова" => "amina.hus@apk-edu.kz",
            "Асылбек Карашев" => "karashev-a@apk-edu.kz",
            "Асылхан Кульжанов" => "asylhan@apk-edu.kz",
            "Б Мухамбеткали" => "myhambetkali@apk-edu.kz",
            "Батанияз Итибаев" => "bataniaz.itibaev@apk-edu.kz",
            "Бахитбек Изтелеуов" => "bakhitbek.iz@apk-edu.kz",
            "Баян Костанова" => "1970b@apk-edu.kz",
            "Бақытгүл Рахат" => "rahat.b@apk-edu.kz",
            "Ботакуз Кобдабаева" => "ltuapfu@apk-edu.kz",
            "Бүркіт Жарылғаған" => "Burkit.Zharylgagan@apk-edu.kz",
            "Г Тилеуова" => "tileyva.g@apk-edu.kz",
            "Галия Урунгалиевна" => "zhumagazina.g@apk-edu.kz",
            "Галым Суюнова" => "suyunova@apk-edu.kz",
            "Галымжан Изимов" => "g123@apk-edu.kz",
            "Гаухар Нурфайзова" => "Gaukhar.Nurfaizova@apk-edu.kz",
            "Гаухар Елтезерова" => "Eltezerova.Gaukhar@apk-edu.kz",
            "Гаухар Марат" => "marat.gaukhar@apk-edu.kz",
            "Гулдана Адилканова" => "adilkanova.guldana@apk-edu.kz",
            "Гулден Есенгалиева" => "eg@apk-edu.kz",
            "Гулден Есенгалиева" => "vr@apk-edu.kz",
            "Гульжанат Казкеева" => "kgn@apk-edu.kz",
            "Гульзада Базекенова" => "bezekenova@apk-edu.kz",
            "Гульмира Кайжанова" => "kaizhanova.gulmira@apk-edu.kz",
            "Гульмира Саркулова" => "gulmirask@apk-edu.kz",
            "Гульмира Саркулова" => "guulmirask@apk-edu.kz",
            "Гульнара Сулейменова" => "Gulnara.Suleimenova@apk-edu.kz",
            "Гульсара Сабдыкова" => "sabdikova@apk-edu.kz",
            "Дархан Шанбаев" => "darhan@apk-edu.kz",
            "Даулетьярова Токжан" => "dauletyarova.tokzhan@apk-edu.kz",
            "Дияр Базарбаев" => "diyar1983@apk-edu.kz",
            "Евгений Сизов" => "eugene@apk-edu.kz",
            "Ерекешев Кабеш" => "erekeshev.kabesh@apk-edu.kz",
            "ЕРЖАН УТЕУЛИЕВ" => "yerzhan_ub@apk-edu.kz",
            "Ермек Жубанышев" => "zhubanyshev.er@apk-edu.kz",
            "Есболат Жалгасов" => "Zhalgasov.Esbolat@apk-edu.kz",
            "Ж Торегалиева" => "toregalieva@apk-edu.kz",
            "Жазира Нурина" => "zhazira@apk-edu.kz",
            "Жайнагуль Абиева" => "lwzapbk@apk-edu.kz",
            "Жанар Тулегенова" => "tulegenova@apk-edu.kz",
            "Жанат Дабылова" => "dabilova@apk-edu.kz",
            "Жанат Ходжаниязова" => "zhanat@apk-edu.kz",
            "Жанна Сейтмаганбетова" => "szha@apk-edu.kz",
            "Жанна Шатаякова" => "Sh.Zhanna@apk-edu.kz",
            "Жаннат Жолаева" => "Zholaeva.Zhanat@apk-edu.kz",
            "Жаркынай Жанбырбаева" => "janbirbaeva@apk-edu.kz",
            "Жастілек Насыров" => "zhastilek.nassyrov@apk-edu.kz",
            "Женисгуль Сагидоллаевна" => "polytech@apk-edu.kz",
            "Женисгуль Мухамбетпаизова" => "mukhambetpaizova@apk-edu.kz",
            "Женискул Сагидуллаевна" => "Sagidullaevna@apk-edu.kz",
            "Жупар Ещжанова" => "eshzhanova@apk-edu.kz",
            "Инкар Жиеналина" => "izh@apk-edu.kz",
            "Инна Аксенова" => "inna@apk-edu.kz",
            "Ирина Бедная" => "bi@apk-edu.kz",
            "Ирина Авдеева" => "avdeeva.i@apk-edu.kz",
            "Исмагулова Нургуль" => "ismagulova.n@apk-edu.kz",
            "Кабеш Ерекешев" => "erekeshevkm@apk-edu.kz",
            "Камшат Ахметова" => "akhmetova.kamshat@apk-edu.kz",
            "Касымбек Алдияров" => "apk@apk-edu.kz",
            "Кобдабаева Шынар" => "kobdabaeva.shynar@apk-edu.kz",
            "Койшыбай Каналин" => "kanalin@apk-edu.kz",
            "Консбаева Айнур" => "konysbaeva.ainur@apk-edu.kz",
            "Конысжан Агатаев" => "qonysjan@apk-edu.kz",
            "Куралай Кылышбаева" => "kilishbaeva@apk-edu.kz",
            "Курмансейтова Нуржамал" => "kurmanseitova.nurzhamal@apk-edu.kz",
            "Кушерхан Алиханович" => "kusherkhan.al@apk-edu.kz",
            "Кымбат Алдонгарова" => "kymbat9802@apk-edu.kz",
            "Линия поддержки" => "info@apk-edu.kz",
            "Лязат Асабаева" => "Asabaeva.Lazzat@apk-edu.kz",
            "М Хасангалиева" => "hasangalieva@apk-edu.kz",
            "Майра Еримбетова" => "erimbetova@apk-edu.kz",
            "Максат Султанов" => "maksat@apk-edu.kz",
            "Махаббат Бахитжанова" => "makhabbat.b@apk-edu.kz",
            "Медет Айткулов" => "medet@apk-edu.kz",
            "Менсулу Турмаганбетова" => "turmaganbetova.m@apk-edu.kz",
            "Меруерт Молдабаева" => "meruert.m@apk-edu.kz",
            "Мерует Советова" => "meruet.sov@apk-edu.kz",
            "Мира Есетова" => "mira@apk-edu.kz",
            "Н Медиев" => "mediev.n@apk-edu.kz",
            "Назым Сейлова" => "Nazym.s@apk-edu.kz",
            "Нурислам Сабыржан" => "nurislam@apk-edu.kz",
            "Нурсулу Сакебаева" => "sn@apk-edu.kz",
            "Отдел Кадров" => "otdel-kadrov@apk-edu.kz",
            "Р Муханбетова" => "myhanbetova.r@apk-edu.kz",
            "Рауза Байжанова" => "brn@apk-edu.kz",
            "Раушан Жилмагамбетова" => "lzmapsc@apk-edu.kz",
            "Ринат Хайруллаев" => "rin.ray@apk-edu.kz",
            "Роман Кудайберген" => "roman79@apk-edu.kz",
            "Роман Соколов" => "romanrar@apk-edu.kz",
            "С Ақжігіт" => "akjigit@apk-edu.kz",
            "С Ільяс" => "ilyas.s@apk-edu.kz",
            "Саламат Гүлбабаш" => "salamat.gulbabash@apk-edu.kz",
            "Салтанат Бекеева" => "bekeeva.s@apk-edu.kz",
            "Салтанат Ескалиева" => "esb@apk-edu.kz",
            "Сандугаш Рахметова" => "sandugash.rh@apk-edu.kz",
            "Света Искакова" => "is@apk-edu.kz",
            "Сәлімкерей Гүлстан" => "salimkerey.gulstan@apk-edu.kz",
            "Талгат Тулегенов" => "Tulegenov.Talgat@apk-edu.kz",
            "Талгат Ахметов" => "talgat.ahmetov@apk-edu.kz",
            "Талгат Карашулаков" => "talgat65@apk-edu.kz",
            "Танжарык Кыдырбаев" => "tanzharyk.k@apk-edu.kz",
            "Шынар Амангалиева" => "shynar97@apk-edu.kz",
            "Қаракөз Музиева" => "myzeeva.k@apk-edu.kz",
            "Ә Диханбай" => "dihanbai@apk-edu.kz",
            "Баян Типография" => "Bayan@apk-edu.kz",
            "Амина Типография" => "amina_b@apk-edu.kz"
        ];

        foreach ($jayParsedAry as $key => $value) {
            // $password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
            $password = "ahpc-" . rand(1000, 9999);

            $this->addDB($key, $value, Hash::make($password), 1);
            echo $key . " - " .$value . ":" . $password . "\n";
        }
    }

    function addDB($name, $email, $password, $role)
    {
        $user = \App\Models\User::factory()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        DB::table('role_user')->insert([
            'user_id' => $user["id"],
            'role_id' => $role,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
