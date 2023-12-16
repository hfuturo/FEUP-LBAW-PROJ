<div id="report_content_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeReportContentForm()">&times;</span>
        @csrf
        <label for="reason">Reason</label>
        <textarea id="reason" name="reason"></textarea>
        <button type="submit" id="submit_report"> Report </button>
    </div>
</div>

<button onclick="openReportContentForm()">Report</button>
