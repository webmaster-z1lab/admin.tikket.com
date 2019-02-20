@extends('layouts.default-external')

@section('content')
    <div id="vue-event-index" class="container-fluid">
        <loading-component :is-loading="isLoading"></loading-component>

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="javascript:;" class="btn btn-primary" @click="createEvent">Criar Evento</a>
                    </div>

                    <h4 class="page-title">Meus Eventos</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Lista de Eventos</h4>
                        <p class="text-muted font-14 mb-4">
                            Aqui você encontra a lista de todos os seus eventos(Rascunhos, Eventos Presentes/Futuros e Passados).
                        </p>

                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 show active">
                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">Eventos Futuros</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0 show">
                                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">Eventos Passados</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="home1">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Eventos</th>
                                                <th>Status</th>
                                                <th>Data de Início</th>
                                                <th>Localização</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($events_active as $event_active)
                                            <tr>
                                                <td>{{$event_active->attributes->name}}</td>
                                                <td>{{$event_active->attributes->status}}</td>
                                                <td>{{$event_active->attributes->starts_at}}</td>
                                                <td>{{$event_active->attributes->address ? $event_active->attributes->address->formatted : '-'}}</td>
                                                <td class="table-action text-center">
                                                    <a href="javascript:;" class="action-icon" @click="editEvent({{ json_encode($event_active) }})">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <a href="javascript:;" class="action-icon" @click="deleteEvent({{ json_encode($event_active->id) }})">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <div class="text-center mt-2">
                                                        <figure class="mx-auto mb-4">
                                                            <img src="{{asset("/svg/undraw_schedule_pnbk.svg")}}" alt="SVG" width="20%">
                                                        </figure>

                                                        <div class="mb-4">
                                                            <h1 class="h3"><strong>Nenhum Evento Futuro</strong></h1>

                                                            <p class="h5">Clique abaixo e adicione um evento, ficaremos muito felizes em fazer parte do seu evento.</p>

                                                            <button type="button" @click="createEvent" class="btn btn-icon btn-primary mt-2">
                                                                Adicionar Evento
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane show" id="profile1">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Eventos</th>
                                            <th>Status</th>
                                            <th>Data de Início</th>
                                            <th>Localização</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($events_past as $event_past)
                                            <tr>
                                                <td>{{$event_past->attributes->name}}</td>
                                                <td>{{$event_past->attributes->status}}</td>
                                                <td>{{$event_past->attributes->starts_at}}</td>
                                                <td>{{$event_active->attributes->address ? $event_active->attributes->address->formatted : '-'}}</td>
                                                <td class="table-action text-center">
                                                    <a href="javascript:;" class="action-icon" @click="test({{ json_encode($event_past->id) }})">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <div class="text-center mt-2">
                                                        <figure class="mx-auto mb-4">
                                                            <img src="{{asset("svg/undraw_events_2p66.svg")}}" alt="SVG" width="20%">
                                                        </figure>

                                                        <div class="mb-4">
                                                            <h1 class="h3"><strong>Nenhum Evento Passado</strong></h1>

                                                            <p class="h5">Clique abaixo e adicione um evento, ficaremos muito felizes em fazer parte do seu evento.</p>

                                                            <button type="button" @click="createEvent" class="btn btn-icon btn-primary mt-2">
                                                                Adicionar Evento
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix("js/event/my-events/main.js") }}"></script>
@endpush

