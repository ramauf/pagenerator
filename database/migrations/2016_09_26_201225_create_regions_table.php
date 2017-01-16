<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->engine = 'MYISAM';
        });
        DB::insert('INSERT INTO `regions` VALUES(1, \'Хакасия\');');
        DB::insert('INSERT INTO `regions` VALUES(2, \'Оренбургская область\');');
        DB::insert('INSERT INTO `regions` VALUES(3, \'Краснодарский край\');');
        DB::insert('INSERT INTO `regions` VALUES(4, \'Башкортостан\');');
        DB::insert('INSERT INTO `regions` VALUES(5, \'Татарстан\');');
        DB::insert('INSERT INTO `regions` VALUES(6, \'Адыгея\');');
        DB::insert('INSERT INTO `regions` VALUES(7, \'Ростовская область\');');
        DB::insert('INSERT INTO `regions` VALUES(8, \'Тыва\');');
        DB::insert('INSERT INTO `regions` VALUES(9, \'Северная Осетия - Алания\');');
        DB::insert('INSERT INTO `regions` VALUES(10, \'Свердловская область\');');
        DB::insert('INSERT INTO `regions` VALUES(11, \'Чувашия\');');
        DB::insert('INSERT INTO `regions` VALUES(12, \'Якутия\');');
        DB::insert('INSERT INTO `regions` VALUES(13, \'Алтайский край\');');
        DB::insert('INSERT INTO `regions` VALUES(14, \'Владимирская область\');');
        DB::insert('INSERT INTO `regions` VALUES(15, \'Пермский край\');');
        DB::insert('INSERT INTO `regions` VALUES(16, \'Сахалинская область\');');
        DB::insert('INSERT INTO `regions` VALUES(17, \'Белгородская область\');');
        DB::insert('INSERT INTO `regions` VALUES(18, \'Тульская область\');');
        DB::insert('INSERT INTO `regions` VALUES(19, \'Иркутская область\');');
        DB::insert('INSERT INTO `regions` VALUES(20, \'\n\');');
        DB::insert('INSERT INTO `regions` VALUES(21, \'Хабаровский край\');');
        DB::insert('INSERT INTO `regions` VALUES(22, \'Тверская область\');');
        DB::insert('INSERT INTO `regions` VALUES(23, \'Кемеровская область\');');
        DB::insert('INSERT INTO `regions` VALUES(24, \'Мурманская область\');');
        DB::insert('INSERT INTO `regions` VALUES(25, \'Московская область\');');
        DB::insert('INSERT INTO `regions` VALUES(26, \'Чечня\');');
        DB::insert('INSERT INTO `regions` VALUES(27, \'Мордовия\');');
        DB::insert('INSERT INTO `regions` VALUES(28, \'Нижегородская область\');');
        DB::insert('INSERT INTO `regions` VALUES(29, \'Саратовская область\');');
        DB::insert('INSERT INTO `regions` VALUES(30, \'Приморский край\');');
        DB::insert('INSERT INTO `regions` VALUES(31, \'Красноярский край\');');
        DB::insert('INSERT INTO `regions` VALUES(32, \'Томская область\');');
        DB::insert('INSERT INTO `regions` VALUES(33, \'Астраханская область\');');
        DB::insert('INSERT INTO `regions` VALUES(34, \'Челябинская область\');');
        DB::insert('INSERT INTO `regions` VALUES(35, \'Вологодская область\');');
        DB::insert('INSERT INTO `regions` VALUES(36, \'Бурятия\');');
        DB::insert('INSERT INTO `regions` VALUES(37, \'Калининградская область\');');
        DB::insert('INSERT INTO `regions` VALUES(38, \'Кабардино-Балкария\');');
        DB::insert('INSERT INTO `regions` VALUES(39, \'Калужская область\');');
        DB::insert('INSERT INTO `regions` VALUES(40, \'Забайкальский край\');');
        DB::insert('INSERT INTO `regions` VALUES(41, \'Новосибирская область\');');
        DB::insert('INSERT INTO `regions` VALUES(42, \'Ульяновская область\');');
        DB::insert('INSERT INTO `regions` VALUES(43, \'Кировская область\');');
        DB::insert('INSERT INTO `regions` VALUES(44, \'Пензенская область\');');
        DB::insert('INSERT INTO `regions` VALUES(45, \'Амурская область\');');
        DB::insert('INSERT INTO `regions` VALUES(46, \'Карелия\');');
        DB::insert('INSERT INTO `regions` VALUES(47, \'Ханты-Мансийский АО — Югра\');');
        DB::insert('INSERT INTO `regions` VALUES(48, \'Чукотский АО\');');
        DB::insert('INSERT INTO `regions` VALUES(49, \'Ставропольский край\');');
        DB::insert('INSERT INTO `regions` VALUES(50, \'Воронежская область\');');
        DB::insert('INSERT INTO `regions` VALUES(51, \'Ленинградская область\');');
        DB::insert('INSERT INTO `regions` VALUES(52, \'Орловская область\');');
        DB::insert('INSERT INTO `regions` VALUES(53, \'Новгородская область\');');
        DB::insert('INSERT INTO `regions` VALUES(54, \'Костромская область\');');
        DB::insert('INSERT INTO `regions` VALUES(55, \'Дагестан\');');
        DB::insert('INSERT INTO `regions` VALUES(56, \'Смоленская область\');');
        DB::insert('INSERT INTO `regions` VALUES(57, \'Псковская область\');');
        DB::insert('INSERT INTO `regions` VALUES(58, \'Архангельская область\');');
        DB::insert('INSERT INTO `regions` VALUES(59, \'Камчатский край\');');
        DB::insert('INSERT INTO `regions` VALUES(60, \'Ивановская область\');');
        DB::insert('INSERT INTO `regions` VALUES(61, \'Марий Эл\');');
        DB::insert('INSERT INTO `regions` VALUES(62, \'Волгоградская область\');');
        DB::insert('INSERT INTO `regions` VALUES(63, \'Коми\');');
        DB::insert('INSERT INTO `regions` VALUES(64, \'Удмуртия\');');
        DB::insert('INSERT INTO `regions` VALUES(65, \'Ярославская область\');');
        DB::insert('INSERT INTO `regions` VALUES(66, \'Калмыкия\');');
        DB::insert('INSERT INTO `regions` VALUES(67, \'Липецкая область\');');
        DB::insert('INSERT INTO `regions` VALUES(68, \'Ямало-Ненецкий АО\');');
        DB::insert('INSERT INTO `regions` VALUES(69, \'Курганская область\');');
        DB::insert('INSERT INTO `regions` VALUES(70, \'Курская область\');');
        DB::insert('INSERT INTO `regions` VALUES(71, \'Брянская область\');');
        DB::insert('INSERT INTO `regions` VALUES(72, \'Тамбовская область\');');
        DB::insert('INSERT INTO `regions` VALUES(73, \'Самарская область\');');
        DB::insert('INSERT INTO `regions` VALUES(74, \'Тюменская область\');');
        DB::insert('INSERT INTO `regions` VALUES(75, \'Омская область\');');
        DB::insert('INSERT INTO `regions` VALUES(76, \'Ингушетия\');');
        DB::insert('INSERT INTO `regions` VALUES(77, \'Карачаево-Черкесия\');');
        DB::insert('INSERT INTO `regions` VALUES(78, \'Рязанская область\');');
        DB::insert('INSERT INTO `regions` VALUES(79, \'Еврейская АО\');');
        DB::insert('INSERT INTO `regions` VALUES(80, \'Магаданская область\');');
        DB::insert('INSERT INTO `regions` VALUES(81, \'Оспаривается\');');
        DB::insert('INSERT INTO `regions` VALUES(82, \'Алтай\');');
        DB::insert('INSERT INTO `regions` VALUES(83, \'Москва\');');
        DB::insert('INSERT INTO `regions` VALUES(84, \'Ненецкий АО\');');
        DB::insert('INSERT INTO `regions` VALUES(85, \'Санкт-Петербург\');');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('regions');
    }
}
