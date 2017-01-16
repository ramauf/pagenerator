<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Models;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName', 30);
            $table->string('lastName', 30);
            $table->string('email', 30);
            $table->enum('status', ['verified', 'unverified']);
            $table->enum('type', ['driver','passenger']);
            $table->string('birthdate', 10);
            $table->integer('cities_id');
            $table->integer('points_id');
            $table->string('password', 32);
            $table->string('verification', 32);
            $table->engine = 'MYISAM';
        });
        $firstNames = ['Александр','Алексей','Андрей','Антон','Арсений','Артем','Василий','Виктор','Виталий','Владимир','Владислав','Вячеслав','Георгий','Глеб','Григорий','Даниил','Данила','Денис','Дмитрий','Евгений','Егор','Иван','Игорь','Илья','Кирилл','Константин','Лев','Максим','Марк','Матвей','Михаил','Никита','Николай','Олег','Павел','Роман','Руслан','Сергей','Станислав','Степан','Тимофей','Тимур','Федор','Юрий','Ярослав'];
        $lastNames = ['Абрамов','Авдеев','Агафонов','Аксёнов','Александров','Алексеев','Андреев','Анисимов','Антонов','Артемьев','Архипов','Афанасьев','Баранов','Белов','Белозёров','Белоусов','Беляев','Беляков','Беспалов','Бирюков','Блинов','Блохин','Бобров','Бобылёв','Богданов','Большаков','Борисов','Брагин','Буров','Быков','Васильев','Веселов','Виноградов','Вишняков','Владимиров','Власов','Волков','Воробьёв','Воронов','Воронцов','Гаврилов','Галкин','Герасимов','Голубев','Горбачёв','Горбунов','Гордеев','Горшков','Григорьев','Гришин','Громов','Гуляев','Гурьев','Гусев','Гущин','Давыдов','Данилов','Дементьев','Денисов','Дмитриев','Доронин','Дорофеев','Дроздов','Дьячков','Евдокимов','Евсеев','Егоров','Елисеев','Емельянов','Ермаков','Ершов','Ефимов','Ефремов','Жданов','Жуков','Журавлёв','Зайцев','Захаров','Зимин','Зиновьев','Зуев','Зыков','Иванков','Иванов','Игнатов','Игнатьев','Ильин','Исаев','Исаков','Кабанов','Казаков','Калашников','Калинин','Капустин','Карпов','Кириллов','Киселёв','Князев','Ковалёв','Козлов','Колесников','Колобов','Комаров','Комиссаров','Кондратьев','Коновалов','Кононов','Константинов','Копылов','Корнилов','Королёв','Костин','Котов','Кошелев','Красильников','Крылов','Крюков','Кудрявцев','Кудряшов','Кузнецов','Кузьмин','Кулагин','Кулаков','Куликов','Лаврентьев','Лазарев','Лапин','Ларионов','Лебедев','Лихачёв','Лобанов','Логинов','Лукин','Лыткин','Макаров','Максимов','Мамонтов','Марков','Мартынов','Маслов','Матвеев','Медведев','Мельников','Меркушев','Миронов','Михайлов','Михеев','Мишин','Моисеев','Молчанов','Морозов','Муравьёв','Мухин','Мышкин','Мясников','Назаров','Наумов','Некрасов','Нестеров','Никитин','Никифоров','Николаев','Никонов','Новиков','Носков','Носов','Овчинников','Одинцов','Орехов','Орлов','Осипов','Павлов','Панов','Панфилов','Пахомов','Пестов','Петров','Петухов','Поляков','Пономарёв','Попов','Потапов','Прохоров','Рогов','Родионов','Рожков','Романов','Русаков','Рыбаков','Рябов','Савельев','Савин','Сазонов','Самойлов','Самсонов','Сафонов','Селезнёв','Селиверстов','Семёнов','Сергеев','Сидоров','Силин','Симонов','Ситников','Соболев','Соколов','Соловьёв','Сорокин','Степанов','Стрелков','Субботин','Суворов','Суханов','Сысоев','Тарасов','Терентьев','Тетерин','Тимофеев','Титов','Тихонов','Третьяков','Трофимов','Туров','Уваров','Устинов','Фадеев','Фёдоров','Федосеев','Федотов','Филатов','Филиппов','Фокин','Фомин','Фомичёв','Фролов','Харитонов','Хохлов','Цветков','Чернов','Шарапов','Шаров','Шашков','Шестаков','Шилов','Ширяев','Шубин','Щербаков','Щукин','Юдин','Яковлев','Якушев','Смирнов'];
        for ($i = 0; $i < 10000; $i++){
            //Users::addRow(['firstName' => $firstNames[array_rand($firstNames)], 'lastNames' => $lastNames[array_rand($lastNames)]]);
            DB::insert('INSERT INTO `users` (`firstName`, `lastName`, `birthdate`) VALUES (?, ?, ?)', [
                $firstNames[array_rand($firstNames)],
                $lastNames[array_rand($lastNames)],
                rand(mktime(1, 1, 1, 1, 1, 1970), mktime(1, 1, 1, 1, 1, 1997))
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
