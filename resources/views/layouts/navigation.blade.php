<!-- <input type="checkbox" id="check">

<header>
    <label for="check">
        <i class="fas fa-bars" id="sidebar_btn"></i>
    </label>
    <div class="left_area">
        <h3>Go<span>Snippets</span></h3>
    </div>
    <div class="right_area">
        <a href="#" class="logout_btn">Logout</a>
    </div>
</header>


<div class="mobile_nav">
    <div class="nav_bar">
        <img src="1.png" class="mobile_profile_image" alt="">
        <i class="fa fa-bars nav_btn"></i>
    </div>
    <div class="mobile_nav_items">
      <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" iconClass="fas fa-desktop">
        {{ __('Dashboard') }}
      </x-nav-link>
	  <x-nav-link :href="route('clientes')" :active="request()->routeIs('clientes')" iconClass="fas fa-desktop">
        {{ __('Clientes') }}
      </x-nav-link>
	  <x-nav-link :href="route('orcamentos')" :active="request()->routeIs('orcamentos')" iconClass="fas fa-desktop">
        {{ __('Orçamentos') }}
      </x-nav-link>
    </div>
</div>


<div class="sidebar">
    <div class="profile_info">
        <img src="https://i.imgur.com/iQpdHb2.jpg" class="profile_image" alt="">
        <h4>{{ Auth::user()->name }}</h4>
    </div>
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" iconClass="fas fa-desktop">
        {{ __('Dashboard') }}
      </x-nav-link>
	  <x-nav-link :href="route('clientes')" :active="request()->routeIs('clientes')" iconClass="fas fa-desktop">
        {{ __('Clientes') }}
      </x-nav-link>
	  <x-nav-link :href="route('orcamentos')" :active="request()->routeIs('orcamentos')" iconClass="fas fa-desktop">
        {{ __('Orçamentos') }}
      </x-nav-link>
</div>

-->
<nav class="menu" tabindex="0">
	<div class="smartphone-menu-trigger"></div>
  <header class="avatar">
    <h3>Larasys</h3>
  </header>
	<ul>
    <li>
	<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" iconClass="fa-solid fa-chart-line">
        {{ __('Dashboard') }}
      </x-nav-link></li>
    <li><x-nav-link :href="route('clientes')" :active="request()->routeIs('clientes')" iconClass="fa-solid fa-user-tie">
        {{ __('Clientes') }}
      </x-nav-link></li>
    <li><x-nav-link :href="route('orcamentos')" :active="request()->routeIs('orcamentos')" iconClass="fa-solid fa-file-invoice-dollar">
        {{ __('Orçamentos') }}
      </x-nav-link></li>
    <li>
		<form method="POST" action="{{ route('logout') }}">
			@csrf
	
			<x-nav-link :href="route('logout')" onclick="event.preventDefault();
												this.closest('form').submit();"
												iconClass="fas fa-desktop">
				{{ __('Logout') }}
			</x-nav-link>
		</form>
	</li>
  </ul>
</nav>