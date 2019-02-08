@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{route('event.new')}}" class="btn btn-primary">Criar Evento</a>
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
                                            <th>Ingressos</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>asasas</td>
                                            <td>1289804962</td>
                                            <td>asssas</td>
                                            <td>asssas</td>
                                            <td class="table-action text-center">
                                                <a href="" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                                <a href="" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                                <a href="javascript:;" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane show" id="profile1">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Documento</th>
                                            <th>Data de Criação</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>asasas</td>
                                            <td>1289804962</td>
                                            <td>asssas</td>
                                            <td class="table-action text-center">
                                                <a href="" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                                <a href="" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                                <a href="javascript:;" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
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
