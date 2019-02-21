import * as types from '../../mutation-types'

export default {
    setTicket(context, payload) {
        context.commit(types.SET_TICKETS, payload)
    }
}
