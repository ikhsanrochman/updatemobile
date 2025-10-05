<!-- resources/views/layouts/navbar-user.blade.php -->
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-lg position-fixed rounded-4" style="height: 71px; right: 30px; left: 280px; z-index: 1000; top: 0;">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-end align-items-center w-100">
            <!-- Right Side Of Navbar - Always Visible -->
            <div class="d-flex align-items-center">
                <a href="{{ route('user.profile.index') }}" class="d-flex align-items-center text-decoration-none text-dark" style="padding-right: 20px;">
                    <i class="bi bi-person me-1"></i>
                    {{ Auth::user()->nama}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
.swal2-logout-popup {
    border-radius: 25px !important;
    padding-bottom: 2rem !important;
}
.swal2-logout-yes {
    background: #d32d2f !important;
    color: #fff !important;
    border-radius: 2rem !important;
    font-size: 1.2rem !important;
    width: 100px !important;
    height: 50px !important;
    margin-right: 1.5rem;
}
.swal2-logout-no {
    background: #444 !important;
    color: #fff !important;
    border-radius: 2rem !important;
    font-size: 1.2rem !important;
    width: 100px !important;
    height: 50px !important;
}
</style>

@push('scripts')
<script>
    function showLogoutConfirmation() {
        Swal.fire({
            title: '<span style="font-size:2.5rem;font-weight:bold;color:#fff;">Sign Out</span>',
            html: '<span style="color:#fff;font-size:1.2rem;">Apakah anda yakin?</span>',
            background: '#0a2a47',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            customClass: {
                popup: 'swal2-logout-popup',
                confirmButton: 'swal2-logout-yes',
                cancelButton: 'swal2-logout-no'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
@endpush 