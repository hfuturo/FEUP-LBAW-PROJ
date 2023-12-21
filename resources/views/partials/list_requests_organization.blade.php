<div id="request_org_popup" class="popup">
    <div class="popup-content">
        <h3>New Requests</h3>
        <span class="close" onclick="closeRequestOrg()">&times;</span>
        @if($organization->requests->count()===0)
            <p>There are no requests to show.</p>
        @else
            @foreach ($organization->requests as $request)
            <div class="requests" id="{{$request->id}}">
                <p>Name: {{ $request->name}}<p>
                <p>Date: {{ \Carbon\Carbon::parse($request->joined_date) }}<p>
                <button class="button manage" data-operation="accept">Accept</button>
                <button class="button manage" data-operation="decline">Decline</button>
            </div>
            @endforeach
        @endif
        </table>
    </div>
</div>