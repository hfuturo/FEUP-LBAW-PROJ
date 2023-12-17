<div id="members_org_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeMembersOrg()">&times;</span>
        <table>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Joined Date</th>
        </tr>
        @foreach ($organization->members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->member_type }}</td>
                <td>{{ \Carbon\Carbon::parse($member->parse_date) }}</td>
            </tr>
        @endforeach
        </table>
    </div>
</div>