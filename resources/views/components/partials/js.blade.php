@if (config('settings.disable_interactions') == true)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('contextmenu', e => e.preventDefault());
            document.addEventListener('copy', e => e.preventDefault());
            document.addEventListener('cut', e => e.preventDefault());
            document.addEventListener('paste', e => e.preventDefault());
            document.addEventListener('paste', e => e.preventDefault());
            document.addEventListener('keydown', function(e) {
                if (e.key === 'F12' || e.keyCode === 123) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endif

@if (config('settings.disable_form_autocomplete'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form').forEach(function (form) {
                form.setAttribute('autocomplete', 'off');
            });
        });
    </script>
@endif
