<h1>MemberPoint Info</h1>
<table>
    <thead>
        <tr>
            <th>Point</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody id="body">
        @foreach ($memberpoints as $memberpoint)
        <tr>
            <td>{{ $memberpoint->memberpoint }}</td>
            <td>{{ $memberpoint->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach

    </tbody>
</table>
<div class="paginate">
    {{$memberpoints->links()}}
</div>