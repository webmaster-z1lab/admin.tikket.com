import Information from './view/Information'
import Organizer from './view/Organizer'
import Location from './view/Location'
import Tickets from './view/Tickets'
import NewTicket from './view/NewTicket'
// import Vue404 from '../../components/erros/404'

const routes = [
    {path: '/', name: 'home', redirect: 'information'},
    {path: '/information', name: 'information', component: Information},
    {path: '/organizer', name: 'organizer', component: Organizer},
    {path: '/location', name: 'location', component: Location},
    {path: '/tickets', name: 'tickets', component: Tickets},
    {path: '/tickets/ticket', name: 'tickets.ticket', component: NewTicket},
    // {path: '*', name: 'page_not_found', component: Vue404}
];

export default routes
