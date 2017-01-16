<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Направление</th>
                        <th>Отбытие</th>
                        <th>Цена, руб</th>
                        <th>Водитель</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td><a href = '/poputchik/{{strtolower($post->pointFrom['transname'])}}/{{strtolower($post->pointTo['transname'])}}/{{strtolower($post->id)}}'>Из "<b>{{$post->pointFrom['address']}}</b>" в "<b>{{$post->pointTo['address']}}</b>"</a></td>
                        <td>{{date('Y-m-d H:i', $post->startTime)}}</td>
                        <td>{{$post->cost}}</td>
                        <td>{{$post->user['lastName']}} {{$post->user['firstName']}}, возраст: {{floor((time() - $post->user['birthdate'])/(60*60*24*365))}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <h4>История поездок</h4>
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width = 10%>Год</th>
                        <th>Месяц</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($year = date('Y'); $year >= 2016; $year--)
                    <tr>
                        <td>{{$year}}</td>
                        <td>
                            @foreach($months as $ind => $val)

                                <div class="col-md-1"><a href = '?date={{$ind}}.{{$year}}'>{{$val}}</a></div>
                            @endforeach
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>