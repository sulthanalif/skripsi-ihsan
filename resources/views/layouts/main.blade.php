<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body class="sidebar-mini layout-fixed layout-navbar-fixed">
    @include('layouts.sidebar')
    <div class="content-wrapper">
        @yield('content')
    </div>

    @include('layouts.footer')
    @include('layouts.script')

    @if (config('switchuser.enabled'))
        <script>
            $(document).ready(function() {
                // Get all users
                $.ajax({
                    url: "{{ route('users.get') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            // Populate the user select dropdown
                            response.data.forEach(function(user) {
                                $("#user-select").append(
                                    `<option value="${user.id}">${user.name}</option>`);
                            });
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });

                // Handle user switch
                $("#user-select").on("change", function() {
                    const userId = $(this).val();
                    if (userId) {
                        $.ajax({
                            url: "{{ route('users.switch') }}",
                            type: "POST",
                            data: {
                                user_id: userId,
                                _token: "{{ csrf_token() }}" // Add CSRF token for security
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status) {
                                    // Show success message before refresh
                                    alert('User switched successfully');
                                    window.location.href = window.location.href;
                                } else {
                                    alert(response.message || 'Failed to switch user');
                                }
                            },
                            error: function(error) {
                                alert('An error occurred while switching user');
                                console.error(error);
                            }
                        });
                    }
                });
            });
        </script>
    @endif
</body>

</html>
