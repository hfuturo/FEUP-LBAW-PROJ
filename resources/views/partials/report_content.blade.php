<div id="report_content_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeReportContentForm()">&times;</span>
        <form id="report_form">
            @csrf
            <input type="hidden" id="id_content" name="id_content" value="">
            <label for="reason">Reason</label>
            <textarea id="reason" name="reason" placeholder="Reason for the report" required></textarea>
            @error("reason")
                <p class="report_error">{{ $message }}</p>
            @enderror
            <button  class="button" type="submit" id="submit_report">Report</button>
        </form>
    </div>
</div>
