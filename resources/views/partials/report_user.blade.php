<div id="report_user_popup" class="popup">
    <div class="popup-content">
        <h3>Report!</h3>
        <span class="close" onclick="closeReportUserForm()">&times;</span>
        {{ csrf_field() }}
        <input type="hidden" id="reported" name="id_reported" value="{{ $user->id }}">
        <label for="reason">Reason</label>
        <textarea id="reason" name="reason"></textarea>
        @error("reason")
            <p class="report_error">{{ $message }}</p>
        @enderror
        <button class="button" type="submit" id="submit_report"> Report </button>
    </div>
</div>

<button onclick="openReportUserForm()">Report</button>
