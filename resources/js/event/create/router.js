import Information from './components/view/information'
import Organizer from './components/view/organizer'
import Location from './components/view/location'
import Tickets from './components/view/tickets'
import NewTicket from './components/view/new-ticket'
import ErrorComponent from '../../components/errorComponent'

const routes = [
    {path: '/', name: 'home', redirect: {name: 'information'}},
    {path: '/information', name: 'information', component: Information},
    {path: '/organizer', name: 'organizer', component: Organizer, meta: { requiresStartEvent: true }},
    {path: '/location', name: 'location', component: Location, meta: { requiresStartEvent: true }},
    {path: '/tickets', name: 'tickets', component: Tickets, meta: { requiresStartEvent: true }},
    {path: '/tickets/ticket', name: 'tickets.ticket', component: NewTicket, meta: { requiresStartEvent: true }},
    {path: '/error/:code', name: 'error', component: ErrorComponent, meta: {layout: 'error'}, props: true},
    {path: '*', name: 'page_not_found', component: ErrorComponent, meta: {layout: 'error'}, props: {code: '404'}}
];

export default routes
