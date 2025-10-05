<!-- resources/views/components/sidebar.blade.php -->
<div id="sidebar" class="sidebar d-flex flex-column position-fixed top-0 start-0">
    <div class="d-flex align-items-center py-3 px-3">
        <button id="sidebar-toggle" class="btn text-white p-0 me-3">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="m-0 fw-bold fs-6 text-white">Si-Pemdora</h5>
    </div>

    <div class="menu-section">
        <div class="menu-wrap">
            <a href="{{ route('user.dashboard') }}" class="menu-item {{ Request::routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>

        


    <div class="menu-header">
        <span>ACCOUNT PAGES</span>
    </div>

    <div class="menu-section">
        <div class="menu-wrap">
            <a href="{{ route('user.profile.index') }}" class="menu-item {{ Request::routeIs('user.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user me-2"></i>
                <span>Profile</span>
            </a>
        </div>
       
        <div class="menu-wrap">
            <a href="#" class="menu-item" onclick="event.preventDefault(); showLogoutConfirmation();">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span>Sign out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>

<style>
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #002B5B;
    z-index: 1030;
    overflow-x: hidden;
    overflow-y: auto;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
}

.sidebar.collapsed {
    width: 250px;
    height: 60px;
    flex-direction: row;
    border-radius: 0 0 30px 0;
    transition: all 0.3s;
}

.sidebar.collapsed > .d-flex.align-items-center {
    width: 100%;
    justify-content: flex-start;
    display: flex;
}

.sidebar.collapsed .menu-section,
.sidebar.collapsed .menu-header {
    display: none;
}

.sidebar.collapsed h5 {
    display: block;
    font-size: 1.3rem;
    margin-left: 10px;
}

.menu-header {
    padding: 1.5rem 1.5rem 0.5rem;
}

.menu-header span {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.menu-section {
    padding: 0.25rem 0;
}

.menu-wrap {
    position: relative;
    margin: 6px 0;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 0.8rem 1.5rem;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 0.68rem;
    position: relative;
    z-index: 1;
    white-space: nowrap;
    overflow: visible;
    text-overflow: unset;
}

.menu-item:hover:not(.active) {
    color: white;
    background-color: rgba(255, 255, 255, 0.1);
}

.menu-item i {
    width: 20px;
    text-align: center;
}

.menu-item span {
    display: inline-block;
    white-space: nowrap;
    overflow: visible;
    text-overflow: unset;
    font-size: 0.7rem;
}

.menu-item.active {
    background: white;
    color: #002B5B;
    font-weight: 500;
    border-radius: 30px 0 0 30px;
}

.menu-item.active i,
.menu-item.active span {
    color: #002B5B;
    position: relative;
    z-index: 3;
}

.menu-wrap:has(.active) {
    margin: 16px 0;
    padding-left: 24px;
    border-radius: 30px 0 0 30px;
    background: white;
}

.menu-wrap:has(.active)::before,
.menu-wrap:has(.active)::after {
    content: '';
    position: absolute;
    right: 0;
    height: 25px;
    width: 25px;
    background-color: #002B5B;
}

.menu-wrap:has(.active)::before {
    top: -25px;
    border-bottom-right-radius: 25px;
    box-shadow: 5px 5px 0 5px white;
}

.menu-wrap:has(.active)::after {
    bottom: -25px;
    border-top-right-radius: 25px;
    box-shadow: 5px -5px 0 5px white;
}

.menu-wrap:has(.active) .menu-item::after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 100%;
    background: white;
    z-index: -1;
}

::-webkit-scrollbar {
    width: 0px;
}

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

<!-- Tambahkan Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const contentWrapper = document.querySelector('.content-wrapper');
        
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.getAttribute('href') === '#') {
                    e.preventDefault();
                    menuItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
        
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('collapsed');
                contentWrapper.classList.toggle('full-width');
            });
        }

        // Add click event listener to content wrapper
        if (contentWrapper) {
            contentWrapper.addEventListener('click', function(e) {
                // Only collapse if sidebar is not already collapsed
                if (!sidebar.classList.contains('collapsed')) {
                    sidebar.classList.add('collapsed');
                    contentWrapper.classList.add('full-width');
                }
            });
        }
    });
</script>
@endpush
