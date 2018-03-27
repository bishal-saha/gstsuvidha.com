<?php
$route_name = Route::current()->getName();
?>
<div class="site-menubar">
    <div class="site-menubar-header">
        <div class="cover overlay">
            <img class="cover-image" src="{{ asset('backend/assets//examples/images/dashboard-header-5.jpg') }}"
                 alt="...">
            <div class="overlay-panel vertical-align overlay-background">
                <div class="vertical-align-middle">
                    <a class="avatar avatar-lg" href="javascript:void(0)">
                        <img src="{{ asset('backend/global/portraits/bishal.jpg') }}" alt="">
                    </a>
                    <div class="site-menubar-info">
                        <h5 class="site-menubar-user">{{ Auth::user()->name }}</h5>
                        <p class="site-menubar-email">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>  <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-item @if($route_name == 'home') active @endif">
                        <a class="animsition-link" href="{{ route('home') }}">
                            <i class="fas fa-tachometer-alt" aria-hidden="true"></i>
                            <span class="site-menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="fab fa-blogger-b" aria-hidden="true"></i>
                            <span class="site-menu-title">Blog</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            <li class="site-menu-item @if($route_name == 'posts.index') active @endif">
                                <a class="animsition-link" href="{{ route('posts.index') }}">
                                    <span class="site-menu-title">Posts</span>
                                </a>
                            </li>
                            <li class="site-menu-item @if($route_name == 'posts.index') active @endif">
                                <a class="animsition-link" href="#">
                                    <span class="site-menu-title">Categories</span>
                                </a>
                            </li>
                            <li class="site-menu-item @if($route_name == 'users.index') active @endif">
                                <a class="animsition-link" href="{{ route('users.index') }}">
                                    <span class="site-menu-title">Slugs</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ route('posts.index') }}">
                            <i class="fas fa-file-alt" aria-hidden="true"></i>
                            <span class="site-menu-title">Pages</span>
                        </a>
                    </li>
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="fas fa-users" aria-hidden="true"></i>
                            <span class="site-menu-title">Users</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('users.index') }}">
                                    <span class="site-menu-title">All Users</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('users.index') }}">
                                    <span class="site-menu-title">Associates</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('users.index') }}">
                                    <span class="site-menu-title">Kendra</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="fas fa-cogs" aria-hidden="true"></i>
                            <span class="site-menu-title">Settings</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('roles.index') }}">
                                    <span class="site-menu-title">Roles</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('permissions.index') }}">
                                    <span class="site-menu-title">Permissions</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('states.index') }}">
                                    <span class="site-menu-title">States</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('districts.index') }}">
                                    <span class="site-menu-title">Districts</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="fas fa-cogs" aria-hidden="true"></i>
                            <span class="site-menu-title">Taxpayer</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('roles.index') }}">
                                    <span class="site-menu-title">All Taxpayers</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('permissions.index') }}">
                                    <span class="site-menu-title">Companies</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>