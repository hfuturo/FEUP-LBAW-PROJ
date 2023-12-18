<div id="request_org_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeRequestOrg()">&times;</span>
        @foreach ($organization->requests as $request)
        <div class="requests" id="{{$request->id}}">
            <p>Name: {{ $request->name}}<p>
            <p>Date: {{ \Carbon\Carbon::parse($request->joined_date) }}<p>
            <button class="button manage" data-operation="accept">Accept</button>
            <button class="button manage" data-operation="decline">Decline</button>
        </div>
        @endforeach
        </table>
    </div>
</div>