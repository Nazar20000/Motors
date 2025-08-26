<!-- Header -->
<header class="header">
    <div class="container">
    <a href="{{ route('home') }}">
        <div class="logo">
            <span class="logo-text">D.N B<br>Motors V</span>
            <span class="logo-subtext">auto llc</span>
        </div>
    </a>
        <nav class="nav">
            <a href="{{ route('home') }}" class="nav-link active">Home</a>
            <a href="{{ route('inventory') }}" class="nav-link">Inventory</a>
            <a href="{{ route('car_finder') }}" class="nav-link">Car Finder</a>
            <a href="{{ route('apply_online') }}" class="nav-link">Apply Online</a>
            <a href="{{ route('about_us') }}" class="nav-link">About Us</a>
            <a href="{{ route('contact_us') }}" class="nav-link">Contact Us</a>
            <span  class="material-symbols-outlined search-icon">search</span>
        </nav>
        <button class="mobile-menu-btn">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>
</header>
