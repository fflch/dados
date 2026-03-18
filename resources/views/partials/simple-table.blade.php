<table class="table table-bordered">
    <thead>
        <tr>
            @foreach($table_labels as $label)
                <th scope="col">{{$label}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($table_data as $row)
            <tr>
                @foreach ($table_keys as $key)
                    <td>{{ $row[$key] }} </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>