<div id="vue-header">
    <loading-component :is-loading="isLoading"></loading-component>

    <img :src="`${urlSite}/logout`" style="display:none !important;" v-if="logout">

    <div class="navbar-custom">
        <ul class="list-unstyled topbar-right-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                   aria-expanded="false">
                <span class="account-user-avatar">
                    <img :src="user.avatar" :alt="`Foto de ${user.name}`" class="rounded-circle">
                </span>
                    <span>
                    <span class="account-user-name">@{{ user.name }}</span>
                </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Bem Vindo!</h6>
                    </div>

                    <!-- item-->
                    <a :href="`${urlSite}/usuario/perfil`" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle mr-1"></i>
                        <span>Meu perfil</span>
                    </a>

                    <!-- item-->
                    <a href="#" class="dropdown-item notify-item">
                        <i class="fas fa-ticket-alt mr-1"></i>
                        <span>Meus ingressos</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item" @click="logoutSubmit">
                        <i class="mdi mdi-logout mr-1"></i>
                        <span>Sair</span>
                    </a>
                </div>
            </li>
        </ul>
        <button class="button-menu-mobile open-left disable-btn">
            <i class="mdi mdi-menu"></i>
        </button>
        <div class="app-search">
            <a href="{{route('event.my-events')}}" class="btn btn-primary btn-sm">Meus Eventos</a>
            <a href="/" class="btn btn-outline-primary btn-sm">Meus Ingressos</a>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ mix("js/auth/header.js") }}"></script>
@endpush
