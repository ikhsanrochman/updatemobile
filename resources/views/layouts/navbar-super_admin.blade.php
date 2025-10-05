<!-- resources/views/layouts/navbar-admin.blade.php -->
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top" id="mainNav">
    <div class="container-fluid px-2 px-md-4">
        <button class="btn d-md-none me-2" type="button" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <a class="navbar-brand d-md-none" href="#">
            Si-Pemdora
        </a>

        <div class="d-flex align-items-center ms-auto">
            <a href="{{ route('super_admin.profile.index') }}" class="text-decoration-none text-dark d-flex align-items-center">
                <i class="bi bi-person me-1"></i>
                <span class="d-none d-sm-inline">{{ Auth::user()->nama }}</span>
            </a>
        </div>
    </div>
</nav>

<style>
#mainNav {
    height: 60px;
    z-index: 1030;
    background-color: #fff;
}

@media (min-width: 769px) {
    #mainNav {
        left: 280px;
        right: 30px;
        border-radius: 0.8rem;
    }
}

@media (max-width: 768px) {
    #mainNav {
        left: 0;
        right: 0;
        border-radius: 0;
    }
    
    #sidebarToggle {
        padding: 0.25rem 0.5rem;
        font-size: 1.2rem;
        color: #002B5B;
    }
}
</style>

<style>
    @media (max-width: 768px) {
        .navbar {
            left: 0 !important;
            right: 0 !important;
            border-radius: 0 !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar'); // Make sure your sidebar has this class
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }
    });
</script> 