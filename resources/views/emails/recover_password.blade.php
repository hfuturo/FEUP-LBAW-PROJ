<h2>Hello, {{ $mailData['name'] }}!</h2>
<p>Someone has requested a password reset.</p>
<p>Code: {{ $mailData['code'] }}</p>
<p>If this was a mistake, just ignore this email and nothing will happen.</p>
