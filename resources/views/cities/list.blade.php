
<div class="col-lg-12">
    @foreach ($words as $word)
        <a href = '/cities/{{$word->transword}}'>[{{$word->word}}]</a>&nbsp;
    @endforeach
    <br /><br />
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Город</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cities as $city)
                    <tr>
                        <td><a href = '/poputchik/{{$city->transname}}'>Из города "<b>{{$city->name}}</b>"</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>