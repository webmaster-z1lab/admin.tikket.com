import Information from './view/Information'
import Organizer from './view/Organizer'
import Location from './view/Location'
import Tickets from './view/Tickets'
import NewTicket from './view/NewTicket'
import errorComponent from '../../components/errorComponent'

const routes = [
    {path: '/', name: 'home', redirect: 'information'},
    {path: '/information', name: 'information', component: Information},
    {path: '/organizer', name: 'organizer', component: Organizer, meta: { requiresStartEvent: true }},
    {path: '/location', name: 'location', component: Location, meta: { requiresStartEvent: true }},
    {path: '/tickets', name: 'tickets', component: Tickets, meta: { requiresStartEvent: true }},
    {path: '/tickets/ticket', name: 'tickets.ticket', component: NewTicket, meta: { requiresStartEvent: true }},
    {path: '/error/:code', name: 'error', component: errorComponent},
    {path: '*', name: 'page_not_found', component: errorComponent, props: {code: '404'}}
];

export default routes
