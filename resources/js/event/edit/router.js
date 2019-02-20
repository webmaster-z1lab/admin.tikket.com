import Panel from './components/view/panel/index'
import Participant from './components/view/participant/index'
import Ticket from './components/view/tickets/index'
import CheckIn from './components/view/check-in/index'
import Financial from './components/view/financial/index'
import ErrorComponent from '../../components/errorComponent'

const withPrefix = (prefix, routes) =>
    routes.map((route) => {
        route.path = prefix + route.path;
        return route;
    });

const routes = [
    ...withPrefix('/evento/:id', [
        {path: '/', name: 'home', redirect: {name: 'panel'}},
        {path: '/painel', name: 'panel', component: Panel},
        {path: '/participantes', name: 'participant', component: Participant},
        {path: '/ingressos', name: 'ticket', component: Ticket},
        {path: '/check-in', name: 'check-in', component: CheckIn},
        {path: '/financeiro', name: 'financial', component: Financial},
        {path: '/error/:code', name: 'error', component: ErrorComponent, meta: {layout: 'error'}, props: true},
        {path: '*', name: 'page_not_found', component: ErrorComponent, meta: {layout: 'error'}, props: {code: '404'}}
    ])
];

export default routes
