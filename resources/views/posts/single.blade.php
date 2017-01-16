<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">Описание</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <td width = 40%><b>Откуда</b></td>
                        <td>{{$post->pointFrom['address']}}</td>
                    </tr>
                    <tr>
                        <td><b>Куда</b></td>
                        <td>{{$post->pointTo['address']}}</td>
                    </tr>
                    <tr>
                        <td><b>Расстояние, км</b></td>
                        <td>{{round($post->distance/1000, 1)}}</td>
                    </tr>
                    <tr>
                        <td><b>Отбытие</b></td>
                        <td>{{date('Y-m-d H:i', $post->startTime)}}</td>
                    </tr>
                    <tr>
                        <td><b>Прибытие</b></td>
                        <td>{{date('Y-m-d H:i', $post->endTime)}}</td>
                    </tr>
                    <tr>
                        <td><b>Мест свободно/всего</b></td>
                        <td>{{$post->freePlace}} / {{$post->totalPlace}}</td>
                    </tr>
                    <tr>
                        <td><b>Размер багажа</b></td>
                        <td>{{$post->luggageName}}</td>
                    </tr>
                    <tr>
                        <td><b>Цена, руб</b></td>
                        <td>{{$post->cost}}</td>
                    </tr>
                    <tr>
                        <td><b>Водитель</b></td>
                        <td>{{$post->user['lastName']}} {{$post->user['firstName']}}</td>
                    </tr>
                    <tr>
                        <td><b>Возраст</b></td>
                        <td>{{floor((time() - $post->user['birthdate'])/(60*60*24*365))}}</td>
                    </tr>
                    <tr>
                        <td><b>Рейтинг</b></td>
                        <td>{{$post->user['rate']['avg']}}</td>
                    </tr>
                    <tr>
                        <td><b>Голосов</b></td>
                        <td>{{$post->user['rate']['cnt']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php if(Session::has('users')){?>
    <?php if(isset($selfAccepts[$post->id])){?>
    <div class="alert alert-info">Вы уже оставляли заявку</div>
    <?php }else{ ?>
    <form method = 'post'>
        <input type = 'hidden' name = '_token' value = '{{csrf_token()}}' />
        <input type = 'hidden' name = 'order' value = '' />
        <div class="g-recaptcha" data-sitekey="6LfrYAgUAAAAAOMWioSTqqj6JSzhayYkZXYBhi3u"></div>
        <input type="button" class="btn btn-primary btn-lg" value = 'Оставить заявку' onclick = 'this.form.submit();' />
    </form>
    <?php } ?>
    <?php }else{?>
    <br /><br />
    Чтобы оставить заявку необходимо <a href = '/login'>авторизоваться</a> или <a href = '/registration'>зарегистрироваться</a>, если вы еще не зарегистрированы
    <br /><br />
    <br /><br />
    <?php }?>
    @if (isset($errorsList))
        @foreach ($errorsList as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
</div>
<div class="col-lg-6">
    <div id="map" style="width: 100%; height: 500px"></div>
</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
    function init () {
        var multiRoute = new ymaps.multiRouter.MultiRoute({
            referencePoints: [
                [{{$post->pointFrom['coord']}}],
                [{{$post->pointTo['coord']}}]
            ],
            params: {
                results: 2
            }
        }, {
            boundsAutoApply: true
        });

        var myMap = new ymaps.Map('map', {
            center: [55.750625, 37.626],
            zoom: 7,
            //controls: [trafficButton, viaPointButton]
        }, {
            buttonMaxWidth: 300
        });
        myMap.geoObjects.add(multiRoute);
    }
    ymaps.ready(init);
</script>