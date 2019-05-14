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
                        <span class="account-position">@{{ scheduleGreetings }}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                    <a href="{{ config('app.domains.main_site') }}/usuario/perfil" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle mr-1"></i>
                        <span>Meu perfil</span>
                    </a>

                    <a href="{{ config('app.domains.main_site') }}/meus-ingressos" class="dropdown-item notify-item">
                        <i class="fas fa-ticket-alt mr-1"></i>
                        <span>Meus ingressos</span>
                    </a>

                    <a href="javascript:void(0);" class="dropdown-item notify-item" @click="logoutSubmit">
                        <i class="mdi mdi-logout mr-1"></i>
                        <span>Sair</span>
                    </a>
                </div>
            </li>
        </ul>
        <div class="app-search ml-4">
            <a href="{{route('event.my-events')}}" class="btn btn-primary btn-sm">Meus Eventos</a>
            <a href="javascript:;" class="btn btn-outline-primary btn-sm" @click="createEvent">Criar Evento</a>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ mix("js/auth/header.js") }}"></script>
@endpush
